<?php

namespace App\Filament\Company\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Client;
use App\Models\Country;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\ClientResource\Pages;
use App\Filament\Company\Resources\ClientResource\RelationManagers;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;


    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 7;


    public static function getNavigationLabel(): string
    {
        return __('Clients');
    }


    public static function getModelLabel(): string
    {
        return __('Client');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Clients');

    }
    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function getNavigationBadge(): ?string
    {
        if(!Auth::user()->hasRole('Admin')){
            $company = Auth::user()->companies->first();
            return $company->clients()->count();
        }
        return  null;
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
                                TextInput::make('name')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->translateLabel()
                                    ->maxLength(100)
                                    ->columnSpan(2),
                                Toggle::make('active')
                                    ->translateLabel()
                                    ->inline(false)
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger')
                            ])->columns(3),
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
                                FileUpload::make('photo')
                                    ->translateLabel()
                                    ->directory('clients')
                                    ->preserveFilenames()
                                    ->columnSpanFull(),
                            ])->columns(2),
                        Section::make()
                            ->schema([

                            ])
                    ])->columns(3),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Select::make('country_id')
                                    ->relationship('country', 'country')
                                    ->translateLabel()
                                    ->reactive()
                                    ->required()
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
                                TextInput::make('colony')
                                    ->translateLabel()
                                    ->maxLength(100),
                                TextInput::make('zipcode')
                                    ->translateLabel()
                                    ->maxLength(5),

                            ])->columns(2),
                    ]),



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
                TextColumn::make('email')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('photo'),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
