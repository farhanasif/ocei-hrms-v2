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

use App\Model\LeaveType;



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
        dd($input);
        $input['application_from_date'] = dateConvertFormtoDB($request->application_from_date);
        $input['application_to_date']   = dateConvertFormtoDB($request->application_to_date);
        $input['application_date']      =  date('Y-m-d');

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
