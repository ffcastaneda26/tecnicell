<?php

namespace App\Filament\Company\Resources;

use App\ExcellsusClass;
use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Device;
use App\ExcellsusTrait;
use Filament\Forms\Form;
use App\Models\Reparation;
use Filament\Tables\Table;
use App\Models\ReparationStatus;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\ReparationResource\Pages;
use App\Filament\Company\Resources\ReparationResource\RelationManagers;

class ReparationResource extends Resource
{
    protected static ?string $model = Reparation::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 12;


    public static function getModelLabel(): string
    {
        return __('Reparation');
    }

    public static function getNavigationLabel(): string
    {
        return __('Reparations');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Reparations');

    }
    public static function getNavigationGroup(): string
    {
        return __('Processes');
    }
    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->reparations()->count() ? $company->devices()->count() : '';
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
                        TextInput::make('cost')
                            ->required()
                            ->minValue(1.00)
                            ->translateLabel()
                            ->numeric()
                            ->prefixIcon('heroicon-o-currency-dollar'),


                    ])->columns(4),
                Group::make()
                    ->schema([
                        MarkdownEditor::make('notes')
                            ->required()
                            ->translateLabel()
                            ->columns(2),

                    ]),
                Group::make()
                    ->schema([
                        DatePicker::make('start_date')
                            ->translateLabel()
                            ->required(),
                        DatePicker::make('finish_date')
                            ->translateLabel()
                            ->required(),
                        Select::make('reparation_status_id')
                            ->relationship('status')
                            ->options(function (): array {
                                if (App::isLocale('en')) {
                                    return ReparationStatus::all()->pluck('english', 'id')->all();
                                } else {
                                    return ReparationStatus::all()->pluck('spanish', 'id')->all();
                                }
                            })
                            ->required()
                            ->translateLabel(),
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
                TextColumn::make('notes')
                    ->translateLabel()
                    ->limit(50),
                TextColumn::make('status.spanish')
                    ->translateLabel()
                    ->visible(App::isLocale('es')),
                TextColumn::make('status.english')
                    ->translateLabel()
                    ->visible(App::isLocale('en')),

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
            'index' => Pages\ListReparations::route('/'),
            'create' => Pages\CreateReparation::route('/create'),
            'edit' => Pages\EditReparation::route('/{record}/edit'),
        ];
    }

    public static function getStatusLabel(): string
    {
        return App::isLocale('en') ? 'english' : 'spanish';
    }
}
