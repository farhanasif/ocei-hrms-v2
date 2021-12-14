<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'employee_id','user_id','finger_id','department_id','designation_id','branch_id','supervisor_id','work_shift_id','email','first_name',
        'last_name','date_of_birth','date_of_joining','date_of_leaving','gender','marital_status',
        'photo','present_address','emergency_contacts','phone','status','created_by','updated_by','religion','pay_grade_id','hourly_salaries_id','permanent_status','nid',
        'spouse_name','spouse_nid','spouse_birth_certificate_no','spouse_date_of_birth','spouse_nid_or_birth_certificate','logistic_file',
        'etin_number','gpf_number','freedom_fighter','permanent_address','father_name','mother_name','fixation_verification_number',
        'present_increement_salary','bangla_first_name','bangla_last_name','bangla_father_name','bangla_mother_name','bangla_spouse_name'
    ];

    public function userName(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function designation(){
        return $this->belongsTo(Designation::class,'designation_id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id');
    }

    public function payGrade(){
        return $this->belongsTo(PayGrade::class,'pay_grade_id');
    }

    public function supervisor(){
        return $this->belongsTo(Employee::class,'supervisor_id');
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function hourlySalaries(){
        return $this->belongsTo(HourlySalary::class,'hourly_salaries_id');
    }

}
