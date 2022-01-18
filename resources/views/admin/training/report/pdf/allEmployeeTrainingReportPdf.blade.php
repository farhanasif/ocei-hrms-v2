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
		Government Of The People's Republic Of Bangladesh <br>
		<b>Office of the Chief Electrical Inspector</b> <br>
		Electric Division <br>
		Ministry of Power Energy and Mineral Resources <br>
		25 New Eskaton Road, Dhaka-1000 <br>
		<a href="https://ocei.portal.gov.bd/">www.ocei.gov.bd</a>
		<br>
		<br>
	</div>
	<div class="container">
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
                        <th>Day</th>
						<th>Hour</th>
                        <th>Employee Name</th>
					</tr>
				</thead>
				<tbody>

					@php
						$trainingHour = 0;
					@endphp
					@if(count($traningInfo) > 0)
						{{$sl=null}}
						@foreach($traningInfo as $value)

						@php
							$trainingHour += $value->training_day * $value->training_hour;
						@endphp
						<tr>
							<td>{{++$sl}}</td>
							<td>{{$value->training_type_name}}</td>
							<td>{{$value->subject}}</td>
							<td>{{$value->organization_name}}</td>
							<td>{{$value->start_date}}</td>
							<td>{{$value->end_date}}</td>
							@if($value->start_time !='')
								<td>
									{!! date("h:i a", strtotime($value->start_time)) !!} To
									{!! date("h:i a", strtotime($value->end_time)) !!}
								</td>
							@else
								<td>--</td>
							@endif
							<td>
								@if (isset($value->training_day) && !empty($value->training_day))
									{{$value->training_day}} Day <br>
								@endif
							</td>
							<td>
								@if (isset($value->training_hour) && !empty($value->training_hour))
								{{$value->training_day * $value->training_hour}} Hour
							@endif
							</td>
							<td>
							{{-- @php
								if($value->action == "Yes"){
									echo "<b style='color: green'><i class='cr-icon glyphicon glyphicon-ok'></i></b>";
								}else{
									echo "--";
								}
							@endphp --}}
							{{$value->full_name}}
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
			{{ date('F Y',strtotime($from_date)) }} To {{ date('F Y',strtotime($to_date)) }}
			<br>
			<div style="width: 40%">
				<p>Per Employee Traning Time =  {{ $trainingHour }} hour / {{ $totalEmployee }} person = {{  number_format($trainingHour / $totalEmployee , 2) }} Hours</p>
				<p>Total Training Hour = {{ $trainingHour }} Hours</p>
				{{-- <p>Training = </p> --}}
			</div>

			{{-- <div style="width: 40%; float:right;margin: 0 auto">
				<p>Total Employee = </p>
				<p>Training = </p>
				<p>Training = </p>
			</div> --}}

        </div>
	</div> 

</body>
</html>


