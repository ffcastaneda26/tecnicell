<?php

namespace App\Filament\Company\Resources;

use App\ExcellsusTrait;
use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Device;
use Filament\Forms\Form;
use App\Models\Cotization;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\CotizationResource\Pages;
use App\Filament\Company\Resources\CotizationResource\RelationManagers;
use App\Models\CotizationStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\App;

class CotizationResource extends Resource
{
    protected static ?string $model = Cotization::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 10;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->companies->count() || Auth::user()->hasRole('Admin');
    }
    public static function getModelLabel(): string
    {
        return __('Cotization');
    }

    public static function getNavigationLabel(): string
    {
        return __('Cotizations');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Cotizations');

    }
    public static function getNavigationGroup(): string
    {
        return __('Processes');
    }
    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            if($company){
                return $company->cotizations()->count() ? $company->devices()->count() : '';

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
                Section::make()
                    ->schema([
                        Select::make('branch_id')
                            ->relationship('branch', 'name')
                            ->required()
                            ->translateLabel()
                            ->options(Branch::query()->where('company_id', Auth::user()->companies->first()->id)->pluck('name', 'id')),
                        Select::make('client_id')
                            ->translateLabel()
                            ->relationship('client', 'name')
                            ->options(Client::query()->where('company_id', Auth::user()->companies->first()->id)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->translateLabel(),
                        Select::make('device_id')
                            ->translateLabel()
                            ->relationship('device', 'serial_number')
                            ->options(Device::query()->where('company_id', Auth::user()->companies->first()->id)->pluck('serial_number', 'id'))
                            ->required()
                            ->searchable()
                            ->translateLabel(),
                        TextInput::make('estimated_cost')
                            ->required()
                            ->minValue(1.00)
                            ->translateLabel()
                            ->numeric()
                            ->prefixIcon('heroicon-o-currency-dollar'),


                    ])->columns(4),
                Group::make()
                    ->schema([
                        MarkdownEditor::make('description')
                            ->required()
                            ->translateLabel()
                            ->columns(2),

                    ]),
                Group::make()
                    ->schema([
                        Select::make('cotization_status_id')
                            ->options(function (): array {
                                if (App::isLocale('en')) {
                                    return CotizationStatus::all()->pluck('english', 'id')->all();
                                } else {
                                    return CotizationStatus::all()->pluck('spanish', 'id')->all();
                                }
                            })
                            ->required()
                            ->translateLabel()
                            ->columns(1),
                        Section::make()
                            ->schema([
                                Toggle::make('client_approved')
                                    ->translateLabel()
                                    ->disabled(),
                                DatePicker::make('approval_date')
                                    ->translateLabel()
                                    ->disabled(),
                            ])->columns(2),

                        // Section::make()
                        //     ->schema([


                        //     ])->columns(2),
                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('client.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->date('D d M y'),

                TextColumn::make('device.brand.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('device.model.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->translateLabel()
                    ->limit(50),
                TextColumn::make('status.spanish')
                    ->translateLabel()
                    ->visible(App::isLocale('es')),
                TextColumn::make('status.english')
                    ->translateLabel()
                    ->visible(App::isLocale('en')),
                IconColumn::make('client_approved')->translateLabel()->boolean(),

            ])
            ->filters([
                SelectFilter::make('branch')
                    ->relationship('branch', 'name')
                    ->translateLabel()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('client')
                    ->relationship('client', 'name')
                    ->translateLabel()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('device')
                    ->relationship('device', 'serial_number')
                    ->translateLabel()
                    ->searchable()
                    ->preload()
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
            'index' => Pages\ListCotizations::route('/'),
            'create' => Pages\CreateCotization::route('/create'),
            'edit' => Pages\EditCotization::route('/{record}/edit'),
        ];
    }
}
