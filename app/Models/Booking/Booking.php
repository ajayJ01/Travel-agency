<?php

namespace App\Models\Booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
     
    public function vendor_info(){
    return $this->hasOne('App\Models\Vendor\Vendor','id', 'vendor_id');
    }
    public function origin_info(){
        return $this->hasOne('App\Models\Airport', 'iata_code', 'origin');
    }
    public function destination_info(){
        return $this->hasOne('App\Models\Airport', 'iata_code', 'destination');
    }

}