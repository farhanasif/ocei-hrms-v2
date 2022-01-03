<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WhiteListedIp extends Model
{
    protected $table = 'white_listed_ips';

    protected $fillable = [
        'ip_setting_id', 'white_listed_ip'
    ];
}
