<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class EmployeeChildInformation extends Model
{
    protected $table = 'employee_child_information';
    protected $primaryKey = 'employee_child_information_id';
    protected $fillable = [
        'employee_education_qualification_id','employee_id','child_name','child_date_of_birth','child_nid_number','birth_certificate_number'
    ];
}
