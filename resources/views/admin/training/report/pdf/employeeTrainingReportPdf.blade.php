<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>@lang('training.employee_training_report')</title>
		<meta charset="utf-8">
	</head>
	<style>
		table {
			margin: 0 0 40px 0;
			width: 100%;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
			display: table;
			border-collapse: collapse;
		}
		.printHead{
			width: 35%;
			margin: 0 auto;
			text-align: center;
		}
		table, td, th {
			border: 1px solid black;
		}
		td{
			padding: 5px;
		}

		th{
			padding: 5px;
		}
		tbody{
			font-weight: 100;

		}

	</style>
	<body>
	<div class="printHead">
		Peoples Republic of Bangladesh <br>
		<b>Office of the Chief Electrical Inspector</b> <br>
		Electric Division <br>
		Ministry of Power Energy and Mineral Resources <br>
		25 New Eskaton Road, Dhaka-1000 <br>
		<a href="https://ocei.portal.gov.bd/">www.ocei.gov.bd</a>


		{{-- @if($printHead)
			{!! $printHead->description !!}
		@endif --}}

		<br>
		<br>
	</div>
	<div class="container">
		<b>@lang('common.name') : </b>{{$employee_name}},<b>@lang('employee.department') : </b>{{$department_name}}<b>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th style="width:100px;">@lang('common.serial')</th>
						<th>@lang('training.training_type')</th>
						<th> Course title </th>
						<th>Organization Name</th>
						<th>From Date</th>
						<th>To Date</th>
						<th>Time</th>
                        <th>@lang('training.training_duration')</th>
                        <th>@lang('common.status')</th>
					</tr>
				</thead>
				<tbody>
					@if(count($results) > 0)
						{{$sl=null}}
						@foreach($results as $value)
						<tr>
							<td>{{++$sl}}</td>
							<td>{{$value['training_type_name']}}</td>
							<td>{{$value['subject']}}</td>
							<td>{{$value['organization_name']}}</td>
							<td>{{$value['start_date']}}</td>
							<td>{{$value['end_date']}}</td>
							@if($value['start_time'] !='')
								<td>
									{!! date("h:i a", strtotime($value['start_time'])) !!} To
									{!! date("h:i a", strtotime($value['end_time'])) !!}
								</td>
							@else
								<td>--</td>
							@endif
							<td>
								@if (isset($value['training_day']) && !empty($value['training_day']))
									{{$value['training_day']}} Day <br>
								@endif
								@if (isset($value['training_hour']) && !empty($value['training_hour']))
									{{$value['training_hour']}} Hour
								@endif
							</td>
							<td>
							@php
								if($value['action'] == "Yes"){
									echo "<b style='color: green'><i class='cr-icon glyphicon glyphicon-ok'></i></b>";
								}else{
									echo "--";
								}
							@endphp
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4">@lang('common.no_data_available') !</td>
						</tr>
					@endif
				</tbody>
			</table>
        </div>
	</div>

</body>
</html>


