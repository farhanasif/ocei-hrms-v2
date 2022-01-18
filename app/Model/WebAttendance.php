<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WebAttendance extends Model
{
    protected $table = 'view_employee_in_out_data';
    protected $primaryKey = 'employee_attendance_id';
    protected $fillable = ['employee_attendance_id','finger_print_id','in_time','out_time','date','working_time','late_time','basic_time','over_time'];

}
