<?php

namespace App\Http\Controllers\Leave;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class OptionalLeaveSetupController extends Controller
{
	
    public function index(){
        $optional_Leave = DB::table('optional_Leave')->get();
       return view('admin.leave.optionalLeaveSetup.index', compact('optional_Leave'));
    }

    public function create(){
        return view('admin.leave.optionalLeaveSetup.create');
    }


    public function store(Request $request){
        $input = $request->all();
        $input['leave_date'] = dateConvertFormtoDB($request->leave_date);
        try{
           $optional_Leave = DB::table('optional_Leave')->insert($input);
            $bug = 0;
        }
        catch(\Exception $e){
            dd($e);
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('optionalLeaveSetup')->with('success', 'Optional leave successfully saved.');
        }else {
            return back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    // public function edit($id){
    //     $editModeData = LeaveType::findOrFail($id);
    //     return view('admin.leave.optionalLeaveSetup.form',['editModeData' => $editModeData]);
    // }


    public function update(Request $request,$id) {
        $data   = LeaveType::findOrFail($id);
        $input  = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Optional leave successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
           
     $count = LeaveApplication::where('leave_type_id','=',$id)->count();

        if ($count>0) {
          return "hasForeignKey";
        }

        try{
            $data = LeaveType::findOrFail($id);
            $data->delete();
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
