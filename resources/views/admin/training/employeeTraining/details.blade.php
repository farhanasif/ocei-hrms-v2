@extends('admin.master')
@section('content')
@section('title')
@lang('training.employee_training_details')
@endsection

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
				<a href="{{route('trainingInfo.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('training.view_employee_training') </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<div class="col-lg-offset-2 col-md-8">
								<div class="white-box">
									<div class="comment-center p-t-10">
										<div class="comment-body">
											<div class="mail-contnet">
												<h5>
													<b>@lang('common.employee_name'):</b>
													@if(isset($result->employee->first_name))
														{{$result->employee->first_name}} {{ $result->employee->last_name}}
													@endif
												</h5>
												<h5>
													<b>@lang('department.department_name'):</b>
													@if(isset($result->employee->department->department_name))
														{{$result->employee->department->department_name}}
													@endif
												</h5>
												<h5>
													<b>@lang('training.training_type'):</b>
													@if(isset($result->trainingType->training_type_name))
														{{$result->trainingType->training_type_name}}
													@endif
												</h5>
												<h5>
													<b>Training Name:</b>
													@if(isset($result->subject))
														{{$result->subject}}
													@endif
												</h5>
												<h5>
													<b>Organization Name:</b>
													@if(isset($result->organization_name))
														{{$result->organization_name}}
													@endif
												</h5>
												<h5>
													<b>Training Date&Time:</b>
													{{dateConvertDBtoForm($result->start_date)}} To {{dateConvertDBtoForm($result->end_date	)}} &nbsp;&nbsp;
													{!! date("h:i a", strtotime($result->start_time)) !!} To
													{!! date("h:i a", strtotime($result->end_time)) !!}
												</h5>
												<h5>
													<b>@lang('training.training_duration'):</b>
													{{$result->training_day}} Day &nbsp;
													{{$result->training_hour}} Hour
													@php
														
														$start_time = new DateTime($result->start_time);
														$end_time 	= new DateTime($result->end_time);
														$interval 	= $end_time->diff($start_time);
														$hour 	= $interval->format('%H');
														$minutes 	= $interval->format('%I');
														$total_hour_minute = (int)($hour*60);
														$minute = (int)$minutes;

														// dd(ceil(($total_hour_minute + $minute)/60));
														// dd($total_hour_minute);


													@endphp
												</h5>

												<br>
												<br/><span class="">
													{{$result->description}}
												</span>
												<br/>
												<br/>
												<br/>
												@php
													if($result->certificate!='')
													{
														$info  = new SplFileInfo($result->certificate);
														$extension = $info->getExtension();

														if($extension === 'png' || $extension === 'jpg' || $extension === 'jpeg' || $extension === 'PNG' || $extension === 'JPG' || $extension === 'JPEG'){
															echo '<img src="'.asset('uploads/employeeTrainingCertificate/'.$result->certificate).'" width="100%" >';
														}else{
															echo '<embed src="'.asset('uploads/employeeTrainingCertificate/'.$result->certificate).'" width="100%" height="550px" />';
														}
													}
												@endphp

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

