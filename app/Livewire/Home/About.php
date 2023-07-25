<?php

namespace App\Livewire\Home;

use App\Models\Doctor;
use Livewire\Component;

class About extends Component
{
  public $doctors;
  public function mount()
  {
    $this->doctors = Doctor::all();
  }
  public function goToAppointment($doctorId)
  {

    session(['selectedDoctor' => $doctorId]);
    return $this->redirect('/appointment', navigate: true);
  }
  public function render()
  {
    return view('livewire.home.about');
  }
}
