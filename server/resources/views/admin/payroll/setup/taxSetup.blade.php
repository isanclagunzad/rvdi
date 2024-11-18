@extends('admin.master')
@section('content')
@section('title')
@lang('payroll_setup.tax_rule_setup')
@endsection
<style>
	.select2 {
		width: 100% !important;
	}
</style>

<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			<ol class="breadcrumb">
				<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
				<li>@yield('title')</li>
			</ol>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @lang('payroll_setup.rate_of_income_tax')</div>
				<div class="panel-wrapper collapse in" aria-expanded="true">
					<div class="panel-body">
						@if(session()->has('success'))
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
						</div>
						@endif
						@if(session()->has('error'))
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
						</div>
						@endif
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="tr_header">
										<th>@lang('common.serial')</th>
										<th>@lang('payroll_setup.income_min')</th>
										<th>@lang('payroll_setup.income_max')</th>
										<th>@lang('payroll_setup.base_tax_amount')</th>
										<th>@lang('payroll_setup.marginal_tax_rate') %</th>
										<th>@lang('common.update')</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="5"><b>@lang('payroll_setup.tax_rules') (@lang('payroll_setup.male'))</b></td>
									</tr>

									<input type="hidden" name="_token" value="{{ csrf_token() }}">

									@foreach($maleTaxes as $key => $maleTax)
									<tr>
										<td>
											@php
											if($key == 0){
											echo __('payroll_setup.first');
											}
											else{
											echo __('payroll_setup.next');
											}
											@endphp
										</td>
										<td>
											<input type="text" class="form-control min_income_bracket male" name="min_income" value="{{$maleTax->min_income_bracket}}">
										</td>
										<td>
											<input type="hidden" name="tax_rule_id" class="form-control tax_rule_id male" value="{{ $maleTax->tax_rule_id }}">
											<input type="hidden" name="gender" class="form-control gender male" value="{{ $maleTax->gender }}">

											@if($maleTax->max_income_bracket < 0)
												<input type="text"
												class="form-control max_income_bracket male"
												name="max_income_bracket"
												value="{{ __('payroll_setup.remaining_total_income') }}">
												@else
												<input type="number"
													class="form-control max_income_bracket male"
													name="max_income_bracket"
													value="{{ $maleTax->max_income_bracket }}">
												@endif
										</td>

										<td>
											@if($maleTax->base_amount < 0)
												<input type="text"
												class="form-control base_amount male"
												name="base_amount"
												value="{{ __('payroll_setup.remaining_taxable_amount') }}">
												@else
												<input type="number"
													class="form-control base_amount male"
													name="base_amount"
													value="{{ $maleTax->base_amount }}">
												@endif
										</td>
										<td>
											<input type="number" step="0.01" value="{{ $maleTax->tax }}" class="form-control tax male" name="tax">
										</td>
										<td style="width:100px;">
											<button type="button" class="btn btn-sm btn-success update-tax male">
												@lang('common.update')
											</button>
										</td>
									</tr>
									@endforeach

									<tr>
										<td colspan="5"><b>@lang('payroll_setup.tax_rules') (@lang('payroll_setup.female'))</b></td>
									</tr>

									@foreach($femaleTaxes as $key => $femaleTax)
									<tr>
										<td>
											@php
											if($key == 0){
											echo __('payroll_setup.first');
											}
											else{
											echo __('payroll_setup.next');
											}
											@endphp
										</td>
										<td>
											<input type="text" class="form-control female min_income_bracket" name="min_income" value="{{$femaleTax->min_income_bracket}}">
										</td>
										<td>
											<input type="hidden" name="tax_rule_id" class="form-control tax_rule_id female" value="{{ $femaleTax->tax_rule_id }}">
											<input type="hidden" name="gender" class="form-control gender female" value="{{ $femaleTax->gender }}">

											@if($femaleTax->max_income_bracket < 0)
												<input type="text"
												class="form-control max_income_bracket female"
												name="max_income_bracket"
												value="{{ __('payroll_setup.remaining_total_income') }}">
												@else
												<input type="number"
													class="form-control max_income_bracket female"
													name="max_income_bracket"
													value="{{ $femaleTax->max_income_bracket }}">
												@endif
										</td>
										<td>
											@if($femaleTax->base_amount < 0)
												<input type="text"
												class="form-control base_amount female"
												name="base_amount"
												value="{{ __('payroll_setup.remaining_taxable_amount') }}">
												@else
												<input type="number"
													class="form-control base_amount female"
													name="base_amount"
													value="{{ $femaleTax->base_amount }}">
												@endif
										</td>
										<td>
											<input type="number" step="0.01" value="{{ $femaleTax->tax }}" class="form-control tax female" name="tax">
										</td>
										<td style="width:100px;">
											<button type="button" class="btn btn-sm btn-success update-tax female">
												@lang('common.update')
											</button>
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

@section('page_scripts')
<script type="text/javascript">
	jQuery(function() {

		/*$(document).on("keyup",".amount,.percentage_of_tax  ",function(){
		    var amount 				= $(this).parents('tr').find('.amount').val();
		    var percentage_of_tax   = $(this).parents('tr').find('.percentage_of_tax').val();
		    var taxableAmount = 0;
		    taxableAmount = (amount * percentage_of_tax) /100;
		    $(this).parents('tr').find('.amount_of_tax').val(taxableAmount);
		});*/


		$("body").on("click", ".update-tax  ", function() {
			const tax_rule_id = $(this).parents('tr').find('.tax_rule_id').val();
			const min_income_bracket = $(this).parents('tr').find('.min_income_bracket').val();
			const max_income_bracket = $(this).parents('tr').find('.max_income_bracket').val();
			const base_amount = $(this).parents('tr').find('.base_amount').val();
			const tax = $(this).parents('tr').find('.tax').val();
			const gender = $(this).parents('tr').find('.gender').val();
			const action = "{{ URL::to('taxSetup/updateTaxRule') }}";

			$.ajax({
				type: "post",
				url: action,
				data: {
					tax_rule_id,
					min_income_bracket,
					max_income_bracket,
					base_amount,
					tax,
					'_token': $('input[name=_token]').val()
				},
				success: function(data, textStatus, responseDetails) {
					console.log(data);
					if (textStatus == 'success') {
						$.toast({
							heading: 'Success!',
							text: data.message,
							position: 'top-right',
							loaderBg: '#ff6849',
							icon: 'success',
							hideAfter: 3000,
							stack: 6
						});
					} else {
						$.toast({
							heading: 'Error!',
							text: data.message,
							position: 'top-right',
							loaderBg: '#ff6849',
							icon: 'error',
							hideAfter: 3000,
							stack: 6
						});
					}

				}
			});
		})
	});
</script>
@endsection