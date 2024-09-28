<?php

namespace App\Models\apitype;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apitype extends Model
{
    use HasFactory;
    protected $table = 'api_types';
    protected $fillable =[
      'name'
    ];
}
