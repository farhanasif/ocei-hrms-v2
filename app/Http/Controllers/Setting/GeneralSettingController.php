<?php

namespace App\Http\Controllers\Setting;

use App\Model\PrintHeadSetting;
use Illuminate\Support\Facades\Validator;

use App\Model\CompanyAddressSetting;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\IpSetting;
use App\Model\WhiteListedIp;
use DB;

class GeneralSettingController extends Controller
{


    public function index()
    {
        $data           = CompanyAddressSetting::first();
        $printHeadData  = PrintHeadSetting::first();
        return view('admin.setting.generalSetting',['data' => $data,'printHeadData'=>$printHeadData]);
    }


    public function store(Request $request)
    {
        $validator=validator::make($request->all(),[
            'address'=>'required|max:2000',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $input = $request->all();
        try{
            CompanyAddressSetting::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('generalSettings')->with('success', 'Company Address Successfully saved.');
        }else {
            return  redirect('generalSettings')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function update(Request $request,$id)
    {
        $validator=validator::make($request->all(),[
            'address'=>'required|max:2000',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = CompanyAddressSetting::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('generalSettings')->with('success', 'Company Address Successfully Updated.');
        }else {
            return redirect('generalSettings')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function printHeadSettingsStore(Request $request)
    {
        $validator=validator::make($request->all(),[
            'description'=>'required|max:2000',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $input = $request->all();
        try{
            PrintHeadSetting::create($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug==0){
            return redirect('generalSettings')->with('success', 'Print Head Successfully saved.');
        }else {
            return redirect('generalSettings')->with('error', 'Something Error Found !, Please try again.');
        }
    }


    public function printHeadSettingsUpdate(Request $request,$id)
    {
        $validator=validator::make($request->all(),[
            'description'=>'required|max:2000',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = PrintHeadSetting::FindOrFail($id);
        $input = $request->all();
        try{
            $data->update($input);
            $bug = 0;
        }
        catch(\Exception $e){
            $bug = $e->errorInfo[1];
        }

        if($bug == 0){
            return redirect('generalSettings')->with('success', 'Print Head Successfully Updated.');
        }else {
            return redirect('generalSettings')->with('error', 'Something Error Found !, Please try again.');
        }
    }

  public function ipSetting()
  {
    $ip_data = DB::table('ip_settings')->get();
    return view('admin.setting.ip.ip_setting',['ip_data'=>$ip_data]);
  }

  public function addNewIp()
  {
     return view('admin.setting.ip.add_ip_address');
  }

 public function ipStore(Request $request)
 {
    try{
        $input = $request->all();

        if($request->ip_address1 and $request->ip_address2){
            $start = explode('.', $request->ip_address1);
            $end = explode('.', $request->ip_address2);
            $startIp = (int)$start[3];
            $endIp = (int)$end[3];

            for($i = $startIp ; $i <= $endIp; $i++){
                $current_ip = $start[0].'.'.$start[1].'.'.$start[2].'.'.$i;
                $input['ip_address'] = $current_ip;
                $ip = IpSetting::create($input);
                $whiteIp['ip_setting_id'] = $ip->id;
                $whiteIp['white_listed_ip'] = $current_ip;
                WhiteListedIp::create($whiteIp);
            }
        }elseif ($request->ip_address) {
            $ip = IpSetting::create($input);
            $whiteIp['ip_setting_id'] = $ip->id;
            $whiteIp['white_listed_ip'] = $request->ip_address;
            WhiteListedIp::create($whiteIp);
        }
        return redirect()->back()->with('success', 'New IP Address added Successfully.');
    }catch(\Exception $e){
        return redirect()->back()->with('error', 'Sorry! Sometheings is wrong .... New IP Address adding UnSuccessful.');
    }
    return view('admin.setting.ip.add_ip_address');
 }

 public function editIp(Request $request, $id)
 {
    $old_ip = IpSetting::find($id);
    return view('admin.setting.ip.edit_ip_address',['old_ip'=>$old_ip]);
 }

 public function updateIp(Request $request)
 {
   $ip = IpSetting::find($request->id);
   $ip->update(['ip_address'=> $request->ip_address]);
   return redirect()->back()->with('success', 'Ip Address edited Successfully.');
 }

 public function deleteIp(Request $request, $id)
 {
    $ip = IpSetting::find($id);
    $ip->delete();
    WhiteListedIp::where('ip_setting_id',$ip->ip_setting_id)->delete();
    return redirect()->back()->with('success', 'Successfully Ip Address deleted.');
 }

 public function changeIpStatus(Request $request, $id)
 {
    $ip = IpSetting::find($id);
    $ip->update(['ip_status'=> !$ip->ip_status, 'status'=> !$ip->status]);
    return redirect()->back()->with('success', 'Successfully Ip Address Status changes.');
 }
}
