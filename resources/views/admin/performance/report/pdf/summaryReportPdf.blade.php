
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Summary Report</title>
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
		<div class="table-responsive">
			<b>@lang('common.from_date') : </b>{{$from_month}},
			<b>@lang('common.to_date') : </b>{{$to_month}}
                @foreach($results as $lk => $val)
                    <table id="" class="table table-bordered">
                        <thead class="tr_header">
                            <tr>
                                <th colspan="4" style="text-align: center;">{{$val->first_name }} {{$val->last_name }} <br /> <span>{{$val->designation_name  }}</span></th>
                            </tr>
                            <tr>
                                <th style="">@lang('common.serial')</th>
                                <th style="width: 500px">Performance Type Name</th>
                                <th> Performance Rating </th>
                                <th> Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($val->parpormance) > 0)
                                @php
                                    $serial = 0;
                                    $totalRating = 0;
                                    $item = 0;
                                @endphp
                                @foreach($val->parpormance as $key => $value)
                                    @php
                                        $item++;
                                        $totalRating += $value->rating;
                                    @endphp
                                    <tr>
                                        <td style="">{{++$serial}}</td>
                                        <td>{{ $value->performance_criteria_name }}</td>
                                        <td class="text-center">{{ $value->rating }}</td>
                                        <td>{{ $value->comments }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2" style="text-align: right;"><b>@lang('performance.total_rating'):
                                            &nbsp;</b></td>
                                    <td ><b></b> {{ $totalRating }} </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right;"><b>@lang('performance.average_rating'):
                                            &nbsp;</b></td>
                                    <td><b></b> {{ number_format(($totalRating / $item),2) }} </td>
                                    <td></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="3">@lang('common.no_data_available') !</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endforeach
		</div>
	</div>
</body>
</html>


