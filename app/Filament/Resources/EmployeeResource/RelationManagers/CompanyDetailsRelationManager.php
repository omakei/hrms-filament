<?php

namespace App\Filament\Resources\EmployeeResource\RelationManagers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeCompanyDetail;
use App\Models\Shift;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class CompanyDetailsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'company_details';

    protected static ?string $title = 'Employee company details';

    protected static ?string $recordTitleAttribute = 'employee_number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('employee_number')
                    ->disabled()
                    ->default('OMA-'.rand(111,444).'-'.rand(555,999).'-'. now()->year)
                    ->unique(EmployeeCompanyDetail::class, 'employee_number', fn ($record) => $record)
                    ->maxLength(255),
                Forms\Components\DatePicker::make('joined_at')
                    ->required()
                    ->default(now()),
                Forms\Components\DatePicker::make('left_at')
                    ->default(now()),
                Forms\Components\Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'terminate_contract' => 'Terminate Contract',
                    ]),
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->options(Department::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('manager_id')
                    ->label('Manager')
                    ->options(Employee::all()->pluck('first_name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('shift_id')
                    ->label('Shift')
                    ->options(Shift::all()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_number'),
                Tables\Columns\TextColumn::make('joined_at')
                    ->date(),
                Tables\Columns\TextColumn::make('left_at')
                    ->date(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ]);
    }
}
