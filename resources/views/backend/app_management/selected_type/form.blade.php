@extends('backend.layouts.app')
@section('content')
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
                        <li class="breadcrumb-item active">@lang('Types Of Selected Person')</li>
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
                    @if($data->id)
                    <h4 class='card-title'>@lang('Update Selected Type')</h4>
                    @else
                    <h4 class='card-title'>@lang('Create Selected Type')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{route('admin.app-management.selected-type.index') }}" class="btn btn-sm btn-info"><i class="fas fa-arrow-left"></i> @lang('Selection Type List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form id="parliamentForm" name="parliamentForm" method="POST"
                      @if($data->id)
                      action="{{ route('admin.app-management.selected-type.update', $data->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    @else
                        action="{{ route('admin.app-management.selected-type.store') }}">
                    @endif
                    @csrf

                    <input type="hidden" id="id" name="id" value="{{$data->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="name_bn">@lang('Selected Type Name') (Bangla)<span
                                            style="color: red;"> *</span></label>
                                    <input required type="text" id="name_bn" name="name_bn"
                                           class="form-control" value="{{$data->name_bn}}" placeholder="@lang('Selected Type Name') (Bangla)"/>

                                    @error('name_bn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="name_en">@lang('Selected Type Name') (English)<span
                                            style="color: red;"> *</span></label>
                                    <input required type="text" id="name_en" name="name_en"
                                           class="form-control" value="{{$data->name_en}}" placeholder="@lang('Selected Type Name') (English)"/>

                                    @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="status">@lang('Status')<span
                                            style="color: red;"> *</span></label>
                                            <select required class="form-control @error('requested_to') is-invalid @enderror" id="status" name="status">
                                                <option value="1" {{$data->status == 1?'selected':''}}>@lang('Active')</option>
                                                <option value="0" {{$data->status == 0?'selected':''}}>@lang('Inactive')</option>
                                            </select>
                                    {{-- <input type="text" id="status" name="status"
                                           class="form-control" placeholder="@lang('Mother Name')"/> --}}

                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{route('admin.app-management.selected-type.index') }}">@lang('Back')</a>
                                    </button>
                                    @if($data->id)
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
    $(function () {
        $('.preload').show();
        setTimeout(() => {
            $('.preload').hide();
        }, 1000);
        $('#ap_place').hide();
        $('#ministry').hide();
        $('#mp_list').hide();
    });
</script>
@endsection

