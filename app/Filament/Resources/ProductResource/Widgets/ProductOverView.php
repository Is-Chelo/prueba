<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverView extends BaseWidget
{
    protected function getStats(): array
    {
        $categories = Category::withCount('products')->get();
        $stats = [];

        foreach ($categories as $category) {
            $stats[] = Stat::make($category->nombre, $category->products_count);
        }

        return $stats;
    }
}
