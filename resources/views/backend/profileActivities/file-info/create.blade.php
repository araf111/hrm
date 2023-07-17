@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h6 class="m-0 text-dark">@lang('File Management') (<span>@lang('Save only the necessary files'))</span></h6>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('File Management')</li>
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
                    {{ isset($editData) ? $editData->name_bn : __('File Information') }}
                    @else
                    {{ isset($editData) ? $editData->name_eng : __('File Information') }}
                    @endif
                    <a href="{{ route('admin.profile-activities.file-info.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('File List')</a>
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($editData) ? route('admin.profile-activities.file-info.update',$editData->id) : route('admin.profile-activities.file-info.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($editData))
                    @method('PUT')
                    @endif
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="" class="control-label"><span class="color-red" style="color:red">*</span>@lang('Category')</label>
                            <select name="file_category_id" id="file_category_id" class="form-control form-control-sm select2 @error('file_category_id') is-invalid @enderror" requered>
                                {!! fileCategoryDropdown($editData->file_category_id ?? '') !!}
                            </select>
                            @error('file_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="" class="control-label"><span class="color-red" style="color:red">*</span>@lang('Name Of File')</label>
                            <input type="text" name="file_name" value="{{ $editData->file_name ?? old('file_name') }}" class="form-control form-control-sm @error('file_name') is-invalid @enderror" placeholder="">
                            @error('file_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="" class="attachment-label"><span class="color-red" style="color:red">*</span>@lang('File Attachment')</label>
                            <div class="file p-0">
                                <input type="file" class="form-control attachment_upload pl-1 @error('attachment') is-invalid @enderror" name="attachment" id="attachment" accept=".png, .jpg, .jpeg, .pdf">
                                <span>{{ @($editData)? $editData->attachment : '' }}</span>
                            </div>
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label></label>
                            <div class="file pt-1">
                                <p>(Only xlsx, xls, csv, jpg, jpeg, png, bmp, doc, docx, pdf, tif, tiff images are allowed and file size max {{$each_file_limit}}MB)</p>
                            </div>
                        </div>

                        <div class="form-group col-sm-4 mt-3 mb-5">
                            <button class="btn btn-info"><i class="fa fa-save mr-2"></i> {{ isset($editData) ? __('Update File') : __('Save') }} </button>
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
</script>
@endsection
@push('page_scripts')
@include('backend.includes.location_scripts')
@endpush