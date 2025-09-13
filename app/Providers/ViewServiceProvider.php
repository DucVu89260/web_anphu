<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

use App\Models\Partner;
use App\Models\Article;
use App\Models\Portfolio;
use App\Models\Category;
use App\Models\Service;
use App\Models\CustomPage;

use App\Enums\CategoryType;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {   
        $portfolioCategories = Category::whereNull('parent_id')
            ->where('type', CategoryType::PORTFOLIO->value)
            ->get();

        $portfolioByCategories = [];

        foreach ($portfolioCategories as $category) {
            // gom id cha + con (nếu có)
            $categoryIds = collect([$category->id])
                ->merge($category->children()->pluck('id'));

            $projects = Portfolio::with('category')
                ->whereIn('category_id', $categoryIds)
                ->latest()
                ->take(4)
                ->get();

            $portfolioByCategories[] = [
                'category' => $category,
                'projects' => $projects
            ];
        }


        $partners = collect();

        if (Schema::hasTable('partners')) {
            $partners = Partner::get();
        }


        $services = collect();

        if (class_exists(Service::class) && Schema::hasTable('services')) {
            $services = Service::all();
        }

        $custom_pages = CustomPage::all();
        
        $congTrinhCategory = Category::where('slug', 'cong-trinh')->first();
        $camNhanCategory = Category::where('slug', 'cam-nhan-khach-hang')->first();

        $congTrinhArticles = collect();
        $camNhanArticles = collect();

        // EXTRA VIEW CONTENT
        if ($congTrinhCategory) {
            $congTrinhArticles = Article::with('category') // <-- thêm with('category') ở đây
                ->where('category_id', $congTrinhCategory->id)
                ->latest()
                ->take(1)
                ->get();
        }

        if ($camNhanCategory) {
            $camNhanArticles = Article::with('category') // <-- thêm with('category') ở đây
                ->where('category_id', $camNhanCategory->id)
                ->latest()
                ->take(1)
                ->get();
        }

        View::share([
            'portfolioByCategories' => $portfolioByCategories,
            'partners' => $partners,
            'services' => $services,
            'custom_pages' => $custom_pages,
            'congTrinhArticles' => $congTrinhArticles,
            'congTrinhCategory' => $congTrinhCategory,
            'camNhanArticles' => $camNhanArticles,
            'camNhanCategory' => $camNhanCategory,
        ]);
        
    }
    
    public function register(): void
    {
        //
    }
}