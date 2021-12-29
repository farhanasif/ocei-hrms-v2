@extends('admin.master')
@section('content')
@section('title')
    @lang('performance.performance_summary_report')
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
        $("#performanceSummaryReport").validate();
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
                        <h3>Performance Category - NIS </h3>
                        {{ Form::open(['route' => 'performance_nisperformance_category', 'id' => 'performance_nisperformance_category']) }}

                        <div class="row">
                            {{-- <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="control-label" for="email">Performance Category<span
                                                class="validateRq">*</span></label>
                                        <select name="performance_category_id" id="performance_category_id"
                                            class="form-control performance_category_id required select2">
                                            <option value="">--- @lang('common.please_select') ---</option>
                                            @foreach ($performanceCategory as $category)
                                                <option value="{{ $category->performance_category_id }}"
                                                    @if ($category->performance_category_id == old('performance_category_id')) {{ 'selected' }} @endif>
                                                    {{ $category->performance_category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label" for="email">From Pay Grade<span
                                            class="validateRq">*</span></label>
                                    <select name="from_pay_grade_name" id="from_pay_grade_name"
                                        class="form-control from_pay_grade_name required select2">
                                        <option value="">--- @lang('common.please_select') ---</option>
                                        @foreach ($payGrade as $payGradeValue)
                                            <option value="{{ $payGradeValue->pay_grade_id }}"
                                                @if ($payGradeValue->pay_grade_id == old('pay_grade_id')) {{ 'selected' }} @endif>
                                                {{ $payGradeValue->pay_grade_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label class="control-label" for="email">To Pay Grade<span
                                            class="validateRq">*</span></label>
                                    <select name="to_pay_grade_name" id="to_pay_grade_name"
                                        class="form-control to_pay_grade_name required select2">
                                        <option value="">--- @lang('common.please_select') ---</option>
                                        @foreach ($payGrade as $toPayGradeValue)
                                            <option value="{{ $toPayGradeValue->pay_grade_id }}"
                                                @if ($toPayGradeValue->pay_grade_id == old('pay_grade_id')) {{ 'selected' }} @endif>
                                                {{ $toPayGradeValue->pay_grade_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="control-label" for="email">@lang('common.from_date')<span
                                        class="validateRq">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control monthField required" readonly
                                        placeholder="@lang('common.from_date')" name="from_month"
                                        value="@if (isset($from_month)) {{ $from_month }}@else {{ date('Y-01') }} @endif">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="control-label" for="email">@lang('common.to_date')<span
                                        class="validateRq">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control monthField required" readonly
                                        placeholder="@lang('common.to_date')" name="to_month"
                                        value="@if (isset($to_month)) {{ $to_month }}@else {{ date('Y-m') }} @endif">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="submit" style="width: 100px;" class="btn btn-success "
                                        value="@lang('common.filter')">
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}

                        <h3>Performance Category - ACR </h3>
                        <div class="row">
                            <div id="searchBox">
                                {{ Form::open(['route' => 'performanceSummaryReport.performanceSummaryReport', 'id' => 'performanceSummaryReport']) }}
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="form-group employeeName">
                                        <label class="control-label" for="email">@lang('common.employee')<span
                                                class="validateRq">*</span></label>
                                        <select class="form-control employee_id select2 required" required
                                            name="employee_id">
                                            <option value="">---- @lang('common.please_select') ----</option>
                                            @foreach ($employeeList as $value)
                                                <option value="{{ $value->employee_id }}" @if (@$value->employee_id == $employee_id) {{ 'selected' }} @endif>
                                                    {{ $value->first_name }} {{ $value->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label" for="email">@lang('common.from_date')<span
                                            class="validateRq">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control monthField required" readonly
                                            placeholder="@lang('common.from_date')" name="from_month"
                                            value="@if (isset($from_month)) {{ $from_month }}@else {{ date('Y-01') }} @endif">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label" for="email">@lang('common.to_date')<span
                                            class="validateRq">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="form-control monthField required" readonly
                                            placeholder="@lang('common.to_date')" name="to_month"
                                            value="@if (isset($to_month)) {{ $to_month }}@else {{ date('Y-m') }} @endif">
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
                        @if ($results && count($results) > 0)
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <h4 style="">
                                        <a class="btn btn-success" style="color: #fff"
                                            href="{{ URL('downloadPerformanceSummaryReport/?employee_id=' . $employee_id . '&from_month=' . $from_month . '&to_month=' . $to_month) }}"><i
                                                class="fa fa-download fa-lg" aria-hidden="true"></i>
                                            @lang('common.download') PDF</a>
                                    </h4>
                                </div>
                            </div>
                        @endif
                        @if($results)
                            <div class="table-responsive">
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
                                                <td colspan="2" class="text-right"><b>@lang('performance.total_rating'):
                                                        &nbsp;</b></td>
                                                <td ><b></b> {{ $totalRating }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-right"><b>@lang('performance.average_rating'):
                                                        &nbsp;</b></td>
                                                <td><b></b> {{ number_format(($totalRating / $item),2) }} </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="text-right"><b>@lang('performance.star_rating'):
                                                        &nbsp;</b></td>
                                                <td>
                                                    <span class="PerformanceRating"></span>
                                                </td>
                                            </tr>

                                            <script>
                                                $(function() {
                                                    var rating;
                                                    $(".PerformanceRating").rateYo({
                                                        rating: <?php echo number_format(($totalRating / $item),2); ?>,
                                                        ratedFill: "#FF4500"
                                                    }).on("rateyo.set", function(e, data) {

                                                    });
                                                });
                                            </script>
                                        @else
                                            <tr>
                                                <td colspan="3">@lang('common.no_data_available') !</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
