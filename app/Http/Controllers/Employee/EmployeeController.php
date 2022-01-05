<?php

namespace App\Http\Controllers\Employee;

use App\Model\EmployeeEducationQualification;

use App\Http\Requests\EmployeeRequest;

use App\Repositories\EmployeeRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Model\EmployeeExperience;

use App\Model\EmployeeChildInformation;
use App\Model\EmployeePerformance;
use Illuminate\Http\Request;

use App\Model\HourlySalary;

use App\Model\Department;

use App\Model\Designation;

use App\Model\WorkShift;

use App\Model\PayGrade;

use App\Model\Employee;
use App\Model\Logistic;
use App\Model\Branch;
use App\Model\EmployeeLogisticInformation;
use App\Model\Role;



use App\User;


class EmployeeController extends Controller
{

    protected $employeeRepositories;

    public function __construct(EmployeeRepository $employeeRepositories)
    {
        $this->employeeRepositories = $employeeRepositories;
    }


    public function index(Request $request)
    {
        $departmentList     = Department::get();
        $branchList         = Branch::get();
        $designationList    = Designation::get();
        $roleList           = Role::get();


        $results = Employee::with(['userName' => function ($q) {
            $q->with('role');
        }, 'department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries'])
            ->orderBy('finger_id', 'ASC')->paginate(10);

        if (request()->ajax()) {
            if ($request->role_id != '') {
                $results = Employee::whereHas('userName', function ($q) use ($request) {
                    $q->with('role')->where('role_id', $request->role_id);
                })->with('department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries')->orderBy('finger_id', 'ASC');
            } else {
                $results = Employee::with(['userName' => function ($q) {
                    $q->with('role');
                }, 'department', 'designation', 'branch', 'payGrade', 'supervisor', 'hourlySalaries'])->orderBy('finger_id', 'ASC');
            }

            if ($request->department_id != '') {
                $results->where('department_id', $request->department_id);
            }

            if ($request->designation_id != '') {
                $results->where('designation_id', $request->designation_id);
            }

            if($request->branch_id != '') {
                $results->where('branch_id', $request->branch_id);
            }

            if ($request->employee_name != '') {
                $results->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->employee_name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->employee_name . '%');
                });
            }

            $results = $results->paginate(10);
            return   View('admin.employee.employee.pagination', ['results' => $results])->render();
        }

        return view('admin.employee.employee.index', ['results' => $results, 'departmentList' => $departmentList, 'designationList' => $designationList, 'roleList' => $roleList, 'branchList' => $branchList]);
    }


    public function create()
    {
        $userList               = User::where('status', 1)->get();
        $roleList               = Role::get();
        $departmentList         = Department::get();
        $designationList        = Designation::get();
        $branchList             = Branch::get();
        $logisticList           = Logistic::get();
        $workShiftList          = WorkShift::get();
        $supervisorList         = Employee::where('status', 1)->get();
        $payGradeList           = PayGrade::all();
        $hourlyPayGradeList     = HourlySalary::all();
        $presentPayGradeSalary  = DB::table('present_pay_grade_salary')->get();
        // dd($presentPayGradeSalary);

        $data = [
            'userList'              => $userList,
            'roleList'              => $roleList,
            'departmentList'        => $departmentList,
            'designationList'       => $designationList,
            'branchList'            => $branchList,
            'logisticList'          => $logisticList,
            'supervisorList'        => $supervisorList,
            'workShiftList'         => $workShiftList,
            'payGradeList'          => $payGradeList,
            'hourlyPayGradeList'    => $hourlyPayGradeList,
            'presentPayGradeSalary' => $presentPayGradeSalary,
        ];

        return view('admin.employee.employee.addEmployee', $data);
    }
    
    public function payGradeWiseSalary($pay_grade_id)
    {
        $pay_grade_salary = DB::table('present_pay_grade_salary')->where('pay_grade_id',$pay_grade_id)->get();
        $code = 404;
        $msg = 'No Data Found';
        if($pay_grade_salary != null) {
            $code = 200;
            $msg = 'Success';
        }

        return response()->json(['code' => $code,'msg'=> $msg,'data'=> $pay_grade_salary]);
    }

    public function store(EmployeeRequest $request)
    {
        // dd($request->all());

        $photo = $request->file('photo');
        if ($photo) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads/employeePhoto/', $imgName);
            $employeePhoto['photo'] = $imgName;
        }
        $employeeDataFormat  = $this->employeeRepositories->makeEmployeePersonalInformationDataFormat($request->all());
        if (isset($employeePhoto)) {
            $employeeData = $employeeDataFormat + $employeePhoto;
        } else {
            $employeeData = $employeeDataFormat;
        }

        $spouse_nid_or_birth_certificate = $request->file('spouse_nid_or_birth_certificate');
        if ($spouse_nid_or_birth_certificate) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('spouse_nid_or_birth_certificate')) . '.' . $request->file('spouse_nid_or_birth_certificate')->getClientOriginalExtension();
            $request->file('spouse_nid_or_birth_certificate')->move('uploads/employeeSpouseBirthCertificate/', $imgName);
            $employeeSpouseBirthCertificate['spouse_nid_or_birth_certificate'] = $imgName;
        }

        if (isset($employeeSpouseBirthCertificate)) {
            $employeeData = $employeeData + $employeeSpouseBirthCertificate;
        } else {
            $employeeData = $employeeData;
        }

        // logistic file upload 
        $logistic_file = $request->file('logistic_file');
        if ($logistic_file) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('logistic_file')) . '.' . $request->file('logistic_file')->getClientOriginalExtension();
            $request->file('logistic_file')->move('uploads/employeeLogisticFile/', $imgName);
            $employeeLogisticFile['logistic_file'] = $imgName;
        }

        if (isset($employeeLogisticFile)) {
            $employeeData = $employeeData + $employeeLogisticFile;
        } else {
            $employeeData = $employeeData;
        }

        // dd($employeeData);

        try {
            DB::beginTransaction();

            $employeeAccountDataFormat  = $this->employeeRepositories->makeEmployeeAccountDataFormat($request->all());
            $parentData = User::create($employeeAccountDataFormat);

            $employeeData['user_id'] = $parentData->user_id;
            $childData = Employee::create($employeeData);

            $employeeLogisticData  = $this->employeeRepositories->makeLogisticInformationDataFormat($request->all(), $childData->employee_id);
            if (count($employeeLogisticData) > 0) {
                EmployeeLogisticInformation::insert($employeeLogisticData);
            }

            $employeeChildData  = $this->employeeRepositories->makeChildInformationDataFormat($request->all(), $childData->employee_id);
            if (count($employeeChildData) > 0) {
                EmployeeChildInformation::insert($employeeChildData);
            }

            $employeeEducationData  = $this->employeeRepositories->makeEmployeeEducationDataFormat($request->all(), $childData->employee_id);
            if (count($employeeEducationData) > 0) {
                EmployeeEducationQualification::insert($employeeEducationData);
            }

            $employeeExperienceData  = $this->employeeRepositories->makeEmployeeExperienceDataFormat($request->all(), $childData->employee_id);
            if (count($employeeExperienceData) > 0) {
                EmployeeExperience::insert($employeeExperienceData);
            }

            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            // dd($e);
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect('employee')->with('success', 'Employee information successfully saved.');
        } else {
            return redirect('employee')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id)
    {
        $userList               = User::where('status', 1)->get();
        $roleList               = Role::get();
        $departmentList         = Department::get();
        $designationList        = Designation::get();
        $branchList             = Branch::get();
        $supervisorList         = Employee::where('status', 1)->get();
        $editModeData           = Employee::findOrFail($id);
        $workShiftList          = WorkShift::get();
        $payGradeList           = PayGrade::all();
        $hourlyPayGradeList     = HourlySalary::all();
        $presentPayGradeSalary  = DB::table('present_pay_grade_salary')->where('pay_grade_id',$editModeData->pay_grade_id)->get();

        $employeeAccountEditModeData        = User::where('user_id', $editModeData->user_id)->first();
        $educationQualificationEditModeData = EmployeeEducationQualification::where('employee_id', $id)->get();
        $experienceEditModeData             = EmployeeExperience::where('employee_id', $id)->get();
        $childEditModeData                  = EmployeeChildInformation::where('employee_id', $id)->get();
        $logisticEditModeData               = EmployeeLogisticInformation::where('employee_id', $id)->get();
        // dd($editModeData);

        $data = [
            'userList'              => $userList,
            'roleList'              => $roleList,
            'departmentList'        => $departmentList,
            'designationList'       => $designationList,
            'branchList'            => $branchList,
            'supervisorList'        => $supervisorList,
            'workShiftList'         => $workShiftList,
            'payGradeList'          => $payGradeList,
            'editModeData'          => $editModeData,
            'hourlyPayGradeList'    => $hourlyPayGradeList,
            'employeeAccountEditModeData'           => $employeeAccountEditModeData,
            'educationQualificationEditModeData'    => $educationQualificationEditModeData,
            'experienceEditModeData'                => $experienceEditModeData,
            'childEditModeData'                     => $childEditModeData,
            'logisticEditModeData'                  => $logisticEditModeData,
            'presentPayGradeSalary'                 => $presentPayGradeSalary,
        ];

        return view('admin.employee.employee.editEmployee', $data);
    }


    public function update(EmployeeRequest $request, $id)
    {
        // dd($request->all());

        $employee = Employee::findOrFail($id);
        $photo = $request->file('photo');
        if ($photo) {
            // dd($photo);
            $imgName = md5(str_random(30) . time() . '_' . $request->file('photo')) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->move('uploads/employeePhoto/', $imgName);
            if (file_exists('uploads/employeePhoto/' . $employee->photo) and !empty($employee->photo)) {
                unlink('uploads/employeePhoto/' . $employee->photo);
            }
            $employeePhoto['photo'] = $imgName;
            // dd($employeePhoto['photo']);
        }


        $spouse_nid_or_birth_certificate = $request->file('spouse_nid_or_birth_certificate');
        if ($spouse_nid_or_birth_certificate) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('spouse_nid_or_birth_certificate')) . '.' . $request->file('spouse_nid_or_birth_certificate')->getClientOriginalExtension();
            $request->file('spouse_nid_or_birth_certificate')->move('uploads/employeeSpouseBirthCertificate/', $imgName);
            if (file_exists('uploads/employeeSpouseBirthCertificate/' . $employee->spouse_nid_or_birth_certificate) and !empty($employee->spouse_nid_or_birth_certificate)) {
                unlink('uploads/employeeSpouseBirthCertificate/' . $employee->spouse_nid_or_birth_certificate);
            }
            $employeeSpouseBirthCertificate['spouse_nid_or_birth_certificate'] = $imgName;
        }

        // logistic file upload
        $logistic_file = $request->file('logistic_file');
        if ($logistic_file) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('logistic_file')) . '.' . $request->file('logistic_file')->getClientOriginalExtension();
            $request->file('logistic_file')->move('uploads/employeeLogisticFile/', $imgName);
            if (file_exists('uploads/employeeLogisticFile/' . $employee->logistic_file) and !empty($employee->logistic_file)) {
                unlink('uploads/employeeLogisticFile/' . $employee->logistic_file);
            }
            $employeeLogisticFile['logistic_file'] = $imgName;
        }


        // dd('ok');
        $employeeDataFormat  = $this->employeeRepositories->makeEmployeePersonalInformationDataFormat($request->all());
        if (isset($employeePhoto)) {
            $employeeData = $employeeDataFormat + $employeePhoto;
        } else {
            $employeeData = $employeeDataFormat;
        }

        if (isset($employeeSpouseBirthCertificate)) {
            $employeeData = $employeeData + $employeeSpouseBirthCertificate;
        } else {
            $employeeData = $employeeData;
        }

        // dd($employeeData);

        if (isset($employeeLogisticFile)) {
            $employeeData = $employeeData + $employeeLogisticFile;
        } else {
            $employeeData = $employeeData;
        }

        // dd($employeeData);

        try {
            DB::beginTransaction();

            $employeeAccountDataFormat  = $this->employeeRepositories->makeEmployeeAccountDataFormat($request->all(), 'update');
            User::where('user_id', $employee->user_id)->update($employeeAccountDataFormat);

            // dd($employeeData);
            // Update Personal Information
            $employee->update($employeeData);

            // Delete Logistic information
            EmployeeLogisticInformation::whereIn('employee_logistic_id', explode(',', $request->delete_logistic_information_cid))->delete();

            // Update Logistic information
            $employeeLogisticData  = $this->employeeRepositories->makeLogisticInformationDataFormat($request->all(), $id, 'update');
            foreach ($employeeLogisticData as $logisticValue) {
                $cid = $logisticValue['logisticInformation_cid'];
                unset($logisticValue['logisticInformation_cid']);
                if ($cid != "") {
                    EmployeeLogisticInformation::where('employee_logistic_id', $cid)->update($logisticValue);
                } else {
                    $logisticValue['employee_id'] = $id;
                    EmployeeLogisticInformation::create($logisticValue);
                }
            }

            // Delete child information
            EmployeeChildInformation::whereIn('employee_education_qualification_id', explode(',', $request->delete_child_information_cid))->delete();

            // Update child information
            $employeeChildData  = $this->employeeRepositories->makeChildInformationDataFormat($request->all(), $id, 'update');
            foreach ($employeeChildData as $childValue) {
                $cid = $childValue['childInformation_cid'];
                unset($childValue['childInformation_cid']);
                if ($cid != "") {
                    EmployeeChildInformation::where('employee_education_qualification_id', $cid)->update($childValue);
                } else {
                    $childValue['employee_id'] = $id;
                    EmployeeChildInformation::create($childValue);
                }
            }


            // Delete education qualification
            EmployeeEducationQualification::whereIn('employee_education_qualification_id', explode(',', $request->delete_education_qualifications_cid))->delete();

            // Update Education Qualification
            $employeeEducationData  = $this->employeeRepositories->makeEmployeeEducationDataFormat($request->all(), $id, 'update');
            foreach ($employeeEducationData as $educationValue) {
                $cid = $educationValue['educationQualification_cid'];
                unset($educationValue['educationQualification_cid']);
                if ($cid != "") {
                    EmployeeEducationQualification::where('employee_education_qualification_id', $cid)->update($educationValue);
                } else {
                    $educationValue['employee_id'] = $id;
                    EmployeeEducationQualification::create($educationValue);
                }
            }

            // Delete experience
            EmployeeExperience::whereIn('employee_experience_id', explode(',', $request->delete_experiences_cid))->delete();

            // Update Education Qualification
            $employeeExperienceData  = $this->employeeRepositories->makeEmployeeExperienceDataFormat($request->all(), $id, 'update');
            if (count($employeeExperienceData) > 0) {
                foreach ($employeeExperienceData as $experienceValue) {
                    $cid = $experienceValue['employeeExperience_cid'];
                    unset($experienceValue['employeeExperience_cid']);
                    if ($cid != "") {
                        EmployeeExperience::where('employee_experience_id', $cid)->update($experienceValue);
                    } else {
                        $experienceValue['employee_id'] = $id;
                        EmployeeExperience::create($experienceValue);
                    }
                }
            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Employee information successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function show($id)
    {

        $data['employeeInfo']           = Employee::where('employee.employee_id', $id)->first();
        $data['employeeExperience']     = EmployeeExperience::where('employee_id', $id)->get();
        $data['employeeEducation']      = EmployeeEducationQualification::where('employee_id', $id)->get();
        $data['employeeChildData']      = EmployeeChildInformation::where('employee_id', $id)->get();
        $data['employeeLogisticData']   = EmployeeLogisticInformation::where('employee_id', $id)->get();

        $data['othersInfo'] = DB::table('employee')
            ->select('employee.*', 'department.department_name as department_name', 'designation.designation_name as designation_name', 'pay_grade.*')
            ->leftjoin('department', 'employee.department_id', '=', 'department.department_id')
            ->leftjoin('designation', 'employee.designation_id', '=', 'designation.designation_id')
            ->leftjoin('pay_grade', 'employee.pay_grade_id', '=', 'pay_grade.pay_grade_id')
            ->where('employee.employee_id', $id)
            ->first();

        $data['present_salary'] = DB::table('employee')->select('prg.*')
                                    ->join('present_pay_grade_salary as prg','prg.present_pay_grade_salary_id','=','employee.present_increement_salary')
                                    ->where('employee.employee_id', session('logged_session_data.employee_id'))
                                    ->first();
                                    
        $data['traningInfo'] = DB::table('training_info')
            ->select('training_info.*', 'training_type.training_type_name as training_type_name')
            ->leftjoin('training_type', 'training_info.training_type_id', '=', 'training_type.training_type_id')
            ->where('training_info.employee_id', $id)
            ->get();

        $data['criteriaDataFormat'] = EmployeePerformance::select(
            'employee_performance.employee_id',
            'employee_performance.month',
            'employee_performance.employee_performance_id',
            'employee_performance_details.performance_criteria_id',
            'employee_performance_details.rating',
            'employee_performance_details.judgement',
            'employee_performance_details.comments',
            'employee.first_name',
            'employee.last_name',
            'performance_criteria.performance_criteria_name',
            'performance_criteria.performance_category_id',
            'performance_category.performance_category_name',
            'department.department_name'
        )
            ->join('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
            ->join('performance_criteria', 'performance_criteria.performance_criteria_id', '=', 'employee_performance_details.performance_criteria_id')
            ->join('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->join('department', 'department.department_id', '=', 'employee.department_id')
            ->where('employee.employee_id', $id)
            ->get()->toArray();

        $data['employeeAward'] = DB::table('employee_award')->where('employee_id', $id)->first();
        $data['promotionInfo'] = DB::table('promotion')->where('employee_id', $id)->first();

        $pay_grade_id_from_employee = $data['employeeInfo']->pay_grade_id;

        $data['house_rent_from_pay_grade'] =  DB::table('pay_grade')->where('pay_grade_id', $pay_grade_id_from_employee)->first()->house_rent_of_basic_salary;

        $data['totalSalaryWithAllowance'] = DB::table('allowance')
            ->select('allowance.*')
            ->leftjoin('pay_grade_to_allowance', 'allowance.allowance_id', '=', 'pay_grade_to_allowance.allowance_id')
            ->where('pay_grade_to_allowance.pay_grade_id', $pay_grade_id_from_employee)
            ->get();

        //     return view('admin.user.user.profile',
        //     [
        //     'employeeChildData'=>$employeeChildData,
        //     'employeeInfo'=>$employeeInfo,
        //     'employeeExperience'=>$employeeExperience,
        //     'employeeEducation'=>$employeeEducation
        // ]);

        return view('admin.user.user.profile', $data);
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $data = Employee::FindOrFail($id);
            if (!is_null($data->photo)) {
                if (file_exists('uploads/employeePhoto/' . $data->photo) and !empty($data->photo)) {
                    unlink('uploads/employeePhoto/' . $data->photo);
                }
            }
            if (!is_null($data->spouse_nid_or_birth_certificate)) {
                if (file_exists('uploads/employeePhoto/' . $data->spouse_nid_or_birth_certificate) and !empty($data->spouse_nid_or_birth_certificate)) {
                    unlink('uploads/employeePhoto/' . $data->spouse_nid_or_birth_certificate);
                }
            }
            if (!is_null($data->logistic_file)) {
                if (file_exists('uploads/employeeLogisticFile/' . $data->logistic_file) and !empty($data->logistic_file)) {
                    unlink('uploads/employeeLogisticFile/' . $data->logistic_file);
                }
            }

            $result = $data->delete();
            if ($result) {
                DB::table('user')->where('user_id', $data->user_id)->delete();
                DB::table('employee_child_information')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_education_qualification')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_child_information')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_experience')->where('employee_id', $data->employee_id)->delete();
                DB::table('employee_attendance')->where('finger_print_id', $data->finger_id)->delete();
                DB::table('employee_award')->where('employee_id', $data->employee_id)->delete();

                DB::table('employee_bonus')->where('employee_id', $data->employee_id)->delete();

                DB::table('promotion')->where('employee_id', $data->employee_id)->delete();

                DB::table('salary_details')->where('employee_id', $data->employee_id)->delete();

                DB::table('training_info')->where('employee_id', $data->employee_id)->delete();

                DB::table('warning')->where('warning_to', $data->employee_id)->delete();

                DB::table('leave_application')->where('employee_id', $data->employee_id)->delete();

                DB::table('employee_performance')->where('employee_id', $data->employee_id)->delete();

                DB::table('termination')->where('terminate_to', $data->employee_id)->delete();

                DB::table('notice')->where('created_by', $data->employee_id)->delete();

                DB::table('employee_logistic_info')->where('employee_id', $data->employee_id)->delete();
            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            return $e;
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }
}
