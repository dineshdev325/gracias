<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;
    protected $fillable=['date','doctors_id','time','is_available'];
    public function consultation()
    {
        return $this->hasMany(TimeSlot::class,'consultations_id');
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'doctors_id');
    }
}
