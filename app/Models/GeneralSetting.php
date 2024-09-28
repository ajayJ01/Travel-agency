<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'site_name', 
        'email', 
        'phone', 
        'footer', 
        'currency_name', 
        'currency_code', 
        'support_phone', 
        'address', 
        'descreption', 
        'logo', 
        'favicon',
        'service_charge',
        'gst_applied',
        'email_config'
    ];
}
