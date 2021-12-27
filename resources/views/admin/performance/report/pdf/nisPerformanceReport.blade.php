<!DOCTYPE html>
<html lang="en">

<head>
    <title>NIS Performance Report</title>
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
                            <table>
                                <thead>
                                    @php
                                        $total_rating = 0;
                                        $most_rating = 0;
                                    @endphp
                                        <tr>
                                            <th></th>
                                            <th> নাম ও পদবী ও বেতন গ্রেড </th>
                                            @foreach ($performance_criteria_name as $key => $value)
                                                <th>{{ $value->performance_criteria_name_bn }}</th>
                                            @endforeach
                                                <th>মোট</th>
                                                <th>মন্তব্য</th>
                                        </tr>

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

                                        <tr>
                                            @foreach($data as $key => $value)
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value->bangla_first_name }} {{ $value->bangla_last_name }}</td>
                                                @foreach($value->parpormance as $key => $val)
                                                    <?php $total_rating += $val->rating; ?>
                                                    <td>{{ $bangla_number[$val->rating]}}</td>
                                                @endforeach
                                                @for($i = 0; $i < count($performance_criteria_name) - count($value->parpormance); $i++)
                                                    <td> </td>
                                                @endfor
                                            @endforeach
                                            <td> {{ $bangla_number[$total_rating]}}</td>
                                            <td> </td>
                                        </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
