@extends('admin.master')
@section('content')
@section('title')
@if(isset($editModeData))
	@lang('Edit Holiday Calendar')
@else
	@lang('Add Holiday Calendar')
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
				<a href="{{route('publicHoliday.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('View Holiday Calendar')</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
								@if(isset($editModeData))
									{{ Form::model($editModeData, array('route' => array('holidayCalendar.update', $editModeData->id), 'method' => 'PUT','files' => 'true','enctype'=>'multipart/form-data', 'id' => 'holidayCalendarForm','class' => 'form-horizontal')) }}
								@else
									{{ Form::open(array('route' => 'holidayCalendar.store','enctype'=>'multipart/form-data','id'=>'holidayCalendarForm','class' => 'form-horizontal')) }}
								@endif
								<div class="form-body">
									<div class="row">
										<div class="col-md-offset-2 col-md-6">
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
													<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
												</div>
											@endif
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">Holiday Name<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<!-- {{ Form::select('holiday_id',$holidayList, Input::old('leave_id'), array('class' => 'form-control holiday_id select2 required')) }} -->
													<select class="form-control holiday_id select2 required" name="leave_id" id="leave_id">
														<option value="">--- select Holiday ---</option>
														<option value="21">Public Holiday</option>
														<option value="22">Government Holiday</option>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">Year<span class="validateRq">*</span></label>
												<div class="col-md-8">
													{!! Form::text('year',(isset($editModeData)) ? dateConvertDBtoForm($editModeData->year) :  Input::old('year'), $attributes = array('class'=>'form-control required monthField','id'=>'year','readonly'=>'readonly','placeholder'=> 'Select Year')) !!}
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">Calendar Image<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<!-- {!! Form::file('image', Input::old('image'), $attributes = array('class'=>'form-control image','id'=>'image','placeholder'=> 'Upload Image')) !!} -->
													<input vlass="form-control image" type="file" id="image" name = "image">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<div class="row">
										<div class="col-md-8">
											<div class="row">
												<div class="col-md-offset-4 col-md-8">
													@if(isset($editModeData))
														<button type="submit" class="btn btn-success btn_style"><i class="fa fa-pencil"></i> @lang('common.update')</button>
													@else
														<button type="submit" class="btn btn-success btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
													@endif
												</div>
											</div>
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


