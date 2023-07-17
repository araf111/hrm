    <style>
        .navbar-nav {
            display: inherit !important;
        }

    </style>
    <div class="col-sm-12">
        <div class="card pt-5">
            <div class="multisteps-form">
                <div class="row ">
                    <div class="col-12 text-center">
                        <center>
                            <img src="{{ asset('public/backend/user') }}/{{$profileData->photo}}" class="ml-2 img-circle elevation-2" alt="User Image" style="width: 100px; height:100px;">
                           
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
                                            {{ digitDatelang($profileData->profileID) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('2'). @lang('Name (Bangla)')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            {{ $profileData->name_bn }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('3'). @lang('Name (English)')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            {{ $profileData->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('4'). @lang('Email')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            {{ $profileData->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('5'). @lang('Designation')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            {{ $profileData->designation }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('6'). @lang('Mobile No.')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            {{ $profileData->mobile_no }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('7'). @lang('Department')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            @if(session()->get('language')=='bn')
                                                {{ $profileData->department_name_bn }}
                                            @else
                                            {{ $profileData->department_name_en }}  
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="39%">@lang('8'). @lang('User Type')</th>
                                        <td width="1%"><strong>:</strong></td>
                                        <td width="60%">
                                            {{ $profileData->usertype }}
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
