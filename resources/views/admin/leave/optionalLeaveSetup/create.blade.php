@extends('admin.master')
@section('content')

@section('title')
    Add optional leave
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
        <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
            <a href="{{ route('optional.leave.setup.index') }}"
                class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i
                    class="fa fa-list-ul" aria-hidden="true"></i> View Option Leave </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                            <form action="{{url('optionalLeaveSetup/store')}}" method="POST" class="form-horizontal">
                                {{ csrf_field() }}
                                 <div class="form-body">
                            <div class="row">
                                <div class="col-md-offset-2 col-md-6">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Religion Name<span
                                                class="validateRq">*</span></label>
                                        <div class="col-md-8">
                                            <select class="form-control" id="religion_name" name="religion_name" required>
                                                <option value="">>--- Select Religion ---<</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Hinduism">Hinduism</option>
                                                <option value="Buddhism">Buddhism</option>
                                                <option value="Christianity">Christianity</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            <!-- <input type="text" class="form-control" name="religion_name" placeholder="Religion Name" class="close" value="{{old('religion_name')}}"> -->
                                  </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Leave Year<span
                                                class="validateRq">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control monthField" name="leave_year" placeholder="Leave Year" value="{{old('leave_year')}}" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input_date_wrap">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Leave Date & Name<span
                                                    class="validateRq">*</span></label>
                                               <!-- <div><input type="text" name="mytext[]"></div> -->
                                            <div class="col-md-4">
                                                <input type="text" class="form-control dateField" name="leave_date[]" placeholder="First Leave Date" required value="{{old('leave_date')}}" >
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="leave_name[]" placeholder="First Leave Name" required value="{{old('leave_name')}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="add_date_button" style="color:#7ace4c;height:38px;border: 0.5px solid #7ace4c;"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                                <button type="submit" class="btn btn-success btn_style"><i
                                                        class="fa fa-check"></i> @lang('common.save')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
        var max_fields      = 6; //maximum input boxes allowed
        var wrapper         = $(".input_date_wrap"); //Fields wrapper
        var add_button      = $(".add_date_button"); //Add button ID

        var x = 1; //initlal text box count
        var leave_date = ['First','Second', 'Third', 'Four', 'Five', 'Six'];
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="input_date_wrap"><div class="col-md-8"><div class="form-group"><label class="control-label col-md-4">Leave Date<span class="validateRq">*</span></label><div class="col-md-4"><input type="text" class="form-control dateField" name="leave_date[]" placeholder="'+leave_date[x-1]+' Leave Date" required></div><div class="col-md-4"><input type="text" class="form-control" name="leave_name[]" placeholder="'+leave_date[x-1]+' Leave Name" required></div></div></div><div class="col-md-4"><button class="remove_date" style="color:red;height:38px;border: 0.5px solid red;"><i class="fa fa-minus" aria-hidden="true"></i></button></div></div>'); //add input box
            }
        });

        $(wrapper).on("click",".remove_date", function(e){ //user click on remove text
            // e.preventDefault(); $(this).parent('div').remove(); 
            $(this).closest('.input_date_wrap').remove();
            x--;
        })
    });
</script>
@endsection
