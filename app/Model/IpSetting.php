<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class IpSetting extends Model
{
    protected $table = 'ip_settings';

    protected $fillable = [
        'ip_address', 'ip_status','status'
    ];
}
