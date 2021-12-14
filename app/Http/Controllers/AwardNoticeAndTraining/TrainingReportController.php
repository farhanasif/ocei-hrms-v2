<?php

namespace App\Http\Controllers\AwardNoticeAndTraining;

use App\Http\Controllers\Controller;

use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PrintHeadSetting;

use App\Model\TrainingType;

use Illuminate\Http\Request;

use App\Model\TrainingInfo;

use App\Model\Employee;
use Illuminate\Support\Facades\DB;

class TrainingReportController extends Controller
{


    public function employeeTrainingReport(Request $request)
    {
        $employeeList = Employee::where('status', 1)->get();
        $data = [];

        if ($request->employee_id) {
            $data = $this->employeeTrainingDataFormat($request->employee_id);
        }

        return view('admin.training.report.employeeTrainingReport', ['employeeList' => $employeeList, 'results' => $data, 'employee_id' => $request->employee_id]);
    }



    public function employeeTrainingDataFormat($employee_id)
    {
        $trainingType = TrainingType::where('status', 1)->get();
        $trainingInfo = TrainingInfo::where('employee_id', $employee_id)->get()->toArray();
        $arrayFormat = [];
        foreach ($trainingType as $value) {
            $temp = [];
            $hasData = array_search($value->training_type_id, array_column($trainingInfo, 'training_type_id'));
            if (gettype($hasData) == 'integer') {
                $temp['training_type_name'] = $value->training_type_name;
                $temp['action']             = "Yes";
                $temp['subject']            = $trainingInfo[$hasData]['subject'];
                $temp['organization_name']  = $trainingInfo[$hasData]['organization_name'];
                $temp['start_date']         = $trainingInfo[$hasData]['start_date'];
                $temp['end_date']           = $trainingInfo[$hasData]['end_date'];
                $temp['start_time']         = $trainingInfo[$hasData]['start_time'];
                $temp['end_time']           = $trainingInfo[$hasData]['end_time'];
                $temp['training_day']       = $trainingInfo[$hasData]['training_day'];
                $temp['training_hour']      = $trainingInfo[$hasData]['training_hour'];
                $temp['certificate']        = $trainingInfo[$hasData]['certificate'];
            } else {
                $temp['training_type_name'] = $value->training_type_name;
                $temp['action']             = "No";
                $temp['subject']            = '';
                $temp['organization_name']  = '';
                $temp['start_date']         = '';
                $temp['end_date']           = '';
                $temp['start_time']         = '';
                $temp['end_time']           = '';
                $temp['training_day']       = '';
                $temp['training_hour']      = '';
                $temp['certificate']        = '';
            }
            $arrayFormat[] = $temp;
        }

        return $arrayFormat;
    }



    public function downloadTrainingReport(Request $request)
    {
        $employeeInfo    = Employee::with('department')->where('employee_id', $request->employee_id)->first();
        $results         = $this->employeeTrainingDataFormat($request->employee_id);
        $printHead       = PrintHeadSetting::first();

        $data = [
            'results'   => $results,
            'printHead' => $printHead,
            'employee_name' => $employeeInfo->first_name . ' ' . $employeeInfo->last_name,
            'department_name' => $employeeInfo->department->department_name,
        ];

        $pdf = PDF::loadView('admin.training.report.pdf.employeeTrainingReportPdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $pageName = "training.pdf";
        return $pdf->download($pageName);
    }

    public function dateFilterTrainingReport(Request $request)
    {
        $from_date = dateConvertFormtoDB($request->from_date);
        $to_date = dateConvertFormtoDB($request->to_date);

        $totalEmployee = DB::table('employee')->count();

        $traningInfo = DB::table('training_info')
            ->select('training_info.*', 'training_type.training_type_name as training_type_name', DB::raw("CONCAT(employee.first_name,' ',employee.last_name) as full_name"))
            ->leftjoin('training_type', 'training_info.training_type_id', '=', 'training_type.training_type_id')
            ->leftjoin('employee', 'training_info.employee_id', '=', 'employee.employee_id')
            ->where('training_info.start_date', $from_date)
            ->orWhere('training_info.end_date', $to_date)->get();


        $pdf = PDF::loadView('admin.training.report.pdf.allEmployeeTrainingReportPdf', compact('traningInfo', 'from_date', 'to_date', 'totalEmployee'));
        $pdf->setPaper('A4', 'landscape');
        $pageName = "all-employee-training-report.pdf";
        // return $pdf->download($pageName);
        return $pdf->stream($pageName);

        // dd($traningInfo);
        // return view('admin.training.report.pdf.allEmployeeTrainingReportPdf', compact('traningInfo', 'from_date', 'to_date', 'totalEmployee'));
    }
}
