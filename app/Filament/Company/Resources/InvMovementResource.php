<?php

namespace App\Filament\Company\Resources;

use Closure;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\Product;
use Filament\Forms\Get;

use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Warehouse;
use Filament\Tables\Table;
use App\Models\InvMovement;
use App\Models\KeyMovement;
use App\InvMovementStatusEnum;
use App\Models\WarehouseProduct;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Array_;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\InvMovementResource\Pages;
use App\Filament\Company\Resources\InvMovementResource\RelationManagers;

class InvMovementResource extends Resource
{
    protected static ?string $model = InvMovement::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 2;


    public static function getNavigationLabel(): string
    {
        return __('Inv Movements');
    }


    public static function getModelLabel(): string
    {
        return __('Inv Movement');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Inv Movements');
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
                $query->where('company_id', $company->id)
                    ->wherehas('products');
            });

    }



    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('warehouse_id')
                            ->translateLabel()
                            ->options(function (): array {
                                return Warehouse::where('company_id', self::getCompanyUser()->id)
                                    ->wherehas('products')->pluck('name', 'id')->all();
                            })
                            ->required()
                            ->translateLabel()
                            ->rules([
                                fn(Get $get, string $operation): Closure => function (string $attribute, $value, Closure $fail) use ($get, $operation) {
                                    if ($operation == 'create') {
                                        $exists = WarehouseProduct::where('product_id', $get('product_id'))
                                            ->where('warehouse_id', $get('warehouse_id'))
                                            ->exists();
                                        if (!$exists) {
                                            $fail(__('The product does not exist in this warehouse'));
                                        }
                                    }
                                },
                            ])
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(callable $set) => $set('product_id', null)),
                        Select::make('product_id')
                            ->relationship(name: 'product', titleAttribute: 'name'),
                        Select::make('key_movement_id')
                            ->translateLabel()
                            ->options(function (): array {
                                if (App::isLocale('en')) {
                                    return KeyMovement::where('company_id', self::getCompanyUser()->id)
                                        ->where('used_to', 'I')
                                        ->pluck('name_english', 'id')->all();
                                }
                                return KeyMovement::where('company_id', self::getCompanyUser()->id)
                                    ->where('used_to', 'I')
                                    ->pluck('name_spanish', 'id')->all();

                            })
                            ->required(),
                        DatePicker::make('date')
                            ->required()
                            ->translateLabel()
                            ->before(now()),
                        TextInput::make('quantity')
                            ->required()
                            ->translateLabel()
                            ->numeric(),
                        TextInput::make('cost')
                            ->translateLabel(),
                    ])->columns(3),
                Group::make()
                    ->schema([
                        MarkdownEditor::make('notes')
                            ->translateLabel(),
                    ]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('reference')
                                    ->translateLabel()
                                    ->maxLength(100),
                                Select::make('status')
                                    ->options(InvMovementStatusEnum::class)
                                    ->translateLabel(),
                            ])->columns(2),

                        FileUpload::make('voucher_image')
                            ->translateLabel()
                            ->directory('/inventory/movements/vouchers')
                            ->preserveFilenames(),

                    ]),



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
                TextColumn::make('date')
                    ->dateTime('d-m-Y')
                    ->translateLabel(),

                TextColumn::make('key_movement.name_spanish')
                    ->translateLabel()
                    ->visible(App::isLocale('es')),
                TextColumn::make('key_movement.name_english')
                    ->translateLabel()
                    ->visible(App::isLocale('en')),
                TextColumn::make('quantity')
                    ->translateLabel()
                     ->numeric(decimalPlaces: 0),
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
            'index' => Pages\ListInvMovements::route('/'),
            'create' => Pages\CreateInvMovement::route('/create'),
            'edit' => Pages\EditInvMovement::route('/{record}/edit'),
        ];
    }

    private static function getCompanyUser(): Company
    {
        return Auth::user()->companies->first();
    }

}
