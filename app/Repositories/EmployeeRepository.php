<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;


class EmployeeRepository
{

    public function makeEmployeeAccountDataFormat($data,$action = false){
        $employeeAccountData['role_id']     = $data['role_id'];
        if($action != 'update'){
            $employeeAccountData['password']    = Hash::make($data['password']);
        }
        $employeeAccountData['user_name']   = $data['user_name'];
        $employeeAccountData['status']      = $data['status'];
        $employeeAccountData['created_by']  = Auth::user()->user_id;
        $employeeAccountData['updated_by']  = Auth::user()->user_id;

        return $employeeAccountData;
    }


    public function makeEmployeePersonalInformationDataFormat($data){
       
        $employeeData['first_name']                     = $data['first_name'];
        $employeeData['last_name']                      = $data['last_name'];
        $employeeData['finger_id']                      = $data['finger_id'];
        //$employeeData['department_id']                  = $data['department_id'];
        $employeeData['designation_id']                 = $data['designation_id'];
        $employeeData['branch_id']                   = $data['branch_id'];  // this field remove as per as client requirement 
        $employeeData['supervisor_id']                  = $data['supervisor_id']; // this is reporting or superior 
        // $employeeData['work_shift_id']               = $data['work_shift_id'];
        $employeeData['pay_grade_id']                   = $data['pay_grade_id']; //this is pay grade name
        // $employeeData['hourly_salaries_id']          = $data['hourly_salaries_id']; // this field remove as per as client requirement 
        $employeeData['email']                          = $data['email'];
        $employeeData['date_of_birth']                  = dateConvertFormtoDB($data['date_of_birth']);
        $employeeData['date_of_joining']                = dateConvertFormtoDB($data['date_of_joining']);
        $employeeData['date_of_leaving']                = dateConvertFormtoDB($data['date_of_leaving']);
        $employeeData['marital_status']                 = $data['marital_status'];
        $employeeData['present_address']                = $data['present_address'];
        $employeeData['emergency_contacts']             = $data['emergency_contacts'];
        $employeeData['gender']                         = $data['gender'];
        $employeeData['religion']                       = $data['religion'];
        $employeeData['phone']                          = $data['phone'];
        $employeeData['permanent_status']               = $data['permanent_status'];
        $employeeData['status']                         = $data['status'];
        $employeeData['nid']                            = $data['nid'];

        $employeeData['spouse_name']                    = $data['spouse_name'];
        $employeeData['spouse_nid']                     = $data['spouse_nid'];
        $employeeData['spouse_birth_certificate_no']    = $data['spouse_birth_certificate_no'];
        $employeeData['spouse_date_of_birth']           = dateConvertFormtoDB($data['spouse_date_of_birth']);

        $employeeData['etin_number']                    = $data['etin_number'];
        $employeeData['gpf_number']                     = $data['gpf_number'];
        $employeeData['freedom_fighter']                = $data['freedom_fighter'];
        $employeeData['permanent_address']              = $data['permanent_address'];
        $employeeData['father_name']                    = $data['father_name'];
        $employeeData['mother_name']                    = $data['mother_name'];
        $employeeData['fixation_verification_number']   = $data['fixation_verification_number'];
        $employeeData['present_increement_salary']      = $data['present_increement_salary'];

        // bangla entry data
        $employeeData['bangla_first_name']              = $data['bangla_first_name'];
        $employeeData['bangla_last_name']               = $data['bangla_last_name'];
        $employeeData['bangla_father_name']             = $data['bangla_father_name'];
        $employeeData['bangla_mother_name']             = $data['bangla_mother_name'];
        $employeeData['bangla_spouse_name']             = $data['bangla_spouse_name'];

        $employeeData['created_by']                     = Auth::user()->user_id;
        $employeeData['updated_by']                     = Auth::user()->user_id;

        return $employeeData;
    }


    public function makeChildInformationDataFormat($data,$employee_id,$action = false){
        $childData = [];
        if(isset($data['child_name'])) {
            for ($i=0; $i < count($data['child_name']); $i++) {
                $childData[$i] =[
                    'employee_id'       => $employee_id,
                    'child_name'         => $data['child_name'][$i],
                    'child_date_of_birth'  => dateConvertFormtoDB($data['child_date_of_birth'][$i]),
                    'child_nid_number'            => $data['child_nid_number'][$i],
                    'birth_certificate_number'      => $data['birth_certificate_number'][$i]
                ];
                if($action == 'update'){
                    $childData[$i]['childInformation_cid'] = $data['childInformation_cid'][$i];
                }
            }
        }
        return $childData;
    }


   public function makeEmployeeEducationDataFormat($data,$employee_id,$action = false){
        $educationData = [];
        if(isset($data['institute'])) {
            for ($i=0; $i < count($data['institute']); $i++) {
                $educationData[$i] =[
                    'employee_id'       => $employee_id,
                    'institute'         => $data['institute'][$i],
                    'board_university'  => $data['board_university'][$i],
                    'degree'            => $data['degree'][$i],
                    'passing_year'      => $data['passing_year'][$i],
                    'result'            => $data['result'][$i],
                    'cgpa'              => $data['cgpa'][$i],
                ];
                if($action == 'update'){
                    $educationData[$i]['educationQualification_cid'] = $data['educationQualification_cid'][$i];
                }
            }
        }
        return $educationData;
    } 


    public function makeEmployeeExperienceDataFormat($data,$employee_id,$action = false){
        $experienceData = [];
        if(isset($data['organization_name'])) {
            for ($i = 0; $i < count($data['organization_name']); $i++) {
                $experienceData[$i] = [
                    'employee_id'           => $employee_id,
                    'organization_name'     => $data['organization_name'][$i],
                    'designation'           => $data['designation'][$i],
                    'from_date'             => dateConvertFormtoDB($data['from_date'][$i]),
                    'to_date'               => dateConvertFormtoDB($data['to_date'][$i]),
                    'responsibility'        => $data['responsibility'][$i],
                    'skill'                 => $data['skill'][$i],
                ];
                if($action == 'update'){
                    $experienceData[$i]['employeeExperience_cid'] = $data['employeeExperience_cid'][$i];
                }
            }
        }
        return $experienceData;
    }


    public function makeLogisticInformationDataFormat($data,$employee_id,$action = false){
        $logicticData = [];
        if(isset($data['logistic_name'])) {
            for ($i=0; $i < count($data['logistic_name']); $i++) {
                $logicticData[$i]           =[
                    'employee_id'           => $employee_id,
                    'logistic_type'         => $data['logistic_type'][$i],
                    'logistic_name'         => $data['logistic_name'][$i],
                    'logistic_reference_no' => $data['logistic_reference_no'][$i],
                    'logistic_quantity'     => $data['logistic_quantity'][$i],
                    'logistic_date'         => dateConvertFormtoDB($data['logistic_date'][$i])
                ];
                if($action == 'update'){
                    $logicticData[$i]['logisticInformation_cid'] = $data['logisticInformation_cid'][$i];
                }
            }
        }
        return $logicticData;
    }

}
