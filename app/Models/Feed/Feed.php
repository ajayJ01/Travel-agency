<?php

namespace App\Models\Feed;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    use HasFactory;
    protected $fillable=['vendor_id','name','function_name','type','header_parameter','body_parameter','status'];

    public function vendorDetails(){
        return $this->hasOne('App\Models\Vendor\Vendor','id','vendor_id')->select('id','name');
    }
}
