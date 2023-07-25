<?php

namespace App\Livewire\Details;

use Livewire\Component;

class Detail extends Component
{
    public $doctorDetail;
    public $selectedDate;
    public $selectedTime;
    public function mount()
    {
        $this->selectedDate = session()->get('selectedDate');
        $this->selectedTime = session()->get('selectedTime');
    }
    public function render()
    {
        return view('livewire.details.detail');
    }
}
