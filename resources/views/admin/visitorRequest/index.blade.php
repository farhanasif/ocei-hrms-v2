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
                        <div class="tabbable">
                            <ul class="nav nav-tabs" id="">
                                <li class="@if(count($visitorRequests['pending'])) active @endif">
                                    <a data-toggle="tab" href="#pending">
                                        <i class="blue ace-icon fa fa-tasks bigger-120"></i>
                                        Pending
                                    </a>
                                </li>

                                <li class="@if(!count($visitorRequests['pending']) && count($visitorRequests['approve'])) active @endif">
                                    <a data-toggle="tab" href="#approve">
                                        <i class="blue ace-icon fa fa-tasks bigger-120"></i>
                                        Approved
                                    </a>
                                </li>
                                <li class="@if(!count($visitorRequests['pending']) && !count($visitorRequests['approve']) && count($visitorRequests['reject'])) active @endif">
                                    <a data-toggle="tab" href="#reject">
                                        <i class="blue ace-icon fa fa-tasks bigger-120"></i>
                                        Rejected
                                    </a>
                                </li>
                            </ul>
                        <div class="tab-content" style="padding-bottom: 20px;">
                            
                                <div class="table-responsive tab-pane fade in @if(count($visitorRequests['pending'])) active @endif" id="pending">
                                @if(count($visitorRequests['pending']))
                                    <table id="" class="table table-bordered datatable">
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
                                                <!-- <th>Status</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($visitorRequests['pending'] as $visitor)
                                                <tr>
                                                    <td style="width: 100px;">{{ $loop->iteration }}</td>
                                                    <td>{{ $visitor->name }}</td>
                                                    <td>{{ $visitor->email }}</td>
                                                    <td>{{ $visitor->phone }}</td>
                                                    <td>{{ $visitor->address }}</td>
                                                    <td>{{ $visitor->purpose }}</td>
                                                    <td>{{ $visitor->request_detail }}</td>
                                                    <td>{{ $visitor->date_time }}</td>
                                                    <td style="width: 100px;">
                                                        <a href="{{ route('visitor.request.approval', $visitor->appointment_id) }}"
                                                            class="btn btn-success btn-xs btnColor" style="margin-bottom: 10px;">
                                                            Approved
                                                        </a>

                                                        <a href="{{ route('visitor.request.rejected', $visitor->appointment_id) }}"
                                                            class="btn btn-danger btn-xs deleteBtn btnColor ">
                                                            Rejected
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="tab-pane fade in active" id="pending">
                                        <div class="tabbable">
                                            <h4>No Pending task are Available Right Now</h4>
                                        </div>
                                    </div>
                                @endif
                                </div>

                            
                                <div class="table-responsive tab-pane fade in @if(!count($visitorRequests['pending']) && count($visitorRequests['approve'])) active @endif" id="approve">
                                @if(count($visitorRequests['approve']))
                                    <table id="" class="table table-bordered datatable">
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
                                                <!-- <th>Status</th> -->
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($visitorRequests['approve'] as $visitor)
                                                <tr>
                                                    <td style="width: 100px;">{{ $loop->iteration }}</td>
                                                    <td>{{ $visitor->name }}</td>
                                                    <td>{{ $visitor->email }}</td>
                                                    <td>{{ $visitor->phone }}</td>
                                                    <td>{{ $visitor->address }}</td>
                                                    <td>{{ $visitor->purpose }}</td>
                                                    <td>{{ $visitor->request_detail }}</td>
                                                    <td>{{ $visitor->date_time }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="tab-pane fade in active" id="pending">
                                        <div class="tabbable">
                                            <h4>No Data are Available Right Now</h4>
                                        </div>
                                    </div>
                                @endif
                                </div>

                            @if(count($visitorRequests['reject']))
                                <div class="table-responsive tab-pane fade in @if(!count($visitorRequests['pending']) && !count($visitorRequests['approve']) && count($visitorRequests['reject'])) active @endif" id="reject">
                                    <table id="" class="table table-bordered datatable">
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
                                                <!-- <th>Status</th> -->
                                                <!-- <th>Action</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($visitorRequests['reject'] as $visitor)
                                                <tr>
                                                    <td style="width: 100px;">{{ $loop->iteration }}</td>
                                                    <td>{{ $visitor->name }}</td>
                                                    <td>{{ $visitor->email }}</td>
                                                    <td>{{ $visitor->phone }}</td>
                                                    <td>{{ $visitor->address }}</td>
                                                    <td>{{ $visitor->purpose }}</td>
                                                    <td>{{ $visitor->request_detail }}</td>
                                                    <td>{{ $visitor->date_time }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="tab-pane fade in active" id="pending">
                                    <div class="tabbable">
                                        <h4>No Data are Available Right Now</h4>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_scripts')
<script>
  $(function () {
    $('#acr_nis li:first-child a').tab('show');
    $('.datatable').DataTable({
                "ordering": false,
    });
  })
</script>
@endsection