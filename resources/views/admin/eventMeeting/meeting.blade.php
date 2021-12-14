@extends('admin.master')
@section('content')
@section('title', 'Meeting')

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
                    <li>@yield('title')</li>
				</ol>
			</div>	
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<a href="#"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</a>
			</div>	
		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-success">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> Meeting</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<div class="table-responsive">
								<table id="myTable" class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>SL NO</th>
											<th>Meeting Name</th>
											<th>Time</th>
											<th>Date</th>
											<th>Room</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td style="width: 100px;"></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td style="width: 100px;">
													<a href="#"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="#" class="delete btn btn-danger btn-xs deleteBtn btnColor">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </a>
												</td>
											</tr>
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
