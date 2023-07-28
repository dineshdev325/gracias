<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultationResource\Pages;
use App\Filament\Resources\ConsultationResource\RelationManagers;
use App\Models\Consultation;
use App\Models\PatientDetails;
use App\Models\TimeSlot;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\Split;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split as LayoutSplit;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $activeNavigationIcon = 'heroicon-s-book-open';


    protected static ?string $navigationGroup = 'Appointment Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Card::make([
                    Select::make('time_slots_id')
                        ->relationship('timeSlots', 'id')
                        ->getOptionLabelFromRecordUsing(fn (TimeSlot $record) => "{$record->doctor->name}  {$record->date} ".date('h:i A',strtotime($record->time)))
                        ->preload()
                        ->required(),
                    Select::make('patient_details_id')
                        ->relationship('patient', 'full_name')
                        ->getOptionLabelFromRecordUsing(fn (PatientDetails $record) => "{$record->full_name} - {$record->email}")
                        ->preload()
                        ->searchable()
                        ->required(),
                    Textarea::make('health_concerns')
                        ->required()
                        ->rows(5)
                        ->cols(10),
                    Toggle::make('is_paid')
                        ->inline(false)
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                LayoutSplit::make([
                    Stack::make([
                        TextColumn::make('timeSlots.doctor.name')
                        ->sortable()
                        ->searchable()

                        ,
                        TextColumn::make('timeSlots.date'),
                        TextColumn::make('timeSlots.time')
                        ->dateTime('h:i A'),

                    ])->space(2),
                    Stack::make([
                        TextColumn::make('patient.full_name'),
                        TextColumn::make('patient.email'),

                    ])->space(1),
                    TextColumn::make('health_concerns')
                        ->limit(10)
                        ->label('Health Concerns'),
                    ToggleColumn::make('is_paid')
                        //  ->onIcon('heroicon-s-currency-rupee')
                        // ->offIcon('heroicon-o-currency-rupee')
                        ->inline(false)
                    //
                ])

            ])
            ->filters([
                //IsAvailable
                Filter::make('is_paid')
                    ->query(fn (Builder $query): Builder => $query->where('is_paid', true)),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListConsultations::route('/'),
            'create' => Pages\CreateConsultation::route('/create'),
            'edit' => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }
}
