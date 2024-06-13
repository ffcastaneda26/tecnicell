<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Geographics;
use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers;
use App\Filament\Resources\CountryResource\RelationManagers\IdentificationsRelationManager;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?int $navigationSort = 20;

    public static function getNavigationLabel(): string
    {
        return __('Countries');
    }

    protected static ?string $cluster = Geographics::class;


    public static function getModelLabel(): string
    {
        return __('Country');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Countries');
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->orderBy('isdefault','desc')
        ->orderby('country');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('country')->disabled(),
                Toggle::make('isdefault')->label('¿Predeterminado?')
                    ->inline(false)
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country')->label('País')->searchable()->sortable(),
                TextColumn::make('code')->label('Código')->searchable()->sortable(),
                TextColumn::make('url')->label('Url')->searchable()->sortable(),
                IconColumn::make('isdefault')->label('¿Predeterminado?')->boolean(),
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
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
