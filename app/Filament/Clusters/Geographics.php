<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Geographics extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('Geographic');
    }
}
