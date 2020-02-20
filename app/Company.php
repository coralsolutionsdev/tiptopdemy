<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'emails', 'phone_numbers', 'faxes',
        'addresses', 'postcode', 'city', 'state',
        'country_code', 'description', 'vision', 'mission',
        'leave_Settings', 'status', 'logo', 'dropbox_token', 'website',
        'old_email_data','industry', 'company_size', 'registration_no',
        'quotes_settings'];

    protected $casts = [
        'emails' => 'array',
        'phone_numbers' => 'array',
        'faxes' => 'array',
        'leave_Settings' => 'array',
    ];}
