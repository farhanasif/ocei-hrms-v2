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
    .tip-box {
        color: #2e5014;
        background: #e7dfa5;
    }

    .note-box, .warning-box, .tip-box {
        padding: 15px 15px 2.5px 27.5px;
    }
    .tip-icon {
    background: #92CD59;
    }

    .info-tab {
        width: 40px;
        height: 40px;
        display: inline-block;
        position: absolute;
        top: 16px;
        left: 0;
    }
    .shadow {
        background: #F7F8F9;
        padding: 3px;
        margin: 15px 0 20px;
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
                                {!! Form::hidden('role_id', isset($getUserInfo) ? $getUserInfo->role_id : '', $attributes = ['class' => 'role_id']) !!}

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
                                <div class="col-md-4" id="curr_bal">
                                    <div class="form-group">
                                        <label for="exampleInput">@lang('leave.current_balance')<span
                                                class="validateRq">*</span></label>
                                        {!! Form::text('', '', $attributes = ['class' => 'form-control current_balance', 'readonly' => 'readonly', 'placeholder' => __('leave.current_balance')]) !!}
                                    </div>
                                </div>

                                <div class="col-md-4" id="auth_leave_provide">
                                    <div class="form-group">
                                        <label for="exampleInput">Author Provide @lang('common.employee_name')<span
                                                class="validateRq">*</span></label>
                                        {{ Form::select('for_employee_id', $getAllEmployeeList, Input::old('employee_id'), ['class' => 'form-control employee_id select2 required']) }}
                                    </div>
                                </div>
                            </div>

                            <div id="calendar">
                                
                            </div>
                            <div class="row" id="optionalLeaveType_no">
                                <div class="col-md-4">
                                    <label for="exampleInput">@lang('common.from_date')<span class="validateRq" 
                                             id="from_date_span">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        {!! Form::text('application_from_date', Input::old('application_from_date'), $attributes = ['class' => 'form-control application_from_date', 'readonly' => 'readonly', 'placeholder' => __('common.from_date')]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInput">@lang('common.to_date')<span class="validateRq"
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
                                        {!! Form::text('number_of_day', '', $attributes = ['class' => 'form-control number_of_day','id' => 'number_of_day', 'readonly' => 'readonly','required'=>'required', 'placeholder' => __('leave.number_of_day')]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="casual_leave_cause">
                                <div class="color-box space">
                                    <div class="shadow">
                                        <div class="tip-box">
                                            <p style="font-size: 16px;"><strong style="color:#ff5a5a;">Warning:</strong> Only <code>3 days</code>allow for<code> casual leave</code>but special purpose <code> maximum 10 days.</code> Please mention your special purpose to "purpose" field then apply.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="attact_purpose">
                                <div class="col-md-4"  id="religionWiseLeave">
                                    <div class="form-group">
                                        <label for="exampleInput">Religion Name<span
                                                class="validateRq">*</span></label>
                                        {{ Form::select('religion_name', $religionList, Input::old('religion_name'), ['class' => 'form-control religion_name select2 required']) }}
                                    </div>
                                </div>
                                <div class="col-md-4" id="attachment_doc2">
                                    <label for="exampleInput">Attachment<span
                                                class="validateRq">*</span><br /><span style="color: gray; opacity: 0.8; font-size: 12px;">The Medical Report document is highly required for this leave apply</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="	fa fa-picture-o"></i></span>
                                        <input class="form-control attachment" id="attachment" name="attachment"
                                            type="file">
                                    </div>
                                </div>

                                <div class="col-md-4" id="attachment_doc1">
                                    <label for="exampleInput">Attachment</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="  fa fa-picture-o"></i></span>
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
        $('#casual_leave_cause').hide();
        $('#attachment_doc2').hide();
        $('#auth_leave_provide').hide();

        var leave_type_id = '';
        var role_id = $('.role_id ').val();
        
        if(role_id == 1 || role_id == 10){
            $(document).on("focus", ".application_from_date", function() {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    // startDate: new Date(),
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                });
            });

            $(document).on("focus", ".application_to_date", function() {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    // startDate: new Date(),
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                });
            });
        }else{
            $(document).on("focus", ".application_from_date", function() {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    // startDate: new Date(),
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                });
            });

            $(document).on("focus", ".application_to_date", function() {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    // startDate: new Date(),
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                });
            });
        }


        $(document).on("change", ".application_from_date,.application_to_date  ", function() {

            var application_from_date = $('.application_from_date ').val();
            var application_to_date = $('.application_to_date ').val();
            var leave_type_id = $('.leave_type_id ').val();

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
                            if(leave_type_id == 24) {
                                $('#casual_leave_cause').show();
                                $('#number_of_day').val(data[0]);
                            }
                        }
                        
                        if (data[1] == 24 && data[0] > 10) {
                            alert('The requested leave date range more than 10 days! Sorry! Maximum 10 days causal leave request are accepteable.');
                            return;
                        }

                        if(data[1] == 9 && data[0] > 21) {
                            $('#attachment_doc2').show();
                            $('#attachment_doc1').hide();
                        }

                        if(data[1] == 14 && data[0] > 90) {
                            $('#attachment_doc2').show();
                            $('#attachment_doc1').hide();
                        }

                        if (data[0] > currentBalance && leave_type_id != 19 && leave_type_id != 20) {
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
                });
            } else {
                if(leave_type_id != 19 && leave_type_id != 20){
                    $('body').find('#formSubmit').attr('disabled', true);
                }
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
                                html += '<div class="form-check" style="font-size: 18px;padding-left: 20px"><input class="form-check-input" type="checkbox" value="'+ response.datelist[i]['leave_date']+'" id="flexCheckDefault_'+i+'" name="leave_date[]"/><label class="form-check-label" for="flexCheckDefault" style="padding-left: 10px"></label>'+ response.datelist[i]['leave_date']+'     '+ response.datelist[i]['leave_name']+'</div>'
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


            $('#calendar').empty();
            $('#curr_bal').show();
            $('#optionalLeaveType_no').show();
            $('#attact_purpose').show();
            $('#formSubmit').show();
            $('#auth_leave_provide').hide();
            
            var leave_type_id = $('.leave_type_id ').val();
            var employee_id = $('.employee_id ').val();

            if(leave_type_id == 21 || leave_type_id == 22) {
                  $.ajax({
                        url: "{{ URL::to('applyForLeave/getHolidayCalendar') }}/" + leave_type_id,
                        type: 'get',
                        dataType: 'json',
                        success: function (response) {
                          if (response.length == 0) {
                            console.log( "No data found");
                          } else { 
                            // set values
                            console.log(response);
                            $('#calendar').append(
                                 '<img src="'+ response.data +
                                 '" alt="Calendar" style ="padding-left:300px; width: 700px; height: 500px;">'
                                );

                            $('#curr_bal').hide();
                            $('#optionalLeaveType_no').hide();
                            $('#attact_purpose').hide();
                            $('#formSubmit').hide(); 
                          }
                        }
                    });
            }

            if(leave_type_id == 19 || leave_type_id == 20) {
                if(role_id != 1 && role_id != 10) {
                    $.toast({
                        heading: 'Warning',
                        text: 'Sorry! You can not apply for leave. This leave apply only for Authority.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'warning',
                        hideAfter: 3000,
                        stack: 6
                    });
                    return;
                }else {
                   $('#curr_bal').hide();
                   $('#auth_leave_provide').show();
                }
            }

            if(leave_type_id == 16 || leave_type_id == 8 || leave_type_id == 15) {
                $('#attachment_doc2').show();
                $('#attachment_doc1').hide();
            }else{
                $('#attachment_doc2').hide();
                $('#attachment_doc1').show();
            }

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

            if (leave_type_id != '' && employee_id != '' && leave_type_id != 19 && leave_type_id != 20) {
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
                if(leave_type_id != 19 && leave_type_id != 20) {
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
            }
        });

    });
</script>
@endsection

$2y$10$7D6azhrLZP.pcxGsyp1MSuKkn5gbHG.CmRPyAkyVMf03qtjWYXacG