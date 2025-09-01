<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Portfolio;
use App\Models\FacebookPost;
use App\Services\FacebookApiService;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Throwable;

class FacebookPostController extends Controller
{
    private FacebookApiService $facebook;

    public function __construct(FacebookApiService $facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * Danh sách bài post từ page
     */
    public function index(Request $request)
    {
        $limit  = $request->input('limit', 10);
        $after  = $request->input('after');
        $before = $request->input('before');
        $status = $request->input('status');

        $result = $this->facebook->getPagePostsWithCursor($limit, $after, $before);

        $articleFbIds = Article::whereNotNull('fb_post_id')
            ->pluck('fb_post_id')
            ->mapWithKeys(fn($id) => [$id => 'article']);

        $portfolioFbIds = Portfolio::whereNotNull('fb_post_id')
            ->pluck('fb_post_id')
            ->mapWithKeys(fn($id) => [$id => 'portfolio']);

        $savedFbMap = $articleFbIds
            ->merge($portfolioFbIds)
            ->toArray();

        $allPosts = collect($result['posts']);

        // Lọc theo trạng thái
        $filteredPosts = $allPosts->filter(function ($post) use ($status, $savedFbMap) {
            $savedType = $savedFbMap[$post['id']] ?? null;

            return match ($status) {
                'article'   => $savedType === 'article',
                'portfolio' => $savedType === 'portfolio',
                'unsaved'   => $savedType === null,
                default     => true,
            };
        })->values();

        return view('admins.facebook.index', [
            'posts'          => $filteredPosts,
            'cursors'        => $result['cursors'],
            'has_next'       => $result['has_next'],
            'has_previous'   => $result['has_previous'],
            'total_count'    => $allPosts->count(),
            'filtered_count' => $filteredPosts->count(),
            'savedFbMap'     => $savedFbMap,
            'status'         => $status,
        ]);
    }

    public function edit($id, Request $request)
    {
        $type = $request->input('type');
        $post = $this->facebook->getPostById($id);


        $content = '';

        if (!empty($post['message'])) {
            $content .= $post['message'];
        }

        if (!empty($post['attachments']['data'])) {
            foreach ($post['attachments']['data'] as $attachment) {
                $attachType = $attachment['type'] ?? null;
                $mediaType  = $attachment['media_type'] ?? null;

                if (in_array($attachType, ['video_inline', 'video']) || $mediaType === 'video') {
                    $videoUrl   = $attachment['url'] ?? ($post['permalink_url'] ?? null);
                    $videoSrcMp4 = $attachment['media']['source'] ?? null;

                    if ($videoUrl) {
                        $embedUrl = "https://www.facebook.com/plugins/video.php?href=" 
                                    . urlencode($videoUrl) 
                                    . "&show_text=0&width=560";

                        $content .= '<div class="fb-video-wrapper" style="margin:10px 0;">
                                        <iframe src="' . $embedUrl . '" 
                                            width="560" height="315" 
                                            style="border:none;overflow:hidden" 
                                            scrolling="no" frameborder="0" 
                                            allowfullscreen="true" 
                                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                                        </iframe>
                                    </div>';
                    }
                    elseif ($videoSrcMp4) {
                        $content .= '<video width="560" height="315" controls>
                                        <source src="' . $videoSrcMp4 . '" type="video/mp4">
                                    </video>';
                    }
                }

                elseif (isset($attachment['media']['image']['src'])) {
                    $content .= '<p><img src="' . $attachment['media']['image']['src'] . '" class="img-fluid" /></p>';
                }

                if (!empty($attachment['subattachments']['data'])) {
                    foreach ($attachment['subattachments']['data'] as $sub) {
                        if (isset($sub['media']['image']['src'])) {
                            $content .= '<p><img src="' . $sub['media']['image']['src'] . '" class="img-fluid" /></p>';
                        }
                    }
                }
            }

        }


        if ($type === 'article') {
            $categories = Category::where('type', 'article')->with('children')->get();

            $article = new Article([
                'name'        => $post['message'] ?? '',
                'slug'        => Str::slug(substr($post['message'] ?? 'bai-dang', 0, 50)),
                'link'        => $post['permalink_url'] ?? '',
                'description' => $post['attachments']['data'][0]['description'] ?? null,
                'content'     => $content,
                'type'        => 'article',
            ]);

            $thumbnail_url = $post['full_picture'] ?? null;

            return view('admins.articles.create', [
                'article'        => $article,
                'categories'     => $categories,
                'thumbnail_url'  => $thumbnail_url,
                'facebook_post'  => $post,
            ]);

        } else {
            $categories = Category::where('type', 'portfolio')->with('children')->get();

            $portfolio = new Portfolio([
                'name'        => $post['message'] ?? '',
                'slug'        => Str::slug(substr($post['message'] ?? 'du-an', 0, 50)),
                'description' => $post['attachments']['data'][0]['description'] ?? null,
                'content'     => $content,
                'type'        => 'portfolio',
            ]);

            $thumbnail_url = $post['full_picture'] ?? null;

            return view('admins.portfolios.create', [
                'portfolio'      => $portfolio,
                'categories'     => $categories,
                'thumbnail_url'  => $thumbnail_url,
                'facebook_post'  => $post,
            ]);
        }
    }

}
