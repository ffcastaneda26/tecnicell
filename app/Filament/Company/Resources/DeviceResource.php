<?php

namespace App\Filament\Company\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use App\Models\Device;
use App\ExcellsusTrait;

use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\DeviceType;
use Filament\Tables\Table;
use App\Models\DeviceModel;
use App\Models\DeviceStatus;
use Filament\Support\Markdown;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\True_;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\DeviceResource\Pages;
use App\Filament\Company\Resources\DeviceResource\RelationManagers;

class DeviceResource extends Resource
{
    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 10;
    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->companies->count() || Auth::user()->hasRole('Admin');
    }

    public static function getNavigationLabel(): string
    {
        return __('Devices');
    }


    public static function getModelLabel(): string
    {
        return __('Device');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Devices');

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
                return $company->devices()->count() ? $company->devices()->count() : __('There are no Devices');
            }
        }
        return null;
    }



    public static function getNavigationBadgeColor(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            if($company){
                return $company->devices()->count() < 1 ? 'danger' : 'success';
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
                        Select::make('device_type_id')
                            ->translateLabel()
                            ->options(function (): array {
                                if (App::isLocale('en')) {
                                    return DeviceType::all()->pluck('english', 'id')->all();
                                } else {
                                    return DeviceType::all()->pluck('spanish', 'id')->all();
                                }
                            })
                            ->required()
                            ->preload()
                            ->searchable()
                            ->translateLabel(),

                        Select::make('brand_id')
                            ->required()
                            ->relationship('brand')
                            ->translateLabel()
                            ->options(Brand::query()->wherehas('models')->pluck('name', 'id'))
                            ->live(),
                        Select::make('device_model_id')
                            ->translateLabel()
                            ->options(fn(Get $get): Collection => DeviceModel::query()
                                ->where('brand_id', $get('id_brand'))
                                ->pluck('name', 'id'))
                            ->required(),
                        Select::make('device_status_id')
                            ->translateLabel()

                            ->options(function (): array {
                                if (App::isLocale('en')) {
                                    return DeviceStatus::all()->pluck('english', 'id')->all();
                                } else {
                                    return DeviceStatus::all()->pluck('spanish', 'id')->all();
                                }
                            })
                            ->required(),
                    ])->columns(4),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('serial_number')
                                    ->translateLabel()
                                    ->required()
                                    ->unique(ignoreRecord: True),
                                TextInput::make('imei')
                                    ->translateLabel()
                                    ->required()
                                    ->unique(ignoreRecord: True),

                            ])->columns(2),
                    ]),
                MarkdownEditor::make('notes')
                    ->translateLabel()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type.' . ExcellsusTrait::getAttributeLanguage())
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model.name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('serial_number')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('imei')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status' . ExcellsusTrait::getAttributeLanguage())
                    ->label(__('Status'))
                    ->sortable()
                    ->searchable(),

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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
