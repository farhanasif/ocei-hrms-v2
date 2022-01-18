<?php

namespace App\Http\Controllers\Leave;

use App\Repositories\LeaveRepository;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Model\LeaveApplication;

use Illuminate\Http\Request;

use App\Model\Employee;

use DB;
class RequestedApplicationController extends Controller
{
	
    protected $leaveRepository;

    public function __construct(LeaveRepository $leaveRepository){
        $this->leaveRepository  = $leaveRepository;
    }


    public function index(){
        $hasSupervisorWiseEmployee       = Employee::select('employee_id')->get()->toArray();

        $user_data = Employee::select('user.role_id')->join('user','user.user_id','=','employee.user_id')->where('employee.employee_id',session('logged_session_data.employee_id'))->first();
        // dd($user_data->role_id);
        if(count($hasSupervisorWiseEmployee) == 0){
            $results = [];
        }else {

            if($user_data->role_id == 1 or $user_data->role_id == 9) {
                    $results  = LeaveApplication::with(['employee','leaveType'])
                        ->where('employee_id','!=',session('logged_session_data.employee_id'))
                        ->orderBy('status','asc')
                        ->orderBy('leave_application_id','desc')
                        ->get();
            }else{
                $results  = LeaveApplication::with(['employee','leaveType'])
                        ->whereIn('employee_id',array_values($hasSupervisorWiseEmployee))
                        ->where('employee_id','!=',session('logged_session_data.employee_id'))
                        ->orderBy('status','asc')
                        ->orderBy('leave_application_id','desc')
                        ->get();
            }

            // dd($results);
            foreach($results as $key => $value) {
                $leave_date_name_list = [];
                if($value->leave_date_list){
                    $value->leave_date_list = unserialize($value->leave_date_list);
                    foreach ($value->leave_date_list as $key2 => $val) {
                        $current_year = date('Y-m');
                        $leave_name = DB::table('optional_Leave')->select('leave_name')->where('leave_date',$val)->first();
                        if ($leave_name != null) {
                             $leave_date_name_list[] = $val.'<b><span style="color: green;"> : '.$leave_name->leave_name. '</span></b><br />';
                         }else{
                            $leave_date_name_list[] = $val;
                         }
                    }
                }
                $value->optional_leave_date_name_list = $leave_date_name_list;
            }
            // dd($results);
        }
        return view('admin.leave.leaveApplication.leaveApplicationList',['results'=>$results]);
    }


    public function viewDetails($id){
        // dd('ok');
        $leaveApplicationData  = LeaveApplication::with(['employee'=>function($q){
            $q->with(['designation']);
        }])->with('leaveType')->where('leave_application_id',$id)->where('status',1)->first();

        if(!$leaveApplicationData){
            return response()->view('errors.404', [], 404);
        }

        $currentBalance        = $this->leaveRepository->calCulateEmployeeLeaveBalance($leaveApplicationData->leave_type_id,$leaveApplicationData->employee_id);
        return view('admin.leave.leaveApplication.leaveDetails',['leaveApplicationData' => $leaveApplicationData,'currentBalance' => $currentBalance]);
    }


    public function update(Request $request,$id){

        $data = LeaveApplication::findOrFail($id);
        $input = $request->all();
        if($request->status == 2) {
            $input['approve_date']     = date('Y-m-d');
            $input['approve_by']       = session('logged_session_data.employee_id');
        }else{
            $input['reject_date']      = date('Y-m-d');
            $input['reject_by']        = session('logged_session_data.employee_id');
        }

        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            if($request->status == 2) {
                return redirect('requestedApplication')->with('success', 'Leave application approved successfully. ');
            }else{
                return redirect('requestedApplication')->with('success', 'Leave application reject successfully. ');
            }
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }

    }

	
    public function approveOrRejectLeaveApplication(Request $request){

        $data = LeaveApplication::findOrFail($request->leave_application_id);
        $input = $request->all();
        // dd($input);
        if($request->status == 2) {
            if($data->leave_type_id == 23){
                $pre_date_list = unserialize($data['leave_date_list']);
                $input['request_leave_date_list'] = serialize($pre_date_list);
                $input['leave_date_list'] = serialize($request->optional_date_list);
                $input['number_of_day'] = count($request->optional_date_list);
            }
            $input['approve_date']     = date('Y-m-d');
            $input['approve_by']       = session('logged_session_data.employee_id');

        }else{
            $input['reject_date']      = date('Y-m-d');
            $input['reject_by']        = session('logged_session_data.employee_id');
        }
        
        // dd($input);
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }
        if($bug==0){
            if($request->status == 2) {
                echo "approve";
            }else{
                echo "reject";
            }
        }else {
           echo "error";
        }
    }


}
