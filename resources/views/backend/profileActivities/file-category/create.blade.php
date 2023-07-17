@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('File Management') </h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Category Management')</li>
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
                    @if(session()->get('language') =='bn')
                    {{ isset($editData) ? $editData->name_bn : __('Category Information') }}
                    @else
                    {{ isset($editData) ? $editData->name_eng : __('Category Information') }}
                    @endif
                    <a href="{{ route('admin.profile-activities.file-category.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Category List')</a>
                </h4>
            </div>
            <div class="card-body">
                <form id="formSubmit" method="POST" action="{{ isset($editData) ? route('admin.profile-activities.file-category.update',$editData->id) : route('admin.profile-activities.file-category.store') }}">
                    @csrf
                    @if (isset($editData))
                    @method('PUT')
                    @endif
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="" class="control-label"><span class="color-red" style="color:red">*</span>@lang('Category Name (Bangla)')</label>
                            <input type="text" name="category_name_bn" value="{{ $editData->category_name_bn ?? old('category_name_bn') }}" class="form-control form-control-sm category_name_bn @error('category_name_bn') is-invalid @enderror" placeholder="@lang('Enter Category Name in Bangla')" required>
                            
                            @error('category_name_bn')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="" class="control-label"><span class="color-red" style="color:red">*</span>@lang('Category Name (English)')</label>
                            <input type="text" name="category_name_en" value="{{ $editData->category_name_en ?? old('category_name_en') }}" class="form-control form-control-sm category_name_en @error('category_name_en') is-invalid @enderror" placeholder="@lang('Enter Category Name in English')" required>
                            
                            @error('category_name_en')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4 mt-3 mb-5">
                            <button class="btn btn-info"><i class="fa fa-save mr-2"></i> {{ isset($editData) ? __('Update Category') : __('Save') }} </button>
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
    $(function() {
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD',
        });
    })

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
            'category_name_bn' : {
                required : true,
                regex_bn:true,
            },
            'category_name_en' : {
                required : true,
                regex_en:true,
            },
            
        });
    })

</script>
@endsection
@push('page_scripts')
@include('backend.includes.location_scripts')
@endpush