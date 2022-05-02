<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayRollResource\Pages;
use App\Filament\Resources\PayRollResource\RelationManagers;
use App\Models\Employee;
use App\Models\PayRoll;
use App\Models\PayScale;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PayRollResource extends Resource
{
    protected static ?string $model = PayRoll::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Employees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->options(Employee::all()->pluck('full_name', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('pay_scale_id',
                        (Employee::find($state))->financial_details()->first()?->pay_scale?->id))
                    ->required(),
                Forms\Components\Select::make('pay_scale_id')
                    ->label('Pay scale')
                    ->options(PayScale::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('year')
                    ->default(now()->year)
                    ->options(array_combine(range(date("Y"), 2010), range(date("Y"), 2010)))
                    ->required(),
                Forms\Components\Select::make('month')
                    ->default(strtolower(now()->monthName))
                    ->options([
                        'january' => 'January',
                        'february' => 'February',
                        'march' => 'March',
                        'april' => 'April',
                        'may' => 'May',
                        'june' => 'June',
                        'july' => 'July',
                        'august' => 'August',
                        'september' => 'September',
                        'october' => 'October',
                        'november' => 'November',
                        'december' => 'December',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Payment Status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'canceled' => 'Canceled',

                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('pay_scale.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('year')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('month')->searchable()->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary',
                        'danger' => 'canceled',
                        'warning' => 'pending',
                        'success' => 'paid',
                    ])
                    ->label('Payment Status')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->prependActions([
                Tables\Actions\LinkAction::make('payslip')
                    ->url(fn ($record) => route('payslip.download', $record->id))
                    ->icon('heroicon-o-download')
                    ->color('primary'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DeductionsRelationManager::class,
            RelationManagers\AllowancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayRolls::route('/'),
            'create' => Pages\CreatePayRoll::route('/create'),
            'edit' => Pages\EditPayRoll::route('/{record}/edit'),
        ];
    }
}
