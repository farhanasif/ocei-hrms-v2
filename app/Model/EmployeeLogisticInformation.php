<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeLogisticInformation extends Model
{
    //
    protected $table = 'employee_logistic_info';
    protected $primaryKey = 'employee_logistic_id';
    protected $fillable = [
        'employee_logistic_id','employee_id','logistic_name','logistic_type','logistic_reference_no','logistic_quantity','logistic_date','logistic_file'
    ];

}
