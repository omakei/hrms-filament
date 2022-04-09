<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Employees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('avatar')->collection('avatars')->columns(1),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dob')
                    ->default(now())
                    ->withoutTime()
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ]),
                Forms\Components\TextInput::make('phone_1')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_2')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('current_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('permanent_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('nationality')
                    ->required()
                    ->options([
                        'tanzanian' => 'Tanzanian',
                        'kenyan' => 'Kenyan',
                        'uganda' => 'Uganda',
                    ]),
                Forms\Components\TextInput::make('reference_name_1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference_phone_1')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference_name_2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference_phone_2')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\Select::make('marital status')
                    ->required()
                    ->options([
                        'married' => 'Married',
                        'single' => 'Single'
                    ]),
                Forms\Components\Textarea::make('comment')
                    ->required()
                    ->maxLength(65535),
                SpatieMediaLibraryFileUpload::make('Documents')
                    ->collection('employee-documents')
                    ->multiple()
                    ->minFiles(1)
                    ->maxFiles(5),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')->collection('avatars')->conversion('thumb'),
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('dob')
                    ->date(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('nationality'),
                Tables\Columns\TextColumn::make('marital status'),
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
            RelationManagers\BankAccountDetailsRelationManager::class,
            RelationManagers\CompanyDetailsRelationManager::class,
            RelationManagers\FinancialDetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
