
<!DOCTYPE html>
    <html lang="en">
    <head>
        <title>{{ $employeeInfo->first_name }} {{ $employeeInfo->last_name }} Profile PDF</title>
    </head>
    <style>
    @font-face {
        font-family: "nikosh";
        font-style: normal;
        font-weight: normal;
    }

    * {
        font-family: 'nikosh', Arial ;
    }
    .col-sm-12 {
        width: 100%;
    }
    .col-xs-12 {
        width: 100%;
    }
    .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9 {
        float: left;
    }

    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }

    .panel-green, .panel-success {
        border-color: #7ace4c;
    }

    .panel {
        border-radius: 0;
        margin-bottom: 30px;
        border: 0;
        box-shadow: none;
    }

    .panel .panel-heading {
        border-radius: 0;
        font-weight: 500;
        font-size: 16px;
        padding: 10px 25px;
    }

    .panel-green .panel-heading, .panel-success .panel-heading {
        border-color: #7ace4c;
        color: #fff;
        background-color: #7ace4c;
    }
    .collapse.in {
        display: block;
    }
    .panel .panel-body {
        padding: 25px;
    }
    .col-md-4 {
        width: 33.33333333%;
    }

    .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
        float: left;
    }


    p {
        line-height: 1.6;
        margin: 0 0 10px;
    }
    .col-md-offset-2 {
        margin-left: 16.66666667%;
    }

    .col-md-6 {
        width: 50%;
    }
    .text-right {
        text-align: right;
    }

    img {
        vertical-align: middle;
    }

    .row {
        margin-right: -15px;
        margin-left: -15px;
    }
    .panel-custom {
        background-color: #F1F1F1;
        box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        padding: 10px 15px;
    }

    .panel .panel-body:first-child h3 {
        /*margin-top: 0;
        font-weight: 500;*/
        font-family: Rubik,sans-serif;
        font-size: 14px;
        text-transform: uppercase;
    }
    .fa {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: inherit;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .col-md-12 {
        width: 100%;
    }
    .item {
        padding: 2px 21px;
    }
    .col-md-3 {
        width: 25%;
    }

    .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
        float: left;
    }
/*    .col-md-9 {
        width: 75%;
    }*/
    section, summary {
        display: block;
    }
    .table-bordered {
        border: 1px solid #e4e7ea;
    }

    .table-bordered, .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        border-top: 1px solid #e4e7ea;
    }
    .table {
        margin-bottom: 10px;
    }
    .table-bordered {
        border: 1px solid #ddd;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
    }
    table {
        background-color: transparent;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }

    .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 0;
    }

    .table>thead>tr>th {
        vertical-align: bottom;
        border-bottom: 1px solid #e4e7ea;
    }

    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #e4e7ea;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 15px 8px;
    }

    th {
        color: #000;
        font-weight: 600;
    }

    th {
        text-align: left;
    }
    tbody {
        color: #000;
    }
/*    .personal_info {
        overflow: hidden;
    }
    .personal_info_bn {
        padding-top: 450px;
    }*/

/*    .personal_info_bn {
        padding-top: 450px;
    }*/
/*    .education_qualification {
        padding-top: 120px;
    }*/
/*# sourceMappingURL=bootstrap.css.map */
    /*  table {
            margin: 0 0 40px 0;
            width: 100%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            display: table;
            border-collapse: collapse;
        }
        .printHead{
            width: 35%;
            margin: 0 auto;
        }
        table, td, th {
            border: 1px solid black;
        }
        td{
            padding: 5px;
        }

        th{
            padding: 5px;
        }*/
    </style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>
                        @lang('employee.profile')</div>
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <div class="panel-body">
                                    <div class="personal_info">
                                            <div class="col-xs-6 col-sm-6 col-md-4">
                                                <div id="resume">
                                                    <p><strong>{{ $employeeInfo->first_name }}
                                                            {{ $employeeInfo->last_name }}</strong>
                                                    </p>
                                                    <p>{{ $employeeInfo->bangla_first_name }}
                                                            {{ $employeeInfo->bangla_last_name }}
                                                    </p>
                                                    <p> <b>Department :</b> {{ $othersInfo->department_name }}</p>
                                                    <p> <b>Designation :</b> {{ $othersInfo->designation_name }}</p>
                                                    <p> <b>@lang('employee.phone') :</b> {{ $employeeInfo->phone }}</p>
                                                    <p><b>@lang('employee.email') :</b> {{ $employeeInfo->email }}</p>
                                                    <p>
                                                    </p>
                                                    <p class="applicant_address"> <b>@lang('employee.address') : </b>
                                                        {{ $employeeInfo->present_address }}</p>
                                                    <p> <b>NID :</b> {{ $employeeInfo->nid }}</p>
                                                    <p>

                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-offset-2 col-xs-6 col-sm-6">
                                                <div class="applicant_pic text-right">
                                                    <?php
                                                        if($employeeInfo->photo !=''){
                                                    ?>
                                                    <img style="width: 124px;height:135px" src="{!! asset('uploads/employeePhoto/' . $employeeInfo->photo) !!}">
                                                    <?php  }else{ ?>
                                                    <img style="width: 124px;height:135px" src="{!! asset('admin_assets/img/default.png') !!}">
                                                    <?php } ?>
                                                </div>
                                                <br>
                                            </div>
                                    </div>

                                   <!-- Personoal Information: -->

                                    <div class="personal_info_en" style="padding-top: 370px;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="panel-custom">
                                                    <h3 class="panel-title"><i class="fa fa-info-circle"></i>
                                                        @lang('employee.personal_information') (English)</h3>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="personal_info">
                                                    <div class="item">
                                                        <p class="">@lang('employee.name')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->first_name }}
                                                            {{ $employeeInfo->last_name }}</p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Father Name
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->father_name }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Mother Name
                                                     <!--    </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->mother_name }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">@lang('employee.email')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->email }}</p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">@lang('employee.address')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->present_address }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">@lang('employee.phone')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->phone }}</p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">
                                                            @lang('employee.date_of_joining')
                                                       <!--  </div>
                                                        <div class=""> -->
                                                            : {{ dateConvertDBtoForm($employeeInfo->date_of_joining) }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">
                                                            @lang('employee.date_of_birth')
                                                       <!--  </div>
                                                        <div class=""> -->
                                                            : {{ dateConvertDBtoForm($employeeInfo->date_of_birth) }}
                                                        </p>
                                                    </div>

                                                    <div class="item">
                                                        <p class="">@lang('employee.gender')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->gender }}</p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">@lang('employee.religion')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->religion }}</p>
                                                    </div>
                                                    <div class="item">
                                                        <p class=""> Freedom Fighter
                                                        <!--  </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->freedom_fighter }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">
                                                            @lang('employee.marital_status')
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->marital_status }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Spouse Name
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->spouse_name }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Spouse NID
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->spouse_nid }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Spouse Birth Certificate
                                                            No.
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->spouse_birth_certificate_no }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Spouse Date of Birth 
                                                        <!-- </div>
                                                        <div class=""> -->
                                                            : {{ $employeeInfo->spouse_date_of_birth }}
                                                        </p>
                                                    </div>
                                                    <div class="item">
                                                        <p class="">Spouse Birth Certificate
                                                            Document 
                                                           <!--  </div>
                                                        <div class=""> -->
                                                            : 
                                                            @if ($employeeInfo->spouse_nid_or_birth_certificate != '' && file_exists('uploads/employeeSpouseBirthCertificate/' . $employeeInfo->spouse_nid_or_birth_certificate))
                                                                <a class="btn btn-success" style="color: black"
                                                                    target="_blank" href="{!! asset('uploads/employeeSpouseBirthCertificate/' . $employeeInfo->spouse_nid_or_birth_certificate) !!}">View
                                                                    Birth Certificate</a>
                                                            @else
                                                                <a href="#"> </a>
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <br>

                                    <div class="personal_info_bn" style="padding-top: 120px;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="panel-custom">
                                                    <h3 class="panel-title"><i class="fa fa-info-circle"></i>
                                                        @lang('employee.personal_information') (Bangla)</h3>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="item">
                                                    <p class="">@lang('employee.name')
                                                    <!-- </div> -->
                                                    <!-- <div class=""> -->
                                                        : {{ $employeeInfo->bangla_first_name }}
                                                        {{ $employeeInfo->bangla_last_name }}</p>
                                                </div>
                                                <div class="item">
                                                    <p class="">Father Name
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $employeeInfo->bangla_father_name }}
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class="">Mother Name
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $employeeInfo->bangla_mother_name }}
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class="">Spouse Name
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $employeeInfo->bangla_spouse_name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <!-- 'ACADEMIC QUALIFICATION: -->
                                    <div class="education_qualification" style="padding-top: 160px;">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="panel-custom">
                                                        <h3 class="panel-title"><i class="fa fa-graduation-cap"></i>
                                                            @lang('employee.educational_qualification')</h3>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <table id="example1" class="table table-bordered table-hover">
                                                                <thead class="education_lable">
                                                                    <tr>
                                                                        <th>@lang('employee.degree')</th>
                                                                        <th>@lang('employee.institute') /
                                                                            @lang('employee.university')</th>
                                                                        
                                                                        <th>@lang('employee.board') </th>
                                                                        <th>@lang('employee.result') ( Class )</th>
                                                                        <th>Result (@lang('employee.gpa') / @lang('employee.cgpa'))
                                                                        </th>
                                                                        <th>@lang('employee.passing_year')</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="education_lable">
                                                                    @if (count($employeeEducation) > 0)
                                                                        @foreach ($employeeEducation as $education)
                                                                            <tr>
                                                                                <td>{{ $education->degree }}</td>
                                                                                <td>{{ $education->institute }}</td>
                                                                                
                                                                                <td>{{ $education->board_university }}
                                                                                </td>
                                                                                <td>{{ $education->result }}</td>
                                                                                <td>{{ $education->cgpa }}</td>
                                                                                <td>{{ $education->passing_year }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                    </div>

                                    <div class="professional_experience">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="panel-custom">
                                                        <h3 class="panel-title"><i class="fa fa-laptop"></i>
                                                            @lang('employee.professional_experience')</h3>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <table id="example1" class="table table-bordered table-hover">
                                                                <thead class="education_lable">
                                                                    <tr>
                                                                        <th>@lang('employee.organization_name')</th>
                                                                        <th>@lang('employee.designation')</th>
                                                                        <th>@lang('employee.duration')</th>
                                                                        <th>@lang('employee.skill')</th>
                                                                        <th>@lang('employee.responsibility')</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="education_lable">
                                                                    @if (count($employeeExperience) > 0)
                                                                        @foreach ($employeeExperience as $experience)
                                                                            <tr>
                                                                                <td>{{ $experience->organization_name }}
                                                                                </td>
                                                                                <td>{{ $experience->designation }}</td>
                                                                                <td>{{ $experience->from_date }} To
                                                                                    {{ $experience->to_date }}</td>
                                                                                <td>{{ $experience->skill }}</td>
                                                                                <td>{{ $experience->responsibility }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                    </div>

                                    <div class="child_information">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="panel-custom">
                                                        <h3 class="panel-title"><i class="fa fa-laptop"></i> Employee
                                                            Child
                                                            Information</h3>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <table id="example1" class="table table-bordered table-hover">
                                                                <thead class="child_lable">
                                                                    <tr>
                                                                        <th>Child Name</th>
                                                                        <th>Date Of Birth</th>
                                                                        <th>NID Number</th>
                                                                        <th>Birth Certificate Number</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="education_lable">
                                                                    @if (count($employeeChildData) > 0)
                                                                        @foreach ($employeeChildData as $child)
                                                                            <tr>
                                                                                <td>{{ $child->child_name }}</td>
                                                                                <td>{{ $child->child_date_of_birth }}
                                                                                </td>
                                                                                <td>{{ $child->child_nid_number }}</td>
                                                                                <td>{{ $child->birth_certificate_number }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                    </div>

                                    <div class="logistic_information">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="panel-custom">
                                                        <h3 class="panel-title"><i class="fa fa-laptop"></i> Employee
                                                            Logistic Information</h3>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <table id="example1" class="table table-bordered table-hover">
                                                                <thead class="logistic_lable">
                                                                    <tr>
                                                                        <th>Type </th>
                                                                        <th>Name</th>
                                                                        <th>Quantity</th>
                                                                        <th>Date</th>
                                                                        <th>Reference No</th>
                                                                        <th>Logistic Document</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="education_lable">
                                                                    @if (count($employeeLogisticData) > 0)
                                                                        @foreach ($employeeLogisticData as $logisticData)
                                                                            <tr>
                                                                                <td>{{ $logisticData->logistic_type }}
                                                                                </td>
                                                                                <td>{{ $logisticData->logistic_name }}
                                                                                </td>
                                                                                <td>{{ $logisticData->logistic_quantity }}
                                                                                </td>
                                                                                <td>{{ $logisticData->logistic_date }}
                                                                                </td>
                                                                                <td>{{ $logisticData->logistic_reference_no }}
                                                                                </td>
                                                                                <td>
                                                                                    @if ($employeeInfo->logistic_file != '' && file_exists('uploads/employeeLogisticFile/' . $employeeInfo->logistic_file))
                                                                                        <a class="btn btn-success"
                                                                                            style="color: black"
                                                                                            target="_blank"
                                                                                            href="{{ asset('uploads/employeeLogisticFile/' . $employeeInfo->logistic_file) }}">View
                                                                                            Logistic Document</a>
                                                                                    @else
                                                                                        <a href="#"> </a>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                    </div>

                                    <!--paygrade info -->

                                    <br>
                                    <div class="personal_info">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="panel-custom">
                                                    <h3 class="panel-title"><i class="fa fa-info-circle"></i> Paygrade
                                                        Information</h3>
                                                </div>
                                            </div>

                                            <div class="personal_info">
                                                <div class="item">
                                                    <p class="">Paygrade Name
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $othersInfo->pay_grade_name }}</p>
                                                </div>

                                                {{-- <div class="item">
                                                    <div class=""> Pay Grade Salary </div>
                                                    <div class="">
                                                        : {{ $othersInfo->basic_salary }}
                                                    </div>
                                                </div> --}}

                                                <div class="item">
                                                    <p class=""> Basic Salary
                                                   <!--  </div>
                                                    <div class=""> -->
                                                        : {{ $employeeInfo->present_increement_salary }}
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class=""> Gross Salary
                                                    <!-- </div> -->
                                                    @php
                                                        $totalSalary = 0;
                                                        $houseRentAmount = ($employeeInfo->present_increement_salary * $house_rent_from_pay_grade) / 100;
                                                    @endphp
                                                    @foreach ($totalSalaryWithAllowance as $value)
                                                        @php
                                                            $totalSalary += $value->limit_per_month;
                                                        @endphp
                                                    @endforeach
                                                    <!-- <div class=""> -->
                                                        : 
                                                        @if (isset($employeeInfo->present_increement_salary))
                                                            {{ isset($totalSalary) ? $totalSalary + $employeeInfo->present_increement_salary + $houseRentAmount : null }}
                                                        @else
                                                            {{ isset($totalSalary) ? $totalSalary + $othersInfo->basic_salary + $houseRentAmount : null }}
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class=""> e-TIN Number 
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $othersInfo->etin_number }}
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class=""> GPF Number 
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $othersInfo->gpf_number }}
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class=""> Fixation Verification Number
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ $othersInfo->fixation_verification_number }}
                                                    </p>
                                                </div>
                                                <div class="item">
                                                    <p class=""> Last Promotion Date
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ isset($promotionInfo->promotion_date) ? $promotionInfo->promotion_date : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                    <div class="performance_information">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="panel-custom">
                                                        <h3 class="panel-title"><i class="fa fa-laptop"></i>
                                                            Performance
                                                            Information</h3>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <table id="example1" class="table table-bordered table-hover">
                                                                <thead class="child_lable">
                                                                    <tr>
                                                                        <th>Category Name</th>
                                                                        <th>Criteria Name</th>
                                                                        <th>rating (Out of 5)</th>
                                                                        <th>Judgement</th>
                                                                        <th>Comments</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="education_lable">
                                                                    @if (count($criteriaDataFormat) > 0)
                                                                        @foreach ($criteriaDataFormat as $criteria)
                                                                            <tr>
                                                                                <td>{{ $criteria['performance_category_name'] }}
                                                                                </td>
                                                                                <td>{{ $criteria['performance_criteria_name'] }}
                                                                                </td>
                                                                                <td>{{ $criteria['rating'] }}</td>
                                                                                <td>{{ $criteria['judgement'] }}</td>
                                                                                <td>{{ $criteria['comments'] }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                    </div>

                                    <!-- Employee Award info -->

                                    <br>
                                    <div class="personal_info">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="panel-custom">
                                                    <h3 class="panel-title"><i class="fa fa-info-circle"></i> Award
                                                        Information</h3>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="personal_info">
                                                <div class="item">
                                                    <p class="">Award Name
                                                    <!-- </div>
                                                    <div class=""> -->
                                                        : {{ isset($employeeAward->award_name) ? $employeeAward->award_name : '' }}
                                                    </p>
                                                </div>

                                                <div class="item">
                                                    <p class=""> Month 
                                                   <!--  </div>
                                                    <div class=""> -->
                                                        : {{ isset($employeeAward->month) ? $employeeAward->month : '' }}
                                                    </p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Employee Training info -->

                                    <br>


                                    <div class="child_information">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="panel-custom">
                                                        <h3 class="panel-title"><i class="fa fa-laptop"></i> Training
                                                            Information</h3>
                                                    </div>
                                                    <div class="box">
                                                        <div class="box-body">
                                                            <table id="example1" class="table table-bordered table-hover">
                                                                <thead class="child_lable">
                                                                    <tr>
                                                                        <th>Training Type Name</th>
                                                                        <th>Training Name</th>
                                                                        <th>Organization Name</th>
                                                                        <th>Training Date&Time</th>
                                                                        <th>@lang('training.training_duration')</th>
                                                                        <th>Description</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="education_lable">
                                                                    @if (count($traningInfo) > 0)
                                                                        @foreach ($traningInfo as $traningInfoData)
                                                                            <tr>
                                                                                <td>{{ $traningInfoData->training_type_name }}
                                                                                </td>
                                                                                <td style="width:60px;">{{ $traningInfoData->subject }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $traningInfoData->organization_name }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ dateConvertDBtoForm($traningInfoData->start_date) }}
                                                                                    To
                                                                                    {{ dateConvertDBtoForm($traningInfoData->end_date) }}
                                                                                    &nbsp;&nbsp;

                                                                                    <br>{!! date('h:i a', strtotime($traningInfoData->start_time)) !!} To
                                                                                    {!! date('h:i a', strtotime($traningInfoData->end_time)) !!}
                                                                                </td>
                                                                                <td>
                                                                                    @if (isset($traningInfoData->training_day) && !empty($traningInfoData->training_day))
                                                                                        {{ $traningInfoData->training_day }}
                                                                                        Day <br>
                                                                                    @endif
                                                                                    @if (isset($traningInfoData->training_hour) && !empty($traningInfoData->training_hour))
                                                                                        {{ $traningInfoData->training_hour }}
                                                                                        Hour
                                                                                    @endif
                                                                                </td>
                                                                                <td style="max-width: 300px;text-align: justify-all;">
                                                                                <div>{{ $traningInfoData->description }}</div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr class="text-center">
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                            <td>--</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</body>
</html>
