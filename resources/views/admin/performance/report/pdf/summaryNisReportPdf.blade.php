
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Nis Summary Report</title>
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

	</style>
	<body>
	<div class="printHead">
		@if($printHead)
			{!! $printHead->description !!}
		@endif
		<br>
		<br>
	</div>
	<div class="container">
		<div >
			<div style="float: left;width: 40%">
				<b>@lang('common.from_date') : </b>{{$from_month}},
				<b>@lang('common.to_date') : </b>{{$to_month}}
			</div>
	        <div style="float: right;width: 50%">
		        <span style="float: right;">
		        	<b>Pay Grade: </b>{{$from_pay_grade}} To {{$to_pay_grade}}
		        </span>
	        	
	        </div>
		</div>
		<div class="table-responsive" style="padding-top: 20px;">
	        <table>
	            <thead>
	                @php
	                    $total_rating = 0;
	                    $most_rating = 0;
	                @endphp
	                    <tr>
	                        <th></th>
	                        <th> Name </th>
	                        @foreach ($performance_criteria_name as $key => $value)
	                            <th>{{ $value->performance_criteria_name }}</th>
	                        @endforeach
	                            <th>Total</th>
	                            <th>Comments</th>
	                    </tr>

	                    <tr>
	                        <td> </td>
	                        <td> </td>
	                        @foreach ($performance_criteria_name as $item)
	                            <?php $most_rating += 5; ?>
	                            <td>5</td>
	                        @endforeach
	                        <td>{{ $most_rating }}</td>
	                        <td> </td>
	                    </tr>

	                    @foreach($results as $key => $value)
	                        @php
	                            $total_rating = 0;
	                        @endphp
	                        <tr>
	                            <td>{{ $key + 1 }}</td>
	                            <td>{{ $value->first_name }} {{ $value->last_name }}</td>
	                            @foreach($value->parpormance as $key_v => $val)
	                                <?php $total_rating += $val->rating; ?>
	                                <td>{{ $val->rating }}</td>
	                            @endforeach
	                            @for($i = 0; $i < count($performance_criteria_name) - count($value->parpormance); $i++)
	                                <td> </td>
	                            @endfor
	                            <td> {{ $total_rating }}</td>
	                            <td> </td>
	                        </tr>
	                    @endforeach
	                    
	            </thead>

	        </table>
		</div>
	</div>
</body>
</html>


