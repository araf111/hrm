<style>
    .navbar-nav {
        display: inherit !important;
    }

    .error_msg {
        color: red;
    }

</style>

<div class="col-md-12">
    <div class="myloader d-none"></div>
    <div class="card">
        <div class="card-header d-none">

            <h4 class="card-title w-100">
                @if (session()->get('language') == 'bn')
                    {{ isset($editData) ? $editData->nameBng : __('Parliament Member Information') }}
                @else
                    {{ isset($editData) ? $editData->nameEng : __('Parliament Member Information') }}
                @endif
                <a href="{{ route('admin.profile-activities.v2profiles.index') }}" class="btn btn-info float-right"><i
                        class="fa fa-list mr-2"></i>
                    @lang('Parliament Member List')
                </a>
            </h4>
        </div>
        <div class="card-body overflow-hidden">

            <div class="row ">
                <div class="col-12 text-center">
                    <center>
                         @if (isset($editData->photo) && $editData->photo != '')
                            <img src="{{ asset('public/backend/user')}}/{{$editData->photo}}" class="ml-2 img-circle elevation-2" alt="" style="width: 100px;">
                                @endif
                    </center>
                </div>
            </div>
            <div class="clearfix">
                &nbsp;
            </div>


            <div class="multisteps-form">
                <!--form panels-->
                <div class="row">
                    <div class="col-12 m-auto">
                        <form method="post" action="#" enctype="multipart/form-data" id="myForm">
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
                                                    <label class="control-label">@lang('ID')</label>
                                                    <input type="text" name="profileID" id="profileID"
                                                        value="{{ @$editData->profileID }}"
                                                        class="form-control form-control-sm @error('profileID') is-invalid @enderror"
                                                        placeholder="@lang('Enter ID')">
                                                        
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
                                                    <span class="error_msg" id="error_name_bn"></span>
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
                                                    <span class="error_msg" id="error_name"></span>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="control-label">@lang('Designation')</label>
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
                                                    <span class="error_msg" id="error_email"></span>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="control-label">@lang('Mobile No.') </label>
                                                        <div class="input-group" data-target-input="nearest">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text" style="padding: 4px;">
                                                                    <span style="border-bottom-right-radius: 0; border-top-right-radius: 0;">+88</span>
                                                                </div>
                                                            </div>
                                                <input type="number" min="0" inputmode="numeric" pattern="[0-9]*" name="mobile_no" id="mobile_no"
                                                    value="{{ @$editData->mobile_no }}"
                                                    class="form-control form-control-sm @error('mobile') is-invalid @enderror"
                                                    placeholder="@lang('Enter Mobile No.')" autocomplete="off">
                                                        </div>
                                                    <span id="mobileMsg" class="text-danger"></span>
                                                @error('mobile')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="control-label">@lang('User Type') <span
                                                            style="color: red">*</span></label>
                                                    <select name="usertype" id="usertype" class="form-control  select2">
                                                        <option value="">@lang('Select User Type')</option>
                                                        @foreach ($user_type_list as $t)
                                                            <option value="{{ $t['id'] }}"
                                                                @if (isset($editData) && $t['id'] == $editData->usertype) {{ 'selected' }} @endif>
                                                                {{ $t['name'] }}
                                                        @endforeach
                                                    </select>
                                                    <span class="error_msg" id="error_usertype"></span>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label class="control-label">@lang('Department')</label>
                                                    <select name="department_id" id="department_id"
                                                        class="form-control form-control-sm select2">
                                                        <option value="">@lang('Select Department')</option>
                                                        @foreach ($department_list as $d)
                                                            <option value="{{ $d->id }}"
                                                                @if (isset($editData) && $d->id == $editData->department_id) {{ 'selected' }} @endif>
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
                                                    <label class="control-label">@lang('Roll Permission') <span
                                                            style="color: red">*</span></label>
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
                                                    <label class="control-label">@lang('Password') <span
                                                            style="color: red">*</span></label>
                                                    <input type="password" name="password" id="password" value=""
                                                        class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                        placeholder="@lang('Enter Password')" autocomplete="off">
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="control-label">@lang('Confirm Password') <span
                                                            style="color: red">*</span></label>
                                                    <input type="password" name="confirm_password" value=""
                                                        class="form-control form-control-sm @error('confirm_password') is-invalid @enderror"
                                                        placeholder="@lang('Enter Confirm Password')"
                                                        autocomplete="off">
                                                    @error('confirm_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <h6 style="font-size: 14px; font-weight: 600;">@lang('Photo') <br><small>(jpg, jpeg, png, gif)</small></h6>
                                                    <div class="custom-file">
                                                        <button type="button" class="btn btn-sm btn-info"
                                                        onclick="document.getElementById('photo').click()">
                                                        @lang('Choose Files')</button>
                                                    <input type="file" class="form-control attachment_upload pl-1"
                                                        name="photo" id="photo" accept=".jpg, .jpeg, .png, .gif" style="display:none">
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
<script>
     var fileuploadinit = function(){
        $('#photo').change(function(){
            var pathwithfilename = $('#photo').val();
            var filename = pathwithfilename.substring(12);
            $('#photo_name').html(filename).css({
                'display':'inline-block'
            });
        });
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    $('#myForm').submit(function(e) {
        e.preventDefault();
        my_loader('start');
        //resetFormControl(false);
        var formData = new FormData(this);
        //formData.append('profileID', "{{ $editData->profileID }}");
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.user-management.user-info.update', $editData->id) }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                data = JSON.parse(data);
                if (data.status) {
                    my_loader('stop');
                    Swal.fire({
                        text: '@lang("Data Updated Successfully")',
                        type: 'success'
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    var message = data.message;
                    $.each(message, function(key, value) {
                        $('#error_' + key).html('');
                        for (var i = 0; i < value.length; i++) {
                            $('#error_' + key).append(value[i]);
                        }
                    });

                    //resetFormControl(true);
                    my_loader('stop');
                }
            },
            error: function(data) {
                //Swal.fire('something went wrong', '', 'error');
                my_loader('stop');
            }
        });

    });


    $(document).ready(function(){
        resetFormControl();
        fileuploadinit();

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
    });

    function resetFormControl() {
        $("input").change(function() {
            $(this).siblings('.error_msg').empty();
        });
        $("select").change(function() {
            $(this).siblings('.error_msg').empty();
        });
        $("textarea").change(function() {
            $(this).siblings('.error_msg').empty();
        });
    }
</script>
