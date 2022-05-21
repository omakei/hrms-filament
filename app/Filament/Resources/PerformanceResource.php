<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerformanceResource\Pages;
use App\Filament\Resources\PerformanceResource\RelationManagers;
use App\Models\Employee;
use App\Models\Performance;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class PerformanceResource extends Resource
{
    protected static ?string $model = Performance::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';

    protected static ?string $navigationGroup = 'Employees';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->options(Employee::all()->pluck('full_name', 'id'))
                    ->required(),
                Forms\Components\Select::make('year')
                    ->options(array_combine(range(date("Y"), 2010), range(date("Y"), 2010)))
                    ->required(),
                Forms\Components\Select::make('month')
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
                Forms\Components\Select::make('ratings')
                    ->options([
                        1 => 1,
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                        7 => 7,
                        8 => 8,
                        9 => 9,
                        10 => 10,
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->date(),
                Tables\Columns\TextColumn::make('month'),
                Tables\Columns\TextColumn::make('ratings'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->pushBulkActions([
                BulkAction::make('export')
                    ->action(fn (Collection $records) => redirect(route('performance.download')))
                    ->icon('heroicon-o-document-download')
                    ->label('Export Data')
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
            'index' => Pages\ListPerformances::route('/'),
            'create' => Pages\CreatePerformance::route('/create'),
            'edit' => Pages\EditPerformance::route('/{record}/edit'),
        ];
    }
}
