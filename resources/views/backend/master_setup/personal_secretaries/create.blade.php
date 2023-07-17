@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Personal Secretary Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Personal Secretary Management')</li>
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
                    <h4 class="card-title w-100">@lang('Personal Secretary Information')
                        <a href="{{ route('admin.master_setup.personal_secretaries.index') }}"
                            class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Personal Secretary List')</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form id="formSubmit" method="POST" action="{{ route('admin.master_setup.personal_secretaries.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">@lang('Name (Bangla)')</label>
                                <input type="text" name="name_bn" id="name_bn" class="form-control form-control-sm name_bn @error('name_bn') is-invalid @enderror"
                                    value="{{ old('name_bn') ?? $editData->name_bn ?? '' }}" placeholder="@lang('Enter Name in Bangla')">
                                    @error('name_bn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">@lang('Name (English)')</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm name @error('name') is-invalid @enderror"
                                    value="{{ old('name') ?? $editData->name ?? '' }}" placeholder="@lang('Enter Name in English')">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">@lang('Email')</label>
                                <input type="email" name="email" id="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    value="{{ old('email') ?? $editData->email ?? '' }}" placeholder="@lang('Enter Email')" autocomplete="off">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">@lang('Password')</label>
                                <input type="password" name="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    autocomplete="off" placeholder="@lang('Enter Password')">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">@lang('Confirm Password')</label>
                                <input id="password-confirm" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="@lang('Enter Password Again')">
                            </div>
                            <div class="form-group col-sm-4">
                                {{-- always use user_id --}}
                                <label for="" class="control-label">@lang('MP')</label>
                                <select name="mp_user_id" id="mp_user_id" class="form-control form-control-sm @error('mp_user_id') is-invalid @enderror">
                                    <option value="">@lang('Select MP')</option>
                                    @if (isset($mpUsers) && count($mpUsers) > 0)
                                        @foreach ($mpUsers as $mpUser)
                                            <option value="{{ $mpUser->id }}">
                                                @if(session()->get('language') =='bn')
                                                {{ $mpUser->name_bn }}
                                                @else
                                                {{ $mpUser->name }}
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('mp_user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-4 mt-auto">
                                <button class="btn btn-sm btn-info"><i class="fa fa-save mr-2"></i>@lang('Save')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('script')
<script>
    $(document).ready(function(){
        $('#formSubmit').validate({
            ignore:[],
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            errorClass:'text-danger',
            validClass:'text-success',

        });

        jQuery.validator.addClassRules({
            'name_bn' : {
                required : true,
                regex_bn:true,
            },
            'name' : {
                required : true,
                regex_en:true,
            },
            
        });
    })
</script>
@endsection