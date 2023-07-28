<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $activeNavigationIcon = 'heroicon-s-user';


    protected static ?string $navigationGroup = 'Doctor Management';

    public static function form(Form $form): Form
    {
            return $form
            ->schema([
                Card::make()
                   ->schema([
                    // Doctor table fields
                TextInput::make('name')
                ->required()
                ->minValue(1)
                ->maxValue(255),
                TextInput::make('whatsapp_number')
                ->numeric()
                ->required()
                ->minLength(10)
                ->maxLength(10),
                Textarea::make('specialization')
                ->required()
                   ->rows(5)
                   ->cols(10),
                TextInput::make('amount')
                 ->numeric()
                 ->required(),
              TextInput::make('image')
                // FileUpload::make('image')
                //     ->image()
                //     ->disk('s3')
                //     ->directory('form-attachments')
                //     ->imageResizeMode('cover')
                //     ->imageCropAspectRatio('16:9')
                //     ->imageResizeTargetWidth('1920')
                //     ->imageResizeTargetHeight('1080'),

            ])
                   ])
                   ->columns(2); 
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
            ->searchable()
            ->sortable(),
            TextColumn::make('specialization')
            ->limit(50),
            TextColumn::make('amount')
            ->sortable()
            
        ])
        ->filters([
             
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }    
}
