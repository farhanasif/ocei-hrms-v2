@extends('admin.master')
@section('content')
@section('title', 'Visitor Request')

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i>
                        @lang('dashboard.dashboard')</a></li>
                <li>@yield('title')</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> Visitor Request </div>
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
                                <thead>
                                    <tr class="tr_header">
                                        <th>SL NO</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Purpose</th>
                                        <th>Request Detail</th>
                                        <th>Date & Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitorRequests as $visitor)
                                        <tr>
                                            <td style="width: 100px;">{{ $loop->iteration }}</td>
                                            <td>{{ $visitor->name }}</td>
                                            <td>{{ $visitor->email }}</td>
                                            <td>{{ $visitor->phone }}</td>
                                            <td>{{ $visitor->address }}</td>
                                            <td>{{ $visitor->purpose }}</td>
                                            <td>{{ $visitor->request_detail }}</td>
                                            <td>{{ $visitor->date_time }}</td>
                                            <td>
                                                @if ($visitor->approval_of == 1)
                                                    <span class="label label-success">Approved</span>
                                                @elseif ($visitor->approval_of == 3)
                                                    <span class="label label-info">Waiting To Get Permission</span>
                                                @else
                                                    <span class="label label-danger">Rejected</span>
                                                @endif
                                            </td>

                                            <td style="width: 100px;">

                                                @if ($visitor->approval_of == 0 or $visitor->approval_of == 3)
                                                    <a href="{{ route('visitor.request.approval', $visitor->appointment_id) }}"
                                                        class="btn btn-success btn-xs btnColor">
                                                        Approved
                                                    </a>
                                                @else
                                                    <a href="{{ route('visitor.request.rejected', $visitor->appointment_id) }}"
                                                        class="btn btn-danger btn-xs deleteBtn btnColor">
                                                        Rejected
                                                    </a>
                                                @endif
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
