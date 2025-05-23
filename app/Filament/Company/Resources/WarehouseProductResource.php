<?php

namespace App\Filament\Company\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Warehouse;
use App\Models\DeviceType;
use Filament\Tables\Table;
use App\Models\WarehouseProduct;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\WarehouseProductResource\Pages;
use App\Filament\Company\Resources\WarehouseProductResource\RelationManagers;

class WarehouseProductResource extends Resource
{
    protected static ?string $model = WarehouseProduct::class;


    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->companies->count() || Auth::user()->hasRole('Admin');
    }
    public static function getNavigationLabel(): string
    {
        return __('Products');
    }


    public static function getModelLabel(): string
    {
        return __('Product');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Products');
    }
    public static function getNavigationGroup(): string
    {
        return __('Inventory');
    }

    public static function getEloquentQuery(): Builder
    {

        if (Auth::user()->hasrole('Admin')) {
            return parent::getEloquentQuery();
        }
        $company = Auth::user()->companies->first();

        return parent::getEloquentQuery()
            ->wherehas('warehouse', function ($query) use ($company) {
                $query->where('company_id', $company->id);
            });

    }



    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Select::make('warehouse_id')
                            ->translateLabel()
                            ->options(function (): array {
                                return Warehouse::where('company_id', self::getCompanyUser()->id)->pluck('name', 'id')->all();
                            })
                            ->required()
                            ->translateLabel()
                            ->rules([
                                fn(Get $get, string $operation): Closure => function (string $attribute, $value, Closure $fail) use ($get, $operation) {
                                    if ($operation == 'create') {
                                        $exists = WarehouseProduct::where('product_id', $get('product_id'))
                                            ->where('warehouse_id', $get('warehouse_id'))
                                            ->exists();

                                        if ($exists) {
                                            $fail(__('The product already exists in this warehouse'));
                                        }
                                    }

                                },
                            ]),
                        Select::make('product_id')
                            ->options(function (): array {
                                return Product::where('company_id', self::getCompanyUser()->id)->pluck('name', 'id')->all();
                            })
                            ->translateLabel()
                            ->required(),
                        Section::make()
                            ->schema([
                                TextInput::make('stock_min')
                                    ->required()
                                    ->translateLabel(),
                                TextInput::make('stock_max')
                                    ->required()
                                    ->translateLabel(),
                                TextInput::make('stock_reorder')
                                    ->required()
                                    ->translateLabel(),
                                TextInput::make('average_cost')
                                    ->required()
                                    ->translateLabel()
                            ])->columns(4)
                            ->description(__('Data for inventory control'))
                    ])->columns(2),
                Group::make()
                    ->schema([
                        TextInput::make('price_sale')
                            ->required()
                            ->translateLabel(),
                        TextInput::make('last_purchase_price')
                            ->translateLabel(),
                        TextInput::make('stock')
                            ->required()
                            ->translateLabel(),
                        TextInput::make('stock_available')
                            ->required()
                            ->translateLabel(),

                        TextInput::make('stock_compromised')
                            ->required()
                            ->translateLabel(),
                        Toggle::make('active'),
                        Section::make()
                            ->schema([
                                FileUpload::make('image')
                                ->translateLabel()
                                ->directory('/warehouse/products')
                                ->preserveFilenames()
                                ->columns(3),
                            ]),

                           ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse.name')
                    ->translateLabel(),
                TextColumn::make('product.name')
                    ->translateLabel(),
                TextColumn::make('price_sale')
                    ->translateLabel()
                    ->numeric(),
                TextColumn::make('last_purchase_price')
                    ->translateLabel()
                    ->numeric(),
                TextColumn::make('stock')
                    ->translateLabel()
                    ->numeric(),
                TextColumn::make('stock_available')
                    ->translateLabel()
                    ->numeric(),

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
            'index' => Pages\ListWarehouseProducts::route('/'),
            'create' => Pages\CreateWarehouseProduct::route('/create'),
            'edit' => Pages\EditWarehouseProduct::route('/{record}/edit'),
        ];
    }

    private static function getCompanyUser(): Company
    {
        return Auth::user()->companies->first();
    }
}
