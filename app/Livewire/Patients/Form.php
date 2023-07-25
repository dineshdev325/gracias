<?php

namespace App\Livewire\Patients;

use App\Models\Consultation;
use App\Models\PatientDetails;
use App\Models\TimeSlot;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Form extends Component
{
  #[Rule('required || alpha ||max:255')]
  public $fullName;

  #[Rule('required || email')]
  public $email;

  #[Rule('required ')]
  public $phoneNumber;

  #[Rule('required ')]
  public $healthConcerns;

  //INSERT DATA INTO PATIENT AND CONSULTATION DETAILS 
  public function patient_details()
  {
    $this->validate();

    //GET SESSION DATA
    $selectedDoctor = session()->get('selectedDoctor');
    $selectedDate = session()->get('selectedDate');
    $selectedTime = session()->get('selectedTime');

    //INSERT PATIENTS DATA
    $patient = PatientDetails::create([
      'full_name' => $this->fullName,
      'email' => $this->email,
      'phone_number' => $this->phoneNumber
    ]);
    $patientId = $patient->id;
    $timeSlotId = TimeSlot::where('doctors_id', $selectedDoctor)->where('time', $selectedTime)->whereDate('date', $selectedDate)->pluck('id');

    // INSERT CONSULTATION DATA
    $consultation = Consultation::create([
      'time_slots_id' => $timeSlotId[0],
      'patient_details_id' => $patientId,
      'health_concerns' => $this->healthConcerns

    ]);

    $consultationId = $consultation->id;
    if ($consultationId) {
      session(['consultationId' => $consultationId]);
      return redirect()->to('/confirm');
    }
  }
  public function render()
  {
    return view('livewire.patients.form');
  }
}
