<?php

namespace App\Http\Controllers\Payroll;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PayGrade;
use Illuminate\Support\Facades\DB;

class PresentPayScaleController extends Controller
{
    public function index()
    {
        $presentPayGradeSalary =  DB::table('present_pay_grade_salary')->select('present_pay_grade_salary.*', 'pay_grade.pay_grade_name')
            ->join('pay_grade', 'pay_grade.pay_grade_id', 'present_pay_grade_salary.pay_grade_id')
            ->get();
        // dd($presentPayGradeSalary);

        return view('admin.payroll.presentPayScale.index', compact('presentPayGradeSalary'));
    }

    public function create()
    {
        $payGrades = PayGrade::all();
        return view('admin.payroll.presentPayScale.form', ['payGrades' => $payGrades]);
    }

    public function store(Request $request)
    {

        $input = $request->all();
        // dd($input);
        try {
            $result = DB::table('present_pay_grade_salary')->insert([
                'pay_grade_id' => $request->pay_grade_name,
                'present_pay_grade_salary' => $request->present_pay_grade_salary
            ]);
            $bug = 0;
        } catch (\Exception $e) {
            // dd($e);
        }

        if ($bug == 0) {
            return redirect()->route('presentPayScale.create')->with('success', 'Present Pay grade Salary Successfully saved.');
        } else {
            return redirect()->route('presentPayScale.create')->with('error', 'Something Error Found !, Please try again.');
        }
    }

    public function edit($id)
    {
        $payGrades = PayGrade::all();
        $editModeData = DB::table('present_pay_grade_salary')->where('present_pay_grade_salary_id', $id)->first();
        return view('admin.payroll.presentPayScale.form', ['editModeData' => $editModeData, 'payGrades' => $payGrades]);
    }


    public function update(Request $request, $id)
    {

        // $input = $request->all();
        // dd($input);
        try {
            $result = DB::table('present_pay_grade_salary')->where('present_pay_grade_salary_id',$id)->update([
                'pay_grade_id' => $request->pay_grade_name,
                'present_pay_grade_salary' => $request->present_pay_grade_salary
            ]);
            $bug = 0;
        } catch (\Exception $e) {
            // dd($e);
        }

        if ($bug == 0) {
            return redirect('presentPayScale')->with('success', 'Present Pay grade Salary Successfully updated.');
        } else {
            return redirect('presentPayScale')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id)
    {
        try {
            $data = DB::table('present_pay_grade_salary')->where('present_pay_grade_salary_id', $id)->delete();
            $bug = 0;
        } catch (\Exception $e) {
            // dd($e);
        }

        if ($bug == 0) {
            return redirect('presentPayScale')->with('success', 'Present Pay grade Salary Successfully deleted.');
        } else {
            return redirect('presentPayScale')->with('error', 'Something Error Found !, Please try again.');
        }
    }
}
