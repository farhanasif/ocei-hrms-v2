<?php

namespace App\Http\Controllers\Performance;

use App\Http\Requests\EmployeePerformanceRequest;

use App\Model\EmployeePerformanceDetails;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

use App\Model\PerformanceCriteria;

use App\Model\EmployeePerformance;
use App\Model\PerformanceCategory;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Model\Employee;

use Carbon\Carbon;


class EmployeePerformanceController extends Controller
{


    public function index()
    {
        $results = EmployeePerformance::select('employee_performance.*', 'employee.first_name', 'employee.last_name', DB::raw('AVG(rating) as avgRating'))
            ->leftJoin('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
            ->groupBy('employee_performance_details.employee_performance_id')
            ->orderBy('employee_performance_details.employee_performance_id', 'DESC')
            ->get();

        return view('admin.performance.employeePerformance.index', ['results' => $results]);
    }



    public function create()
    {
        $data['performanceCategory']           = PerformanceCategory::all();
        $data['employeeList']       = Employee::where('status', 1)->get();

        $criteria           = PerformanceCriteria::select('performance_criteria_id', 'performance_criteria.performance_category_id', 'performance_criteria_name', 'performance_category.performance_category_name')
            ->join('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->get()->toArray();

        $data['nisCriteria']           = PerformanceCriteria::select('performance_criteria_id', 'performance_criteria.performance_category_id', 'performance_criteria_name', 'performance_category.performance_category_name')
            ->join('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->where('performance_category.performance_category_id', 4)
            ->get()->toArray();

        $data['acrCriteria']           = PerformanceCriteria::select('performance_criteria_id', 'performance_criteria.performance_category_id', 'performance_criteria_name', 'performance_category.performance_category_name')
            ->join('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->where('performance_category.performance_category_id', 3)
            ->get()->toArray();

        // dd($data['employeeList']);

        $data['criteriaDataFormat'] = [];
        foreach ($criteria  as $value) {
            $criteriaDataFormat[$value['performance_category_name']][] = $value;
            // $criteriaDataFormat[$value['performance_category_id']][] = $value;
        }

        // dd($performanceCategory);

        // $data = [
        //     'employeeList'          => $employeeList,
        //     'criteriaDataFormat'    => $criteriaDataFormat,
        //     'performanceCategory'   => $performanceCategory,
        // ];

        return view('admin.performance.employeePerformance.addEmployeePerformance', $data);
    }



    public function store(Request $request)
    {
        // $input = $request->all();

        // $input['created_by'] = Auth::user()->user_id;
        // $input['updated_by'] = Auth::user()->user_id;

        // if (!isset($request->rating)) {
        //     return redirect()->back()->withInput()->with('error', 'Enter employee rating.');
        // }
        // try {
        //     DB::beginTransaction();
        //     $result = EmployeePerformance::create($input);
        //     $criteria = $this->performanceCriteriaDataFormat($input, $result->employee_performance_id);
        //     EmployeePerformanceDetails::insert($criteria);
        //     DB::commit();
        //     $bug = 0;
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $bug = $e->errorInfo[1];
        // }

        // if ($bug == 0) {
        //     return redirect('empPerformance/' . $result->employee_performance_id . '/edit')->with('success', 'Employee Performance Successfully saved.');
        // } else {
        //     return redirect('empPerformance')->with('error', 'Something Error Found !, Please try again.');
        // }

        if ($request->type == 'acr') {

            $acrInput = $request->all();
            $acrInput['status'] = 1;
            $acrInput['type'] = 'acr';
            $acrInput['created_by'] = Auth::user()->user_id;
            $acrInput['updated_by'] = Auth::user()->user_id;

            try {
                DB::beginTransaction();
                $result = EmployeePerformance::create($acrInput);
                $criteria = $this->acrPerformanceCriteriaDataFormat($acrInput, $result->employee_performance_id);
                EmployeePerformanceDetails::insert($criteria);
                DB::commit();
                $bug = 0;
            } catch (\Exception $e) {
                DB::rollback();
                $bug = $e->errorInfo[1];
            }

            if ($bug == 0) {
                return response()->json('success');
            } else {
                return response()->json('error');
            }

            // if ($bug == 0) {
            //     return redirect('empPerformance/' . $result->employee_performance_id . '/edit')->with('success', 'Employee Performance Successfully saved.');
            // } else {
            //     return redirect('empPerformance')->with('error', 'Something Error Found !, Please try again.');
            // }

        } elseif ($request->type == 'nis') {
            $nisInput = $request->all();
            // dd($nisInput);
            $nisInput['type'] = 'nis';
            $nisInput['status'] = 1;
            $nisInput['created_by'] = Auth::user()->user_id;
            $nisInput['updated_by'] = Auth::user()->user_id;

            try {
                DB::beginTransaction();
                $result = EmployeePerformance::create($nisInput);
                $criteria = $this->nisPerformanceCriteriaDataFormat($nisInput, $result->employee_performance_id);
                EmployeePerformanceDetails::insert($criteria);
                DB::commit();
                $bug = 0;
            } catch (\Exception $e) {
                DB::rollback();
                $bug = $e->errorInfo[1];
            }

            if ($bug == 0) {
                return response()->json('success');
            } else {
                return response()->json('error');
            }
        }
    }



    public function acrPerformanceCriteriaDataFormat($data, $employee_performance_id)
    {
        $dataFormat = [];
        for ($i = 0; $i < count($data['acr_rating']); $i++) {
            if ($data['acr_rating'][$i] != '') {
                $acr_rating  = $data['acr_rating'][$i];
            } else {
                $acr_rating  = 0;
            }
            $dataFormat[$i] = [
                'employee_performance_id'       => $employee_performance_id,
                'performance_criteria_id'       => $data['acr_performance_criteria_id'][$i],
                'rating'                        => $acr_rating,
                'comments'                      => $data['acr_comments'][$i],
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ];
        }
        return $dataFormat;
    }

    public function nisPerformanceCriteriaDataFormat($data, $employee_performance_id)
    {
        $dataFormat = [];
        for ($i = 0; $i < count($data['nis_rating']); $i++) {
            if ($data['nis_rating'][$i] != '') {
                $nis_rating  = $data['nis_rating'][$i];
            } else {
                $nis_rating  = 0;
            }
            $dataFormat[$i] = [
                'employee_performance_id'       => $employee_performance_id,
                'performance_criteria_id'       => $data['nis_performance_criteria_id'][$i],
                'rating'                        => $nis_rating,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ];
        }
        return $dataFormat;
    }


    public function performanceCriteriaDataFormat($data, $employee_performance_id)
    {
        // dd($data);

        $dataFormat = [];
        for ($i = 0; $i < count($data['rating']); $i++) {
            if ($data['rating'][$i] != '') {
                $rating  = $data['rating'][$i];
            } else {
                $rating  = 0;
            }
            $dataFormat[$i] = [
                'employee_performance_id'       => $employee_performance_id,
                'performance_criteria_id'       => $data['performance_criteria_id'][$i],
                'rating'                        => $rating,
                'judgement'                     => $data['judgement'][$i],
                'comments'                      => $data['comments'][$i],
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ];
        }
        return $dataFormat;
    }



    public function edit($id)
    {
        $editModeData       = EmployeePerformance::FindOrFail($id);
        $employeeList       = Employee::where('status', 1)->get();
        $criteria           = PerformanceCriteria::select(
            'performance_criteria.performance_criteria_id',
            'performance_criteria.performance_category_id',
            'performance_criteria_name',
            'performance_category.performance_category_name',
            'employee_performance_details.rating',
            'employee_performance_details.employee_performance_id',
            'employee_performance_details.judgement',
            'employee_performance_details.comments',
            'employee_performance_details.employee_performance_details_id'
        )
            ->leftJoin('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->leftJoin('employee_performance_details', 'employee_performance_details.performance_criteria_id', '=', 'performance_criteria.performance_criteria_id')
            ->where('employee_performance_details.employee_performance_id', $id)
            ->orWhereNull('employee_performance_details.employee_performance_id')
            ->get()->toArray();

        $criteriaDataFormat = [];
        foreach ($criteria  as $value) {
            $criteriaDataFormat[$value['performance_category_name']][] = $value;
        }

        $data = [
            'editModeData'  => $editModeData,
            'employeeList'  => $employeeList,
            'criteriaDataFormat' => $criteriaDataFormat,
        ];

        return view('admin.performance.employeePerformance.editEmployeePerformance', $data);
    }



    public function update(EmployeePerformanceRequest $request, $id)
    {
        $employeePerformance = EmployeePerformance::FindOrFail($id);
        $data = $request->all();
        if (isset($request->submit)) {
            $data['status'] = 1;
        }
        $data['created_by'] = Auth::user()->user_id;
        $data['updated_by'] = Auth::user()->user_id;
        try {

            DB::beginTransaction();
            $employeePerformance->update($data);
            for ($i = 0; $i < count($data['rating']); $i++) {
                if ($data['employee_performance_details_id'][$i] != '') {
                    $dataFormat = [
                        'performance_criteria_id'       => $data['performance_criteria_id'][$i],
                        'rating'                        => $data['rating'][$i],
                        'judgement'                     => $data['judgement'][$i],
                        'comments'                      => $data['comments'][$i],
                        'created_at'                    => Carbon::now(),
                        'updated_at'                    => Carbon::now(),
                    ];
                    EmployeePerformanceDetails::where('employee_performance_details_id', $data['employee_performance_details_id'][$i])->update($dataFormat);
                } else {
                    $dataFormat = [
                        'employee_performance_id'       => $id,
                        'performance_criteria_id'       => $data['performance_criteria_id'][$i],
                        'rating'                        => $data['rating'][$i],
                        'judgement'                     => $data['judgement'][$i],
                        'comments'                      => $data['comments'][$i],
                        'created_at'                    => Carbon::now(),
                        'updated_at'                    => Carbon::now(),
                    ];
                    EmployeePerformanceDetails::create($dataFormat);
                }
            }
            DB::commit();
            $bug = 0;
        } catch (\Exception $e) {
            DB::rollback();
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            if (isset($request->submit)) {
                return redirect('empPerformance')->with('success', 'Employee Performance Successfully Updated.');
            } else {
                return redirect()->back()->with('success', 'Employee Performance Successfully Updated.');
            }
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }



    public function show($id)
    {


        $criteria           = EmployeePerformance::select(
            'employee_performance.employee_id',
            'employee_performance.month',
            'employee_performance.employee_performance_id',
            'employee_performance_details.performance_criteria_id',
            'employee_performance_details.rating',
            'employee_performance_details.judgement',
            'employee_performance_details.comments',
            'employee.first_name',
            'employee.last_name',
            'performance_criteria.performance_criteria_name',
            'performance_criteria.performance_category_id',
            'performance_category.performance_category_name',
            'department.department_name'
        )
            ->join('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
            ->join('performance_criteria', 'performance_criteria.performance_criteria_id', '=', 'employee_performance_details.performance_criteria_id')
            ->join('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->join('department', 'department.department_id', '=', 'employee.department_id')
            ->where('employee_performance.employee_performance_id',$id)
            // ->groupBy('performance_category.performance_category_name')
            ->get();

        $employeeId = $criteria[0]['employee_id'];

        $criteriaDataFormat = [];
        foreach ($criteria  as $value) {
            $criteriaDataFormat[$value['performance_category_name']][] = $value;
        }
        // dd($criteriaDataFormat);
        return view('admin.performance.employeePerformance.employeePerformanceDetails', ['criteriaDataFormat' => $criteriaDataFormat, 'employeeId' => $employeeId, 'performance_id' => $id]);
    }

    public function performanceDetailsPDfDownload($id)
    {

        $criteria           = EmployeePerformance::select(
            'employee_performance.employee_id',
            'employee_performance.month',
            'employee_performance.employee_performance_id',
            'employee_performance_details.performance_criteria_id',
            'employee_performance_details.rating',
            'employee_performance_details.judgement',
            'employee_performance_details.comments',
            'employee.first_name',
            'employee.last_name',
            'performance_criteria.performance_criteria_name',
            'performance_criteria.performance_category_id',
            'performance_category.performance_category_name',
            'department.department_name'
        )
            ->join('employee_performance_details', 'employee_performance_details.employee_performance_id', '=', 'employee_performance.employee_performance_id')
            ->join('employee', 'employee.employee_id', '=', 'employee_performance.employee_id')
            ->join('performance_criteria', 'performance_criteria.performance_criteria_id', '=', 'employee_performance_details.performance_criteria_id')
            ->join('performance_category', 'performance_category.performance_category_id', '=', 'performance_criteria.performance_category_id')
            ->join('department', 'department.department_id', '=', 'employee.department_id')
            ->where('employee_performance.employee_performance_id',$id)
            // ->groupBy('performance_category.performance_category_name')
            ->get();

        // dd($criteria);
        $pdf = PDF::loadView('admin.performance.report.pdf.performanceDetailsPdfDownload', ['criteriaDataFormat' => $criteria]);
        $pdf->setPaper('A4', 'landscape');
        $pageName = ".employee-performance-details.pdf";
        return $pdf->download($pageName);

        // return view('admin.performance.report.pdf.nisPerformanceReport', ['criteriaDataFormat' => $criteria]);
    }



    public function destroy($id)
    {
        try {

            // $data = PerformanceCategory::find($id);
            // $data->delete();
            EmployeePerformance::where('employee_performance_id', '=', $id)->delete();
            EmployeePerformanceDetails::where('employee_performance_id', '=', $id)->delete();
            $bug = 0;
        } catch (\Exception $e) {
            // dd($e);
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            echo "success";
        } elseif ($bug == 1451) {
            echo 'hasForeignKey';
        } else {
            echo 'error';
        }
    }

    public function performancePerformanceSelectData(Request $request)
    {
        $getPayGradeId = DB::table('employee')->where('employee_id',$request->employee_id)->first()->pay_grade_id;

        $payGradeName = DB::table('pay_grade')->where('pay_grade_id',$getPayGradeId )->first()->pay_grade_name;

        return response()->json($payGradeName);
    }
}
