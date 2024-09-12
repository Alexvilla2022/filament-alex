<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimesheetResource\Pages;
use App\Models\Timesheet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;


class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('calendar_id')
                    ->relationship('calendar', 'name') // Cambiado a Select
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name') // Cambiado a Select
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'work' => 'working',
                        'pause' => 'in pause',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('day_in')
                ->searchable()
                    ->required(),
                Forms\Components\DateTimePicker::make('day_out')
                ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendar.name') // Mostrar el nombre del calendario
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name') // Mostrar el nombre del usuario
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('day_in')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('day_out')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
    ->options([
        'work' => 'working',
        'pause' => 'in pause',
    ]),
        Filter::make('day_in')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimesheets::route('/'),
            'create' => Pages\CreateTimesheet::route('/create'),
            'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
}
