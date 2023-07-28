<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Consultation;
use App\Models\PatientDetails;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Split;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split as LayoutSplit;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;


    protected static ?string $navigationIcon = 'heroicon-o-currency-rupee';
    protected static ?string $activeNavigationIcon = 'heroicon-s-currency-rupee';


    protected static ?string $navigationGroup = 'Appointment Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('patient_details_id')
                    ->relationship('patient', 'full_name')
                    ->getOptionLabelFromRecordUsing(fn (PatientDetails $record) => "{$record->full_name} - {$record->email}")
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('consultations_id')
                    ->relationship('consultation', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Consultation $record) => "{$record->patient->full_name} - {$record->timeSlots->doctor->name}")
                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make('amount')
                    ->numeric()
                    ->required(),
                    DatePicker::make('payment_date')
                    ->displayFormat('d-m-Y')
                    ->required()
                    ,
                    TextInput::make('transaction_id ')
                    ->required(),
                Select::make('payment_status')
                    ->options([
                        'Success' => 'Success',
                        'Pending' => 'Pending',
                        'Failure' => 'Failure',
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                LayoutSplit::make([
                    Stack::make([
                        TextColumn::make('consultation.timeSlots.doctor.name')
                        ->searchable()
                        ->sortable(),
                        TextColumn::make('consultation.timeSlots.date'),
                        TextColumn::make('consultation.timeSlots.time')
                        ->dateTime('h:i A'),

                    ])->space(2),
                    Stack::make([
                        TextColumn::make('patient.full_name')
                        ->searchable()
                        ->sortable(),
                        TextColumn::make('patient.email'),

                    ])->space(1),
                    TextColumn::make('amount'),
                    TextColumn::make('transaction_id')
                        ->limit(10),
                   TextColumn::make('date'),
                   TextColumn::make('payment_status')
                   ->badge()
                   ->color(fn (string $state): string => match ($state) {
                       'Pending' => 'warning',
                       'Success' => 'success',
                       'Failure' => 'danger',
                   })
                ])

            ])
            ->filters([
                //
                SelectFilter::make('payment_status')
                ->options([
                    'Success' => 'Success',
                    'Pending' => 'Pending',
                    'Failure' => 'Failure',
                ])
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
