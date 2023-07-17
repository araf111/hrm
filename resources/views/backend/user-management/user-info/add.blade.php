@extends('backend.layouts.app')
@section('content')
    <style>
        .load-data .nav-pills .nav-link {
            background: #ddd;
            margin: 0px 1px 0px 1px;
            border-radius: 0;
            font-family: 'nikosh', Poppins, sans-serif;
            transition: 0.5s;
        }

        .load-data .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background: #33a264;
        }

        .load-data .nav-pills .nav-link:not(.active):hover {
            background: #33a264;
            color: #fff;
        }

        .select2-container {
            padding-right: 0 !important;
        }

        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

    </style>
    @if (session()->get('language') == 'bn')
        <style>
            .custom-file-input:lang(en)~.custom-file-label::after {
                content: "ব্রাউজ";
            }

        </style>
    @else
        <style>
            .custom-file-input:lang(en)~.custom-file-label::after {
                content: "Browse";
            }

        </style>
    @endif
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
            <div class="myloader d-none"></div>
            <div class="card">
                <div class="card-header">

                    <h4 class="card-title w-100">
                        {{-- @if (session()->get('language') == 'bn')
                            {{ isset($editData) ? $editData->name_bn : __('User Information') }}
                        @else
                            {{ isset($editData) ? $editData->name : __('User Information') }}
                        @endif --}}
                        <a href="{{ route('admin.user-management.user-info.list') }}" class="btn btn-info float-right"><i
                                class="fa fa-list mr-2"></i>
                            @lang('User List')
                        </a>
                    </h4>
                </div>
                <div class="card-body overflow-hidden">
                    <div class="row ">
                        <div class="col-12 text-center">
                            <center>
                                @if (isset($editData->photo) && $editData->photo != '')
                                    <img src="{{ asset('public/backend/user')}}/{{$editData->photo}}" class="ml-2 img-circle elevation-2" alt="" style="width: 100px;">
                                   {{--  @if($editData->usertype=='mp')
                                        {!! arrayToimage($editData->photo) !!}
                                    @else 
                                        <img src="{{ asset('public/backend/user')}}/{{$editData->photo}}" class="ml-2 img-circle elevation-2" alt="" style="width: 100px;">
                                    @endif --}}
                                @endif
                            </center>
                        </div>
                    </div>
                    <div class="clearfix">
                        &nbsp;
                    </div>
                    <div class="row ">
                        <div class="col-12">
                            <form>
                                @csrf
                                @if (isset($editData))
                                    @method('PUT')
                                @endif
                                <div class="form-row mb-3">
                                    <div class="form-group col-6 m-auto">
                                        <div class="card card-danger">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('Search for Information')</h3>
                                            </div>

                                            <div class="load-data">
                                                <div class="card2">
                                                    <!-- /.card-header -->
                                                    <div class="card-header p-3">
                                                        <ul class="nav nav-pills" style="justify-content: center;">
                                                            <li class="nav-item"><a class="nav-link active" href="#mp"
                                                                    data-toggle="tab">@lang('MP')</a></li>
                                                            <li class="nav-item"><a class="nav-link" href="#employee"
                                                                    data-toggle="tab"
                                                                    onclick="getProfileInfo('employee','dropdown')">@lang('Employee')</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <div class="card-body">
                                                        <div class="tab-content">
                                                            <div class="active tab-pane mt-0" id="mp">
                                                                <div class="row">
                                                                    <div class="form-group col-sm-6">
                                                                        <label for=""
                                                                            class="control-label ">@lang('Parliament')</label>
                                                                        <select name="parliamentId" id="parliamentId"
                                                                            class='form-control select2'>
                                                                            <option value="">@lang('Select Parliament')
                                                                            </option>
                                                                            @foreach ($parliaments as $parliament)
                                                                                <option
                                                                                    value="{{ $parliament->parliament_number }}"
                                                                                    @if (isset($editData) && $editData->parliamentId == $parliament->parliament_number) {{ 'selected' }} @endif>
                                                                                    {{ digitDatelang($parliament->parliament_number) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <label for="" class="control-label ">
                                                                            @lang('ID No.')
                                                                        </label>
                                                                        <select name="empId" id="empId"
                                                                            class='form-control select2'>

                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-sm-6">
                                                                        <button type="button" name="load_profile"
                                                                            class="btn btn-secondary btn-sm mt-1"
                                                                            onclick="load_data('employee_id')">
                                                                            @lang('Search') </button>
                                                                        <button type="button" name="load_profile"
                                                                            class="btn btn-secondary btn-sm mt-1 d-none"
                                                                            onclick="test_data('employee_id')"> @lang('TEST
                                                                            Search') </button>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- /.tab-pane -->

                                                            <div class="tab-pane mt-0" id="employee">
                                                                <div class="row">
                                                                    <div class="form-group col-12">
                                                                        <label for="" class="control-label ">
                                                                            @lang('ID No.')
                                                                        </label><br />
                                                                        <select name="selected_employee"
                                                                            id="selected_employee"
                                                                            class='form-control select2'>

                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-12">
                                                                        <button type="button" name="load_profile"
                                                                            class="btn btn-secondary btn-sm mt-1"
                                                                            onclick="load_data('non_mp')"> @lang('Search')
                                                                        </button>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.tab-pane -->
                                                        </div>
                                                        <!-- /.tab-content -->
                                                    </div><!-- /.card-body -->
                                                </div><!-- /.card -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <form method="post"
                                action="{{ isset($editData) ? route('admin.user-management.user-info.update', $editData->id) : route('admin.user-management.user-info.store') }}"
                                enctype="multipart/form-data" id="myForm">
                                @csrf
                                <div class="form-row mb-5">
                                    <div class="form-group col-12">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">@lang('User Information')</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">
                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('ID') </label>
                                                        <input type="text" name="profileID" id="profileID" readonly
                                                            value="{{ digitDateLang(@$editData->profileID) }}"
                                                            class="form-control form-control-sm @error('profileID') is-invalid @enderror"
                                                            >
                                                        @error('profileID')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Name (Bangla)') <span
                                                                style="color: red">*</span></label>
                                                        <input type="text" name="name_bn" id="name_bn"
                                                            value="{{ @$editData->name_bn }}"
                                                            class="form-control form-control-sm @error('name_bn') is-invalid @enderror"
                                                            placeholder="@lang('Enter Name in Bangla')">
                                                        @error('name_bn')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Name (English)') <span
                                                                style="color: red">*</span></label>
                                                        <input type="text" name="name" id="name"
                                                            value="{{ @$editData->name }}"
                                                            class="form-control form-control-sm @error('name') is-invalid @enderror"
                                                            placeholder="@lang('Enter Name in English')">
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Designation') </label>
                                                        <input type="text" name="designation" id="designation"
                                                            value="{{ @$editData->designation }}"
                                                            class="form-control form-control-sm @error('designation') is-invalid @enderror"
                                                            placeholder="@lang('Enter Designation')">
                                                        @error('designation')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Email') <span
                                                                style="color: red">*</span></label>
                                                        <input type="email" name="email" id="email"
                                                            value="{{ @$editData->email }}"
                                                            class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                            placeholder="@lang('Enter Email')">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Mobile No.')</label>
                                                                <div class="input-group" data-target-input="nearest">
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text" style="padding: 4px;">
                                                                            <span style="border-bottom-right-radius: 0; border-top-right-radius: 0;">+88</span>
                                                                        </div>
                                                                    </div>
                                                        <input type="number" min="0" inputmode="numeric" pattern="[0-9]*" name="mobile_no" id="mobile_no"
                                                            value="{{ @$editData->mobile_no }}"
                                                            class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                                            placeholder="@lang('Enter Mobile No.')">
                                                                </div>
                                                            <span id="mobileMsg" class="text-danger"></span>
                                                        @error('mobile')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Department') </label>
                                                        <select name="department_id" id="department_id"
                                                            class="form-control form-control-sm select2">
                                                            <option value="">@lang('Select Department')</option>
                                                            @foreach ($department_list as $d)
                                                                <option value="{{ $d->id }}" @if (isset($editData) && $d->id == $editData->department_id) {{ 'selected' }} @endif>
                                                                    @if (session()->get('language') == 'bn')
                                                                        {{ $d->name_bn }}
                                                                    @else
                                                                        {{ $d->name }}
                                                                    @endif
                                                            @endforeach
                                                            </option>

                                                        </select>
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('User Type') <span
                                                                style="color: red">*</span></label>
                                                        <select name="usertype" id="usertype" class="form-control  select2">
                                                            <option value="">@lang('Select User Type')</option>
                                                            @foreach ($user_type_list as $t)
                                                                <option value="{{ $t['id'] }}" @if (isset($editData) && $t['id'] == $editData->usertype) {{ 'selected' }} @endif>
                                                                    {{ $t['name'] }}
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-sm-4">
                                                        <label class="control-label">@lang('Roll Permission') </label>
                                                        <select name="user_role[]" id="user_role"
                                                            class="form-control form-control-sm select2" multiple>

                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}"
                                                                    {{ @$role_array ? (in_array($role->id, array_column($role_array, 'role_id')) ? 'selected' : '') : '' }}>
                                                                    @if (session()->get('language') == 'bn')
                                                                        {{ $role->name_bn }}
                                                                    @else
                                                                        {{ $role->name }}
                                                                    @endif

                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group col-sm-6">
                                                        <label class="control-label">@lang('Password') </label>
                                                        <input type="password" name="password" id="password" value=""
                                                            class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                            placeholder="@lang('Enter Password')" autocomplete="off">
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label class="control-label">@lang('Confirm Password') </label>
                                                        <input type="password" name="confirm_password" value=""
                                                            class="form-control form-control-sm @error('confirm_password') is-invalid @enderror"
                                                            placeholder="@lang('Enter Confirm Password')"
                                                            autocomplete="off">
                                                        @error('confirm_password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-sm-12 ">
                                                        <h6 style="font-size: 14px; font-weight: 600;">@lang('Photo') <br><small>(jpg, jpeg, png, gif)</small></h6>
                                                        {{-- <div class="custom-file">
                                                            <input type="file" name="photo[]" multiple
                                                                class="custom-file-input" id="customFile">
                                                            <label class="custom-file-label" for="customFile">
                                                                @lang('Choose Photo')
                                                            </label>
                                                        </div> --}}
                                                        <div class="file p-0">
                                                            <button type="button" class="btn btn-sm btn-info"
                                                                onclick="document.getElementById('photo').click()">
                                                                @lang('Choose Files')</button>
                                                            <input type="file" class="form-control attachment_upload pl-1"
                                                                name="photo" id="photo" style="display:none">
                                                                <span class="error_msg text-danger" id="error_photo"></span>
                                                                <span id="photo_name"></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-sm-12 mt-sm-auto text-right">
                                                        <button type="submit" class="btn btn-sm btn-info"><i
                                                                class="fas fa-save"></i>
                                                            {{ isset($editData) ? __('Update') : __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    var user_type = '';
    var fileuploadinit = function(){
        $('#photo').change(function(){
            var pathwithfilename = $('#photo').val();
            var filename = pathwithfilename.substring(12);
            $('#photo_name').html(filename).css({
                'display':'inline-block'
            });
        });
    };

        $(document).ready(function() {
            $('#myForm').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "user_role[]") {
                        error.insertAfter(element.next());
                    } else {
                        error.insertAfter(element);
                    }
                },
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    'name_bn': {
                        required: true,
                    },
                    'name': {
                        required: true,
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'usertype': {
                        required: true
                    },
                    @php if(!@$editData){ @endphp 'password': {
                        required: true,
                        minlength: 5
                    },
                    'confirm_password': {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },
                    @php } @endphp
                },
                messages: {
                    name_bn: {
                        required: "@lang('This field is required.')"
                    },
                    name: {
                        required: "@lang('This field is required.')"
                    },
                    email: {
                        required: "@lang('This field is required.')"
                    },
                    usertype: {
                        required: "@lang('This field is required.')"
                    },
                    password: {
                        required: "@lang('This field is required.')",
                        minlength: jQuery.validator.format("At least {0} characters required!")
                    },
                    confirm_password: {
                        required: "@lang('This field is required.')",
                        minlength: jQuery.validator.format("At least {0} characters required!")
                    },
                }

            });

            fileuploadinit();
        });

        $(document).ready(function() {
            $("#parliamentId").on('change', function() {
                getProfileInfo('mp', 'dropdown');
            });
        });

        function getProfileInfo(type, list) {
            var list_type = (type == 'mp') ? $("#parliamentId").val() : '';
            user_type = type;
            $.ajax({
                url: "{{ url('/user-management/user-info/profilelist') }}/" + type,
                type: "GET",
                data: {
                    list: list,
                    parliament_number: list_type
                },

                success: function(response) {
                    if (type == 'mp') {
                        $('#empId').html(response);
                    } else {
                        $('#selected_employee').html(response);
                    }
                    //DOM elements
                    $(".select2").select2({
                        //tags:true
                    });
                },
                error: function(res) {
                    //$('#profile_container').html('@lang("No Data Found")');
                }
            });
        }

        function load_data(type) {
            my_loader('start');
            if (type == 'employee_id') {
                $.ajax({
                    url: "{{ url('/profile-activities/profile_details/info') }}",
                    type: "GET",
                    data: {
                        id: $("#empId").val()
                    },
                    success: function(response) {
                        my_loader('stop');
                        response = JSON.parse(response);
                        if (response.status) {
                            //if (type == 'employee_id') {
                            console.log(response);
                            var basicInfo = response.data;
                            $("#profileID").val(basicInfo.profileID);
                            $("#name_bn").val(basicInfo.nameBng);
                            $("#name").val(basicInfo.nameEng);
                            if (basicInfo.email != '') {
                                $("#email").val(basicInfo.email);
                            }
                            $("#mobile_no").val(basicInfo.personalMobile);
                            $("#usertype").val('mp');
                            $("#usertype").trigger('change');
                            my_loader('stop');
                            //}

                        } else {
                            //console.log($("#selected_employee").val())
                            //$("#profileID").val($("#selected_employee").val());
                            
                            Swal.fire('No Data Found', '', 'error');
                            my_loader('stop');
                        }
                    },
                    error: function(res) {
                        my_loader('stop');
                    }
                });
            } else if (type == 'non_mp') {
                request_data = {
                    _token: "{{ csrf_token() }}",
                    profile_by: type,
                    empId: $("#selected_employee").val()
                };
                $.ajax({
                    url: "{{ url('/profile-activities/loadprofile') }}",
                    type: "POST",
                    data: request_data,
                    success: function(response) {
                        my_loader('stop');
                        response = JSON.parse(response);
                        if (response.responseCode == 200) {
                            //if (type == 'employee_id') {
                            console.log(response);
                            var basicInfo = response.payload.employeeBasicInformationModel;
                            $("#profileID").val(basicInfo.profileID);
                            $("#name_bn").val(basicInfo.nameBng);
                            $("#name").val(basicInfo.nameEng);
                            if (basicInfo.email != '') {
                                $("#email").val(basicInfo.email);
                            }
                            $("#mobile_no").val(basicInfo.personalMobile);
                            $("#usertype").val('staff');
                            $("#usertype").trigger('change');
                            my_loader('stop');
                            //}

                        } else {
                            $("#profileID").val($("#selected_employee").val());
                            //Swal.fire('No Data Found', '', 'error');
                            my_loader('stop');
                        }
                    },
                    error: function(res) {
                        my_loader('stop');
                    }
                });
            }


        }

        $(document).ready(function(e) {

            $('#mobile_no').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#mobileMsg').text('@lang("The Mobile Number Should be 11 Digit")'); 
                }
                if (val.length >= 10) {
                    $('#mobileMsg').text(''); 
                }
                if( val.length>10 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $('#myForm').submit(function(e) {
                e.preventDefault();
                if($('#name_bn').val()=='' || $('#name').val()=='' || $('#email').val()=='' || $('#usertype').val()==''){
                    return false;
                }
                my_loader('start');
                var formData = new FormData(this);
                if($("#profileID").val()==''){
                    if (user_type == 'mp') {
                        $("#profileID").val($('#empId').val());
                    } else {
                        $("#profileID").val($('#selected_employee').val());
                    }
                }
                $.ajax({
                    type: 'POST',
                    url: $(this).attr("action"),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        res = JSON.parse(res);
                        if (res.status) {
                            Swal.fire(res.message, '', 'success').then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            });
                        } else {
                            if(res.message.photo!=undefined){
                                //Swal.fire(res.message.photo[0],'','warning');
                                $('#error_photo').append(res.message.photo[0]);
                            }
                            else{
                                Swal.fire(res.message, '', 'warning');
                            }
                        }
                        my_loader('stop');
                    },
                    error: function(data) {
                        my_loader('stop');
                        Swal.fire('@lang("Something wrong")', '', 'error');
                    }
                });

            });
        });
    </script>
@endsection
