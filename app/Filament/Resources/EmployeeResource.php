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
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Excel;
use pxlrbt\FilamentExcel\Actions\ExportAction;

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
                Forms\Components\Select::make('marital_status')
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
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('avatars')
                    ->conversion('thumb')->rounded(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable()
                ,
                Tables\Columns\TextColumn::make('dob')
                    ->date(),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('nationality'),
                Tables\Columns\TextColumn::make('marital_status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->pushBulkActions([
                ExportAction::make('export')
                    ->icon('heroicon-o-document-download')
                    ->label('Export Data') // Button label
                    ->withWriterType(Excel::CSV) // Export type: CSV, XLS, XLSX
                    ->except('updated_at') // Exclude fields
                    ->withFilename('employee list') // Set a filename
                    ->withHeadings() // Get headings from table or form
                    ->askForFilename(date('Y-m-d') . '-export') // Let the user choose a filename. You may pass a default.
                    ->askForWriterType(Excel::XLS)  // Let the user choose an export type. You may pass a default.
                    ->allFields() // Export all fields on model,
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('recorded_at')
                            ->placeholder(fn ($state): string => 'Dec 18, ' . now()->subYear()->format('Y')),

                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['recorded_at'],
                                fn (Builder $query, $date): Builder => $query->whereDate('recorded_at', '=', $date),
                            );
                    }),
                Tables\Filters\Filter::make('marital status')
                ->form([
                    Forms\Components\Select::make('marital_status')
                        ->options([
                            'married' => 'Married',
                            'single' => 'Single'
                        ])
                ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['marital_status'],
                                fn (Builder $query, $value): Builder => $query->where('marital_status', '=', $value),
                            );
                    })
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
