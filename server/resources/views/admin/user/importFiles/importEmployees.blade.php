@extends('admin.master')
@section('content')
    @section('title')
        @lang('common.import_employees')
    @endsection

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
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i> @lang('common.import_employees')</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            {{ Form::open(array('route' => 'import.employees', 'id'=>'importEmployeeForm','class'=>'form-horizontal', 'method' => 'POST', 'files' => 'true')) }}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-offset-2 col-md-6">
                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                @foreach($errors->all() as $error)
                                                    <strong>{!! $error !!}</strong><br>
                                                @endforeach
                                            </div>
                                        @endif
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
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">@lang('notice.attach_file')<span class="validateRq">*</span></label>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control" name="file" id="address" placeholder="@lang('common.import_employees')" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-offset-4 col-md-8">
                                                <button type="submit" class="btn btn-info btn_style"><i class="fa fa-pencil"></i> @lang('common.update') </button>
                                            </div>
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