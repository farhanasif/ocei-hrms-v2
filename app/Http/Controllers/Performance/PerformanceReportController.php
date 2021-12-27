<?php

namespace App\Http\Controllers\Performance;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Model\EmployeePerformance;

use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PrintHeadSetting;

use Illuminate\Http\Request;

use App\Model\Employee;
use App\Model\PayGrade;
use App\Model\PerformanceCategory;

class PerformanceReportController extends Controller
{

    public function performanceSummaryReport(Request $request)
    {
        $employeeList = Employee::where('status', 1)->get();
        $performanceCategory = PerformanceCategory::all();
        $payGrade = PayGrade::all();

        $results = '';
        if ($_POST) {

            $results = EmployeePerformance::select('employee_performance.*', 'employee.first_name', 'employee.last_name', 'department.department_name', DB::raw('AVG(rating) as avgRating'))
                ->leftJoin('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
                ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
                ->join('department', 'department.department_id', '=', 'employee.department_id')
                ->where('employee_performance.employee_id', $request->employee_id)
                ->where('employee_performance.status', 1)
                ->whereBetween('month', [$request->from_month, $request->to_month])
                ->groupBy('employee_performance_details.employee_performance_id')
                ->orderBy('month', 'ASC')
                ->get();
        }

        $data = [
            'results'           => $results,
            'employeeList'      => $employeeList,
            'employeeList'      => $employeeList,
            'from_month'        => $request->from_month,
            'to_month'          => $request->to_month,
            'employee_id'       => $request->employee_id,
            'payGrade'          => $payGrade,
            'performanceCategory'   => $performanceCategory,
        ];
        // dd($data);
        return view('admin.performance.report.summaryReport', $data);
    }


    public function downloadPerformanceSummaryReport(Request $request)
    {
        $results = EmployeePerformance::select('employee_performance.*', 'employee.first_name', 'employee.last_name', 'department.department_name', DB::raw('AVG(rating) as avgRating'))
            ->leftJoin('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
            ->join('department', 'department.department_id', '=', 'employee.department_id')
            ->where('employee_performance.employee_id', $request->employee_id)
            ->where('employee_performance.status', 1)
            ->whereBetween('month', [$request->from_month, $request->to_month])
            ->groupBy('employee_performance_details.employee_performance_id')
            ->orderBy('month', 'ASC')
            ->get();

        $printHead = PrintHeadSetting::first();

        $data = [
            'results'    => $results,
            'printHead'  => $printHead,
            'from_month' => $request->from_month,
            'to_month'   => $request->to_month,
        ];

        $pdf = PDF::loadView('admin.performance.report.pdf.summaryReportPdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = ".employee-performance.pdf";
        return $pdf->download($pageName);
    }

    public function performance_nisperformance_category(Request $request)
    {
        // dd($request->all());

        $performance_criteria_name = DB::table('performance_criteria')->where('performance_category_id',4)->get();

        $data =  DB::table('employee_performance')->select(
            'employee.first_name as first_name',
            'employee.last_name as last_name',
            'employee.employee_id',
            'employee.designation_id as designation_id',
            'designation.designation_id as designation_id',
            'designation.designation_name  as designation_name',
            'employee_performance.month as month',
            'employee_performance.remarks as remarks',
            'pay_grade.pay_grade_name as pay_grade_name'
        )
            ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
            ->join('pay_grade','pay_grade.pay_grade_id','=','employee.pay_grade_id')
            ->join('designation', 'designation.designation_id', '=', 'employee.designation_id')
            // ->join('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            // ->join('performance_criteria', 'performance_criteria.performance_criteria_id', '=', 'employee_performance_details.performance_criteria_id')
            ->whereBetween('pay_grade.pay_grade_id', [$request->from_pay_grade_name, $request->to_pay_grade_name])
            ->whereBetween('employee_performance.month', [$request->from_month, $request->to_month])
            ->where('employee_performance.status',1)
            // ->where('performance_criteria.performance_category_id', 4)
            // ->groupBy('employee_performance_details.employee_performance_id')
            ->get();
        // $data1 =  DB::table('employee_performance')
        //     ->whereBetween('pay_grade_name', [$request->from_pay_grade_name, $request->to_pay_grade_name])
        //     ->whereBetween('month', [$request->from_month, $request->to_month])
        //     ->get();

        // dd($data);
        $criteriaDataFormat = [];
        foreach ($data  as $value) {
            $criteriaDataFormat[$value->first_name . " ". $value->last_name.",".$value->designation_name][] = $value;
        }

        dd($data);

        return view('admin.performance.report.pdf.nisPerformanceReport', ['criteriaDataFormat' => $criteriaDataFormat, 'data' => $data]);
    }
}
