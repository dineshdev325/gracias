<?php

namespace App\Livewire\Appointment;

use App\Models\Doctor as ModelsDoctor;
use Livewire\Attributes\On;
use Livewire\Component;

class Doctor extends Component
{
    public $doctors;
    public $selectedDoctor;

    public function mount($selectedDoctor)
    {

        $this->doctors = ModelsDoctor::all();
        $this->selectedDoctor = $selectedDoctor;
    }

    public function render()
    {
        return view('livewire.appointment.doctor');
    }
}
