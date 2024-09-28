<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $table = 'general_settings';

    protected $casts = [
                        'service_charge' => 'double',
                        'gst_applied' => 'double',
                    ];
}
