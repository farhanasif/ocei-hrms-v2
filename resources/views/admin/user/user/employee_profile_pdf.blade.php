
<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Nis Summary Report</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="{!! asset('admin_assets/css/style.css') !!}" rel="stylesheet">
	</head>
	<style>
		table {
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
		}
	</style>

<body>
	<div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>
                @lang('employee.profile')</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <div class="panel-body">
                        <div class="">
                            <div class=" col-xs-6 col-sm-6 col-md-4">
                                <div id="resume">
                                    <p><strong>{{ $employeeInfo->first_name }}
                                            {{ $employeeInfo->last_name }}</strong>
                                    </p>
                                    <p><strong>{{ $employeeInfo->bangla_first_name }}
                                            {{ $employeeInfo->bangla_last_name }}</strong>
                                    </p>
                                    <p> <b>Department :</b> {{ $othersInfo->department_name }}</p>
                                    <p> <b>Designation :</b> {{ $othersInfo->designation_name }}</p>
                                    <p> <b>@lang('employee.phone') :</b> {{ $employeeInfo->phone }}</p>
                                    <p><b>@lang('employee.email') :</b> {{ $employeeInfo->email }}</p>
                                    <p>
                                    </p>
                                    <p class="applicant_address"> <b>@lang('employee.address') : </b>
                                        {{ $employeeInfo->present_address }}</p>
                                    <p>
                                    <p> <b>NID :</b> {{ $employeeInfo->nid }}</p>
                                    <p>

                                    </p>
                                </div>
                            </div>
                            <div class="col-md-offset-2 col-xs-6 col-sm-6 col-md-6">
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

                           <!-- Personoal Information: -->

                            <div class="personal_info">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel-custom">
                                            <h3 class="panel-title"><i class="fa fa-info-circle"></i>
                                                @lang('employee.personal_information') (English)</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="personal_info">
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.name')</div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->first_name }}
                                                    {{ $employeeInfo->last_name }}</div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Father Name</div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->father_name }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Mother Name</div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->mother_name }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.email')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->email }}</div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.address')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->present_address }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.phone')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->phone }}</div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">
                                                    @lang('employee.date_of_joining')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ dateConvertDBtoForm($employeeInfo->date_of_joining) }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">
                                                    @lang('employee.date_of_birth')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ dateConvertDBtoForm($employeeInfo->date_of_birth) }}
                                                </div>
                                            </div>

                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.gender')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->gender }}</div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.religion')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->religion }}</div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3"> Freedom Fighter </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->freedom_fighter }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">
                                                    @lang('employee.marital_status')
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->marital_status }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Spouse Name</div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->spouse_name }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Spouse NID</div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->spouse_nid }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Spouse Birth Certificate
                                                    No.
                                                </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->spouse_birth_certificate_no }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Spouse Date of Birth </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->spouse_date_of_birth }}
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="col-xs-2 col-sm-2 col-md-3">Spouse Birth Certificate
                                                    Document </div>
                                                <div class="col-xs-10 col-sm-10 col-md-9">
                                                    :&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @if ($employeeInfo->spouse_nid_or_birth_certificate != '' && file_exists('uploads/employeeSpouseBirthCertificate/' . $employeeInfo->spouse_nid_or_birth_certificate))
                                                        <a class="btn btn-success" style="color: black"
                                                            target="_blank" href="{!! asset('uploads/employeeSpouseBirthCertificate/' . $employeeInfo->spouse_nid_or_birth_certificate) !!}">View
                                                            Birth Certificate</a>
                                                    @else
                                                        <a href="#"> </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="personal_info">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="panel-custom">
                                            <h3 class="panel-title"><i class="fa fa-info-circle"></i>
                                                @lang('employee.personal_information') (Bangla)</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="item">
                                        <div class="col-xs-2 col-sm-2 col-md-3">@lang('employee.name')</div>
                                        <div class="col-xs-10 col-sm-10 col-md-9">
                                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->bangla_first_name }}
                                            {{ $employeeInfo->bangla_last_name }}</div>
                                    </div>
                                    <div class="item">
                                        <div class="col-xs-2 col-sm-2 col-md-3">Father Name</div>
                                        <div class="col-xs-10 col-sm-10 col-md-9">
                                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->bangla_father_name }}
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="col-xs-2 col-sm-2 col-md-3">Mother Name</div>
                                        <div class="col-xs-10 col-sm-10 col-md-9">
                                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->bangla_mother_name }}
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="col-xs-2 col-sm-2 col-md-3">Spouse Name</div>
                                        <div class="col-xs-10 col-sm-10 col-md-9">
                                            :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->bangla_spouse_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- 'ACADEMIC QUALIFICATION: -->
                            <div class="education_qualification">
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
                                                                <th>@lang('employee.institute')</th>
                                                                <th>@lang('employee.degree')</th>
                                                                <th>@lang('employee.board') /
                                                                    @lang('employee.university')</th>
                                                                <th>@lang('employee.result')</th>
                                                                <th>@lang('employee.gpa') / @lang('employee.cgpa')
                                                                </th>
                                                                <th>@lang('employee.passing_year')</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="education_lable">
                                                            @if (count($employeeEducation) > 0)
                                                                @foreach ($employeeEducation as $education)
                                                                    <tr>
                                                                        <td>{{ $education->institute }}</td>
                                                                        <td>{{ $education->degree }}</td>
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

                            <div class="education_qualification">
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
                                </div>
                                <div class="row">
                                    <div class="personal_info">
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3">Paygrade Name</div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $othersInfo->pay_grade_name }}</div>
                                        </div>

                                        {{-- <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> Pay Grade Salary </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $othersInfo->basic_salary }}
                                            </div>
                                        </div> --}}

                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> Basic Salary
                                            </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $employeeInfo->present_increement_salary }}
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> Gross Salary
                                            </div>
                                            @php
                                                $totalSalary = 0;
                                                $houseRentAmount = ($employeeInfo->present_increement_salary * $house_rent_from_pay_grade) / 100;
                                            @endphp
                                            @foreach ($totalSalaryWithAllowance as $value)
                                                @php
                                                    $totalSalary += $value->limit_per_month;
                                                @endphp
                                            @endforeach
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;
                                                @if (isset($employeeInfo->present_increement_salary))
                                                    {{ isset($totalSalary) ? $totalSalary + $employeeInfo->present_increement_salary + $houseRentAmount : null }}
                                                @else
                                                    {{ isset($totalSalary) ? $totalSalary + $othersInfo->basic_salary + $houseRentAmount : null }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> e-TIN Number </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $othersInfo->etin_number }}
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> GPF Number </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $othersInfo->gpf_number }}
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> Fixation Verification Number
                                            </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ $othersInfo->fixation_verification_number }}
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> Last Promotion Date
                                            </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ isset($promotionInfo->promotion_date) ? $promotionInfo->promotion_date : '' }}
                                            </div>
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
                                <div class="row">
                                    <div class="personal_info">
                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3">Award Name</div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ isset($employeeAward->award_name) ? $employeeAward->award_name : '' }}
                                            </div>
                                        </div>

                                        <div class="item">
                                            <div class="col-xs-2 col-sm-2 col-md-3"> Month </div>
                                            <div class="col-xs-10 col-sm-10 col-md-9">
                                                :&nbsp;&nbsp;&nbsp;&nbsp;{{ isset($employeeAward->month) ? $employeeAward->month : '' }}
                                            </div>
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
                                                                        <td style="max-width: 300px; overflow: overlay;">{{ $traningInfoData->description }}
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
</body>
</html>


