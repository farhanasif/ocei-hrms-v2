<?php

namespace App\Http\Controllers\Leave;

use App\Http\Requests\PublicHolidayRequest;
use App\Http\Requests\HolidayCalendarRequest;
use App\Repositories\CommonRepository;

use App\Http\Controllers\Controller;

use App\Model\HolidayDetails;
use App\Model\HolidayCalendar;

use Illuminate\Http\Request;
use DB;

class HolidayCalendarController extends Controller
{
	
    protected $commonRepository;

    public function __construct(CommonRepository $commonRepository){
        $this->commonRepository = $commonRepository;
    }


    public function index(){
        // $results = HolidayDetails::with('holiday')->orderBy('holiday_details_id', 'desc')->get();
        // return view('admin.leave.publicHoliday.index',['results'=>$results]);

        $results = DB::table('holiday_file')
                      ->select('holiday_file.*','leave_type.leave_type_name')
                      ->join('leave_type','leave_type.leave_type_id','holiday_file.leave_id')
                      ->get();
        return view('admin.leave.holidayCalendar.index', ['results'=>$results]);
    }


    public function create(){
        $holidayList = DB::table('holiday_file')->get();
        return view('admin.leave.holidayCalendar.form',['holidayList' => $holidayList]);
    }


    public function store(HolidayCalendarRequest $request){

        $input              = $request->all();
        $input['is_active'] = 1;



        $file = $request->file('image');
        //save format
        
        //save full adress of image
        // $patch = $request->image->store('images');

        
        if ($file) {
            $ext = $request->image->extension();
            // dd($ext);
           if($ext != 'jpeg' and $ext != 'png') {
                return redirect('holidayCalendar')->with('error', 'Holiday Calendar extension is invalid.');
           }

            $name = $file->getClientOriginalName();
            $file->move(public_path('/uploads/calendarImg'),$name);
            $input['image'] = $name;
        }

        try{
            HolidayCalendar::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('holidayCalendar')->with('success', 'Holiday Calendar Uploaded successfully.');
        }else {
            return redirect('holidayCalendar')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function edit($id){
        $holidayList    = $this->commonRepository->holidayList();
        $editModeData   = HolidayCalendar::findOrFail($id);
        return view('admin.leave.publicHoliday.form',['editModeData' => $editModeData,'holidayList'=>$holidayList]);
    }


    public function update(HolidayCalendarRequest $request,$id) {
        $holidayDetails     = HolidayDetails::findOrFail($id);
        $input              = $request->all();
        $input['from_date'] = dateConvertFormtoDB($input['from_date']);
        $input['to_date']   = dateConvertFormtoDB($input['to_date']);
        try{
            $holidayDetails->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect()->back()->with('success', 'Public holiday successfully updated. ');
        }else {
            return redirect()->back()->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function destroy($id){
        try{
            $holidayDetails = HolidayDetails::findOrFail($id);
            $holidayDetails->delete();
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
