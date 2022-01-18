@extends('admin.master')
@section('content')
@section('title')
@lang('Upload Employee Attendance File')
@endsection
<style>
	.uftcl-about-submit {
	    display: inline-block;
	}
</style>

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
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
								<div class="row">
								</div>
						<form action="{{ route('manualAttendance.uploadFile')}}" method="POST" enctype="multipart/form-data" style="margin-left: 250px;">
			              {{ csrf_field() }}

			                <!-- browse -->
			                <div class="form-group uftcl-about" style="margin-top:70px">
			                  <label>Upload Attendance .csv or .xls or .xlsx file</label>
			                  <div class="input-group" name="Fichier1">
			                      <input type="file" class="form-control" name="upload_file" placeholder="Choose a file..." />
			                  </div>
			                  @if ($errors->has('upload_file'))
			                      <span class="help-block fred">
			                          {{ $errors->first('upload_file') }}
			                      </span>
			                  @endif
			                </div>

			                <!-- save -->
			                  <div class="form-group uftcl-about-submit" style="width:19%">
			                    <input type="submit" name="submit" class="form-control save btn btn-success" value="Save change" style="color: #fff;" />
			                    <!-- <input type="reset" class="form-control cancel" value="Cancel" />      -->
			                    
			                  </div>
			              </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
