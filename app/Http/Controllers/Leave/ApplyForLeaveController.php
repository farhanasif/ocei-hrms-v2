<?php

namespace App\Http\Controllers\Leave;

use App\Http\Requests\ApplyForLeaveRequest;

use App\Repositories\CommonRepository;

use App\Repositories\LeaveRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Model\LeaveApplication;

use Illuminate\Http\Request;
use App\Model\Employee;
use App\Model\LeaveType;
use Validator;

class ApplyForLeaveController extends Controller
{

    protected $commonRepository;
    protected $leaveRepository;

    public function __construct(CommonRepository $commonRepository, LeaveRepository $leaveRepository)
    {
        $this->commonRepository = $commonRepository;
        $this->leaveRepository  = $leaveRepository;
    }


    public function index()
    {
        $results = LeaveApplication::with(['employee', 'leaveType', 'approveBy', 'rejectBy'])
            ->where('employee_id', session('logged_session_data.employee_id'))
            ->orderBy('leave_application_id', 'desc')
            ->paginate(10);
        foreach ($results as $key => $value) {
            if($value->leave_date_list){
                $value->leave_date_list = unserialize($value->leave_date_list);
            }
        }
        // dd($results[0]->leave_date_list);
        return view('admin.leave.applyForLeave.index', ['results' => $results]);
    }


    public function create()
    {
        $leaveTypeList      = $this->commonRepository->leaveTypeList();
        $getEmployeeInfo    = $this->commonRepository->getEmployeeInfo(Auth::user()->user_id);
        $religionList = [''=>' <>----  Select Religion  ----<> ','Islam'=>'Islam','Hinduism'=>'Hinduism','Buddhism'=>'Buddhism','Christianity'=>'Christianity','Others'=>'Others'];
        return view('admin.leave.applyForLeave.leave_application_form', ['leaveTypeList' => $leaveTypeList, 'getEmployeeInfo' => $getEmployeeInfo,'religionList'=>$religionList]);
    }


    public function religionWiseLeave($religion_name)
    {
        $optionalLeave = DB::table('optional_Leave')->where('religion_name',$religion_name)->get();
        return response()->json(['code'=>200,'datelist'=>$optionalLeave]);
    }

    public function getEmployeeLeaveBalance(Request $request)
    {
        $leave_type_id = $request->leave_type_id;
        $employee_id   = $request->employee_id;

        if($leave_type_id == 7) {
            $prev_data = DB::table('leave_application')->where('employee_id',$employee_id)->where('status',2)->where('leave_type_id',$leave_type_id)->orderBy('leave_application_id','desc')->first();
            if($prev_data != null) {
                $prev_date = strtotime($prev_data->application_from_date);
                $curr_date = strtotime(date('Y-m-d'));
                $total_day = ($curr_date - $prev_date)/60/60/24;

                if($total_day < 730){
                    return 0;
                }
            }
        }else if($leave_type_id == 10) {
            $prev_data = DB::table('leave_application')
                            ->select(DB::raw('IFNULL(SUM(leave_application.number_of_day), 0) as number_of_day'))
                            ->where('employee_id',$employee_id)
                            ->where('status',2)
                            ->where('leave_type_id',$leave_type_id)
                            ->get();

            if($prev_data[0]->number_of_day >= 360){
                return 0;
            }else if((360 - $prev_data[0]->number_of_day) < 180){
                return (360 - $prev_data[0]->number_of_day);
            }else if((360 - $prev_data[0]->number_of_day) >= 180) {
                return 180;
            }
        }else if($leave_type_id == 5 or $leave_type_id == 6) {
            $employeeInfo = Employee::where('employee_id',$employee_id)->first();
            $joiningdate  = $employeeInfo->date_of_joining;
            $total_days =  $this->leaveRepository->calculateTotalNumberOfLeaveDays($joiningdate, date('Y-m-d'), null);
            $total_leave = LeaveApplication::select(DB::raw('IFNULL(SUM(leave_application.number_of_day), 0) as number_of_day'))
                        ->where('employee_id',$employee_id)
                        ->where('status',2)
                        ->whereBetween('application_to_date',[$joiningdate,date('Y-m-d')])
                        ->first();
            // dd($total_leave);
            $total_day = $total_days[0] - $total_leave->number_of_day;

            if($leave_type_id == 6) {
                return $total_day%11 > 5 ? (int)($total_day/11) + 1 : (int)($total_day/11);
            }elseif($leave_type_id == 5){
                return $total_day%12 > 5 ? (int)($total_day/12) + 1 : (int)($total_day/12);
            }
        }
        if ($leave_type_id != '' && $employee_id != '') {
            return $this->leaveRepository->calculateEmployeeLeaveBalance($leave_type_id, $employee_id);
        }
    }


    public function applyForTotalNumberOfDays(Request $request)
    {
        // dd($request->all());
        // return $request->leave_type_id;

        $application_from_date = dateConvertFormtoDB($request->application_from_date);
        $application_to_date   = dateConvertFormtoDB($request->application_to_date);
        return $this->leaveRepository->calculateTotalNumberOfLeaveDays($application_from_date, $application_to_date, $request->leave_type_id);
    }


    public function store(ApplyForLeaveRequest $request)
    {
        $input = $request->all();

        if($request->leave_type_id == 23){
            $inputs = Validator::make($request->all(),[
                'leave_type_id' => 'required',
                'leave_date' => 'required',
                'purpose' => 'required',
            ],[
                'leave_type_id.required' => 'The leave type field is required.',
                'leave_date' => 'The optional leave date field is required'
            ]);
        }else{
            $inputs = Validator::make($request->all(),[
                'leave_type_id' => 'required',
                'application_from_date' => 'required',
                'application_to_date' => 'required',
                'number_of_day' => 'required|numeric',
                'purpose' => 'required',
            ],[
                'leave_type_id.required' => 'The leave type field is required.',
                'application_from_date.required' => 'The from date field is required.',
                'application_to_date.required' => 'The to date field is required.',
                'number_of_day' => 'The number off day field is required.'
            ]);
        }

        $inputs->validate();
        

        $input['application_from_date'] = dateConvertFormtoDB($request->application_from_date);
        $input['application_to_date']   = dateConvertFormtoDB($request->application_to_date);
        $input['application_date']      =  date('Y-m-d');
        
        if($request->leave_type_id == 23 && count($request->leave_date) != 0) {
            $input['leave_date_list'] =  serialize($input['leave_date']);
            $input['number_of_day'] = count($request->leave_date);
        }

        if($request->leave_type_id == 23 && count($request->leave_date) == 0){
            return redirect('applyForLeave')->with('error', 'Optional leave date is empty!.');
        }else if($request->leave_type_id != 23 && $input['application_from_date'] == null && $input['application_to_date']) {
            return redirect('applyForLeave')->with('error', 'Application From date and To date are empty!.');
        }
        
        // dd($input);

        // For Leave Application Attachment
        $attachment = $request->file('attachment');
        if ($attachment) {
            $imgName = md5(str_random(30) . time() . '_' . $request->file('attachment')) . '.' . $request->file('attachment')->getClientOriginalExtension();
            $request->file('attachment')->move('uploads/leaveApplication/', $imgName);
            $input['attachment'] = $imgName;
        }

        // dd($input);

        try {
            LeaveApplication::create($input);
            $bug = 0;
        } catch (\Exception $e) {
            dd($e);
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect('applyForLeave')->with('success', 'Leave application successfully send.');
        } else {
            return redirect('applyForLeave')->with('error', 'Something error found !, Please try again.');
        }
    }
}
