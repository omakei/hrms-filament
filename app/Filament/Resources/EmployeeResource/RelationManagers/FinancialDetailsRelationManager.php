<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use App\Models\PayScale;
use App\Models\SalaryType;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class FinancialDetailsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'financial_details';

    protected static ?string $title = 'Employee financial details';

    protected static ?string $recordTitleAttribute = 'employee_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('salary_type_id')
                    ->label('Salary Type')
                    ->options(SalaryType::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('pay_scale_id')
                    ->label('Pay Scale')
                    ->options(PayScale::all()->pluck('name', 'id'))
                    ->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pay_scale.name'),
                Tables\Columns\TextColumn::make('salary_type.name'),
            ])
            ->filters([
                //
            ]);
    }
}
