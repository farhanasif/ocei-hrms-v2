@extends('admin.master')
@section('content')

@section('title')
@lang('services.add_ip_address')
@endsection

<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i>@lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>
		<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
			<a href="{{route('ip.setting')}}" class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i> @lang('services.view_all_ip')</a>
		</div>
	</div>

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
		<div class="col-md-12">
			<div class="panel panel-success">
				<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						{{ Form::open(array('route' => 'ip.store','enctype'=>'multipart/form-data','class'=>'form-horizontal')) }}
						    <ul class="nav nav-tabs" id="">
                                <li class="active">
                                    <a data-toggle="tab" href="#single">
                                        <i class="blue ace-icon fa fa-tasks bigger-120"></i>
                                        Add Single Ip
                                    </a>
                                </li>

                                <li class="">
                                    <a data-toggle="tab" href="#range">
                                        <i class="blue ace-icon fa fa-tasks bigger-120"></i>
                                        Add Range Ip
                                    </a>
                                </li>
                            </ul>
						<div class="form-body">

                            <div class="tab-content" style="padding-bottom: 20px;">
								<div class="tab-pane fade in active" id="single">

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">Ip Address<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<input type="text" id="ip_address" class="form-control required role_name" name="ip_address" value="" placeholder="---.---.---.---" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$">
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="tab-pane fade in" id="range">

									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">Ip Range Start<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<input type="text" id="ip_address1" class="form-control required role_name" name="ip_address1" value="" placeholder="---.---.---.---" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$">
												</div>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-md-8">
											<div class="form-group">
												<label class="control-label col-md-4">Ip Range End<span class="validateRq">*</span></label>
												<div class="col-md-8">
													<input type="text" id="ip_address2" class="form-control required role_name" name="ip_address2" value="" placeholder="---.---.---.---" pattern="^([0-9]{1,3}\.){3}[0-9]{1,3}$">
												</div>
											</div>
										</div>
									</div>
								</div>
                            </div>

                            <input type="hidden" name="ip_status" value="1">
                            <input type="hidden" name="status" value="1">
						</div>
						<div class="form-actions">
							<div class="row">
								<div class="col-md-8">
									<div class="row">
										<div class="col-md-offset-4 col-md-8">
											<button type="submit" class="btn btn-success btn_style"><i class="fa fa-check"></i>@lang('common.save')</button>
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

@section('page_scripts')

	<script type="text/javascript">
        (function() {

        })();
	</script>
@endsection