<?php

namespace App\Http\Controllers\Visitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class VisitorRequestController extends Controller
{
    public function index()
    {
            // ->where('appointment.employee_id', session('logged_session_data.employee_id')

        $visitorRequests['pending'] = DB::table('visitor_registration') 
                                          ->select('visitor_registration.*', 'appointment.*', 'appointment.id as appointment_id')
                                          ->join('appointment', 'visitor_registration.id', '=', 'appointment.visitor_id')
                                          ->orderBy('visitor_registration.id', 'desc')
                                          ->where('appointment.approval_of',3)->get();

        $visitorRequests['approve'] = DB::table('visitor_registration') 
                  ->select('visitor_registration.*', 'appointment.*', 'appointment.id as appointment_id')
                  ->join('appointment', 'visitor_registration.id', '=', 'appointment.visitor_id')
                  ->orderBy('visitor_registration.id', 'desc')->where('appointment.approval_of',1)->get();

        $visitorRequests['reject'] = DB::table('visitor_registration') 
                  ->select('visitor_registration.*', 'appointment.*', 'appointment.id as appointment_id')
                  ->join('appointment', 'visitor_registration.id', '=', 'appointment.visitor_id')
                  ->orderBy('visitor_registration.id', 'desc')->whereNotIn('appointment.approval_of',[1,3])->get();


        return view('admin.visitorRequest.index', compact('visitorRequests'));
    }

    public function visitorRequestApproval($appoinment_id)
    {
        $updateApproval = DB::table('appointment')
            ->where('id', $appoinment_id)
            ->update(['approval_of' => 1]);

        if ($updateApproval) {
            return back()->with('success', 'Status change successfully.');
        }else{
            return back()->with('error', 'Something error found !, Please try again.');
        }
    }

    public function visitorRequestRejected($appoinment_id)
    {
        $updateApproval = DB::table('appointment')
            ->where('id', $appoinment_id)
            ->update(['approval_of' => 0]);

        if ($updateApproval) {
            return back()->with('success', 'Status change successfully.');
        }else{
            return back()->with('error', 'Something error found !, Please try again.');
        }
    }
}
