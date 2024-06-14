<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RegimenFiscal;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RegimenFiscalResource\Pages;
use App\Filament\Resources\RegimenFiscalResource\RelationManagers;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class RegimenFiscalResource extends Resource
{
    protected static ?string $model = RegimenFiscal::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 40;

    public static function getNavigationLabel(): string
    {
        return __('Tax Regimes');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Tax Regimes');
    }

    public static function getModelLabel(): string
    {
        return __('Tax Regime');
    }

    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextInput::make('codigo')
                                    ->translateLabel()
                                    ->minLength(3)
                                    ->maxLength(3)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                TextInput::make('nombre')
                                    ->label(__('Name'))
                                    ->minLength(3)
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Toggle::make('fisicas')
                                    ->label(__('Physics'))
                                    ->inline(false)
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger'),
                                Toggle::make('morales')
                                    ->label(__('Physics'))
                                    ->inline(false)
                                    ->onIcon('heroicon-m-check-circle')
                                    ->offIcon('heroicon-m-x-circle')
                                    ->onColor('success')
                                    ->offColor('danger')
                            ])->columns(2),
                    ])->columns(3),
                Group::make()
                    ->schema([
                        DatePicker::make('inicio_vigencia')
                            ->label(__('Start Validity'))
                            ->format('d-m-Y'),
                        DatePicker::make('fin_vigencia')
                            ->label(__('Finish Validity'))
                            ->format('d-m-Y'),
                        Toggle::make('active')
                            ->label(__('Active'))
                            ->inline(false)
                            ->onIcon('heroicon-m-check-circle')
                            ->offIcon('heroicon-m-x-circle')
                            ->onColor('success')
                            ->offColor('danger'),
                    ])->columns(3)



            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('codigo')->label(__('Code')),
                TextColumn::make('nombre')->label(__('Name')),
                IconColumn::make('fisicas')->label(__('Physics'))->boolean(),
                IconColumn::make('morales')->label(__('Morals'))->boolean(),
                TextColumn::make('inicio_vigencia')->label(__('Start'))->date(),
                TextColumn::make('fin_vigencia')->label(__('Finish'))->date(),
                IconColumn::make('active')->label(__('Active'))->boolean(),



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
            'index' => Pages\ListRegimenFiscals::route('/'),
            'create' => Pages\CreateRegimenFiscal::route('/create'),
            'edit' => Pages\EditRegimenFiscal::route('/{record}/edit'),
        ];
    }
}
