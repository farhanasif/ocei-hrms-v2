@extends('admin.master')
@section('content')
@section('title')
    @lang('training.employee_training_report')
@endsection
<style>
    .employeeName {
        position: relative;
    }

    #employee_id-error {
        position: absolute;
        top: 66px;
        left: 0;
        width: 100%he;
        width: 100%;
        height: 100%;
    }

</style>
<script>
    jQuery(function() {
        $("#report").validate();
    });
</script>
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i>
                        @lang('dashboard.dashboard')</a></li>
                <li>@yield('title')</li>
            </ol>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>@yield('title')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
                            </div>
                        @endif
                       <form action="{{ route('employeeTrainingReport.dateFilterTrainingReport') }}" method="get">
						  
						<div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input class="form-control  from_date dateField" readonly id="from_date"
                                        placeholder="From Date" name="from_date" type="text" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input class="form-control  to_date dateField" readonly id="to_date"
                                        placeholder="To Date" name="to_date" type="text" value="" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="submit" style="width: 100px;"
                                        class="btn btn-success " value="Submit">
                                </div>
                            </div>
                        </div>
					   </form>

                        <div class="row">
                            <div id="searchBox">
                                {{ Form::open(['route' => 'employeeTrainingReport.employeeTrainingReport', 'id' => 'report']) }}
                                {{-- <div class="col-md-3"></div> --}}
                                <div class="col-md-4">
                                    <div class="form-group employeeName">
                                        <label class="control-label" for="email">@lang('common.employee')<span
                                                class="validateRq">*</span></label>
                                        <select class="form-control employee_id select2 required" required
                                            name="employee_id">
                                            <option value="">---- @lang('common.please_select') ----</option>
                                            @foreach ($employeeList as $value)
                                                <option value="{{ $value->employee_id }}" @if (isset($employee_id)) @if ($employee_id == $value->employee_id) {{ 'selected' }} @endif @endif>
                                                    {{ $value->first_name }} {{ $value->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="submit" id="filter" style="margin-top: 25px; width: 100px;"
                                            class="btn btn-success " value="@lang('common.filter')">
                                    </div>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <hr>
                        @if (count($results) > 0 && $results != '')
                            <h4 class="text-right">
                                <a class="btn btn-success" style="color: #fff"
                                    href="{{ URL('downloadTrainingReport/?employee_id=' . $employee_id) }}"><i
                                        class="fa fa-download fa-lg" aria-hidden="true"></i> @lang('common.download')
                                    PDF</a>
                            </h4>
                        @endif
                        @if ($results != '')
                            <div class="table-responsive">
                                <table id="" class="table table-bordered">
                                    <thead class="tr_header">
                                        <tr>
                                            <th style="width:100px;">@lang('common.serial')</th>
                                            <th>@lang('training.training_type')</th>
                                            <th>Course title</th>
                                            <th>Organization Name</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Time</th>
                                            <th>@lang('training.training_duration')</th>
                                            <th>@lang('common.status')</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($results) > 0)
                                            {{ $sl = null }}
                                            @foreach ($results as $value)
                                                <tr>
                                                    <td>{{ ++$sl }}</td>
                                                    <td>{{ $value['training_type_name'] }}</td>
                                                    <td>{{ $value['subject'] }}</td>
                                                    <td>{{ $value['organization_name'] }}</td>
                                                    <td>{!! dateConvertDBtoForm($value['start_date']) !!}</td>
                                                    <td>{!! dateConvertDBtoForm($value['end_date']) !!}</td>
                                                    @if ($value['start_time'] != '')
                                                        <td>
                                                            {!! date('h:i a', strtotime($value['start_time'])) !!} To
                                                            {!! date('h:i a', strtotime($value['end_time'])) !!}
                                                        </td>
                                                    @else
                                                        <td>--</td>
                                                    @endif
                                                    <td>
                                                        @if (isset($value['training_day']) && !empty($value['training_day']))
                                                            {{ $value['training_day'] }} Day <br>
                                                        @endif
                                                        @if (isset($value['training_hour']) && !empty($value['training_hour']))
                                                            {{ $value['training_day'] * $value['training_hour'] }} Hour
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            if ($value['action'] == 'Yes') {
                                                                echo "<b style='color: green'><i class='cr-icon glyphicon glyphicon-ok'></i> Done</b>";
                                                            } else {
                                                                echo '--';
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
