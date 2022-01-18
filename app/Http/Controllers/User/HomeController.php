<?php

namespace App\Http\Controllers\User;

use App\Model\EmployeeEducationQualification;

use App\Repositories\AttendanceRepository;

use App\Http\Controllers\Controller;

use App\Model\EmployeePerformance;

use Illuminate\Support\Facades\DB;

use App\Model\EmployeeExperience;

use App\Model\LeaveApplication;

use App\Model\EmployeeAward;
use App\Model\EmployeeAttendance;
use App\Model\TrainingInfo;
use App\Model\EmployeeChildInformation;

use Illuminate\Http\Request;

use App\Model\Termination;

use App\Model\Department;

use App\Model\Employee;
use App\Model\EmployeeLogisticInformation;
use App\Model\Warning;

use App\Model\Notice;
use App\Model\IpSetting;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;


class HomeController extends Controller
{

    protected $employeePerformance, $leaveApplication, $notice, $employeeExperience, $department, $employee, $employeeAward, $attendanceRepository, $warning, $termination;

    function __construct(
        EmployeePerformance $employeePerformance,
        LeaveApplication $leaveApplication,
        Notice $notice,
        EmployeeExperience
        $employeeExperience,
        Department
        $department,
        Employee $employee,
        EmployeeAward
        $employeeAward,
        AttendanceRepository $attendanceRepository,
        Warning $warning,
        Termination $termination
    ) {
        $this->employeePerformance  = $employeePerformance;
        $this->leaveApplication     = $leaveApplication;
        $this->notice               = $notice;
        $this->employeeExperience   = $employeeExperience;
        $this->department           = $department;
        $this->employee             = $employee;
        $this->employeeAward        = $employeeAward;
        $this->attendanceRepository = $attendanceRepository;
        $this->warning              = $warning;
        $this->termination          = $termination;
    }


    public function index()
    {
        $ip_setting = IpSetting::orderBy('id', 'desc')->first();
        $ip_attendance_status = 0;
        $ip_check_status = 0;
        $login_employee = employeeInfo();
        // dd(date('Y-m-d 00:00:00'));
        $totalAttendance  = EmployeeAttendance::whereDate('in_out_time', '>=', date('Y-m-d 00:00:00'))->whereDate('in_out_time', '<', date('Y-m-d 23:59:59'))->groupBy('finger_print_id')->get();

        $count_user_login_today = EmployeeAttendance::where('finger_print_id', '=', $login_employee[0]->finger_id)->whereDate('in_out_time', '=', date('Y-m-d'))->where('is_active',1)->count();
        
        if ($ip_setting) {

            // if 0 then attendance will not take 
            $ip_attendance_status = $ip_setting->status;

            // if 0 then ip will not checked for attendance  

            $ip_check_status = $ip_setting->ip_status;
        }

        if (session('logged_session_data.role_id') != 1) {

            $attendanceData = $this->attendanceRepository->getEmployeeMonthlyAttendance(date("Y-m-01"), date("Y-m-d"), session('logged_session_data.employee_id'));

            $employeePerformance =  $this->employeePerformance->select('employee_performance.*', DB::raw('AVG(employee_performance_details.rating) as rating'))
                ->with(['employee' => function ($d) {
                    $d->with('department');
                }])
                ->join('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
                ->where('month', function ($query) {
                    $query->select(DB::raw('MAX(`month`) AS month'))->from('employee_performance');
                })->where('employee_performance.status', 1)->groupBy('employee_id')->get();

            $employeeTotalAward = $this->employeeAward
                ->select(DB::raw('count(*) as totalAward'))
                ->where('employee_id', session('logged_session_data.employee_id'))
                ->whereBetween('month', [date("Y-01"), date("Y-12")])
                ->first();

            $notice = $this->notice->with('createdBy')->orderBy('notice_id', 'DESC')->where('status', 'Published')->get();

            $terminationData = $this->termination->with('terminateBy')->where('terminate_to', session('logged_session_data.employee_id'))->first();

            $hasSupervisorWiseEmployee       = $this->employee->select('employee_id')->where('supervisor_id', session('logged_session_data.employee_id'))->get()->toArray();
            if (count($hasSupervisorWiseEmployee) == 0) {
                $leaveApplication = [];
            } else {
                $leaveApplication  = $this->leaveApplication->with(['employee', 'leaveType'])
                    ->whereIn('employee_id', array_values($hasSupervisorWiseEmployee))
                    ->where('status', 1)
                    ->orderBy('status', 'asc')
                    ->orderBy('leave_application_id', 'desc')
                    ->get();
            }

            $employeeInfo = $this->employee->with('designation')->where('employee_id', session('logged_session_data.employee_id'))->first();


            $employeeTotalLeave = $this->leaveApplication->select(DB::raw('IFNULL(SUM(number_of_day), 0) as totalNumberOfDays'))
                ->where('employee_id', session('logged_session_data.employee_id'))
                ->where('status', 2)
                ->whereBetween('approve_date', [date("Y-01-01"), date("Y-12-31")])
                ->first();

            $warning = $this->warning->with(['warningBy'])->where('warning_to', session('logged_session_data.employee_id'))->get();

            // date of birth in this month 

            $firstDayThisMonth = date('Y-m-d');
            $lastDayThisMonth  = date("Y-m-d", strtotime("+1 month", strtotime($firstDayThisMonth)));

            $from_date_explode = explode('-', $firstDayThisMonth);
            $from_day = $from_date_explode[2];
            $from_month = $from_date_explode[1];
            $concatFormDayAndMonth = $from_month . '-' . $from_day;

            $to_date_explode = explode('-', $lastDayThisMonth);
            $to_day = $to_date_explode[2];
            $to_month = $to_date_explode[1];
            $concatToDayAndMonth = $to_month . '-' . $to_day;

            $upcoming_birtday =  Employee::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') >= '" . $concatFormDayAndMonth . "' AND DATE_FORMAT(date_of_birth, '%m-%d') <= '" . $concatToDayAndMonth . "' ")->get();

            $upcoming_training = DB::table('training_info')
                ->join('employee', 'training_info.employee_id', '=', 'employee.employee_id')
                ->join('training_type', 'training_info.training_type_id', '=', 'training_type.training_type_id')
                ->select('training_info.*', 'employee.first_name', 'employee.last_name', 'employee.photo', 'training_type.training_type_name as training_type_name')
                ->where('training_info.status', 0)
                ->get();

            $data = [
                'attendanceData'          => $attendanceData,
                'employeePerformance'     => $employeePerformance,
                'employeeTotalAward'      => $employeeTotalAward,
                'notice'                  => $notice,
                'leaveApplication'        => $leaveApplication,
                'employeeInfo'            => $employeeInfo,
                'employeeTotalLeave'      => $employeeTotalLeave,
                'warning'                 => $warning,
                'terminationData'         => $terminationData,
                'upcoming_birtday'        => $upcoming_birtday,
                'ip_attendance_status'    => $ip_attendance_status,
                'ip_check_status'         => $ip_check_status,
                'count_user_login_today'  => $count_user_login_today,
                'upcoming_training'       => $upcoming_training
            ];

            return view('admin.generalUserHome', $data);
        }

        $hasSupervisorWiseEmployee = $this->employee->select('employee_id')->where('supervisor_id', session('logged_session_data.employee_id'))->get()->toArray();
        if (count($hasSupervisorWiseEmployee) == 0) {
            $leaveApplication = [];
        } else {
            $leaveApplication  = $this->leaveApplication->with(['employee', 'leaveType'])
                ->whereIn('employee_id', array_values($hasSupervisorWiseEmployee))
                ->where('status', 1)
                ->orderBy('status', 'asc')
                ->orderBy('leave_application_id', 'desc')
                ->get();
        }

        $date            = date('Y-m-d');

         if (session('logged_session_data.role_id') == 1) {
            $attendanceData  = DB::table('employee_attendance')
                    ->addSelect('employee_attendance.*','employee.first_name','employee.last_name','employee.photo','veiod.in_time','veiod.out_time','veiod.late_time','veiod.working_time')
                    ->join('employee', 'employee.finger_id','=','employee_attendance.finger_print_id')
                    ->join('view_employee_in_out_data as veiod','veiod.employee_attendance_id','=','employee_attendance.employee_attendance_id')
                    ->whereDate('employee_attendance.in_out_time', '=', date('Y-m-d'))
                    ->get();
         }else{
            $attendanceData  = DB::table('employee_attendance')
                    ->addSelect('employee_attendance.*','employee.first_name','employee.last_name','employee.photo','veiod.in_time','veiod.out_time','veiod.late_time','veiod.working_time')
                    ->join('employee', 'employee.finger_id','=','employee_attendance.finger_print_id')
                    ->join('view_employee_in_out_data as veiod','veiod.employee_attendance_id','=','employee_attendance.employee_attendance_id')
                    ->where('employee_attendance.finger_print_id', '=', $login_employee[0]->finger_id)
                    ->whereDate('employee_attendance.in_out_time', '=', date('Y-m-d'))
                    ->get();
         }

        // $attendanceData  = DB::table('employee_attendance')
        //                     ->addSelect('employee_attendance.*','employee.first_name','employee.last_name','employee.photo','veiod.in_time','veiod.out_time','veiod.late_time')
        //                     ->join('employee', 'employee.finger_id','=','employee_attendance.finger_print_id')
        //                     ->join('view_employee_in_out_data as veiod','veiod.employee_attendance_id','=','employee_attendance.employee_attendance_id')
        //                     ->where('employee_attendance.finger_print_id', '=', $login_employee[0]->finger_id)
        //                     ->whereDate('employee_attendance.in_out_time', '=', date('Y-m-d'))
        //                     ->get();

        // dd($attendanceData);
        //DB::select("call `SP_DailyAttendance`('" . $date . "')");
        
        $totalEmployee   = $this->employee->where('status', 1)->count();
        $totalDepartment = $this->department->count();

        $employeePerformance =  $this->employeePerformance->select('employee_performance.*', DB::raw('AVG(employee_performance_details.rating) as rating'))
            ->with(['employee' => function ($d) {
                $d->with('department');
            }])
            ->join('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            ->where('month', function ($query) {
                $query->select(DB::raw('MAX(`month`) AS month'))->from('employee_performance');
            })->where('employee_performance.status', 1)->groupBy('employee_id')->get();

        $employeeAward = $this->employeeAward->with(['employee' => function ($d) {
            $d->with('department');
        }])->limit(10)->orderBy('employee_award_id', 'DESC')->get();

        $notice = $this->notice->with('createdBy')->orderBy('notice_id', 'DESC')->where('status', 'Published')->get();


        // date of birth in this month 

        $firstDayThisMonth = date('Y-m-d');
        $lastDayThisMonth  = date("Y-m-d", strtotime("+1 month", strtotime($firstDayThisMonth)));

        $from_date_explode = explode('-', $firstDayThisMonth);
        $from_day = $from_date_explode[2];
        $from_month = $from_date_explode[1];
        $concatFormDayAndMonth = $from_month . '-' . $from_day;

        $to_date_explode = explode('-', $lastDayThisMonth);
        $to_day = $to_date_explode[2];
        $to_month = $to_date_explode[1];
        $concatToDayAndMonth = $to_month . '-' . $to_day;

        $upcoming_birtday =  Employee::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') >= '" . $concatFormDayAndMonth . "' AND DATE_FORMAT(date_of_birth, '%m-%d') <= '" . $concatToDayAndMonth . "' ")->get();

        $upcoming_training = DB::table('training_info')
            ->join('employee', 'training_info.employee_id', '=', 'employee.employee_id')
            ->join('training_type', 'training_info.training_type_id', '=', 'training_type.training_type_id')
            ->select('training_info.*', 'employee.first_name', 'employee.last_name', 'employee.photo', 'training_type.training_type_name as training_type_name')
            ->where('training_info.status', 0)
            ->get();

        foreach ($leaveApplication as $key => $value) {
            $leave_date_name_list = [];
            if($value->leave_date_list){
                $value->leave_date_list = unserialize($value->leave_date_list);
                foreach ($value->leave_date_list as $key2 => $val) {
                    $current_year = date('Y-m');
                    $leave_name = DB::table('optional_Leave')->select('leave_name')->where('leave_date',$val)->first();
                    
                    if($leave_name != null) {
                        $leave_date_name_list[] = $val.'<b><span style="color: green; font-size: 16px;">( '.$leave_name->leave_name. ' ) </span></b>';
                    }
                    
                }
            }
            $value->optional_leave_date_name_list = $leave_date_name_list;
        }

        // dd($leaveApplication);

        $data = [
            'attendanceData'    => $attendanceData,
            'totalEmployee'     => $totalEmployee,
            'totalDepartment'   => $totalDepartment,
            'totalAttendance'   => count($totalAttendance),
            'totalAbsent'       => $totalEmployee - count($totalAttendance),
            'employeePerformance'  => $employeePerformance,
            'employeeAward'     => $employeeAward,
            'notice'            =>  $notice,
            'leaveApplication'  =>  $leaveApplication,
            'upcoming_birtday'  =>  $upcoming_birtday,
            'ip_attendance_status'    => $ip_attendance_status,
            'ip_check_status'         => $ip_check_status,
            'count_user_login_today'  => $count_user_login_today,
            'upcoming_training'       => $upcoming_training

        ];

        // dd($leaveApplication);
        return view('admin.adminhome', $data);
    }


    public function profile()
    {
        $data['employeeInfo']           = Employee::where('employee.employee_id', session('logged_session_data.employee_id'))->first();
        $data['employeeExperience']     = EmployeeExperience::where('employee_id', session('logged_session_data.employee_id'))->get();
        $data['employeeEducation']      = EmployeeEducationQualification::where('employee_id', session('logged_session_data.employee_id'))->get();
        $data['employeeChildData']      = EmployeeChildInformation::where('employee_id', session('logged_session_data.employee_id'))->get();
        $data['employeeLogisticData']   = EmployeeLogisticInformation::where('employee_id', session('logged_session_data.employee_id'))->get();

        $data['othersInfo'] = DB::table('employee')
            ->select('employee.*', 'department.department_name as department_name', 'designation.designation_name as designation_name', 'pay_grade.*')
            ->leftjoin('department', 'employee.department_id', '=', 'department.department_id')
            ->leftjoin('designation', 'employee.designation_id', '=', 'designation.designation_id')
            ->leftjoin('pay_grade', 'employee.pay_grade_id', '=', 'pay_grade.pay_grade_id')
            ->where('employee.employee_id', session('logged_session_data.employee_id'))
            ->first();

        $data['present_salary'] = DB::table('employee')->select('prg.*')
                                    ->join('present_pay_grade_salary as prg','prg.present_pay_grade_salary_id','=','employee.present_increement_salary')
                                    ->where('employee.employee_id', session('logged_session_data.employee_id'))
                                    ->first();

        $data['traningInfo'] = DB::table('training_info')
            ->select('training_info.*', 'training_type.training_type_name as training_type_name')
            ->leftjoin('training_type', 'training_info.training_type_id', '=', 'training_type.training_type_id')
            ->where('training_info.employee_id', session('logged_session_data.employee_id'))
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
            ->where('employee.employee_id', session('logged_session_data.employee_id'))
            ->where('performance_criteria.performance_category_id',3)
            ->get()->toArray();

        $data['employeeAward'] = DB::table('employee_award')->where('employee_id', session('logged_session_data.employee_id'))->first();
        $data['promotionInfo'] = DB::table('promotion')->where('employee_id', session('logged_session_data.employee_id'))->first();

        $pay_grade_id_from_employee = $data['employeeInfo']->pay_grade_id;

        $data['house_rent_from_pay_grade'] =  DB::table('pay_grade')->where('pay_grade_id', $pay_grade_id_from_employee)->first()->house_rent_of_basic_salary;

        $data['totalSalaryWithAllowance'] = DB::table('allowance')
            ->select('allowance.*')
            ->leftjoin('pay_grade_to_allowance', 'allowance.allowance_id', '=', 'pay_grade_to_allowance.allowance_id')
            ->where('pay_grade_to_allowance.pay_grade_id', $pay_grade_id_from_employee)
            ->get();

       //  // dd($data['totalSalaryWithAllowance']);
       // dd($data);
        return view('admin.user.user.profile', $data);
    }


    public function mail()
    {

        $user = array(
            'name' => "Learning Laravel",
        );

        Mail::send('emails.mailExample', $user, function ($message) {
            $message->to("kamrultouhidsak@gmail.com");
            $message->subject('E-Mail Example');
        });

        return "Your email has been sent successfully";
    }


    public function employeeProfilePdfDownload(Request $request)
    {
        $data['employeeInfo']           = Employee::where('employee.employee_id', session('logged_session_data.employee_id'))->first();
        $data['employeeExperience']     = EmployeeExperience::where('employee_id', session('logged_session_data.employee_id'))->get();
        $data['employeeEducation']      = EmployeeEducationQualification::where('employee_id', session('logged_session_data.employee_id'))->get();
        $data['employeeChildData']      = EmployeeChildInformation::where('employee_id', session('logged_session_data.employee_id'))->get();
        $data['employeeLogisticData']   = EmployeeLogisticInformation::where('employee_id', session('logged_session_data.employee_id'))->get();

        $data['othersInfo'] = DB::table('employee')
            ->select('employee.*', 'department.department_name as department_name', 'designation.designation_name as designation_name', 'pay_grade.*')
            ->leftjoin('department', 'employee.department_id', '=', 'department.department_id')
            ->leftjoin('designation', 'employee.designation_id', '=', 'designation.designation_id')
            ->leftjoin('pay_grade', 'employee.pay_grade_id', '=', 'pay_grade.pay_grade_id')
            ->where('employee.employee_id', session('logged_session_data.employee_id'))
            ->first();

        $data['traningInfo'] = DB::table('training_info')
            ->select('training_info.*', 'training_type.training_type_name as training_type_name')
            ->leftjoin('training_type', 'training_info.training_type_id', '=', 'training_type.training_type_id')
            ->where('training_info.employee_id', session('logged_session_data.employee_id'))
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
            ->where('employee.employee_id', session('logged_session_data.employee_id'))
            ->where('performance_criteria.performance_category_id',3)
            ->get()->toArray();

        $data['employeeAward'] = DB::table('employee_award')->where('employee_id', session('logged_session_data.employee_id'))->first();
        $data['promotionInfo'] = DB::table('promotion')->where('employee_id', session('logged_session_data.employee_id'))->first();

        $pay_grade_id_from_employee = $data['employeeInfo']->pay_grade_id;

        $data['house_rent_from_pay_grade'] =  DB::table('pay_grade')->where('pay_grade_id', $pay_grade_id_from_employee)->first()->house_rent_of_basic_salary;

        $data['totalSalaryWithAllowance'] = DB::table('allowance')
            ->select('allowance.*')
            ->leftjoin('pay_grade_to_allowance', 'allowance.allowance_id', '=', 'pay_grade_to_allowance.allowance_id')
            ->where('pay_grade_to_allowance.pay_grade_id', $pay_grade_id_from_employee)
            ->get();
        
        $pdf = PDF::loadView('admin.user.user.employee_profile_pdf', $data);

        $pdf->setPaper('A4', 'landscape');
        $pageName = ".employee-profile.pdf";
        return $pdf->download($pageName);
    }
}
