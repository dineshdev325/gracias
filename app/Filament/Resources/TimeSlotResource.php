<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimeSlotResource\Pages;
use App\Filament\Resources\TimeSlotResource\RelationManagers;
use App\Models\TimeSlot;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimeSlotResource extends Resource
{
    protected static ?string $model = TimeSlot::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $activeNavigationIcon = 'heroicon-s-clock';


    protected static ?string $navigationGroup = 'Appointment Management';

    public static function form(Form $form): Form
    {
        //CREATE A TIMESLOT
        $timeSlots = array();
        $startTime = strtotime('05:30:00');
        $endTime = strtotime('23:30:00');
        for (
            $start = $startTime;
            $start <= $endTime;
            $start = $start + 30 * 60
        ) {
            $timeSlots[date('H:i:s', $start)] = date('h:i A', $start);
            //  array_push($timeSlots, $start);
        }

        return $form
            ->schema([
                //
                Card::make()
                ->schema([
                    Select::make('doctors_id')
                        ->relationship('doctor', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),
                        DatePicker::make('date')
                    ->displayFormat('d-m-Y')
                    ,
                    Select::make('time')
                        ->options($timeSlots)
                        ->required(),
                    Toggle::make('is_available')
                        
                        ->inline(false)
                ])
                ->columns(2)
        
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
           
            TextColumn::make('doctor.name')
            ->sortable()
            ->searchable()
            ,
            TextColumn::make('date')
            ->sortable() ,   
            TextColumn::make('time')
                ->dateTime('h:i A')
                ->sortable(),
            ToggleColumn::make('is_available')
                
        ])
        ->filters([
            //IsAvailable
            Filter::make('is_available')
                ->query(fn (Builder $query): Builder => $query->where('is_available', true)),
        // DATE
         SelectFilter::make('date')
,            //DOCTOR
        //      SelectFilter::make('slots.doctor')
        //  ->relationship('slots.doctor','name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListTimeSlots::route('/'),
            'create' => Pages\CreateTimeSlot::route('/create'),
            'edit' => Pages\EditTimeSlot::route('/{record}/edit'),
        ];
    }    
}
