<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\DesignationRequest;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Designation;

use App\Model\Employee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{

    public function index()
    {
        // $results = Designation::orderBy('position_no', 'asc')->get();
        $results = Designation::all()->sortBy("position_no");
        // dd($results);

        return view('admin.employee.designation.index', ['results' => $results]);
    }


    public function create()
    {
        return view('admin.employee.designation.form');
    }


    public function store(DesignationRequest $request)
    {
        // $input = $request->all();
        // dd($input);
        try {

            // if (is_null($request->position_no)) {
            //     $request->position_no = Designation::max('position_no') + 1;
            //     return;
            // }

            $lowerPriorityDesignations = Designation::where('position_no', '>=', $request->position_no)
                ->get();

            // dd($lowerPriorityDesignations);

            if ($lowerPriorityDesignations) {
                foreach ($lowerPriorityDesignations as $lowerPriorityCategory) {
                    $lowerPriorityCategory->position_no++;
                    $lowerPriorityCategory->save();
                }

                Designation::create(
                    [
                        'designation_name'  => $request->designation_name,
                        'total_vacant'      => $request->total_vacant,
                        'position_no'       => $request->position_no
                    ]
                );
            } else {
                Designation::create(
                    [
                        'designation_name'  => $request->designation_name,
                        'total_vacant'      => $request->total_vacant,
                        'position_no'       => $request->position_no
                    ]
                );
            }


            // dd('ok');
            // Designation::create($input);
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect('designation')->with('success', 'Designation Successfully saved.');
        } else {
            return redirect('designation')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id)
    {
        $editModeData = Designation::findOrFail($id);
        return view('admin.employee.designation.form', ['editModeData' => $editModeData]);
    }


    public function update(DesignationRequest $request, $id)
    {
        $data = Designation::findOrFail($id);
        $input = $request->all();
        try {
            $data->update($input);
            $bug = 0;
        } catch (\Exception $e) {
            $bug = $e->errorInfo[1];
        }

        if ($bug == 0) {
            return redirect()->back()->with('success', 'Designation Successfully updated.');
        } else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id)
    {

        $count = Employee::where('designation_id', '=', $id)->count();

        if ($count > 0) {

            return  'hasForeignKey';
        }

        try {
            // $lowerPriorityCategories = Designation::where('position', '>', $category->position)
            //     ->get();

            // foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            //     $lowerPriorityCategory->position--;
            //     $lowerPriorityCategory->save();
            // }

            $department = Designation::FindOrFail($id);
            $department->delete();
            $bug = 0;
        } catch (\Exception $e) {
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

    public function order(Request $request)
    {
        if (isset($_GET['update'])) {
            foreach ($_GET['positions'] as $position) {
                $index = $position[0];
                $newPosition = $position[1];
                DB::table('designation')->where('designation_id', $index)->update(['position_no' => $newPosition]);
            }

            // dd($newPosition);

            echo ('success');
        }
    }
}
