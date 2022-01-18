<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

use App\Model\LeaveApplication;

use App\Model\EarnLeaveRule;

use App\Model\LeaveType;

use App\Model\Employee;
use DateTime;

class LeaveRepository
{

    public function calculateTotalNumberOfLeaveDays($application_from_date,$application_to_date,$leave_type_id){

        $holidays  = DB::select(DB::raw('call SP_getHoliday("'. $application_from_date .'","'.$application_to_date .'")'));
        $public_holidays = [];
        foreach ($holidays as $holidays) {
            $start_date = $holidays->from_date;
            $end_date = $holidays->to_date;
            while (strtotime($start_date) <= strtotime($end_date)) {
                $public_holidays[] = $start_date;
                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            }
        }

        $weeklyHolidays = DB::select(DB::raw('call SP_getWeeklyHoliday()'));
        $weeklyHolidayArray = [];
        foreach ($weeklyHolidays as $weeklyHoliday){
            $weeklyHolidayArray[]=$weeklyHoliday->day_name;
        }

        $target = strtotime($application_from_date);
        $countDay = 0;
        while ($target <= strtotime(date("Y-m-d", strtotime($application_to_date)))) {

            $value = date("Y-m-d", $target);
            $target += (60 * 60 * 24);

            //get weekly  holiday name
            $timestamp = strtotime($value);
            $dayName = date("l", $timestamp);

            //if not in holidays and not in weekly  holidays
            if (!in_array($value, $public_holidays) && !in_array($dayName,$weeklyHolidayArray)) {
                $countDay++;
            }
        }

        return [$countDay,$leave_type_id];
    }



    public function calculateEmployeeLeaveBalance($leave_type_id,$employee_id){
        if($leave_type_id == 1){
            return $this->calculateEmployeeEarnLeave($leave_type_id,$employee_id);
        }else {
            $leaveType = LeaveType::where('leave_type_id', $leave_type_id)->first();
            $leaveBalance = DB::select(DB::raw('call SP_calculateEmployeeLeaveBalance(' . $employee_id . ',' . $leave_type_id . ')'));
            return $leaveType->num_of_day - $leaveBalance[0]->totalNumberOfDays;
        }
    }



    public function calculateEmployeeEarnLeave($leave_type_id,$employee_id,$action=false){

        $employeeInfo          = Employee::where('employee_id',$employee_id)->first();
        $joiningYearAndMonth   = explode('-',$employeeInfo->date_of_joining);

        $joiningYear    = $joiningYearAndMonth[0];
        $joiningMonth   = (int) $joiningYearAndMonth[1];

        $currentYear    = date("Y");
        $currentMonth   = (int) date("m");

        $totalMonth = 0;

        if($joiningYear == $currentYear){
            for($i = $joiningMonth;$i <= $currentMonth;$i++){
                $totalMonth +=1;
            }
        }else{
           for($i = 1;$i <= $currentMonth;$i++){
               $totalMonth +=1;
           }
        }


        $ifExpenseLeave = LeaveApplication::select(DB::raw('IFNULL(SUM(leave_application.number_of_day), 0) as number_of_day'))
                        ->where('employee_id',$employee_id)
                        ->where('leave_type_id',$leave_type_id)
                        ->where('status',2)
                        ->whereBetween('approve_date',[date("Y-01-01"),date("Y-12-31")])
                        ->first();

        $earnLeaveRule = EarnLeaveRule::first();


        if($action == 'getEarnLeaveBalanceAndExpenseBalance'){
            $totalNumberOfDays = $totalMonth * $earnLeaveRule->day_of_earn_leave;
            $data = [
                'totalEarnLeave' => round($totalMonth * $earnLeaveRule->day_of_earn_leave),
                'leaveConsume' => $ifExpenseLeave->number_of_day,
                'currentBalance' => round($totalNumberOfDays - $ifExpenseLeave->number_of_day),
            ];
            return $data;
        }

        $totalNumberOfDays = $totalMonth * $earnLeaveRule->day_of_earn_leave;
        return   round($totalNumberOfDays - $ifExpenseLeave->number_of_day);
    }

    public function totalServiceDay($joiningDate, $currDate)
    {
        $curr_date = new DateTime($currDate);
        $join_date = new DateTime($joiningDate);
        $interval = $curr_date->diff($join_date);
        $total_service_day = $interval->format("%a");
        return $total_service_day;
    }

   public function totalLeave($employee_id, $joiningdate, $curr_date, $leave_date_Array)
   {
        $totalLeaveDay = LeaveApplication::select(DB::raw('IFNULL(SUM(leave_application.number_of_day), 0) as number_of_day'))
                        ->where('employee_id',$employee_id)
                        ->where('status',2)
                        ->whereIn('leave_type_id',$leave_date_Array)
                        ->whereBetween('application_to_date',[$joiningdate,$curr_date])
                        ->first();
        return $totalLeaveDay->number_of_day;
   }

   public function earnLeave($total_day, $employee_id, $joiningdate, $curr_date)
   {
        $full_leave_use =  $this->totalLeave($employee_id, $joiningdate, $curr_date, [11]);
        $half_leave_use = 0;
           if($full_leave_use > 180){

                $full_leave_use = 180;
                $half_leave_use = ($full_leave_use - 180) * 2;
           }

        $full_leave_use +=  $this->totalLeave($employee_id, $joiningdate, $curr_date, [19,20]);

        return ($this->fullEarnleave($total_day) - $full_leave_use) + (($this->halfEarnleave($total_day) - $half_leave_use )/2);
   }

   public function fullEarnleave($total_day)
   {
        return $total_day%11 > 5 ? (int)($total_day/11) + 1 : (int)($total_day/11);
   }

   public function halfEarnleave($total_day)
   {
        return $total_day%12 > 5 ? (int)($total_day/12) + 1 : (int)($total_day/12);
   }
}
