<?php
	$total_rating = 0;
	$most_rating = 0;
?>

<!DOCTYPE html>
	<html lang="bn">
	<head>
		<title>Nis Summary Report</title>
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
		<meta charset="UTF-8">
	</head>
	<style>


		   @font-face {
	        font-family: 'Li MAK Ahmodi Unicode';
	        src: url('fonts/Li MAK Ahmodi Unicode.ttf') format('truetype');
	        font-weight: normal;
	        font-style: normal;

	    }

	    body {
	        font-family: "Li MAK Ahmodi Unicode", sans-serif;
	        font-size: 15px;
	    }

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
/*		.table-responsive{
		    font-family: "Nikosh";
		}*/
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

			<div class="table-responsive" style="padding-top: 25px;">
				<table>
                	<thead class="thead">
                        <tr>
                            <td></td>
                            <td> নাম ও পদবী ও বেতন গ্রেড </td>
                            @foreach ($performance_criteria_name as $key => $value)
                                <td>{{ $value->performance_criteria_name_bn }}</td>
                            @endforeach
                                <td>মোট</td>
                                <td>মন্তব্য</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> </td>
                            <td> </td>
                            @foreach ($performance_criteria_name as $item)
                                <?php $most_rating += 5; ?>
                                <td>{{ $bangla_number[5] }}</td>
                            @endforeach
                            <td>{{ $bangla_number[$most_rating]}}</td>
                            <td> </td>
                        </tr>

                        @foreach($results as $key => $value)
                            @php
                                $total_rating = 0;
                            @endphp
                            <tr>
                                <td>{{ $bangla_number[$key + 1] }}</td>
                                <td style="width: 150px;">{{ $value->bangla_first_name }} {{ $value->bangla_last_name }}<br /> {{ $value->designation_name_bn }}</td>
                                @foreach($value->parpormance as $key_v => $val)
                                    <?php $total_rating += $val->rating; ?>
                                    <td>{{ $bangla_number[$val->rating] }}</td>
                                @endforeach
                                @for($i = 0; $i < count($performance_criteria_name) - count($value->parpormance); $i++)
                                    <td> </td>
                                @endfor
                                <td> {{ $bangla_number[$total_rating]}}</td>
                                <td> </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
		</div>
	</body>
</html>


