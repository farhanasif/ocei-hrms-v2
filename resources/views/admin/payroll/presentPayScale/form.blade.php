@extends('admin.master')
@section('content')

@section('title')
@if(isset($editModeData))
	Edit Present Pay Grade Salary
@else
	Add Present Pay Grade Salary
@endif

@endsection
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<a href="{{route('presentPayScale.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> View Present Pay Grade Salary</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						@if(isset($editModeData))
							{{ Form::model($editModeData, array('route' => array('presentPayScale.update', $editModeData->present_pay_grade_salary_id), 'method' => 'PUT','files' => 'true')) }}
						@else
							{{ Form::open(array('route' => 'presentPayScale.store','enctype'=>'multipart/form-data','id'=>'presentPayScaleForm')) }}
						@endif

						<div class="form-body">

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

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">Pay Grade Name<span class="validateRq">*</span></label>
										<select class="form-control pay_grade_name select2  required" name="pay_grade_name">
											<option value="">--- @lang('common.please_select') ---</option>
											@foreach ($payGrades as $value)
												<option value="{{ $value->pay_grade_id }}" @if ( isset($editModeData) && $value->pay_grade_id == $editModeData->pay_grade_id) {{ 'selected' }} @endif>{{ $value->pay_grade_name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">Present Pay Grade Salary<span class="validateRq">*</span></label>
										{!! Form::number('present_pay_grade_salary',Input::old('present_pay_grade_salary'), $attributes = array('class'=>'form-control required present_pay_grade_salary','id'=>'present_pay_grade_salary','placeholder'=>__('Present Pay Grade Salary'))) !!}
									</div>
								</div>
							</div>
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-12">
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
	<script>
        jQuery(function (){

            $("#payGradeForm").validate();

            $(document).on("change",".gross_salary,.percentage_of_basic  ",function(){
                var gross_salary		 =  $('.gross_salary').val();
				var basic_salary		 =  $('.basic_salary').val();
                var percentage_of_basic  =  $('.percentage_of_basic').val();
                var grossSalary = 0;

                grossSalary = parseInt(basic_salary) + (basic_salary * percentage_of_basic) /100;
                $('.gross_salary').val(grossSalary);
            });

            $(document).on("click", '.checkAllAllowance', function (event) {
                if (this.checked) {
                    $('.allowanceInputCheckbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.allowanceInputCheckbox').each(function () {
                        this.checked = false;
                    });
                }
            });

            $(document).on("click", '.checkAllDeduction', function (event) {
                if (this.checked) {
                    $('.deductionInputCheckbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.deductionInputCheckbox').each(function () {
                        this.checked = false;
                    });
                }
            });

        });

	</script>
@endsection

