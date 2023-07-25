<?php

namespace App\Livewire\Appointment;

use App\Models\TimeSlot;
use Carbon\Carbon;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Month extends Component
{

    public $month;

    #[Reactive]
    public $selectedDate;

    #[Reactive]
    public $days;

    public function mount($selectedDate, $days)
    {
        $this->month = Carbon::parse('2023-07-22')->format('F');
        $this->selectedDate = $selectedDate;
        $this->days = $days;
    }
    public function render()
    {
        return view('livewire.appointment.month');
    }
}
