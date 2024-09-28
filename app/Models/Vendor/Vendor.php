<?php

namespace App\Models\Vendor;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable=['name','code','contact_person','email','phone','doc_url','live_credentials','sandbox_credentials','live_url','sandbox_url','environment','commission','status'];




}
