@extends('admin.master')
@section('content')
@section('title')
    {{-- @lang('holiday.public_holiday_list') --}}
    Optional Leave
@endsection

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i>
                        @lang('dashboard.dashboard')</a></li>
                <li>@yield('title')</li>
            </ol>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{ route('optional.leave.setup.create') }}"
                class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i
                    class="fa fa-plus-circle" aria-hidden="true"></i> Add Optional Leave</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
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
                        <div class="table-responsive">
                            <table id="myTable" class="table table-bordered">
                                <thead class="tr_header">
                                    <tr>
                                        <th> @lang('common.serial') </th>
                                        <th>  Name </th>
                                        <th> Year </th>
                                        <th> Leave Date </th>
                                        <th style="text-align: center;">@lang('common.action')</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    {!! $sl = null !!}
                                    @foreach ($optional_Leave as $value)
                                        <tr>
                                            <td>{!! ++$sl !!}</td>
                                            <td>{!! $value->leave_name !!}</td>
                                            <td>{!! $value->leave_year !!}</td>
                                            <td>{!! dateConvertDBtoForm($value->leave_date) !!}</td>
                                            <td style="width: 100px;">
                                                <a href=""
                                                    class="btn btn-success btn-xs btnColor">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                </a>
                                                <a href="" 
                                                    class=" btn btn-danger btn-xs deleteBtn btnColor"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
