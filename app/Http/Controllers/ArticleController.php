<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Services\CloudinaryService;
use App\Services\FacebookPostSyncService;

class ArticleController extends Controller
{
    private Article $model;

    const PER_PAGE = 5;

    public function __construct()
    {
        $this->model = new Article();
    }

    public function index(Request $request)
    {
        $search = $request->input('q');

        $query = $this->model::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $category = Category::find($request->category_id);
            if ($category) {
                $categoryIds = collect([$category->id])
                    ->merge($category->childrenRecursive()->pluck('id'))
                    ->flatten()
                    ->toArray();

                $query->whereIn('category_id', $categoryIds);
            }
        }

        $articles = $query
            ->with(['category.parent'])
            ->latest()
            ->paginate(self::PER_PAGE);

        $categories = Category::with('children')
            ->where('type', CategoryType::ARTICLE)
            ->whereNull('parent_id')
            ->get();

        return view('admins.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::with('children')
            ->where('type', CategoryType::ARTICLE->value)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admins.articles.create', compact('categories'));
    }

    public function store(StoreArticleRequest $request, CloudinaryService $cloudinaryService, FacebookPostSyncService $fbService)
    // public function store(StoreArticleRequest $request, CloudinaryService $cloudinaryService)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('thumbnail')) {
            $uploadResult = $cloudinaryService->upload(
                $request->file('thumbnail'),
                'articles'
            );

            $validated['thumbnail'] = $uploadResult['url'];
        } elseif ($request->filled('thumbnail_fb')) {
            $validated['thumbnail'] = $request->input('thumbnail_fb');
        }

        $validated['content'] = $validated['content'] ?? '';

        $article = $this->model::create($validated);

        if (!empty($validated['category_ids'])) {
            $article->categories()->sync($validated['category_ids']);
        }

        if ($request->filled('facebook_post')) {
            $postData = $request->input('facebook_post');
            $postData['related_type'] = Article::class;
            $postData['related_id']   = $article->id;

            $fbPost = $fbService->sync($postData);

            $article->update([
                'fb_post_id' => $fbPost->fb_post_id,
            ]);
        }

        return redirect()->route('admin.articles.index');
    }


    public function edit($id)
    {
        $article = $this->model::findOrFail($id);

        $categories = Category::with('children')
            ->where('type', CategoryType::ARTICLE->value)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admins.articles.edit', compact(
            'article', 'categories'
        ));
    }

    public function update(UpdateArticleRequest $request, Article $article, CloudinaryService $cloudinaryService)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail_public_id) {
                $cloudinaryService->delete($article->thumbnail_public_id);
            }

            $uploadResult = $cloudinaryService->upload($request->file('thumbnail'), 'articles');
            $data['thumbnail'] = $uploadResult['url'] ?? null;
            $data['thumbnail_public_id'] = $uploadResult['public_id'] ?? null;
        } else {
            $data['thumbnail'] = $article->thumbnail;
            $data['thumbnail_public_id'] = $article->thumbnail_public_id;
        }

        $data['content'] = $data['content'] ?? $article->content;

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Cập nhật thành công!');
    }


    public function show(Article $article)
    {
        $article->load('media');

        return view('admins.articles.show', compact('article'));
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail_public_id) {
            Cloudinary::destroy($article->thumbnail_public_id);
        }

        if ($article->facebookPost) {
            $article->facebookPost->delete();
        }
            
        $article->delete();

        return redirect()->route('admin.articles.index')
        ->with('success', 'Xoá bài viết thành công.');
    }
}