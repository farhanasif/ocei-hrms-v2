@extends('admin.master')
@section('content')
@section('title')
@lang('leave.my_application_list')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<a href="{{ route('applyForLeave.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('leave.apply_for_leave')</a>
			</div>	
		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-success">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(session()->has('success'))
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
							<div class="">
								<table class="table table-hover manage-u-table">
									<thead >
                                         <tr>
                                            <th>#</th>
                                            <th>@lang('common.employee_name')</th>
                                            <th>@lang('leave.leave_type')</th>
                                            <th>@lang('leave.request_duration')</th>
                                            {{-- <th>@lang('leave.number_of_day')</th> --}}
                                            <th>Status</th>
                                            {{-- <th>@lang('leave.reject_status')</th> --}}
                                            <th>@lang('common.status')</th>
											<th>Attachment</th>
											<th>Action</th>
                                        </tr>
									</thead>
									<tbody>
										{!! $sl=null !!}
										@foreach($results AS $value)
											<tr>
												<td>{!! ++$sl !!}</td>
												<td>
													@if(isset($value->employee->first_name)) {!! $value->employee->first_name !!} @endif
													@if(isset($value->employee->last_name)) {!! $value->employee->last_name !!} @endif
												</td>
												<td>
													@if(isset($value->leaveType->leave_type_name)) {!! $value->leaveType->leave_type_name !!} @endif
												</td>
												<td style="text-align: justify-all;">
												    @if($value->leave_date_list)
												    	@foreach($value->leave_date_list as $l_k => $listDate)
												    		{!! dateConvertDBtoForm($listDate) !!}
												    		@if($l_k == count($value->leave_date_list) - 2)
												    		 and
												    		@elseif($l_k < count($value->leave_date_list) - 2)
												    			,
												    		@endif
												    		@if( ($l_k+1) %2 == 0)
												    		   <br />
												    		@endif
												    	@endforeach
												    @else
														{!! dateConvertDBtoForm($value->application_from_date) !!} <b>to</b> {!! dateConvertDBtoForm($value->application_to_date) !!}
													@endif
													<br/><span class="text-muted">Application Date : {!! dateConvertDBtoForm($value->application_date) !!}</span>
													<br/><span class="text-muted">@lang('leave.number_of_day') : {!! $value->number_of_day !!}</span>
												</td>

												{{-- <td>{!! $value->number_of_day !!}</td> --}}
												<td>
												    @if($value->reject_date or $value->approve_date)
														@if(isset($value->approveBy->first_name))
															{!! $value->approveBy->first_name !!} {!! $value->approveBy->last_name !!}
															<br/><span class="text-muted">@lang('leave.approve_date') : {!! dateConvertDBtoForm($value->approve_date) !!}</span>
														@endif
														<hr>
														@if(isset($value->rejectBy->first_name))
															{!! $value->rejectBy->first_name !!} {!! $value->rejectBy->last_name !!}
															<br/><span class="text-muted">@lang('common.reject_date') : {!! dateConvertDBtoForm($value->reject_date) !!}</span>
														@endif
													@else
													   Waiting for Office Approval Or Reject
													@endif
												</td>
												{{-- <td>
													
												</td> --}}

												@if($value->status == 1)
													<td  style="width: 100px;">
														<span class="label label-warning">@lang('common.pending')</span>
													</td>
												@elseif($value->status == 2)
													<td  style="width: 100px;">
														<span class="label label-success">@lang('common.approved')</span>
													</td>
												@else
													<td  style="width: 100px;">
														<span class="label label-danger">@lang('common.rejected')</span>
													</td>
												@endif
												<td>
													@if ($value->attachment != '' && file_exists('uploads/leaveApplication/' . $value->attachment))
													<a class="btn btn-success" style="color: white"
														target="_blank" href="{!! asset('uploads/leaveApplication/' . $value->attachment) !!}">
														Attachment</a>
													@else
														<a href="javascript:void(0)"> Empty </a>
													@endif
												</td>
												{{-- <td>
													<a  title="View Details" href="{{route('applyForLeave.show',$value->leave_application_id)}}" class="btn btn-primary btn-xs btnColor">
														<i class="glyphicon glyphicon-th-large" aria-hidden="true"></i>
													</a>
												</td> --}}

												@if($value->status == 1)
													<td>
														<a href="{!!route('applyForLeave.delete',$value->leave_application_id  )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->leave_application_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
													</td>
												@endif
											</tr>
										@endforeach
									</tbody>
								</table>
								<div class="text-center">
									{{$results->links()}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
