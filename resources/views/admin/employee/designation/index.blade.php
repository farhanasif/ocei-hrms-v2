@extends('admin.master')
@section('content')
@section('title')
@lang('designation.designation_list')
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
			<a href="{{ route('designation.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('designation.add_designation')</a>
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
							<table id="myTable12" class="table table-bordered">
								<thead>
									 <tr class="tr_header">
                                        <th>@lang('common.serial')</th>
                                        <th>@lang('designation.designation_name')</th>
										<th> Position No</th>
										<th> Total Employee </th>
										<th> Working Employee </th>
										<th> Vacant Post </th>
                                        <th style="text-align: center;">@lang('common.action')</th>
                                    </tr>
								</thead>
								<tbody>
									{!! $sl=null !!}
									@foreach($results AS $value)

									@php
										$wroking_employee = DB::table('employee')->where('designation_id',$value->designation_id)->count();
									@endphp
										<tr class="{!! $value->designation_id !!}" data-index="{{ $value->designation_id }}" data-position="{{ $value->position_no }}"> 
											<td style="width: 100px;">{!! ++$sl !!}</td>
											<td>{!! $value->designation_name !!}</td>
											<td>{!! $value->position_no !!}</td>
											<td>{!! $value->total_vacant !!}</td>
											<td>{!! $wroking_employee !!}</td>
											<td>{!! abs($value->total_vacant - $wroking_employee) !!}</td>
											<td style="width: 100px;">
												<a href="{!! route('designation.edit',$value->designation_id) !!}"  class="btn btn-success btn-xs btnColor">
													<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
												</a>
												<a href="{!!route('designation.delete',$value->designation_id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->designation_id!!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

{{-- <script
src="http://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script> --}}
<script
src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
crossorigin="anonymous"></script>
<script>
	$(document).ready(function () {
           $('table tbody').sortable({
               update: function (event, ui) {
                   $(this).children().each(function (index) {
                        if ($(this).attr('data-position') != (index+1)) {
                            $(this).attr('data-position', (index+1)).addClass('updated');
                        }
                   });

                   saveNewPositions();
               }
           });
        });

		function saveNewPositions() {
            var positions = [];
            $('.updated').each(function () {
               positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
               $(this).removeClass('updated');
            });

            $.ajax({
               url: "{{route('designation.order')}}",
               method: 'GET',
               dataType: 'text',
               data: {
                   update: 1,
                   positions: positions
               }, success: function (response) {
                   alert('Designation re-order success');
				   window.location.reload();
               }
            });
        }

</script>
@endsection
