<?php

namespace App\Filament\Resources\AdminOverviewResource\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends BaseWidget
{
    protected function getStats(): array
    {

        return [
            Stat::make("User", User::query()->count())
                ->description('Todos los Usuarios del sistema')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make("Productos", Product::query()->count())
                ->description('Todos los Productos del sistema')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make("Categorias", Category::query()->count())
                ->description('Todas las Categorias del sistema')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

        ];
    }
}
