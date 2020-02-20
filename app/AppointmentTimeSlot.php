<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppointmentTimeSlot extends Model
{
    protected $fillable = ['appointment_id', 'start_time_stamp','end_time_stamp'];
}
