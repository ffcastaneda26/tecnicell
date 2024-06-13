<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

use function Laravel\Prompts\warning;

class IdentificationsRelationManager extends RelationManager
{
    protected static string $relationship = 'identifications';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('english')
                    ->translateLabel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                TextInput::make('spanish')
                    ->translateLabel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                Toggle::make('international')->label(__('International?'))
                    ->inline(false)
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->onColor('success')
                    ->offColor('danger'),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('Identifications'))
            ->recordTitleAttribute(__('Identifications'))
            ->columns([
                Tables\Columns\TextColumn::make('spanish')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make('english')->searchable()->translateLabel(),
                Tables\Columns\IconColumn::make('international')->boolean()->label(__('International?')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label(__('Create Identification')),
                Tables\Actions\AttachAction::make()->label(__('Attach Identification'))
                    ->preloadRecordSelect()
                    ->color('success'),

            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
