<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    protected $table = 'employee_attendance';
    protected $primaryKey = 'employee_attendance_id';
    protected $fillable = ['finger_print_id','in_out_time','check_type','verify_code','sensor_id','Memoinfo','WorkCode','sn','UserExtFmt','mechine_sl','is_active'];

}
