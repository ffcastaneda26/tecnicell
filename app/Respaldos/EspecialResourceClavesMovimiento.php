<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\KeyMovementResource\Pages;
use App\Filament\Company\Resources\KeyMovementResource\RelationManagers;
use App\Models\KeyMovement;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class KeyMovementResource extends Resource
{

    protected static ?string $model = KeyMovement::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    // protected static ?int $navigationSort = 7;


    public static function getNavigationLabel(): string
    {
        return __('Key Movements');
    }


    public static function getModelLabel(): string
    {
        return __('Key Movement');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Key Movements');

    }
    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->key_movements->count() ? $company->key_movements()->count() : '';
        }
        return null;
    }



    public static function getNavigationBadgeColor(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->key_movements->count() < 1 ? 'danger' : 'success';
        }
        return null;
    }


    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->hasrole('Admin')) {
            return parent::getEloquentQuery();
        }
        $company = Auth::user()->companies->first();

        return parent::getEloquentQuery()
            ->where('company_id', $company->id);

    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        TextInput::make('name_spanish')
                            ->translateLabel()
                            ->required(),
                        TextInput::make('name_spanish')
                            ->translateLabel()
                            ->required(),
                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('name_spanish')
                            ->translateLabel()
                            ->required(),
                        TextInput::make('name_spanish')
                            ->translateLabel()
                            ->required(),
                    ]),
                Section::make()
                    ->schema([
                        Radio::make('used_to')
                            ->inline()
                            ->options(KeyMovementResource::getUsedToOptions())
                            ->required(),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_spanish')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('short.spanish')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_english')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('short.english')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('used_to')
                    ->translateLabel(),

                TextColumn::make('type')
                    ->translateLabel(),

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
            'index' => Pages\ListKeyMovements::route('/'),
            'create' => Pages\CreateKeyMovement::route('/create'),
            'edit' => Pages\EditKeyMovement::route('/{record}/edit'),
        ];
    }

    private static function getUsedToOptions(): array
    {
        if(App::isLocal('en')){
            return [
                'I' => 'Inventory',
                'S' => 'Sales'
            ];
        }
        return [
            'I' => 'Inventario',
            'S' => 'Ventas'
        ];

    }
}
