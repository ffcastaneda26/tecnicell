<?php

namespace App\Filament\Company\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use App\Models\Warranty;
use Filament\Forms\Form;
use App\Models\Reparation;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Company\Resources\WarrantyResource\Pages;
use App\Filament\Company\Resources\WarrantyResource\RelationManagers;

class WarrantyResource extends Resource
{
    protected static ?string $model = Warranty::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $activeNavigationIcon = 'heroicon-s-shield-check';
    protected static ?int $navigationSort = 13;


    public static function getModelLabel(): string
    {
        return __('Warranty');
    }

    public static function getNavigationLabel(): string
    {
        return __('Warranties');
    }
    public static function getPluralLabel(): ?string
    {
        return __('Warranties');

    }
    public static function getNavigationGroup(): string
    {
        return __('Processes');
    }
    public static function getNavigationBadge(): ?string
    {
        if (!Auth::user()->hasRole('Admin')) {
            $company = Auth::user()->companies->first();
            return $company->warranties()->count() ? $company->warranties()->count() : '';
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
                        DatePicker::make('start_date')
                            ->translateLabel()
                            ->required()
                            ->before('due_date'),
                        DatePicker::make('due_date')
                            ->translateLabel()
                            ->required()
                            ->after('start_date'),
                        Toggle::make('active')
                            ->translateLabel(),
                        Select::make('reparation_id')
                            ->relationship('reparation', 'id')
                            ->required()
                            ->translateLabel()
                            ->options(Reparation::query()->where('company_id', Auth::user()->companies->first()->id)->pluck('id', 'id')),
                    ])->columns(5),

                MarkdownEditor::make('notes')
                    ->required()
                    ->translateLabel()
                    ->columnSpanFull()
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
                TextColumn::make('start_date')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->date('D d M y'),
                TextColumn::make('due_date')
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->date('D d M y'),
                IconColumn::make('active')
                    ->translateLabel()
                    ->boolean(),

            ])
            ->filters([
                SelectFilter::make('branch')
                    ->relationship('branch', 'name')
                    ->translateLabel()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('start_date')
                    ->searchable(),
                SelectFilter::make('duo_date')
                    ->searchable(),
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
            'index' => Pages\ListWarranties::route('/'),
            'create' => Pages\CreateWarranty::route('/create'),
            'edit' => Pages\EditWarranty::route('/{record}/edit'),
        ];
    }
}
