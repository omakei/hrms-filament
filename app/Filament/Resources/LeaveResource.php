<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveResource\Pages;
use App\Filament\Resources\LeaveResource\RelationManagers;
use App\Models\Employee;
use App\Models\Leave;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class LeaveResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-external-link';

    protected static ?string $navigationGroup = 'Employees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->options(Employee::all()->pluck('full_name','id'))
                    ->required(),
                Forms\Components\Hidden::make('recorded_by')
                    ->default(auth()->user()->id)
                    ->required(),
                Forms\Components\TextInput::make('credit_type')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('credit_leaves')
                    ->required()
                    ->options([
                        'day' => 'Day',
                        'week' => 'Week',
                        'month' => 'Month',
                        'year' => 'Year',
                    ]),
                Forms\Components\DatePicker::make('from')
                    ->default(now())
                    ->required(),
                Forms\Components\DatePicker::make('to')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->default('pending')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                    ]),
                Forms\Components\Textarea::make('reason')
                    ->required()
                    ->maxLength(300),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.full_name')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('recorded by'),
                Tables\Columns\TextColumn::make('credit_type'),
                Tables\Columns\TextColumn::make('credit_leaves'),
                Tables\Columns\TextColumn::make('from')
                    ->date(),
                Tables\Columns\TextColumn::make('to')
                    ->date(),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary',
                        'danger' => 'rejected',
                        'warning' => 'pending',
                        'success' => 'accepted',
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
            'index' => Pages\ListLeaves::route('/'),
            'create' => Pages\CreateLeave::route('/create'),
            'edit' => Pages\EditLeave::route('/{record}/edit'),
        ];
    }
}
