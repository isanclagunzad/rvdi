@extends('admin.master')
@section('content')
	@section('title')
		@lang('employee.Bulk Upload')
	@endsection

	@php
		$loggedSessionData = json_encode(session()->get('logged_session_data'));
	@endphp

	<style>
		.appendBtnColor {
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
											aria-hidden="true">×
									</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;
									<strong>
										{{ session()->get('success') }}
									</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
									</button>
									<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif

							<div id="react-hr"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		var loggedSessionData = "{{ $loggedSessionData }}";
	</script>

@endsection
@section('page_scripts')

@endsection
