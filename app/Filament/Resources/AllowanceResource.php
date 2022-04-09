<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllowanceResource\Pages;
use App\Filament\Resources\AllowanceResource\RelationManagers;
use App\Models\Allowance;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class AllowanceResource extends Resource
{
    protected static ?string $model = Allowance::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
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
            'index' => Pages\ListAllowances::route('/'),
            'create' => Pages\CreateAllowance::route('/create'),
            'edit' => Pages\EditAllowance::route('/{record}/edit'),
        ];
    }
}
