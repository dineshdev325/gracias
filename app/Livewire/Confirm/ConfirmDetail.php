<?php

namespace App\Livewire\Confirm;

use App\Models\Consultation;
use Livewire\Component;

class ConfirmDetail extends Component
{
    public $consultationId;
    public $consultationDetails;
    public function mount()
    {
        $this->consultationId = session()->get('consultationId');
        $this->consultationDetails = Consultation::with('patient', 'timeSlots', 'timeSlots.doctor')->where('id', '=', $this->consultationId)->get();
        // dd($this->consultationDetails);
        // dd($this->consultation_id);
    }
    public function render()
    {
        return view('livewire.confirm.confirm-detail');
    }
}
