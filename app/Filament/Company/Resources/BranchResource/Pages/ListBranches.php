<?php

namespace App\Filament\Company\Resources\BranchResource\Pages;

use App\Filament\Company\Resources\BranchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListBranches extends ListRecords
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        if (!Auth::user()->hasrole('Admin') && Auth::user()->companies->count() && Auth::user()->companies->first()->branches->count() < Auth::user()->companies->first()->permitted_branches ) {
            return [
                Actions\CreateAction::make(),
            ];
        }

        return
        [

        ];

    }
}
