<?php

namespace App\Filament\Clusters\Geographics\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\State;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Geographics;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Geographics\Resources\StateResource\Pages;
use App\Filament\Clusters\Geographics\Resources\StateResource\RelationManagers;
use Filament\Forms\Components\Select;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-americas';

    protected static ?int $navigationSort = 30;

    protected static ?string $cluster = Geographics::class;
    public static function getModelLabel(): string
    {
        return __('State');
    }


    public static function getPluralLabel(): ?string
    {
        return __('States');
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->minLength(5)
                    ->translateLabel(),
                TextInput::make('abbreviated')
                    ->required()
                    ->maxLength(5)
                    ->minLength(2)
                    ->translateLabel(),
                Select::make('country_id')
                    ->relationship(name: 'country', titleAttribute: 'country')
                    ->required()
                    ->preload()
                    ->searchable(['country', 'code'])
                    ->translateLabel(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.country')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('abbreviated')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListStates::route('/'),
            'create' => Pages\CreateState::route('/create'),
            'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }
}
