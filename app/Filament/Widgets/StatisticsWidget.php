<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class StatisticsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
                ->icon('heroicon-s-user-group')
        ];
    }
}
