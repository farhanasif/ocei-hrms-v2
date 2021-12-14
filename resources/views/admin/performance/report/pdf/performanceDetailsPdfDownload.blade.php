<!DOCTYPE html>
<html lang="en">

<head>
    <title>ACR Performance Report</title>
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

    .printHead {
        width: 35%;
        margin: 0 auto;
        text-align: center;
    }

    table,
    td,
    th {
        border: 1px solid black;
    }

    td {
        padding: 5px;
    }

    th {
        padding: 5px;
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
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">

                            @php
                                $full_name = $criteriaDataFormat[0]['first_name'] . ' ' . $criteriaDataFormat[0]['last_name'];
                                $department_name = $criteriaDataFormat[0]['department_name'];
                                $designation_name = $criteriaDataFormat[0]['designation_name'];
                                $date_of_birth = $criteriaDataFormat[0]['date_of_birth'];
                                $date_of_joining = $criteriaDataFormat[0]['date_of_joining'];
                                
                                $monthAndYear = explode('-', $criteriaDataFormat[0]['month']);
                                
                                $month = $monthAndYear[1];
                                $dateObj = DateTime::createFromFormat('!m', $month);
                                $monthName = $dateObj->format('F');
                                $year = $monthAndYear[0];
                                
                                $monthAndYearName = $monthName . ' ' . $year;
                            @endphp

                            <div class="form-body">
                                <div class="" style="margin-bottom:5px">
                                    <strong>Employee Name :</strong>
                                    <span class="employee_name">{{ $full_name }}</span>
                                </div>
                                <div class="" style="margin-bottom:5px ">
                                    <strong>Designation :</strong>
                                    <span class="designation_name">{{ $designation_name }}</span>
                                </div>
                                <div class="" style="margin-bottom:5px ">
                                    <strong>Department :</strong>
                                    <span class="department_name">{{ $department_name }}</span>
                                </div>
                                <div class="" style="margin-bottom:5px ">
                                    <strong>Date Of Birth :</strong>
                                    <span class="date_of_birth">{{ dateConvertDBtoForm($date_of_joining) }}</span>
                                </div>
                                <div class="" style="margin-bottom:5px ">
                                    <strong>Date Of Joining :</strong>
                                    <span class="date_of_joining">{{ dateConvertDBtoForm($date_of_joining) }}</span>
                                </div>
                                {{-- <div class="" style="margin-bottom:5px ">
									<strong>Month :</strong>
									<span class="month"></span>
								</div> --}}
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="">
                                                    <th>Sl</th>
                                                    <th>@lang('performance.category_name')</th>
                                                    <th>@lang('performance.criteria_name') </th>
                                                    <th>Judgement</th>
                                                    <th>Comments</th>
                                                    <th>@lang('performance.rating') (@lang('performance.out_of_ten'))
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $totalRating = 0;
                                                    $totalItem = 0;
                                                @endphp

                                                @foreach ($criteriaDataFormat as $criteria)

                                                    @php
                                                        $totalRating += $criteria['rating'];
                                                        $totalItem += 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $criteria['performance_category_name'] }}</td>
                                                        <td>{{ $criteria['performance_criteria_name'] }}</td>
                                                        <td>{{ $criteria['judgement'] }}</td>
                                                        <td>{{ $criteria['comments'] }}</td>
                                                        <td style="text-align: right">{{ $criteria['rating'] }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="5" style="text-align: right">  <b>@lang('performance.total_rating') :</b></td>
                                                    <td style="text-align: right">
                                                        <b>
                                                            @php
                                                                if($totalItem !=0 && $totalRating !=0){
                                                                    echo round($totalRating ,2);
                                                                }else{
                                                                    echo 0;
                                                                }
                                                            @endphp
                                                        </b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="text-align: right">  <b>@lang('performance.average_rating') :</b></td>
                                                    <td style="text-align: right">
                                                        <b>
                                                            @php
                                                                if($totalItem !=0 && $totalRating !=0){
                                                                    echo round($totalRating / $totalItem,2);
                                                                }else{
                                                                    echo 0;
                                                                }
                                                            @endphp
                                                        </b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
</body>

</html>
