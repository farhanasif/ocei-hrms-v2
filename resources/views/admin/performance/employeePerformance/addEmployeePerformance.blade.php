@extends('admin.master')
@section('content')
@section('title')
    @lang('performance.add_employee_performance')
@endsection
<style>
    .table>tbody>tr>td {
        padding: 5px 7px;
    }

</style>
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i>
                        @lang('dashboard.dashboard')</a></li>
                <li>@yield('title')</li>
            </ol>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <a href="{{ route('employeePerformance.index') }}"
                class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i
                    class="fa fa-list-ul" aria-hidden="true"></i> @lang('performance.view_employee_performance') </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        {{-- {{ Form::open(array('route' => 'employeePerformance.store','enctype'=>'multipart/form-data','id'=>'payGradeForm')) }} --}}

                        <div class="form-body">

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">×</span></button>
                                    @foreach ($errors->all() as $error)
                                        <strong>{!! $error !!}</strong><br>
                                    @endforeach
                                </div>
                            @endif
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <i
                                        class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
                                </div>
                            @endif
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <i
                                        class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInput">Performance Category Name<span
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
                                </div>
                                {{-- <input type="hidden" name="pay_grade_id" id="pay_grade_id" value="{{  }}"> --}}

                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('common.employee_name')<span
                                                class="validateRq">*</span></label>
                                        <select name="employee_id" id="employee_id"
                                            class="form-control employee_id required select2">
                                            <option value="">--- @lang('common.please_select') ---</option>
                                            @foreach ($employeeList as $value)
                                                <option value="{{ $value->employee_id }}" @if ($value->employee_id == old('employee_id')) {{ 'selected' }} @endif>
                                                    {{ $value->first_name }} {{ $value->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInput">Pay Grade Name<span
                                                class="validateRq">*</span></label>
                                        <input type="text" disabled name="pay_grade_name" id="pay_grade_name"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <label for="exampleInput">@lang('common.month')<span
                                            class="validateRq">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input class="form-control required monthField" readonly="readonly" id="month"
                                            placeholder="@lang('common.month')" name="month" type="text"
                                            value="{{ old('month') }}">
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('performance.remarks')</label>
                                        <textarea class="form-control" id="remarks"
                                            placeholder="@lang('performance.remarks')"
                                            name="remarks">{{ old('remarks') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="acrCategoryIdHideOrShowForm">
                                <h3 class="box-title">ACR Performance @lang('performance.criteria_list')</h3>
                                <div class="row" id="acrCategoryIdHideOrShow">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="">
                                                    <th class="col-md-4">
                                                        @lang('performance.performance_criteria_list') </th>
                                                    <th class="col-md-4">@lang('performance.rating')
                                                        (@lang('performance.out_of_ten'))</th>
                                                    <th class="col-md-4">Comments(মন্তব্য)</th>
                                                </tr>
                                            </thead>
                                            <tbody class="report_row">
                                                @foreach ($acrCriteria as $acr)
                                                    <tr>
                                                        <td>{{ $acr['performance_criteria_name'] }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" name="acr_rating[]" id="acr_rating"
                                                                    placeholder="Ex.. 5" class="form-control">

                                                                <input type="hidden" id="acr_performance_criteria_id"
                                                                    name="acr_performance_criteria_id[]"
                                                                    value="{{ $acr['performance_criteria_id'] }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <textarea name="acr_comments[]" id="acr_comments"
                                                                    class="form-control" rows="2" cols="43"
                                                                    placeholder="Comments"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="button" id="acrCategoryBtn"
                                                class="btn btn-success btn_style"><i class="fa fa-check"></i>
                                                @lang('common.save')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="nisCategoryIdHideOrShowForm">
                                <h3 class="box-title">NIS Performance @lang('performance.criteria_list')</h3>
                                <div class="row" id="nisCategoryIdHideOrShow">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="">
                                                    <th class="col-md-8">
                                                        @lang('performance.performance_criteria_list') </th>
                                                    <th class="col-md-4">@lang('performance.rating')
                                                        (@lang('performance.out_of_ten'))</th>
                                                </tr>
                                            </thead>
                                            <tbody class="report_row">
                                                @foreach ($nisCriteria as $value)
                                                    <tr>
                                                        <td>{{ $value['performance_criteria_name'] }}</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="number" id="nis_rating" name="nis_rating[]"
                                                                    placeholder="Ex.. 5" class="form-control">
                                                                <input type="hidden" id="nis_performance_criteria_id"
                                                                    name="nis_performance_criteria_id[]"
                                                                    value="{{ $value['performance_criteria_id'] }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="button" id="nisCategorySubmitBtn"
                                                class="btn btn-success btn_style"><i class="fa fa-check"></i>
                                                @lang('common.save')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- {{ Form::close() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_scripts')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#nisCategoryIdHideOrShowForm").hide();
        $("#acrCategoryIdHideOrShowForm").hide();
    });

    $("#employee_id").change("change", function() {

        var employee_id = $("#employee_id").val();
        var token = "{{ csrf_token() }}";
        var url_data = "{{ url('performancePerformanceSelectData') }}";
        $.ajax({
            method: "GET",
            url: url_data,
            dataType: "json",
            data: {
                _token: token,
                employee_id: employee_id,
            },
            success: function(data) {
                console.log(data);
                if (data) {
                    $('#pay_grade_name').val(data);
                } else {
                    $('#pay_grade_name').empty();
                }
            }
        });
    });


    $(".performance_category_id").on("change", function() {

        var performance_category_id = $("#performance_category_id").val();

        if (performance_category_id == '3') {

            $("#nisCategoryIdHideOrShowForm").hide();
            $("#acrCategoryIdHideOrShowForm").show();

        } else if (performance_category_id == '4') {

            $("#nisCategoryIdHideOrShowForm").show();
            $("#acrCategoryIdHideOrShowForm").hide();
        }
    });

    $('#nisCategorySubmitBtn').on("click", function() {

        var performance_category_id = $("#performance_category_id").val();
        var employee_id = $("#employee_id").val();
        var pay_grade_name = $("#pay_grade_name").val();

        var month = $("#month").val();
        var remarks = $("#remarks").val();

        var nis_rating = $('input[name="nis_rating[]"]').map(function() {
            return this.value;
        }).get();

        var nis_performance_criteria_id = $('input[name="nis_performance_criteria_id[]"]').map(function() {
            return this.value;
        }).get();

        var type = 'nis';

        $.ajax({
            type: 'GET',
            url: "{{ route('employeePerformance.store') }}",
            data: {
                'nis_rating[]': nis_rating,
                'nis_performance_criteria_id[]': nis_performance_criteria_id,
                performance_category_id: performance_category_id,
                employee_id: employee_id,
                type: type,
                month: month,
                pay_grade_name: pay_grade_name,
                remarks: remarks
            },
            dataType: 'json',
            success: (data) => {
                if (data == 'success') {
                    alert('Employee Performance Successfully saved.');
                    window.location.reload();
                } else if (data == 'error') {
                    alert('Something Error Found !, Please try again.');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });


    $("#acrCategoryBtn").on("click", function() {
        var performance_category_id = $("#performance_category_id").val();
        var employee_id = $("#employee_id").val();
        var pay_grade_name = $("#pay_grade_name").val();

        var month = $("#month").val();
        var remarks = $("#remarks").val();

        var type = 'acr';

        var acr_rating = $('input[name="acr_rating[]"]').map(function() {
            return this.value;
        }).get();

        var acr_comments = $('textarea[name="acr_comments[]"]').map(function() {
            return this.value;
        }).get();

        console.log(acr_comments)

        var acr_performance_criteria_id = $('input[name="acr_performance_criteria_id[]"]').map(function() {
            return this.value;
        }).get();

        $.ajax({
            url: "{{ route('employeePerformance.store') }}",
            type: "GET",
            dataType: "json",
            data: {
                'acr_rating[]': acr_rating,
                'acr_comments[]': acr_comments,
                'acr_performance_criteria_id[]': acr_performance_criteria_id,
                employee_id: employee_id,
                performance_category_id: performance_category_id,
                month: month,
                remarks: remarks,
                pay_grade_name: pay_grade_name,
                type: type
            },
            success: function(data) {
                if (data == 'success') {
                    alert('Employee Performance Successfully saved.');
                    window.location.reload();
                } else if (data == 'error') {
                    alert('Something Error Found !, Please try again.');
                }
            }
        });
    });
</script>
@endsection
