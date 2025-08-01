<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

use App\Models\Partner;
use App\Models\Portfolio;
use App\Models\Category;
use App\Models\CompanySetting;

use App\Enums\CategoryType;
use Illuminate\Support\Facades\Log;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {   

        try {
            $interiorCategory = Category::with('children')
            ->where('slug', 'noi-that')
            ->where('type', CategoryType::PORTFOLIO->value)
            ->first();

            $interiorCategoryIds = collect();

            if ($interiorCategory) {
                $interiorCategoryIds = collect([$interiorCategory->id])
                    ->merge($interiorCategory->children->pluck('id'));
            }

            $interiorProjects = collect();
            $otherProjects = collect();

            if ($interiorCategoryIds->isNotEmpty()) {
                $interiorProjects = Portfolio::with('category')
                    ->whereIn('category_id', $interiorCategoryIds)
                    ->latest()
                    ->take(4)
                    ->get();

                $otherProjects = Portfolio::with('category')
                    ->whereNotIn('category_id', $interiorCategoryIds)
                    ->latest()
                    ->take(4)
                    ->get();
            }

            $partners = collect();

            if (Schema::hasTable('partners')) {
                $partners = Partner::get();
            }

            $companySettings = CompanySetting::first();

            View::share([
                'interiorProjects' => $interiorProjects,
                'otherProjects' => $otherProjects,
                'partners' => $partners,
                'companySettings' => $companySettings,
            ]);

        } catch (\Throwable $e) {
            Log::error('ViewServiceProvider Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    
        
    }
    
    public function register(): void
    {
        //
    }
}
