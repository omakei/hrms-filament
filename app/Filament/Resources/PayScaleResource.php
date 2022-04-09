<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayScaleResource\Pages;
use App\Filament\Resources\PayScaleResource\RelationManagers;
use App\Models\PayScale;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PayScaleResource extends Resource
{
    protected static ?string $model = PayScale::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?string $navigationGroup = 'Settings';

//    protected static bool $hasAssociateAction = true;
//    protected static bool $hasDissociateAction = true;
//    protected static bool $hasDissociateBulkAction = true;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->columns(1)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('basic_salary')
                    ->columns(1)
                    ->numeric()
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columns(1)
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('basic_salary')->money('TZS', true),
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
            RelationManagers\AllowancesRelationManager::class,
            RelationManagers\DeductionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayScales::route('/'),
            'create' => Pages\CreatePayScale::route('/create'),
            'edit' => Pages\EditPayScale::route('/{record}/edit'),
        ];
    }


}
