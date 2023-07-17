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
                        <li class="breadcrumb-item active">@lang('Pole')</li>
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
                        <h4 class='card-title'>@lang('Update Pole')</h4>
                    @else
                        <h4 class='card-title'>@lang('Create Pole')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('admin.app-management.pull-list.index') }}" class="btn btn-sm btn-info"><i
                                class="fas fa-arrow-left"></i> @lang('Pole Question List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form enctype="multipart/form-data" id="DSQuestion" name="DSQuestion" method="POST" @if ($data->id) action="{{ route('admin.app-management.pull-list.update', $data->id) }}">
                                                                                                                            <input name="_method" type="hidden" value="PUT">
                    @else action="{{ route('admin.app-management.pull-list.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Pole Name')<span style="color: red;">
                                            *</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $data->name}}" required id="name" />

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label" for="fromDate">@lang('From Date')<span style="color: red;">
                                        *</span></label>
                                <div class="form-group">
                                <input type="text" id="fromDate" class="readonly_date nano_custom_date" name="fromDate">
                                    @error('fromDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-8">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="control-label" for="toDate">@lang('To Date')<span style="color: red;">
                                        *</span></label>
                                <div class="form-group">
                                <input type="text" id="toDate" class="readonly_date nano_custom_date" name="toDate">
                                    @error('toDate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-8">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>@lang('Pole Question List')</label>
                                    <select class="select2" multiple="multiple" name="qlist[]" id="qlist"data-placeholder="Select a question"
                                        style="width: 100%;">
                                        @foreach ($pull_question as $item)
                                            <option value={{ $item->id }} 
                                                @if (in_array($item->id, $selected_question))
                                                selected
                                                @endif
                                                > {{ $item->question }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="form-group col-sm-4">
                                    <label class="control-label">@lang('Roll Permission') </label>
                                    <select name="user_role[]" id="user_role"
                                        class="form-control form-control-sm select2" multiple>

                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ (in_array($role->id,$existing_roles)) ? 'selected' : '' }}>
                                                @if (session()->get('language') == 'bn')
                                                    {{ $role->name_bn }}
                                                @else
                                                    {{ $role->name }}
                                                @endif

                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label class="control-label" for="photo">@lang('Attachment (if any)') <br><small>(jpg,png,jpeg)</small></label>
                            </div>
                            <div class="col-sm-12 col-md-10 col-lg-10">
                                <div class="file p-0">
                                    <button type="button" class="btn btn-sm btn-info" onclick="document.getElementById('photo').click()">@lang('Choose Files')</button>
                                    <input type="file" class="form-control attachment_upload pl-1" name="photo" id="photo" accept=".jpg,.jpeg,.png" style="display:none;">
                                    <span id="photo_name"></span>
                                </div>

                                @error('attachment')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{ route('admin.app-management.pull-list.index') }}">@lang('Back')</a>
                                    </button>
                                    @if ($data->id)
                                        <button type="submit" class="btn btn-success btn-sm" name="DSQuestion"
                                            form="DSQuestion">@lang('Update')</button>
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
        var fileuploadinit = function(){
        $('#photo').change(function(){
            var pathwithfilename = $('#photo').val();
            var filename = pathwithfilename.substring(12);
            $('#photo_name').html(filename).css({
                'display':'inline-block'
            });
        });
    };
        $(function() {
            $('.preload').show();
            setTimeout(() => {
                $('.preload').hide();
            }, 1000);

            $(".readonly_date").keypress(function(e) {
                return false;
            });
            $(".readonly_date").keydown(function(e) {
                return false;
            });

            $('#fromDate').daterangepicker({
                startDate: "{{ date('d-m-Y') }}",
                minDate: "{{ date('d-m-Y') }}",
                singleDatePicker: true,
                locale: daterange_locale,
            });
            
            $('#toDate').daterangepicker({
                startDate: "{{ date('d-m-Y') }}",
                minDate: "{{ date('d-m-Y') }}",
                singleDatePicker: true,
                locale: daterange_locale,
            });

            fileuploadinit();
        });
    </script>
@endsection
