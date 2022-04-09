<?php

namespace App\Filament\Resources\PayScaleResource\RelationManagers;

use App\Models\Deduction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\BelongsToManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class DeductionsRelationManager extends BelongsToManyRelationManager
{
    protected static string $relationship = 'deductions';

    protected static ?string $recordTitleAttribute = 'name';

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
                Tables\Columns\TextColumn::make('amount')->money('TZS', true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }

    public static function attachForm(Form $form): Form
    {
        return $form
            ->schema([
                static::getAttachFormRecordSelect(),
                Forms\Components\TextInput::make('amount')->required()
                    ->numeric(),
            ]);
    }

    public static function getAttachFormRecordSelect(): Select
    {
        return Forms\Components\Select::make('recordId')
            ->label('Deduction')
            ->options(Deduction::all()->pluck('name', 'id'))
            ->searchable();
    }
}
