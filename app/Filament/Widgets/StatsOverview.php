<?php

namespace App\Filament\Widgets;

use App\Models\Doctor;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    protected function getCards(): array
    {
        return [
            //TOTAL DOCTORS
            Card::make('Total Doctors', Doctor::count()),

            //TOTAL PAYMENTS
            Card::make('Total Revenue','₹ '. Payment::where('payment_status', 'success')->sum('amount'))
        ];
    }
}
