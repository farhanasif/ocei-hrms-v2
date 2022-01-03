@extends('admin.master')
@section('content')
@section('title')
@lang('services.ip_list')
@endsection
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
		   <ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>	
		<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
			<a href="{{ route('ip.add_ip_address') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('services.add_ip')</a>
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
						<div class="table-responsive">
							<table id="myTable" class="table table-bordered">
								<thead>
									 <tr class="tr_header">
                                        <th>@lang('common.serial')</th>
                                        <th>IP</th>
                                        <th>Status</th>
                                        <th style="text-align: center;">@lang('common.action')</th>
                                    </tr>
								</thead>
								<tbody>
									{!! $sl=null !!}
									@foreach($ip_data AS $value)
										<tr class="{!! $value->id !!}">
											<td style="">{!! ++$sl !!}</td>
											<td>{!! $value->ip_address !!}</td>
											@if($value->ip_status == 1)
												<td style="color: green !important; font-weight: 600;">Active</td>
											@else
												<td style="color: red !important; font-weight: 600;">Deactive</td>
											@endif
											<td style="width: 100px;">
												<a href="{!! route('ip.edit',$value->id) !!}"  class="btn btn-success btn-xs btnColor">
													<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
												</a>
												<a href="{!!route('ip.destroy',$value->id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												@if($value->ip_status == 1)
													<a href="{!!route('ip.status',$value->id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->ip_status !!}" class="status btn btn-xs statusBtn btn-warning" alt='Deactivate' style="color:green;"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
												@else
													<a href="{!!route('ip.status',$value->id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->ip_status !!}" class="status btn btn-warning btn-xs statusBtn" alt='Activate' style="color:red;"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
												@endif
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page_scripts')

	<script type="text/javascript">
        (function() {

        })();
	</script>
@endsection
