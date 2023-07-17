@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('User Management') </h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('User Management')</li>
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
                    <h4 class="card-title w-100">
                        @if (session()->get('language') == 'bn')
                            {{ isset($user) ? $user->name_bn : '' }}
                        @else
                            {{ isset($user) ? $user->name : '' }}
                        @endif
                        <a href="{{ route('admin.user-management.user-info.list') }}" class="btn btn-info float-right"><i
                                class="fa fa-list mr-2"></i>
                            @lang('User List')
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card pt-5">
                <div class="multisteps-form">
                    <div class="row ">
                        <div class="col-12 text-center">
                            <center>
                                {!! $user->photo !!}
                            </center>

                        </div>
                    </div>
                    <div class="clearfix">
                        &nbsp;
                    </div>

                    <div class="row">
                        <div class="col-12 m-auto">
                            <div class="card card-success mx-3">
                                <div class="card-header bg-success p-2">
                                    <h5 class="m-0">@lang('Personal Info')</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr>
                                                <th width="39%">@lang('1'). @lang('ID')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ digitDatelang($user->profileID) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('2'). @lang('Name (Bangla)')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ $user->name_bn }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('3'). @lang('Name (English)')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ $user->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('4'). @lang('Email')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ $user->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('5'). @lang('Designation')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ $user->designation }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('6'). @lang('Mobile No.')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ $user->mobile_no }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('7'). @lang('Department')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    @if (session()->get('language') == 'bn')
                                                        {{ $user->department_name_bn }}
                                                    @else
                                                        {{ $user->department_name_en }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('8'). @lang('User Type')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    {{ Lang::get($user->usertype) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="39%">@lang('9'). @lang('Roll Permission')</th>
                                                <td width="1%"><strong>:</strong></td>
                                                <td width="60%">
                                                    @foreach ($roles as $role)

                                                        @if (in_array($role->id, array_column($role_array, 'role_id'))) 
                                                        <span class="badge badge-success">
                                                            @if (session()->get('language') == 'bn')
                                                                {{ $role->name_bn }}
                                                            @else
                                                                {{ $role->name }}
                                                            @endif
                                                        </span>
                                                        @endif

                                                    @endforeach
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
