<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->companies->count() || Auth::user()->hasRole('Admin');
    }

    public static function getNavigationLabel(): string
    {
        return Auth::user()->hasrole('Admin') ? __('Companies') : __('Company');
    }

    public static function getNavigationSort(): ?int
    {
        return Auth::user()->hasrole('Admin') ? 5 : 1;
    }

    public static function getModelLabel(): string
    {
        return __('Company');
    }

    public static function canCreate(): bool
    {

        return !Auth::user()->companies->count();
    }

    public static function getPluralLabel(): ?string
    {
        return Auth::user()->hasRole('Admin') ? __('Companies') : __('Company');

    }
    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()->hasRole('Admin')) {
            return static::getModel()::count();
        }
        return null;
    }

    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->hasRole('Admin')) {
            return parent::getEloquentQuery();
        }


        if (Auth::user()->companies->count()) {
            return parent::getEloquentQuery()
                ->where('id',Auth::user()->companies->first()->id );
        }


    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make(__('Generals'))
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->translateLabel()
                                            ->maxLength(100)
                                            ->columnSpan(2),
                                        TextInput::make('short')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(20)
                                            ->translateLabel(),
                                        Toggle::make('active')
                                            ->translateLabel()
                                            ->inline(false)
                                            ->onIcon('heroicon-m-check-circle')
                                            ->offIcon('heroicon-m-x-circle')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->disabled(! auth()->user()->hasRole('Admin'))
                                    ])->columns(4),
                                Group::make()
                                    ->schema([
                                        Section::make()
                                            ->schema([
                                                TextInput::make('rfc')
                                                    ->maxLength(13)
                                                    ->translateLabel()
                                                    ->columns(1),
                                                TextInput::make('email')
                                                    ->maxLength(100)
                                                    ->email()
                                                    ->translateLabel()
                                                    ->columns(1),
                                                TextInput::make('phone')
                                                    ->maxLength(15)
                                                    ->translateLabel(),
                                                TextInput::make('permitted_branches')
                                                    ->minLength(1)
                                                    ->numeric()
                                                    ->translateLabel()
                                                    ->default(1)
                                                    ->disabled(! auth()->user()->hasRole('Admin')),
                                            ])->columns(4),
                                    ]),
                                Section::make()
                                    ->schema([
                                        TextInput::make('address')
                                            ->translateLabel()
                                            ->columnSpan(2),
                                        TextInput::make('num_ext')
                                            ->maxLength(6),
                                        TextInput::make('num_int')
                                            ->maxLength(6),
                                    ])->columns(4),
                                Section::make()
                                    ->schema([
                                        Select::make('country_id')
                                            ->relationship('country', 'country')
                                            ->translateLabel()
                                            ->reactive()
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->afterStateUpdated(fn(callable $set) => $set('state_id', null)),
                                        Select::make('state_id')
                                            ->translateLabel()
                                            ->required()
                                            ->options(function (callable $get) {
                                                $country = Country::find($get('country_id'));
                                                if (!$country) {
                                                    return;
                                                }
                                                return $country->states->pluck('name', 'id');
                                            }),
                                        TextInput::make('municipality')
                                            ->translateLabel()
                                            ->maxLength(100),

                                    ])->columns(3),
                                Section::make()
                                    ->schema([
                                        TextInput::make('city')
                                        ->translateLabel()
                                        ->maxLength(100),
                                    TextInput::make('colony')
                                        ->translateLabel()
                                        ->maxLength(100),
                                    TextInput::make('zipcode')
                                        ->translateLabel()
                                        ->maxLength(5)
                                        ->validationMessages([
                                            'maxLenght' => 'The :attribute.',
                                        ]),
                                    ])->columns(3),
                            ]),
                        Tabs\Tab::make(__('Logo'))
                            ->schema([
                                FileUpload::make('logo')
                                    ->translateLabel()
                                    ->directory('companies')
                                    ->preserveFilenames(),
                            ]),
                    ])->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('short')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('logo'),
                IconColumn::make('active')
                    ->translateLabel()
                    ->boolean(),

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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
