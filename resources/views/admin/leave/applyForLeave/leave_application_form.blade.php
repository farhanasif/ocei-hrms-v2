@extends('admin.master')
@section('content')
@section('title')
    @lang('leave.leave_application_form')
@endsection
<style>
    .datepicker table tr td.disabled,
    .datepicker table tr td.disabled:hover {
        background: none;
        color: red !important;
        cursor: default;
    }

    td {
        color: black !important;
    }

</style>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <ol class="breadcrumb">
                <li class="active breadcrumbColor"><a href="#"><i class="fa fa-home"></i>
                        @lang('dashboard.dashboard')</a></li>
                <li>@yield('title')</li>

            </ol>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <a href="{{ route('applyForLeave.index') }}"
                class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i
                    class="fa fa-list-ul" aria-hidden="true"></i> @lang('leave.view_leave_applicaiton')</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading"><i
                        class="mdi mdi-clipboard-text fa-fw"></i>@lang('leave.leave_application_form')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
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
                                <strong>{{ session()->get('error') }}</strong>
                            </div>
                        @endif

                        {{ Form::open(['route' => 'applyForLeave.store', 'enctype' => 'multipart/form-data', 'id' => 'leaveApplicationForm']) }}
                        <div class="form-body">
                            <div class="row">
                                {!! Form::hidden('employee_id', isset($getEmployeeInfo) ? $getEmployeeInfo->employee_id : '', $attributes = ['class' => 'employee_id']) !!}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('common.employee_name')<span
                                                class="validateRq">*</span></label>
                                        {!! Form::text('', isset($getEmployeeInfo) ? $getEmployeeInfo->first_name . ' ' . $getEmployeeInfo->last_name : '', $attributes = ['class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('leave.leave_type')<span
                                                class="validateRq">*</span></label>
                                        {{ Form::select('leave_type_id', $leaveTypeList, Input::old('leave_type_id'), ['class' => 'form-control leave_type_id select2 required']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('leave.current_balance')<span
                                                class="validateRq">*</span></label>
                                        {!! Form::text('', '', $attributes = ['class' => 'form-control current_balance', 'readonly' => 'readonly', 'placeholder' => __('leave.current_balance')]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="optionalLeaveType_no">
                                <div class="col-md-4">
                                    <label for="exampleInput">@lang('common.from_date')<span
                                             id="from_date_span">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {!! Form::text('application_from_date', Input::old('application_from_date'), $attributes = ['class' => 'form-control application_from_date', 'readonly' => 'readonly', 'placeholder' => __('common.from_date')]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInput">@lang('common.to_date')<span
                                             id="to_date_span">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {!! Form::text('application_to_date', Input::old('application_to_date'), $attributes = ['class' => 'form-control application_to_date', 'readonly' => 'readonly', 'placeholder' => __('common.to_date')]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('leave.number_of_day')<span
                                                 id="number_of_day_span">*</span></label>
                                        {!! Form::text('number_of_day', '', $attributes = ['class' => 'form-control number_of_day', 'readonly' => 'readonly', 'placeholder' => __('leave.number_of_day')]) !!}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4"  id="religionWiseLeave">
                                    <div class="form-group">
                                        <label for="exampleInput">Religion Name<span
                                                class="validateRq">*</span></label>
                                        {{ Form::select('religion_name', $religionList, Input::old('religion_name'), ['class' => 'form-control religion_name select2 required']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInput">Attachment</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="	fa fa-picture-o"></i></span>
                                        <input class="form-control attachment" id="attachment" name="attachment"
                                            type="file">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('leave.purpose')<span
                                                class="validateRq">*</span></label>
                                        {!! Form::textarea('purpose', Input::old('purpose'), $attributes = ['class' => 'form-control purpose', 'id' => 'purpose', 'placeholder' => __('leave.purpose'), 'cols' => '30', 'rows' => '3']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="optionalLeaveList">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" id="formSubmit" class="btn btn-success "><i
                                            class="fa fa-paper-plane"></i> @lang('leave.send_application')</button>
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
@endsection
@section('page_scripts')
<script>
    jQuery(function() {
        $('#religionWiseLeave').hide();
        $('#optionalLeaveList').hide();
        $('#optionalLeaveType_no').show();
        var leave_type_id = '';
        $(document).on("focus", ".application_from_date", function() {
            $(this).datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                clearBtn: true,
                startDate: new Date(),
            }).on('changeDate', function(e) {
                $(this).datepicker('hide');
            });
        });

        $(document).on("focus", ".application_to_date", function() {
            $(this).datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                clearBtn: true,
                startDate: new Date(),
            }).on('changeDate', function(e) {
                $(this).datepicker('hide');
            });
        });

        $(document).on("change", ".application_from_date,.application_to_date  ", function() {

            var application_from_date = $('.application_from_date ').val();
            var application_to_date = $('.application_to_date ').val();
            var leave_type_id = $('.leave_type_id ').val();

            // alert(leave_type_id)

            if (application_from_date != '' && application_to_date != '') {
                var action = "{{ URL::to('applyForLeave/applyForTotalNumberOfDays') }}";
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: {
                        'application_from_date': application_from_date,
                        'application_to_date': application_to_date,
                        'leave_type_id': leave_type_id,
                        '_token': $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        console.log("Data: => " + data);

                        var currentBalance = $('.current_balance').val();
                        // var leave_type_id = $('.leave_type_id ').val();

                        if (data[1] == 24 && data[0] > 3) {
                            // $.toast({
                            //     heading: 'Warning',
                            //     text: 'You have to apply ' + $(
                            //             '.current_balance')
                            //         .val() + ' days!',
                            //     position: 'top-right',
                            //     loaderBg: '#ff6849',
                            //     icon: 'warning',
                            //     hideAfter: 3000,
                            //     stack: 6
                            // });
                            alert(
                                'Only 3 days allow for casual leave but special purpose maximum 10 days. Please mention your special purpose to purpose field then apply.'
                            );

                            // $('body').find('#formSubmit').attr('disabled', true);
                            // $('.number_of_day').val('');
                        } else {
                            if (data[0] > currentBalance) {
                                $.toast({
                                    heading: 'Warning',
                                    text: 'You have to apply ' + $(
                                            '.current_balance')
                                        .val() + ' days!',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'warning',
                                    hideAfter: 3000,
                                    stack: 6
                                });
                                $('body').find('#formSubmit').attr('disabled', true);
                                $('.number_of_day').val('');
                            } else if (data[0] == 0) {
                                $.toast({
                                    heading: 'Warning',
                                    text: 'You can not apply for leave !',
                                    position: 'top-right',
                                    loaderBg: '#ff6849',
                                    icon: 'warning',
                                    hideAfter: 3000,
                                    stack: 6
                                });
                                $('body').find('#formSubmit').attr('disabled', true);
                                $('.number_of_day').val('');
                            } else {
                                $('.number_of_day').val(data[0]);
                                $('body').find('#formSubmit').attr('disabled', false);
                            }
                        }
                    }
                });
            } else {
                $('body').find('#formSubmit').attr('disabled', true);
            }
        });
        $('.religion_name').on('change',function(){
            var religion_name = $('.religion_name').val();
            $('#optionalLeaveList').empty();
                $.ajax({
                    url: "{{ URL::to('applyForLeave/religion_wise_leave_list') }}/" + religion_name,
                    type: 'get',
                    complete: function(){
                    },
                    success:function(response){
                      console.log(response);
                        if(response.code == 200) {
                            var html = '<div class="col-md-8"><div class="form-group"><label for="exampleInput">Religion Wise Leave Date\'s<span class="validateRq">*</span></label>';
                            for(var i = 0; i < response.datelist.length ; i++) {
                                html += '<div class="form-check" style="font-size: 18px;padding-left: 20px"><input class="form-check-input" type="checkbox" value="'+ response.datelist[i]['leave_date']+'" id="flexCheckDefault_'+i+'"/><label class="form-check-label" for="flexCheckDefault" style="padding-left: 10px"></label>'+ response.datelist[i]['leave_date']+'     '+ response.datelist[i]['leave_name']+'</div>'
                          }
                          html += '</div></div>';
                          console.log(html);
                          $('#optionalLeaveList').append(html);
                        }
                    },
                    error: function(error) {
                     console.log(error);
                    }
                });
            })
        $(document).on("change", ".leave_type_id  ", function() {
            var leave_type_id = $('.leave_type_id ').val();
            var employee_id = $('.employee_id ').val();
            if(leave_type_id == 23) {
                $('#religionWiseLeave').show();
                $('#optionalLeaveList').show();
                $('#optionalLeaveType_no').hide();
                $('#from_date_span').removeClass("validateRq");
                $('#to_date_span').removeClass("validateRq");
                $('#number_of_day_span').removeClass("validateRq");
            }else{
                $('#religionWiseLeave').hide();
                $('#optionalLeaveList').hide();
                $('#optionalLeaveType_no').show();
                $('#from_date_span').addClass("validateRq");
                $('#to_date_span').addClass("validateRq");
                $('#number_of_day_span').addClass("validateRq");
            }

            if (leave_type_id != '' && employee_id != '') {
                var action = "{{ URL::to('applyForLeave/getEmployeeLeaveBalance') }}";
                $.ajax({
                    type: 'POST',
                    url: action,
                    data: {
                        'leave_type_id': leave_type_id,
                        'employee_id': employee_id,
                        '_token': $('input[name=_token]').val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data == 0) {
                            $.toast({
                                heading: 'Warning',
                                text: 'You have no leave balance !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'warning',
                                hideAfter: 3000,
                                stack: 6
                            });
                            $('.current_balance').val(data);
                            $('body').find('#formSubmit').attr('disabled', true);
                        } else {
                            $('.current_balance').val(data);
                            $('body').find('#formSubmit').attr('disabled', false);
                        }
                    }
                });
            } else {
                $('body').find('#formSubmit').attr('disabled', true);
                $.toast({
                    heading: 'Warning',
                    text: 'Please select leave type !',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'warning',
                    hideAfter: 3000,
                    stack: 6
                });
                $('.current_balance').val('');
            }
        });

    });
</script>
@endsection
