@extends('admin.master')
@section('content')
    @section('title')
        @lang('attendance.daily_attendance')
    @endsection
    <script>
        jQuery(function () {
            $("#dailyAttendanceReport").validate();
        });

    </script>
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <ol class="breadcrumb">
                    <li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i
                                    class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
                    <li>@yield('title')</li>
                </ol>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><i class="mdi mdi-table fa-fw"></i>@yield('title')</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body">
                            <div id="searchBox">
                                <div class="col-md-1"></div>
                                {{ Form::open(array('route' => 'dailyAttendance.dailyAttendance','id'=>'dailyAttendanceReport','class'=>'form-horizontal', 'method'=> 'GET')) }}
                                    <div id="react-hr"/>
                                {{ Form::close() }}
                            </div>
                            <hr>

                            <div id="react-daily-attendance-table" class="table-responsive"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var results = "{{ json_encode(isset($results) ? $results : []) }}";
        var csrfToken = "{{csrf_token()}}"
        console.log({csrfToken})
    </script>
@endsection
