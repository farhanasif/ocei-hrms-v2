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
                                    @endphp
                                    @foreach ($criteriaDataFormat as $key => $value)
                                        <tr>
                                            <th>S/L</th>
                                            <th> Name Designation Pay Grade </th>
                                            @foreach ($value as $item)
                                                <td>{{ $item->performance_criteria }}</td>
                                            @endforeach
                                            <th>Total</th>
                                            <th>Comments</th>
                                        </tr>

                                        <tr>
                                            <th> </th>
                                            <th> </th>
                                            @foreach ($value as $item)
                                                <td>5</td>
                                            @endforeach
                                            <td>100</td>
                                            <td> </td>
                                        </tr>

                                        <tr>
                                            <th>{{ $loop->iteration }}</th>
                                            <td>{{ $value[0]->first_name . ' ' . $value[0]->last_name }}</td>
                                            @foreach ($value as $item)
                                                @php
                                                    $total_rating += $item->rating;
                                                @endphp
                                                <td>{{ $item->rating }}</td>
                                            @endforeach
                                            <td>{{ $total_rating }}</td>
                                            {{-- <td></td> --}}
                                            {{-- <td></td> --}}
                                        </tr>

                                    @endforeach
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
