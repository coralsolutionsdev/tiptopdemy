<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['appointment_time_slot_id', 'user_id', 'candidate_id', 'type', 'company_id', 'status', 'remarks'];

}
