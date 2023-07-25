<?php

namespace App\Livewire\Appointment;

use Carbon\Carbon;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Slot extends Component
{
    public $startTime;
    public $endTime;
    public $currentTime;
    public $timeSlots;
    #[Reactive]
    public $availableTimeSlots;
    #[Reactive]
    public $selectedDate;
    #[Reactive]
    public $selectedTime;
    public function mount()
    {
        $this->timeSlots = array();
        $this->currentTime = Carbon::now();
        $this->startTime = strtotime('05:30:00');
        $this->endTime = strtotime('23:30:00');
        for (
            $start = $this->startTime;
            $start <= $this->endTime;
            $start = $start + 30 * 60
        ) {
            array_push($this->timeSlots, $start);
        }
    }
    public function render()
    {
        return view('livewire.appointment.slot');
    }
}
