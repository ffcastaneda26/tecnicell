<?php

namespace App\Filament\Company\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Country;
use Filament\Forms\Form;
use App\Models\Warehouse;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\WarehouseResource\Pages;
use App\Filament\Company\Resources\WarehouseResource\RelationManagers;
use Illuminate\Support\Facades\Auth;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 8;
    public static function getNavigationParentItem(): ?string
    {
        return __('Branches');
    }


    public static function getNavigationLabel(): string
    {
        return __('Warehouses');
    }


    public static function getModelLabel(): string
    {
        return __('Warehouse');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Warehouses');

    }
    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->warehouses()->count() ? $company->warehouses()->count() : '';
        }
        return null;
    }


    public static function getNavigationBadgeColor(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->branches()->count() < 1 ? 'danger' : 'success';
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
                        Section::make()
                            ->schema([
                                Select::make('branch_id')
                                    ->relationship('branch', 'name')
                                    ->translateLabel()
                                    ->required(),
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->translateLabel()
                                    ->maxLength(100),
                                TextInput::make('short')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(20)
                                    ->translateLabel(),
                            ])->columns(3),
                    ])->columnSpanFull(),

                Section::make()
                    ->schema([
                        TextInput::make('email')
                            ->maxLength(100)
                            ->email()
                            ->translateLabel()
                            ->columns(1),
                        TextInput::make('phone')
                            ->maxLength(15)
                            ->translateLabel(),
                        Toggle::make('active')
                    ])->columns(3),


                Section::make()
                    ->schema([
                        Select::make('country_id')
                            ->relationship('country', 'country')
                            ->translateLabel()
                            ->reactive()
                            ->searchable()
                            ->preload()
                            ->default(function (callable $get) {
                                $country = Country::where('isdefault', 1)->first();
                                if ($country) {
                                    return $country->id;
                                }
                                return 135;
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('state_id', null)),
                        Select::make('state_id')
                            ->translateLabel()
                            ->options(function (callable $get) {
                                $country = Country::find($get('country_id'));
                                if (!$country) {
                                    return;
                                }
                                return $country->states->pluck('name', 'id');
                            }),

                    ])->columns(2),

                Section::make()
                    ->schema([
                        TextInput::make('municipality')
                            ->translateLabel()
                            ->maxLength(100),
                        TextInput::make('colony')
                            ->translateLabel()
                            ->maxLength(100),
                        TextInput::make('zipcode')
                            ->translateLabel()
                            ->maxLength(5),
                    ])->columns(3)

            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('branch.name')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('short')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('num_ext')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->translateLabel()
                    ->boolean()
            ])
            ->filters([
                SelectFilter::make('branch')
                    ->relationship('branch', 'name')
                    ->translateLabel()
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
