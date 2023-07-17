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

        .avatar-upload {
            position: relative;
            max-width: 205px;
        }

        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }
        .avatar-upload .avatar-edit input+label:after {
            content: "⇪";
            font-family: 'FontAwesome';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }

        .avatar-upload .avatar-preview {
            width: 150px;
            height: 150px;
            position: relative;
            /*border-radius: 100%;*/
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload .avatar-preview>div {
            width: 100%;
            height: 100%;
            /*border-radius: 100%;*/
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .course-photo.avatar-upload {
            max-width: 200px !important;
        }

        .course-photo.avatar-upload .avatar-preview {
            width: 150px !important;
            height: 150px !important;
        }

        #signaturePhoto,#signaturPreview{
            display: none;
        }

        input[type="file"] {
            padding: 1px !important;
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
                    <h4 class="m-0 text-dark">@lang('company.company_management') </h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('company.company_management')</li>
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
                        <a href="{{ route('admin.master_setup.companyinfos.index') }}" 
                            class="btn btn-info float-right">
                            <i class="fa fa-list mr-2"></i>
                            @lang('common.list')
                        </a>
                    </h4>
                </div>
                <div class="card-body overflow-hidden">
                    <form method="post"
                        action="{{ route('admin.master_setup.companyinfos.store') }}"
                        enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="card">
                            <div class="row ">
                                <div class="col-12">
                                    <div class="card-header bg-success">
                                        <h3 class="card-title"><i class="fa fa-building" aria-hidden="true"></i> @lang('company.company_info')</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Company Bangla Name -->
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="company_name_bangla" class="required">@lang('Name (Bangla)')</label>
                                            {{ Form::text('company_name_bangla', null, 
                                                [
                                                    'class' => 'form-control form-control-sm required' . ($errors->has('company_name_bangla') ? ' is-invalid' : ''),
                                                    'id'=>'company_name_bangla',
                                                    'data-msg-required' => trans('common.This field is required'),
                                                    'placeholder' => trans('Enter Name in Bangla'),
                                                ]) 
                                                
                                            }}
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="company_name_english required">@lang('Name (English)')</label>
                                            {{ Form::text('company_name_english', null, 
                                                [
                                                    'class' => 'form-control form-control-sm required' . ($errors->has('company_name_english') ? ' is-invalid' : ''),
                                                    'id'=>'company_name_english',
                                                    'data-msg-required' => trans('common.This field is required'),
                                                    'placeholder' => trans('Enter Name in Bangla'),
                                                ]) 
                                                
                                            }}
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="company_add_bangla required">@lang('company.address_bn')</label>
                                            {{ Form::textarea('company_add_bangla', null, 
                                                [
                                                    'class' => 'form-control form-control-sm required' . ($errors->has('company_add_bangla') ? ' is-invalid' : ''),
                                                    'id'=>'company_add_bangla',
                                                    'data-msg-required' => trans('common.This field is required'),
                                                    'placeholder' => trans('Enter Name in Bangla'),
                                                    'rows' => 2,
                                                    'columns' => 3,
                                                ]) 
                                                
                                            }}
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="company_add_english required">@lang('company.address_en')</label>
                                            {{ Form::textarea('company_add_english', null, 
                                                [
                                                    'class' => 'form-control form-control-sm required' . ($errors->has('company_add_english') ? ' is-invalid' : ''),
                                                    'id'=>'company_add_english',
                                                    'data-msg-required' => trans('common.This field is required'),
                                                    'placeholder' => trans('Enter Name in English'),
                                                    'rows' => 2,
                                                    'columns' => 3,
                                                ]) 
                                                
                                            }}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="company_phone required">@lang('company.phone_num')</label>
                                            {{ Form::text('company_phone', null, 
                                                [
                                                    'class' => 'form-control form-control-sm required' . ($errors->has('company_phone') ? ' is-invalid' : ''),
                                                    'id'=>'company_phone',
                                                    'data-msg-required' => trans('common.This field is required'),
                                                    'placeholder' => trans('company.phone_num'),
                                                ]) 
                                                
                                            }}
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="imageUpload" class="required">@lang('Photo') 
                                            <small>(jpg, jpeg, png, gif)</small>
                                        </label>
                                        <div class="course-photo avatar-upload ml-0">
                                            <div class="avatar-edits">
                                                <input type='file' 
                                                    name="company_logo" 
                                                    id="company_logo" 
                                                    class="form-control form-control-sm required"
                                                />
                                            </div>
                                            <div class="avatar-preview mt-1" id="signaturePhoto">
                                                <div id="imagePreview" 
                                                    style="background-image: url({{ asset('public/images/default-img.png') }});">
                                                </div>
                                            </div>
                                            <div class="help-block"></div>
                                            @if ($errors->has('company_logo'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('company_logo') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="imageUpload" class="required">@lang('company.signature') 
                                            <small>(jpg, jpeg, png, gif)</small>
                                        </label>
                                        <div class="course-photo avatar-upload ml-0">
                                            <div class="avatar-edits">
                                                <input type='file' 
                                                    name="company_signature" 
                                                    id="company_signature" 
                                                    class="form-control form-control-sm required"
                                                />
                                            </div>
                                            <div class="avatar-preview mt-1" id="signaturPreview">
                                                <div id="signatureimagePreview" 
                                                    style="background-image: url({{ asset('public/images/default-img.png') }});">
                                                </div>
                                            </div>
                                            <div class="help-block"></div>
                                            @if ($errors->has('company_signature'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('company_signature') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mt-sm-auto text-right">
                                        <button type="submit" class="btn btn-sm btn-info"><i
                                                class="fas fa-save"></i>
                                            {{ __('Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(window).ready(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#company_logo").change(function () {
                $('#signaturePhoto').css('display', 'block');
                readURL(this);
            });
            function gignaturImageUrl(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#signatureimagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#signatureimagePreview').hide();
                        $('#signatureimagePreview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#company_signature").change(function () {
                $('#signaturPreview').css('display', 'block');
                gignaturImageUrl(this);
            });
        })
    </script>
    <script type="text/javascript">
    var user_type = '';
        $(document).ready(function() {
            $('#myFormaaaa').validate({
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
                    'company_name_english': {
                        required: true,
                    },
                    'company_name_bangla': {
                        required: true,
                    },
                    'company_add_english': {
                        required: true,
                    },
                    'company_add_bangla': {
                        required: true,
                    },
                    'company_phone': {
                        required: true,
                    },
                    'company_logo': {
                        required: true,
                    },
                    'company_signature': {
                        required: true,
                    },
                },
                messages: {
                    company_name_english: {
                        required: "@lang('This field is required.')"
                    },
                    company_name_bangla: {
                        required: "@lang('This field is required.')"
                    },
                    company_add_english: {
                        required: "@lang('This field is required.')"
                    },
                    company_add_bangla: {
                        required: "@lang('This field is required.')"
                    },
                    company_phone: {
                        required: "@lang('This field is required.')"
                    },
                    company_logo: {
                        required: "@lang('This field is required.')"
                    },
                    company_signature: {
                        required: "@lang('This field is required.')"
                    },
                }

            });

        });

        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type':'application/json',
                    'Accept':'application/json'
                }
            });
            $('#myForm').submit(function(e) {
                e.preventDefault();
                my_loader('start');
                var formData = new FormData(this);
                // console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr("action"),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        // var data = res;
                        console.log(res);
                        // console.log('okkk');
                        if (res.status == 200) {
                            Swal.fire(res.message, '', 'success').then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire(res.message, '', 'warning');
                        }
                        my_loader('stop');
                    },
                    error: function(res) {
                        my_loader('stop');
                        Swal.fire('@lang("Something wrong")', '', 'error');
                    }
                });

            });
        });
    </script>
@endsection
