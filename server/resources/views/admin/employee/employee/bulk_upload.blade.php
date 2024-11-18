@extends('admin.master')
@section('content')
@section('title')
@lang('employee.Bulk Upload')
@endsection

	<style>
		.appendBtnColor{
			color: #fff;
			font-weight: 700;
		}
	</style>

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor">
						<a href="{{ url('dashboard') }}">
							<i class="fa fa-home"></i>
							@lang('dashboard.dashboard')
						</a>
					</li>
					<li>
						@yield('title')
					</li>
				</ol>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<a href="{{route('employee.index')}}" 
				   class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">
				   <i class="fa fa-list-ul" aria-hidden="true"></i>
				   @lang('employee.view_employee')
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading">
						<i class="mdi mdi-clipboard-text fa-fw"></i>
						@yield('title')
					</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if($errors->any())
								<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" 
											class="close" 
											data-dismiss="alert" 
											aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									@foreach($errors->all() as $error)
										<strong>{!! $error !!}</strong><br>
									@endforeach
								</div>
							@endif
							@if(session()->has('success'))
								<div class="alert alert-success alert-dismissable">
									<button type="button"
											class="close" 
											data-dismiss="alert" 
											aria-hidden="true">×</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;
									<strong>
										{{ session()->get('success') }}
									</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
							{{ Form::open(array('route' => 'employee.store.bulk','enctype'=>'multipart/form-data','id'=>'employeeForm')) }}
								<div class="form-body">
									<h3 class="box-title">@lang('employee.employee_account') </h3>
									<hr>
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label for="exampleInput">
													@lang('employee.CSV file')
													<a target="_blank" href="{{ url('https://docs.google.com/spreadsheets/d/13bV6i1qn-uba8EIHkX9ZpnuzU8jHD1-K/edit?usp=sharing&ouid=112721467916792197418&rtpof=true&sd=true') }}" >
														View Sample
													</a>
												</label>
												<input type="file" 
													   class="form-control" 
													   name="file" 
													   id="file"
													   accept=".csv"
													   placeholder="@lang('employee.CSV file')">
											</div>
											<div class="form-group">
												<button type="submit" 
														class="btn btn-info btn_style">
													<i class="fa fa-check"></i>
													@lang('employee.Upload')
												</button>
											</div>
										</div>

										<div class="col-md-9">
											<div class="table-responsive">
												<label class="text-center">Field Requirements</label>
												<table class="table table-striped">
													<tr>
														<th>Field Name</th>
														<th>Required</th>
														<th>Description</th>
														<th>Defaults</th>
													</tr>
													<!-- Employee's personal information -->
													<tr>
														<td>Employee number</td>
														<td>No</td>
														<td>Employee number assigned number by the company</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>First name<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's first name</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Middle name<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's middle name</td>
														<td>Blank</td>
													</tr>
													<tr>
														<td>Last name<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's last name</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Suffix</td>
														<td>No</td>
														<td>Employee's suffix</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Birthdate<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's birthdate. Format must be in: <label>YYYY/MM/DD</label></td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Gender<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's gender</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Civil status<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's civil status</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Mobile number</td>
														<td>No</td>
														<td>Employee's mobile number</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Email address</td>
														<td>No</td>
														<td>Employee's email address</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Address</td>
														<td>No</td>
														<td>Employee's local address</td>
														<td>N/A</td>
													</tr>
													<!-- Employee's company status -->
													<tr>
														<td>Employment status<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's current employment status</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Date hired<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's hiring date if employee. Format must be in: <label>YYYY/MM/DD</label></td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Role<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's designation / position role</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Position<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's position at the company. Note: position values can be found on the Employee Management: Designation</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Organizational unit<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's current department / organizational unit. Its values can be found on Employee Management: Department</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Department branch<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's department branch / organizational unit branch</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Basic salary<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's basic salary</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Date of leaving</td>
														<td>No</td>
														<td>Employee's date of resignation. Format must be in: <label>YYYY/MM/DD</label></td>
														<td>N/A</td>
													</tr>
													<tr>
														<td>Date of clearance</td>
														<td>No</td>
														<td>Employee's date of clearance of all responsibility before leaving the company. Format must be in: <label>YYYY/MM/DD</label></td>
														<td>N/A</td>
													</tr>
													<!-- Employee's Credentials -->
													<tr>
														<td>Username</td>
														<td>No</td>
														<td>Chosen user name for the employee</td>
														<td>If none, last name and first name would be chosen temporarily</td>
													</tr>
													<tr>
														<td>Password</td>
														<td>No</td>
														<td>Designated password</td>
														<td>Password value would be the same as the one on the default username</td>
													</tr>
													<tr>
														<td>Fingerprint id<span class="text-danger">*</span></td>
														<td>Yes</td>
														<td>Employee's unique fingerprint number</td>
														<td>Defaults to employee id</td>
													</tr>
													<!-- Others -->
													<tr>
														<td>Deductions</td>
														<td>No</td>
														<td>List of deductions. Separated by a comma. Example: Philhealth,SSS</td>
														<td></td>
													</tr>
													<tr>
														<td>Allowances</td>
														<td>No</td>
														<td>List of allowances. Separated by a comma. Example: De minimis,Allowance2,</td>
														<td></td>
													</tr>
													<tr>
														<td>Work shift</td>
														<td>No</td>
														<td>Assigned workshift</td>
														<td>Defaults to Flex shift</td>
													</tr>
													<tr>
														<td>Supervisor</td>
														<td>No</td>
														<td>The assigned supervisor of the employee. Value must be employee number</td>
														<td></td>
													</tr>
												</table>
											</div>
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

@endsection
