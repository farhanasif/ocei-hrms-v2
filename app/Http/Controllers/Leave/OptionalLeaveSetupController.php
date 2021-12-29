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
        $inputs = $request->all();
        // dd($inputs);
        try{
           $input= $inputs;
           foreach ($inputs['leave_date'] as $key => $value) {
               $input['leave_date'] = dateConvertFormtoDB($value);
               $input['leave_name'] = $inputs['leave_name'][$key];
               $optional_Leave = DB::table('optional_Leave')->insert($input);
           }
           
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


    public function edit($id){
        $editModeData = DB::table('optional_Leave')->where('optional_Leave_id',$id)->first();
        // dd($editModeData->leave_date);
        $editModeData->leave_date = date("d/m/Y",strtotime($editModeData->leave_date));

        return view('admin.leave.optionalLeaveSetup.edit_form',['editModeData' => $editModeData]);
    }


    public function update(Request $request,$id) {
        $input  = $request->all();
        try{
            $input['leave_date'] = dateConvertFormtoDB($request->leave_date);
            $data = DB::table('optional_Leave')->where('optional_Leave_id',$id)->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            dd($e);
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Optional leave successfully updated.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){    
        try{
            $data = DB::table('optional_Leave')->where('optional_Leave_id',$id)->delete();
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Optional leave successfully Deleted.');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }
	
}
