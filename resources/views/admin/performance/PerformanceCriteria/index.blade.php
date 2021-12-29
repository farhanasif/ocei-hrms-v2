@extends('admin.master')
@section('content')
@section('title')
@lang('performance.performance_criteria_list')
@endsection
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
		   <ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>	
		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
			<a href="{{ route('performanceCriteria.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('performance.add_performance_criteria')</a>
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
						<div class="tabbable">
							<ul class="nav nav-tabs" id="acr_nis">
								<li class="@if(count($results['acr'])) active @endif">
									<a data-toggle="tab" href="#acr">
										<i class="blue ace-icon fa fa-tasks bigger-120"></i>
										ACR 
									</a>
								</li>

								<li class="@if(!count($results['acr']) && count($apps['nis'])) active @endif">
									<a data-toggle="tab" href="#nis">
										<i class="blue ace-icon fa fa-tasks bigger-120"></i>
										NIS
									</a>
								</li>
							</ul>
							<div class="tab-content" style="padding-bottom: 20px;">
								<div class="table-responsive tab-pane fade in @if(count($results['acr'])) active @endif" id="acr">
									<table id="myTable" class="table table-bordered">
										<thead>
											 <tr class="tr_header">
		                                        <th>@lang('common.serial')</th>
		                                        <th>@lang('performance.performance_category_name')</th>
		                                        <th>@lang('performance.performance_criteria_name') English</th>
		                                        <th> Performance Criteria Name Bangla</th>
		                                        <th style="text-align: center;">@lang('common.action')</th>
		                                    </tr>
										</thead>
										<tbody>
										{!! $sl=null !!}
										@foreach($results['acr'] AS $value)
											<tr class="{!! $value->performance_criteria_id !!}">
												<td style="">{!! ++$sl !!}</td>
												<td>@if(isset($value->category->performance_category_name )) {{ $value->category->performance_category_name }} @endif</td>
												<td>{!! $value->performance_criteria_name !!}</td>
												<td>{!! $value->performance_criteria_name_bn !!}</td>
												<td style="width: 100px;">
													<a href="{!! route('performanceCriteria.edit',$value->performance_criteria_id) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('performanceCriteria.delete',$value->performance_criteria_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->performance_criteria_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
							    </div>
							    <div class="table-responsive tab-pane fade in @if(!count($results['acr']) && count($apps['nis'])) active @endif" id="nis">
									<table id="myTable1" class="table table-bordered">
										<thead>
											 <tr class="tr_header">
		                                        <th>@lang('common.serial')</th>
		                                        <th>@lang('performance.performance_category_name')</th>
		                                        <th>@lang('performance.performance_criteria_name') English</th>
		                                        <th> Performance Criteria Name Bangla</th>
		                                        <th style="text-align: center;">@lang('common.action')</th>
		                                    </tr>
										</thead>
										<tbody>
										{!! $sl=null !!}
										@foreach($results['nis'] AS $value)
											<tr class="{!! $value->performance_criteria_id !!}">
												<td style="">{!! ++$sl !!}</td>
												<td>@if(isset($value->category->performance_category_name )) {{ $value->category->performance_category_name }} @endif</td>
												<td>{!! $value->performance_criteria_name !!}</td>
												<td>{!! $value->performance_criteria_name_bn !!}</td>
												<td style="width: 100px;">
													<a href="{!! route('performanceCriteria.edit',$value->performance_criteria_id) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('performanceCriteria.delete',$value->performance_criteria_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->performance_criteria_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
	</div>
</div>
@endsection

@section('page_scripts')
<script>
  $(function () {
    $('#acr_nis li:first-child a').tab('show');
    $('#myTable1').DataTable({
                "ordering": false,
    });
  })
	// $(function () {
	// 	$('#nis').hide();
	// 	  $('#acr').on('click',function(){
	// 	  	$('#acr').show();
	// 	  	$('#nis').hide();
	// 	  })
	// 	  $('#nis').on('click',function(){
	// 	  	console.log('nis');
	// 	  	$('#acr').hide();
	// 	  	$('#nis').show();
	// 	  })
	// });
</script>
@endsection
