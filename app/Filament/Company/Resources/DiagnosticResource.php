<?php

namespace App\Filament\Company\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Device;
use Filament\Forms\Form;
use App\Models\Diagnostic;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\DiagnosticResource\Pages;
use App\Filament\Company\Resources\DiagnosticResource\RelationManagers;

class DiagnosticResource extends Resource
{
    protected static ?string $model = Diagnostic::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 10;


    public static function getModelLabel(): string
    {
        return __('Diagnostic');
    }

    public static function getNavigationLabel(): string
    {
        return __('Diagnostics');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Diagnostics');

    }
    public static function getNavigationGroup(): string
    {
        return __('Processes');
    }

    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->diagnostics()->count() ? $company->devices()->count() : __('There are no Diagnostics');
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
                        Select::make('device_id')
                            ->translateLabel()
                            ->relationship('device', 'serial_number')
                            ->options(Device::query()->where('company_id', Auth::user()->companies->first()->id)->pluck('serial_number', 'id'))
                            ->required()
                            ->searchable()
                            ->translateLabel(),
                        DatePicker::make('date')
                            ->translateLabel()
                            ->required(),
                        // TODO:: Revisar si solos e deben asignar usuarios con rol de técnico
                        Select::make('techincal_id')
                            ->required()
                            ->translateLabel()
                            ->options(User::query()->wherehas('companies', function ($query) {
                                $query->where('company_id', Auth::user()->companies->first()->id);
                            })->pluck('name', 'id')),
                        Toggle::make('active')
                            ->translateLabel(),

                    ])->columns(5),

                // TODO:: Dejar textarea o MarkdownEditor
                MarkdownEditor::make('diagnosis')
                    ->required()
                    ->translateLabel()
                    ->columnSpanFull(),
                // Textarea::make('diagnosis')
                //     ->required()
                //     ->translateLabel()
                //     ->columnSpanFull(),
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
                TextColumn::make('date')
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
                TextColumn::make('diagnosis')
                    ->translateLabel()
                    ->limit(50),

                IconColumn::make('active')->translateLabel()->boolean(),

            ])
            ->filters([
                SelectFilter::make('branch')
                    ->relationship('branch', 'name')
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
            'index' => Pages\ListDiagnostics::route('/'),
            'create' => Pages\CreateDiagnostic::route('/create'),
            'edit' => Pages\EditDiagnostic::route('/{record}/edit'),
        ];
    }
}
