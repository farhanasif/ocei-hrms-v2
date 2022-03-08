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
use DateTime;

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
        $getUserInfo    = $this->commonRepository->getUserInfo(Auth::user()->user_id);
        $religionList = [''=>' <>----  Select Religion  ----<> ','Islam'=>'Islam','Hinduism'=>'Hinduism','Buddhism'=>'Buddhism','Christianity'=>'Christianity','Others'=>'Others'];
        $getAllEmployeeList = $this->commonRepository->employeeList();
        return view('admin.leave.applyForLeave.leave_application_form', ['leaveTypeList' => $leaveTypeList, 'getEmployeeInfo' => $getEmployeeInfo,'religionList'=>$religionList,'getUserInfo' => $getUserInfo,'getAllEmployeeList' => $getAllEmployeeList]);
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
        }else if($leave_type_id == 5 or $leave_type_id == 6 or $leave_type_id == 1) {
            $employeeInfo = Employee::where('employee_id',$employee_id)->first();
            $joiningdate  = $employeeInfo->date_of_joining;
            $curr_date = date('Y-m-d');

            // calculate total service days
            $total_days =  $this->leaveRepository->totalServiceDay($joiningdate, date('Y-m-d'));

            // calculate total leave days
            $total_leave = $this->leaveRepository->totalLeave($employee_id, $joiningdate, date('Y-m-d'), $leave_date_Array = [5,6,10,12,13]);

            $total_day = $total_days - $total_leave;

            if($leave_type_id == 6) {
                $leave_use = $this->leaveRepository->totalLeave($employee_id, $joiningdate, date('Y-m-d'), $leave_date_Array = [11]);
                if($leave_use > 180){
                    $leave_use = 180;
                }

                $leave_use += $this->leaveRepository->totalLeave($employee_id, $joiningdate, date('Y-m-d'), $leave_date_Array = [19, 20]);
                return ($this->leaveRepository->fullEarnleave($total_day)) - $leave_use;
            }elseif($leave_type_id == 5){
                $leave_use = $this->leaveRepository->totalLeave($employee_id, $joiningdate, date('Y-m-d'), $leave_date_Array = [11]);
                if($leave_use > 180){
                    $leave_use = ($leave_use - 180) * 2;
                }else {
                    $leave_use = 0;
                }

                return ($this->leaveRepository->halfEarnleave($total_day)) - $leave_use;
            }else{
                $earnLeave = $this->leaveRepository->earnLeave($total_day,$employee_id, $joiningdate, $curr_date);
                return $earnLeave;
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
        // dd($input);
        $employee_data = DB::table('employee')->where('employee_id',session('logged_session_data.employee_id'))->first();

        // calculate total service year 
        $curr_date = new DateTime(date('Y-m-d'));
        $join_date = new DateTime($employee_data->date_of_joining);
        $interval = $curr_date->diff($join_date);
        $total_service_year = $interval->y;


        $total_days =  $this->leaveRepository->totalServiceDay($employee_data->date_of_joining, date('Y-m-d'));

        // calculate total leave days
        $total_leave = $this->leaveRepository->totalLeave(session('logged_session_data.employee_id'), $employee_data->date_of_joining, date('Y-m-d'), [5,6,10,12,13]);

        $total_day = $total_days - $total_leave;

        $prev = LeaveApplication::where('leave_type_id',$request->leave_type_id)->where('status',1)->where('employee_id', session('logged_session_data.employee_id'))->first();

        if($request->leave_type_id != 19 && $request->leave_type_id != 20) {
            if($prev) {
                return redirect('applyForLeave')->with('error', 'Sorry! Your previous leave application are pending now. Please wait for previous application action.');
            }
        }

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

        if($request->leave_type_id == 16 || $request->leave_type_id == 8 || $request->leave_type_id == 15 || ($request->leave_type_id == 9 && $input['number_of_day'] > 21) || ($request->leave_type_id == 14 && $input['number_of_day'] > 90)) {
            $inputs = Validator::make($request->all(),[
                'attachment' => 'required',
            ],[
                'attachment' => 'The Medical Report is highly required for this leave apply.'
            ]);

            $inputs->validate();
        }

        
        

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

        if($request->leave_type_id == 11) {
            if($total_service_year < 25) {
                return redirect('applyForLeave')->with('error', 'Sorry! You are not allow to apply this leave, becuase your service year '.$total_service_year.'. Minimum 25 service years to require for applying this leave.');
            }

            $earnDay =  $this->leaveRepository->earnLeave($total_day,session('logged_session_data.employee_id'), $employee_data->date_of_joining, date('Y-m-d'));

            if($earnDay < $input['number_of_day']) {
                return redirect('applyForLeave')->with('error', 'Sorry! You are not allow to apply this leave, becuase your service year your request number of leave day overflow your earned leave days.');
            }
        }
        

        if($request->leave_type_id == 14) {
            if($employee_data->permanent_status != 1) {
                return redirect('applyForLeave')->with('error', 'Sorry! You are not allow to apply this leave, becuase you are not a permanent employer.');
            }
        }

       // dd($total_service_year);
        if($request->leave_type_id == 13) {
            if($total_service_year < 5 || ($total_service_year >= 25 && $total_service_year <= 28)) {
                return redirect('applyForLeave')->with('error', 'Sorry! You are not allow to apply Study leave. Service year must be grater than 5 years and less than 25 years or grater than 28 years');
            }
        }
        
        $input['apply_by'] = $input['employee_id'];

        if($input['leave_type_id'] == 19 || $input['leave_type_id'] == 20) {
            $input['employee_id'] = $input['for_employee_id'];
        }

        

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

    public function getHolidayCalendar($id)
    {
        $data = DB::table('holiday_file')->where('leave_id',$id)->orderBy('id','desc')->first();
        $data = url('').'/uploads/calendarImg/'.$data->image;
        return response()->json(['code'=>200,'data'=>$data]);
    }


    public function destroy($id){
        try{
            $leaveDetails = LeaveApplication::findOrFail($id);
            $leaveDetails->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            echo "success";
        }elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }
}
