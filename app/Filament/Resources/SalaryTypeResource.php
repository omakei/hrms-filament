<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryTypeResource\Pages;
use App\Filament\Resources\SalaryTypeResource\RelationManagers;
use App\Models\SalaryType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SalaryTypeResource extends Resource
{
    protected static ?string $model = SalaryType::class;

    protected static ?string $navigationIcon = 'heroicon-o-color-swatch';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                ->columns(1),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListSalaryTypes::route('/'),
            'create' => Pages\CreateSalaryType::route('/create'),
            'edit' => Pages\EditSalaryType::route('/{record}/edit'),
        ];
    }
}
