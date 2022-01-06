<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\BranchRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Branch;
use App\Model\Employee;
use App\Model\Logistic;

class LogisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $results = Logistic::get();
        return view('admin.employee.logistic.index',['results'=>$results]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('admin.employee.logistic.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try{
            Logistic::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('logistic')->with('success', 'Logistic Type successfully saved.');
        }else {
            return redirect('logistic')->with('error', 'Something Error Found !, Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function show(Logistic $logistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $editModeData = Logistic::findOrFail($id);
        return view('admin.employee.logistic.form',['editModeData' => $editModeData]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id) {
        $logistic = Logistic::findOrFail($id);
        $input = $request->all();
        try{
            $logistic->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Logistic Type successfully updated ');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Logistic  $logistic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        try{
            $logistic = Logistic::findOrFail($id);
            $logistic->delete();
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
