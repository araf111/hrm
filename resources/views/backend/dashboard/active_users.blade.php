@extends('backend.layouts.app')
@section('content')
<style>
    .overflow_text_column {
        width: 300px;
        overflow:hidden; 
        white-space:nowrap; 
        text-overflow: ellipsis;
    }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Active Users')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Active Users')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>@lang('Active Users for last 24 hours')</h5>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#active_users_tab" onClick="load_data('active_users_table')">@lang('Active in 24 Hours')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#login_activity" onClick="load_data('login_activity_table')">@lang('All Login Activities')</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane container active" id="active_users_tab">
                        <table id="active_users_table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="min-width:20%;">@lang('Name')</th>
                                    <th style="max-width:20%;">@lang('Email')</th>
                                    <th>@lang('IP')</th>
                                    <th>@lang('Login Time')</th>
                                    {{-- <th style="width:30%">@lang('User Agent')</th> --}}
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane container" id="login_activity">
                        <table id="login_activity_table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="min-width:20%;">@lang('Name')</th>
                                    <th style="max-width:20%;">@lang('Email')</th>
                                    <th>@lang('IP')</th>
                                    <th>@lang('Login Time')</th>
                                    <th>@lang('Logout Time')</th>
                                    <th>@lang('Duration')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        load_data('active_users_table');
    });

    function load_data(table_id) {
        var url_path = "{{ url('get-active-users') }}";
        if(table_id=='login_activity_table'){
            url_path = "{{ url('get-login-activity') }}";
        }
        if(table_id=='login_activity_table'){
            var table = $('#'+table_id).DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                filter: true,
                ajax: {
                    url: url_path,
                    dataType: "json",
                    type: "GET",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                },
                
                columns: [{
                        data: 'name',
                        name: 'name'
                        
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address'
                    },
                    {
                        data: 'login_time',
                        name: 'login_time'
                    },
                    {
                        data: 'logout_time',
                        name: 'logout_time'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        } 
        else{
            var table = $('#'+table_id).DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                filter: true,
                ajax: {
                    url: url_path,
                    dataType: "json",
                    type: "GET",
                    data: {
                        _token: "{{csrf_token()}}"
                    }
                },
                
                columns: [{
                        data: 'name',
                        name: 'name'
                        
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address'
                    },
                    {
                        data: 'login_time',
                        name: 'login_time'
                    },
                    
                ]
            });
        }
    }

    function userLogDetails(id=null){
        $("#log_user_title").html($("#user_name_"+id).val());
        var user_id;
        if(id==null){
            user_id = $("#user_id").val();
        }
        else{
            user_id = id;
            $("#user_id").val(id);
        }

        $("#logModal").modal('show');
        var table = $('#user_log_table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            filter: true,
            ajax: {
                url: "{{ url('user-log-details') }}",
                dataType: "json",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    user_id:user_id,
                    date:nanoLangTranslate($('#reportrange').text().trim(),'en')
                }
            },
            
            columns: [
                /* {
                    data: 'name',
                    name: 'name'
                    
                },
                {
                    data: 'email',
                    name: 'email'
                }, */
                {
                    data: 'ip_address',
                    name: 'ip_address'
                },
                {
                    data: 'url',
                    name: 'url',
                    className: "overflow_text_column"
                },
                {
                    data: 'time',
                    name: 'time'
                },
            ]
        });
    }

    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            @if(session()->get('language')=='bn')
            $('#reportrange span').html(nanoLangTranslate(start.format('D-MM-YYYY')) + ' ~ ' + nanoLangTranslate(end.format('D-MM-YYYY')));
            @else
            $('#reportrange span').html(start.format('D-MM-YYYY') + ' ~ ' + end.format('D-MM-YYYY'));
            @endif
        }

        $('#reportrange').daterangepicker({
            singleDatePicker: false,
            locale: daterange_locale,
            ranges: daterange_ranges
        }, cb);
        cb(start, end);
    });
</script>

<div class="modal" id="logModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="log_user_title"> </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-3">
                        <input type="hidden" id="user_id">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-info" onclick="userLogDetails()">@lang('Show')</button>
                    </div>
                </div>
                <div class="table-responsive" style="max-height:85vh;">
                <table id="user_log_table" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>@lang('IP')</th>
                            <th style="max-width: 25% !important">@lang('URL')</th>
                            <th>@lang('Time')</th>
                        </tr>
                    </thead>
                </table>  
                </div>      
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">@lang('Close')</button>
            </div>

        </div>
    </div>
</div>

@endsection