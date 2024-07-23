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
use Filament\Forms\Components\Fieldset;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Illuminate\Validation\ValidationException;

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

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('warehouse_id')
                            ->reactive()
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
                            ->required()
                            ->translateLabel()
                            ->relationship(name: 'product', titleAttribute: 'name')
                            ->reactive()
                            ->disabled(function (callable $get): bool {
                                return $get('warehouse_id') ? false : true;
                            }),
                        Select::make('key_movement_id')
                            ->required()
                            ->translateLabel()
                            ->reactive()
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
                            ->afterStateUpdated(
                                function (callable $get, Set $set, ?int $state) {
                                    if ($state) {
                                        $key_movement = KeyMovement::findOrFail($state);
                                        if ($key_movement->type == 'O') {
                                            $product_cost = WarehouseProduct::where('warehouse_id', $get('warehouse_id'))
                                                ->where('product_id', $get('product_id'))
                                                ->first();
                                            if ($product_cost) {
                                                $set('cost', $product_cost->average_cost);
                                            }
                                        }else{
                                            $set('cost', null);
                                        }
                                    }
                                }
                            )
                            ->disabled(function (callable $get): bool {
                                return $get('product_id') ? false : true;
                            }),

                    ])->columns(3),
                Fieldset::make(__('Details'))
                    ->schema([
                        DatePicker::make('date')
                            ->required()
                            ->translateLabel()
                            ->before(now())
                            ->disabled(function (callable $get): bool {
                                return $get('key_movement_id') ? false : true;
                            }),
                        TextInput::make('quantity')
                            ->required()
                            ->translateLabel()
                            ->minValue(1)
                            ->numeric()
                            ->maxValue(function (callable $get): int {
                                if ($get('key_movement_id')) {
                                    $key_movement = KeyMovement::findOrFail($get('key_movement_id'));
                                    if ($key_movement->type == 'O') {
                                        $product_validate = WarehouseProduct::where('warehouse_id', $get('warehouse_id'))
                                            ->where('product_id', $get('product_id'))
                                            ->first();
                                        return $product_validate ? $product_validate->stock_available : 9999;
                                    }
                                }
                                return 9999;
                            })
                            ->disabled(function (callable $get): bool {
                                return $get('key_movement_id') ? false : true;
                            }),
                        TextInput::make('cost')
                            ->translateLabel()
                            ->required(function (callable $get): bool {
                                $key_movement = null;
                                if ($get('key_movement_id')) {
                                    $key_movement = KeyMovement::findOrFail($get('key_movement_id'));
                                }
                                return $key_movement && $key_movement->type == 'I';
                            })->disabled(function (callable $get): bool {
                                $key_movement = null;
                                if ($get('key_movement_id')) {
                                    $key_movement = KeyMovement::findOrFail($get('key_movement_id'));
                                    return $key_movement && $key_movement->type == 'O';
                                }
                                return $get('key_movement_id') ? false : true;
                            }),
                        TextInput::make('reference')
                            ->translateLabel()
                            ->maxLength(100),
                        Select::make('status')
                            ->options(InvMovementStatusEnum::class)
                            ->translateLabel(),
                    ])->disabled(function (callable $get): bool {
                        return $get('key_movement_id') ? false : true;
                    })->columns(5),
                Fieldset::make(__('Notes and Receipt'))
                    ->schema([
                        MarkdownEditor::make('notes')
                            ->translateLabel(),
                        FileUpload::make('voucher_image')
                            ->translateLabel()
                            ->directory('/inventory/movements/vouchers')
                            ->preserveFilenames(),
                    ])->visible(function (callable $get): bool {
                        return $get('key_movement_id') ? true : false;
                    })->columns(2)
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
                    ->alignment(Alignment::End)
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('cost')
                    ->translateLabel()
                    ->alignment(Alignment::End)
                    ->numeric(decimalPlaces: 2)

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
