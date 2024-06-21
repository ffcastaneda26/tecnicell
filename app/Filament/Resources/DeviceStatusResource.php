<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeviceStatus;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeviceStatusResource\Pages;
use App\Filament\Resources\DeviceStatusResource\RelationManagers;

class DeviceStatusResource extends Resource
{
    protected static ?string $model = DeviceStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-battery-50';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Device Status');
    }
    public static function getNavigationLabel(): string
    {
        return __('Device Statuses');
    }


    public static function getPluralLabel(): ?string
    {
        return __('Device Status');
    }


    public static function getNavigationGroup(): string
    {
        return __('Catalogs');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')
                    ->required()
                    ->translateLabel()
                    ->maxLength(30)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
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
            'index' => Pages\ListDeviceStatuses::route('/'),
            'create' => Pages\CreateDeviceStatus::route('/create'),
            'edit' => Pages\EditDeviceStatus::route('/{record}/edit'),
        ];
    }
}
