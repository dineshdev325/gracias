<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $fillable = ['time_slots_id', 'patient_details_id',  'health_concerns', 'is_paid'];

     
    public function patient()
    {
        return $this->belongsTo(PatientDetails::class,'patient_details_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
      public function timeSlots()
    {
        return $this->belongsTo(TimeSlot::class,'time_slots_id');
    }
}
