<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Clusters\Security;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 0;

    // protected static ?string $cluster = Security::class;
    /** Si desea quita rel cluster descomentar las líneas siguientes */
    public static function getNavigationGroup(): string
    {
        return __('Security');
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Users');
    }

    public static function getNavigationBadge(): ?string
    {
        if (Auth::user()->hasRole('Admin')) {
            return static::getModel()::count();
        }else{
            return static::getModel()::whereHas('companies',function($query){
                $query->where('company_id', Auth::user()->companies->first()->id);
            })->count();
        }
        return static::getModel()::count();
    }



    public static function getEloquentQuery(): Builder
    {
        if (Auth::user()->hasRole('Admin')) {

            return parent::getEloquentQuery()
                ->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['Admin', 'Gerente']);
                });
        }


        if (Auth::user()->companies->count()) {
            return parent::getEloquentQuery()
                ->whereHas('companies', function ($query) {
                    $query->where('company_id', Auth::user()->companies->first()->id);
                });
        }

        return parent::getEloquentQuery();

    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('email')->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                        Section::make('')->schema([
                            Toggle::make('active')
                                ->translateLabel()
                                ->inline(false)
                                ->onIcon('heroicon-m-check-circle')
                                ->offIcon('heroicon-m-x-circle')
                                ->onColor('success')
                                ->offColor('danger'),
                        ])->columns(2),

                    ])->columnSpanFull(),

                ])->columns(2),

                Group::make()->schema([
                    // Select::make('role_id')
                    //     ->translateLabel()
                    //     ->preload()
                    //     ->relationship('roles_gerente', 'name')
                    //     ->required()
                    //     ->afterStateUpdated(fn(callable $set) => $set('company_id', null))
                    //     ->hidden(Auth::user()->hasRole('Admin')),


                    Select::make('role_id')
                        ->relationship(
                            name: 'roles',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('name', ['Admin', 'Gerente'])
                        )
                        ->translateLabel()
                        ->preload()
                        ->required()
                        ->hidden(Auth::user()->hasRole('Admin')),
                    Select::make('role_id')
                        ->translateLabel()
                        ->preload()
                        ->required()
                        ->relationship(
                            name: 'roles',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn(Builder $query) => $query->whereIn('name', ['Admin', 'Gerente'])
                        )
                        ->hidden(!Auth::user()->hasRole('Admin')),
                    Select::make('permissions')
                        ->label('Permisos')
                        ->multiple()
                        ->preload()
                        ->relationship('permissions', 'name'),
                    // TODO: Ver como personalizar el mensaje de requerido
                    Select::make('company_id')
                        ->relationship('companies', 'name')
                        ->translateLabel()
                        ->preload()
                        ->requiredUnless('role_id', 1)
                        ->hidden(!Auth::user()->hasRole('Admin')),

                ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->translateLabel()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->translateLabel()->searchable()->sortable(),
                Tables\Columns\IconColumn::make('active')->translateLabel()->boolean(),
                Tables\Columns\TextColumn::make('roles.name')->label('Roles'),
            ])
            ->filters([])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
