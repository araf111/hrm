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
                        <li class="breadcrumb-item active">@lang('Pole Questions')</li>
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
                        <h4 class='card-title'>@lang('Update Pole Questions')</h4>
                    @else
                        <h4 class='card-title'>@lang('Create Pole Questions')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('admin.app-management.pull-question.index') }}" class="btn btn-sm btn-info"><i
                                class="fas fa-arrow-left"></i> @lang('Pole Question List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form enctype="multipart/form-data" id="DSQuestion" name="DSQuestion" method="POST" @if ($data->id) action="{{ route('admin.app-management.pull-question.update', $data->id) }}">
                                                                                                            <input name="_method" type="hidden" value="PUT">
                    @else action="{{ route('admin.app-management.pull-question.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label class="control-label" for="question">@lang('Type Pole Question')<span
                                            style="color: red;">
                                            *</span></label>
                                    <textarea name="question" required class="form-control"
                                        id="question">{{ $data->question }}</textarea>

                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>

                            {{-- <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="attachement">@lang('Add Atachement Of Your Findings (If Available)')</label>
                                    <input type="file" name="attachement" id="attachement" accept=".png, .jpg, .jpeg, .pdf, .doc"
                                        class="form-control" />

                                    @error('attachement')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}

                        </div>
                        <div class="row">
                            <div class="form-check form-check-inline">
                                <input onchange="changeType(1)" class="form-check-input"
                                    {{ $data->ans_type == 1 ? 'checked' : '' }} value="1" required type="radio"
                                    id="customRadio1" name="type">
                                <label for="customRadio1" class="form-check-label">@lang('MCQ')</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input onchange="changeType(0)" class="form-check-input" value="0"
                                    {{ $data->ans_type == 0 ? 'checked' : '' }} required type="radio" id="customRadio2"
                                    name="type">
                                <label for="customRadio2" class="form-check-label">@lang('Free Text')</label>
                            </div>
                        </div>

                        <div class="" id="mcq">
                            @if ($data->id && count($data->options))
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($data->options as $item)
                                    @php
                                        $i++;
                                    @endphp
                                    <div class="row optRows">
                                        <div class="col-sm-5 ml-2 p-3" style="background: #f7f7f7">
                                            @if ($i == 1)
                                                <label class="control-label">@lang('Add MCQ Options')</label>

                                            @endif
                                            <input class="form-control" value={{ $item->title }}
                                                placeholder="Enter Option" type="text" name="another" />
                                        </div>
                                        <div class="col-sm-1" style="display: contents;">
                                            @if ($i == 1)
                                                <button type="button" class="btn btn-success addMp btn-lg"
                                                    onclick="addOptions()"> <i class="fa fa-plus">
                                                    </i> </button>
                                            @else
                                                <button type="button" class="btn btn-danger removeMember btn-lg"
                                                    onclick="removeOptions({{ $item->id }})"> <i class="fa fa-times">
                                                    </i> </button>


                                            @endif
                                        </div>

                                        <div class="col-sm-6">
                                        </div>
                                    </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-sm-5 ml-2 p-3" style="background: #f7f7f7">
                                <label class="control-label">@lang('Add MCQ Options')</label>
                                <input class="form-control" placeholder="Enter Option" type="text" name="mcq[]" />
                            </div>
                            <div class="col-sm-1" style="display: contents;">
                                <button type="button" class="btn btn-success addMp btn-lg" onclick="addOptions()">
                                    <i class="fa fa-plus">
                                    </i> </button>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                        @endif


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
                    <a href="{{ asset('public/backend/attachment/'.$data->photo)  }}" target="_blank">View Previous Attachment</a><br><br>
                    </div>
 
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
      

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                    <a href="{{ route('admin.app-management.pull-question.index') }}">@lang('Back')</a>
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
            var type = $("input[type='radio'][name='type']:checked").val();
            changeType(type);
            $('.preload').show();
            setTimeout(() => {
                $('.preload').hide();
            }, 1000);
            fileuploadinit();
        });

        function changeType(type) {
            if (type == 1) {
                $('#mcq').show()
            } else if (type == 0) {
                $('#mcq').hide()
            }
        }

        function addOptions() {
            var html = `<div class="row optRows">
            <div class="col-sm-5 ml-2 p-3" style="background: #f7f7f7">
                                <input class="form-control" placeholder="Enter Option" type="text" name="mcq[]" />
                            </div>
                            <div class="col-sm-1" style="display: contents;"> <button type="button" class="btn btn-danger removeMember btn-lg"> <i class="fa fa-times"> </i> </button></div>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>`
            $('#mcq').append(html);

        }

        function removeOptions(id) {
            Swal.fire({
                title: '@lang("Are you sure?")',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang("Yes")',
                cancelButtonText: '@lang("No")'
            }).then((result) => {
                if (result.value) {
                    console.log('click yes');
                    $.ajax({
                        url: "{{ url('app-management/pull-question/options_delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: parseInt(id)
                        }
                    });
                    $(document).on("click", ".removeMember", function() {
                        $(this).closest('.optRows').remove();
                    });
                } else {
                    //Swal.fire('Your data is safe', '', 'success');
                }
            });
            
        }

        
    </script>
@endsection
