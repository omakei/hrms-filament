<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeCompanyDetail;
use App\Models\Shift;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ContractResource extends Resource
{
    protected static ?string $model = EmployeeCompanyDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-clip';

    protected static ?string $navigationGroup = 'Employees';

    protected static ?string $navigationLabel = 'Contracts';

    protected static ?string $pluralLabel = 'Contracts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->options(Employee::all()->pluck('full_name', 'id'))
                    ->required(),
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
                        'contract_end' => 'Contract End',
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
                SpatieMediaLibraryFileUpload::make('Contract Document')
                    ->collection('employee-contracts')
                    ->multiple()
                    ->minFiles(1)
                    ->maxFiles(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee_number'),
                Tables\Columns\TextColumn::make('joined_at')->label('start date')
                    ->date(),
                Tables\Columns\TextColumn::make('left_at')->label('end date')
                    ->date(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary',
                        'danger' => 'terminate_contract',
                        'warning' => 'contract_end',
                        'success' => 'active',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
