<?php

namespace App\Livewire\Appointment;

use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Appointment extends Component
{
    public $carbon;
    // public $doctor_id;

    public $selectedDoctor;

    public $selectedDate;
    public $selectedTime;
    public $days;
    public $availableTimeSlots;
    public function mount()
    {
        $this->carbon = Carbon::now();
        $this->selectedDoctor = Session::get('selectedDoctor') ? Session::get('selectedDoctor') : 1;
        $this->selectedDate =
            $this->days = TimeSlot::where('doctors_id', $this->selectedDoctor)
            ->whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->first();

        $this->days = TimeSlot::where('doctors_id', $this->selectedDoctor)
            ->whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'asc')
            ->pluck('date')->unique();


        $this->availableTimeSlots = TimeSlot::where('doctors_id', $this->selectedDoctor)->where('date', $this->selectedDate)->where('is_available', true)->pluck('time')->toArray();
    }

    // STORE DATA TO DB
    #[On('goToPatient')]
    public function goToPatient()
    {
        if (isset($this->selectedTime)) {
            session(['selectedDoctor' => $this->selectedDoctor]);
            session(['selectedDate' =>   $this->selectedDate]);
            session(['selectedTime' => $this->selectedTime]);
            return $this->redirect('/patient', navigate: true);
        } else {
            Session::flash('message', 'Please Select time!');
        }
    }


    //LISTENING EVENT

    // SET DOCTOR
    #[On('setDoctor')]
    public function updateSelectedDoctor($selectedDoctor)
    {
        $this->selectedDoctor = $selectedDoctor;

        $this->days = TimeSlot::where('doctors_id', $this->selectedDoctor)
            ->whereDate('date', '>=', Carbon::now())
            ->pluck('date')->unique();

        $this->availableTimeSlots = TimeSlot::where('doctors_id', $this->selectedDoctor)->where('date', $this->selectedDate)->where('is_available', true)->pluck('time')->toArray();
    }

    //SET DATE
    #[On('setDate')]
    public function updateSelectedDate($selectedDate)
    {
        $this->selectedDate = $selectedDate;

        $this->availableTimeSlots = TimeSlot::where('doctors_id', $this->selectedDoctor)->where('date', $this->selectedDate)->where('is_available', true)->pluck('time')->toArray();
    }

    //SET TIME
    #[On('setTime')]
    public function updateSelectedTime($selectedTime)
    {
        $this->selectedTime = date('H:i:s', $selectedTime);
        
    }
    public function render()
    {
        return view('livewire.appointment.appointment');
    }
}
