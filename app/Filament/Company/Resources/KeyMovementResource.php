<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\KeyMovementResource\Pages;
use App\Filament\Company\Resources\KeyMovementResource\RelationManagers;
use App\KeyMovementsTypeEnum;
use App\KeyMovementUsedToEnum;
use App\Models\KeyMovement;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
    protected static ?int $navigationSort = 7;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->companies->count() || Auth::user()->hasRole('Admin');
    }
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
            if($company){
                return $company->key_movements->count() ? $company->key_movements()->count() : '';

            }
        }
        return null;
    }



    public static function getNavigationBadgeColor(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            if($company){
                return $company->key_movements->count() < 1 ? 'danger' : 'success';

            }
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
                        TextInput::make('spanish')
                            ->translateLabel()
                            ->required(),
                        TextInput::make('short_spanish')
                            ->translateLabel()
                            ->maxLength(6)
                            ->required(),

                    ]),
                Group::make()
                    ->schema([
                        TextInput::make('english')
                            ->translateLabel()
                            ->required(),
                        TextInput::make('short_english')
                            ->translateLabel()
                            ->maxLength(6)
                            ->required(),
                    ]),
                Group::make()
                    ->schema([
                        Radio::make('type')
                            ->inline()
                            ->translateLabel()
                            ->options(KeyMovementsTypeEnum::class)
                            ->required(),

                    ]),
                Group::make()
                    ->schema([
                        Radio::make('used_to')
                            ->inline()
                            ->translateLabel()
                            ->options(KeyMovementUsedToEnum::class)
                            ->required(),
                        Toggle::make('require_cost')
                            ->translateLabel()
                    ]),

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
                TextColumn::make('short_spanish')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('english')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('short_english')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('used_to')
                    ->translateLabel()
                    ->sortable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'I' => 'success',
                        'O' => 'danger'
                    })
                    ->translateLabel(),

            ])
            ->filters([
                SelectFilter::make('used_to')
                    ->options(KeyMovementUsedToEnum::class)
                    ->translateLabel(),
                SelectFilter::make('type')
                    ->options(KeyMovementResource::getTypeOptions())
                    ->translateLabel()
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
        if (App::isLocale('en')) {
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

    private static function getTypeOptions(): array
    {
        if (App::isLocale('en')) {
            return [
                'I' => 'Input',
                'O' => 'Salida'
            ];
        }

        return [
            'I' => 'Entrada',
            'O' => 'Salida'
        ];
    }


}
