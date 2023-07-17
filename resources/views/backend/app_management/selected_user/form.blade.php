@extends('backend.layouts.app')
@section('content')
<style>
    .focusedInput {
        border-color: rgb(247 60 60) !important;
        outline: 0;
        outline: thin dotted \9;
        -moz-box-shadow: 0 0 3px rgba(255, 0, 0);
        box-shadow: 0 0 3px rgba(255,0,0) !important;
    }

</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Mobile Application Setup')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Selected Person')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if ($data->id)
                        <h4 class='card-title'>@lang('Update Selected Person')</h4>
                    @else
                        <h4 class='card-title'>@lang('Create Selected Person')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('admin.app-management.selected-user.index') }}" class="btn btn-sm btn-info"><i
                                class="fas fa-arrow-left"></i> @lang('Selected Person List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form enctype="multipart/form-data" id="formSubmit" name="formSubmit" method="POST" @if ($data->id) action="{{ route('admin.app-management.selected-user.update', $data->id) }}">
                            <input name="_method" type="hidden" value="PUT">
                    @else
                                action="{{ route('admin.app-management.selected-user.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Name')<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="name" name="name" class="form-control name"
                                        value="{{ $data->name }}" placeholder="@lang('Name')" />

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="father_name">@lang('Father Name')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="father_name" name="father_name" class="form-control father_name"
                                        value="{{ $data->father_name }}" placeholder="@lang('Father Name')" />

                                    @error('father_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="mother_name">@lang('Mother Name')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="mother_name" name="mother_name" class="form-control mother_name"
                                        value="{{ $data->mother_name }}" placeholder="@lang('Mother Name')" />

                                    @error('mother_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="mobile_num">@lang('Mobile Number')<span style="color: red;">
                                            *</span></label>
                                    <input type="number" id="mobile_num" name="mobile_num" class="form-control mobile_num"
                                        value="{{ $data->mobile_num }}" placeholder="@lang('Mobile Number')" />
                                    <span id="mobile_num_msg" class="text-danger"></span>
                                    @error('mobile_num')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="designation">@lang('Designations')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="designation" name="designation" class="form-control designation"
                                        value="{{ $data->designation }}" placeholder="@lang('Designations')" />

                                    @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="email">@lang('Email')<span
                                            style="color: red;"> *</span></label>
                                    <input type="email" id="email" name="email" class="form-control email"
                                        value="{{ $data->email }}" placeholder="@lang('Email')" />

                                        <span id="email_msg" class="text-danger"></span>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="current_address">@lang('Present Address')<span
                                            style="color: red;"> *</span></label>
                                    <textarea name="current_address" class="form-control current_address"
                                        id="current_address">{{ $data->current_address }}</textarea>
                                    @error('current_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="permanent_address">@lang('Permanent Address')<span
                                            style="color: red;"> *</span></label>
                                    <textarea class="form-control permanent_address" name="permanent_address"
                                        id="permanent_address">{{ $data->permanent_address }}</textarea>
                                    @error('permanent_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="selected_type">@lang('Selected Type Name')<span
                                            style="color: red;"> *</span></label>
                                    <select class="form-control selected_type @error('selected_type') is-invalid @enderror"
                                        id="selected_type" name="selected_type">
                                        <option value="">@lang('Selected Type Name')</option>
                                        @foreach ($type_list as $list)
                                            <option value="{{ $list->id }}"
                                                {{ $data->selected_type == $list->id ? 'selected' : '' }}>
                                                @if (session()->get('language') == 'bn')
                                                    {{ $list['name_bn'] }}
                                                @else
                                                    {{ $list['name_en'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selected_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">@lang('Profile Picture')<span
                                            style="color: red;">
                                            *</span></label>
          
                                    <input type="file" accept="image/*" class="form-control image image_upload pl-1" name="image" id="image" accept=".png, .jpg, .jpeg">
                                    
                                    @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @isset($data->image)
                                        <img src="{{asset('public/backend/selected_person')}}/{{$data->image}}" alt="Profile Picture" width="50px">
                                    @endisset

                                </div>
                            </div>
                            @if ($data->id)
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="status">@lang('Status')<span style="color: red;">
                                                *</span></label>
                                        <select class="form-control @error('requested_to') is-invalid @enderror" id="status"
                                            name="status">
                                            <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>@lang('Active')
                                            </option>
                                            <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>@lang('Inactive')
                                            </option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a
                                            href="{{ route('admin.app-management.selected-user.index') }}">@lang('Back')</a>
                                    </button>
                                    @if ($data->id)
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    @else
                                        <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function() {
            // $('.preload').show();
            // setTimeout(() => {
            //     $('.preload').hide();
            // }, 1000);
            $('#ap_place').hide();
            $('#ministry').hide();
            $('#mp_list').hide();
        });
    </script>    
    
    <script>
        $(function() {

            $('#mobile_num').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#mobile_num_msg').text('The Mobile Number Should be 11 Digit'); 
                }
                if (val.length >= 10) {
                    $('#mobile_num_msg').text(''); 
                }
                if( val.length>10 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });

            
        });

    </script>
    <script>
        

        $('#formSubmit').validate({
            ignore:[],
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            errorClass:'text-danger',
            validClass:'text-success',
        });

        jQuery.validator.addClassRules({
            'name' : {
                required : true,
            },
            'father_name' : {
                required : true,
            },
            'mother_name' : {
                required : true,
            },
            'mobile_num' : {
                required : true,
            },
            'designation' : {
                required : true,
            },
            'email' : {
                required : true,
                email: true,
            },
            'current_address' : {
                required : true,
            },
            'permanent_address' : {
                required : true,
            },
            'selected_type' : {
                required : true,
            },
            @if (!isset($data->id))
            'image' : {
                required : true,
                extension: "jpg,jpeg,png",
            }
            @endif

        });
    </script>
@endsection
