<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HolidayCalendar extends Model
{
    protected $table = 'holiday_file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'leave_id','image', 'year','is_active'
    ];
}
