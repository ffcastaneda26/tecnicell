<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CotizationStatus;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CotizationStatusResource\Pages;
use App\Filament\Resources\CotizationStatusResource\RelationManagers;

class CotizationStatusResource extends Resource
{
    protected static ?string $model = CotizationStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('Cotization Status');
    }
    public static function getNavigationLabel(): string
    {
        return __('Cotization Statuses');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Cotization Statuses');
    }


    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }
    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count() ? static::getModel()::count() : '';

    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('spanish')
                    ->required()
                    ->translateLabel()
                    ->maxLength(30),
                TextInput::make('english')
                    ->required()
                    ->translateLabel()
                    ->maxLength(30),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('spanish')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('english')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCotizationStatuses::route('/'),
            'create' => Pages\CreateCotizationStatus::route('/create'),
            'edit' => Pages\EditCotizationStatus::route('/{record}/edit'),
        ];
    }
}
