<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 4;

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
        return __('Catalogs');
    }

    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            if($company){
                return $company->products()->count() ? $company->products()->count() : __('There are no products');

            }
        }
        return null;
    }



    public static function getNavigationBadgeColor(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            if($company){
                return $company->products()->count() < 1 ? 'danger' : 'success';

            }
        }
        return null;
    }
    public static function getEloquentQuery(): Builder
    {

        if(Auth::user()->hasrole('Admin')){
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
                                Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->required()
                                    ->translateLabel()
                                    ->columnSpan(1),
                                Select::make('device_model_id')
                                    ->relationship('device_model', 'name')
                                    ->required()
                                    ->translateLabel()
                                    ->columnSpan(1),
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(150)
                                    ->translateLabel()
                                    ->columnSpanFull(),
                                TextInput::make('sku')
                                    ->maxLength(30)
                                    ->translateLabel(),
                                Toggle::make('active')
                                    ->translateLabel()
                                    ->inline(false)
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ])->columns(2)
                    ]),
                Group::make()
                    ->schema([

                        MarkdownEditor::make('description')
                            ->translateLabel(),
                        FileUpload::make('image')
                            ->translateLabel()
                            ->directory('products')
                            ->preserveFilenames(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('brand.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('device_model.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
