@extends('admin.master')
@section('content')
@section('title')
@if(isset($editModeData))

@lang('training.edit_employee_training')
@else

@lang('training.add_employee_training')

@endif
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
				<a href="{{route('trainingInfo.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('training.view_employee_training') </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if($errors->any())
								<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
									@foreach($errors->all() as $error)
										<strong>{!! $error !!}</strong><br>
									@endforeach
								</div>
							@endif
							@if(session()->has('success'))
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif

							@if(isset($editModeData))
								{{ Form::model($editModeData, array('route' => array('trainingInfo.update', $editModeData->training_info_id), 'method' => 'PUT','files' => 'true','id'=>'trainingInfoForm')) }}
							@else
								{{ Form::open(array('route' => 'trainingInfo.store','enctype'=>'multipart/form-data','id'=>'trainingInfoForm')) }}
							@endif
							<div class="form-body">

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('training.training_type')<span class="validateRq">*</span></label>
											{{ Form::select('training_type_id', $trainingTypeList, Input::old('training_type_id'), array('class' => 'form-control training_type_id required select2')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('common.employee_name')<span class="validateRq">*</span></label>
											{{ Form::select('employee_id',$employeeList, Input::old('employee_id'), array('class' => 'form-control employee_id required select2')) }}
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('training.subject')<span class="validateRq">*</span></label>
											{!! Form::text('subject',Input::old('subject'), $attributes = array('class'=>'form-control required subject','id'=>'subject','placeholder'=>__('training.subject'))) !!}
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">Organization Name<span class="validateRq">*</span></label>
											{!! Form::text('organization_name',Input::old('organization_name'), $attributes = array('class'=>'form-control required organization_name','id'=>'organization_name','placeholder'=>__('Organization Name'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<label for="exampleInput">@lang('common.from_date')<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
<!-- 											<input class="form-control start_date dateField" readonly required
                                            id="start_date" placeholder="@lang('common.from_date')"
                                            name="start_date" type="text" value="{{ old('start_date') }}"> -->
											{!! Form::text('start_date',isset($editModeData) ? dateConvertDBtoForm($editModeData->start_date) : Input::old('start_date'), $attributes = array('class'=>'form-control required dateField','readonly'=>'readonly','id'=>'start_date','placeholder'=>__('common.from_date'))) !!}
										</div>
									</div>
									<div class="col-md-4">
										<label for="exampleInput">@lang('common.to_date')<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											{!! Form::text('end_date',isset($editModeData) ? dateConvertDBtoForm($editModeData->end_date) : Input::old('end_date'), $attributes = array('class'=>'form-control required dateField','readonly'=>'readonly','id'=>'end_date','placeholder'=>__('common.to_date'))) !!}
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-4">
										<label for="exampleInput">Start Time<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
											<div class="bootstrap-timepicker">
												{!! Form::text('start_time',(isset($editModeData)) ? date("h:i a", strtotime($editModeData->start_time)) :  Input::old('start_time'), $attributes = array('class'=>'form-control timePicker start_time','id'=>'start_time','placeholder'=>__('Start Time'))) !!}
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<label for="exampleInput">End Time<span class="validateRq">*</span></label>
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
											<div class="bootstrap-timepicker">
												{!! Form::text('end_time',(isset($editModeData)) ? date("h:i a", strtotime($editModeData->end_time)) :  Input::old('end_time'), $attributes = array('class'=>'form-control timePicker end_time','id'=>'end_time','placeholder'=>__('End Time'))) !!}
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="exampleInput">Training Day<span class="validateRq">*</span></label>
											{!! Form::number('training_day',Input::old('training_day'), $attributes = array('class'=>'form-control required training_day','id'=>'training_day','placeholder'=>__('Training Day'))) !!}
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label for="exampleInput">Training Hour<span class="validateRq">*</span></label>
											{!! Form::number('training_hour',Input::old('training_hour'), $attributes = array('class'=>'form-control required training_hour','id'=>'training_hour','placeholder'=>__('Training Hour'))) !!}
										</div>
									</div>
								</div>
								<br>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('training.certificate')(JPG,JPEG,PNG,PDF)</label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-files-o"></i></span>
												{!! Form::file('certificate', $attributes = array('class'=>'form-control certificate','accept'=>'image/png, image/jpeg,image/jpg,.pdf')) !!}
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="exampleInput">@lang('training.description')</label>
											{!! Form::textarea('description',Input::old('description'), $attributes = array('class'=>'form-control','id'=>'description','placeholder'=>__('training.description'),'cols'=>'30','rows'=>'4')) !!}
										</div>
									</div>
								</div>

							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-6">
										@if(isset($editModeData))
											<button type="submit" class="btn btn-success btn_style"><i class="fa fa-pencil"></i> @lang('common.update')</button>
										@else
											<button type="submit" class="btn btn-success btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
										@endif
									</div>
								</div>
							</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
            var start_date;
            var start_time;
            $('#start_date').on('change', function() {
            	start_date = $('#start_date').val();
            });

            $('#end_date').on('change',function () {
            	var end_date = $('#end_date').val();
            	
            	start_date = moment(start_date,'D/M/YYYY');
                end_date = moment(end_date,'D/M/YYYY');
                // alert(start_date + ' = ' + end_date);
	            if(start_date != '' && end_date != ''){
	            	var total_day = end_date.diff(start_date, 'days');
	            	// var total_day = end_date.diff(start_date,'days');
	            	$('#training_day').val(total_day+1);
	            }
            });

		$('#start_time').timepicker({
		   useCurrent: false,
		   format: 'hh:mm:ss',
		});
	    $('#end_time').timepicker({
		   useCurrent: false,
		   format: 'hh:mm:ss',
		});

        $('#start_time').on('change', function() {
            start_time = $('#start_time').val();
            var end_time = $('#end_time').val();

	            if(start_time != '' && end_time != ''){
	            	var total_hours = moment.utc(moment(end_time, "HH:mm:ss").diff(moment(start_time, "HH:mm:ss"))).format("hh");
	            	$('#training_hour').val(total_hours);
	            }
        });

        $('#end_time').on('change', function() {
            var end_time = $('#end_time').val();
            start_time = $('#start_time').val();

            if(start_time != '' && end_time != ''){
            	var total_hours = moment.utc(moment(end_time, "HH:mm:ss").diff(moment(start_time, "HH:mm:ss"))).format("hh");
            	$('#training_hour').val(total_hours);
            }
        });
    });
    
</script>
@endsection