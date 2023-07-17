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
                        <li class="breadcrumb-item active">@lang('Asking Answer')</li>
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
                        <h4 class='card-title'>@lang('Asking Answer')</h4>
                    @else
                        <h4 class='card-title'>@lang('Asking Answer')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('admin.app-management.digital-support-ans.index') }}"
                            class="btn btn-sm btn-info"><i class="fas fa-arrow-left"></i> @lang('Asking Answer List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form enctype="multipart/form-data" id="parliamentForm" name="parliamentForm" method="POST" @if ($data->id) action="{{ route('admin.app-management.digital-support-ans.update', $data->id) }}">
                       <input name="_method" type="hidden" value="PUT">
                    @else action="{{ route('admin.app-management.digital-support-ans.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="answer">@lang('Problem/Asking')</label>
                                    <p class="control-label">{{ $data->question }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="answer">@lang('Problem Picture(If Available)')</label>
                                    <br />
                                    @isset($data->attachement)
                                        <img src="{{ asset('public/backend/digital_support/' . $data->attachement) }}"
                                            class="control-label" />
                                    @endisset
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input onchange="changeType(1)" class="form-check-input"
                                            {{ $data->type == 1 || $data->type == 0 ? 'checked' : '' }} value="1" required
                                            type="radio" id="customRadio1" name="type">
                                        <label for="customRadio1" class="form-check-label">@lang('Answer')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input onchange="changeType(2)" class="form-check-input" value="2"
                                            {{ $data->type == 2 ? 'checked' : '' }} required type="radio"
                                            id="customRadio2" name="type">
                                        <label for="customRadio2" class="form-check-label">@lang('Already Answered')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input onchange="changeType(3)" class="form-check-input" value="3"
                                            {{ $data->type == 3 ? 'checked' : '' }} required type="radio"
                                            id="customRadio3" name="type">
                                        <label for="customRadio3" class="form-check-label">@lang('Decline')</label>
                                    </div>

                                    @if (count($already_answered_list))
                                        <select class="form-control @error('requested_to') is-invalid @enderror" id="aaq_id"
                                            name="aaq_id">

                                            @foreach ($already_answered_list as $list)
                                                <option value="{{ $list->id }}"
                                                    {{ $data->aaq_id == $list->id ? 'selected' : '' }}>
                                                    {{ $list->question }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    <textarea name="answer" required class="form-control" id="answer"
                                        placeholder="@lang('Write Answer')">{{ $data->answer }}</textarea>
                                    <textarea name="comment" required class="form-control" id="comment"
                                        placeholder="@lang('Comments')">{{ $data->comment }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>

                        <div class="row" id="status_ans">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="status">@lang('Status')<span style="color: red;">
                                            *</span></label>
                                    <select class="form-control @error('requested_to') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>@lang('Open for Everyone')
                                        </option>
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>@lang('Private')
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
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a
                                            href="{{ route('admin.app-management.digital-support-ans.index') }}">@lang('Back')</a>
                                    </button>
                                    @if ($data->id)
                                        <button type="submit" class="btn btn-success btn-sm" name="parliamentForm"
                                            form="parliamentForm">@lang('Update')</button>
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
            var type = $("input[type='radio'][name='type']:checked").val();
            if (type == 1) {
                $('#answer').show();
                $("#answer").prop('disabled', false);

                $('#status_ans').show();
                $("#status_ans").prop('disabled', false);

                $('#aaq_id').hide();
                $("#aaq_id").prop('disabled', true);

                $('#comment').hide();
                $("#comment").prop('disabled', true);
                
            } else if (type == 2) {

                $('#aaq_id').show();
                $("#aaq_id").prop('disabled', false);

                $('#answer').hide();
                $("#answer").prop('disabled', true);

                $('#status_ans').hide();
                $("#status_ans").prop('disabled', true);

                $('#comment').hide();
                $("#comment").prop('disabled', true);

            } else if (type == 3) {
                $('#comment').show();
                $("#comment").prop('disabled', false);

                $('#answer').hide();
                $("#answer").prop('disabled', true);

                $('#aaq_id').hide();
                $("#aaq_id").prop('disabled', true);

                $('#status_ans').hide();
                $("#status_ans").prop('disabled', true);

            } else {
                $('#status_ans').show();
                $("#status_ans").prop('disabled', false);

                $('#answer').show();
                $("#answer").prop('disabled', false);

                $('#comment').hide();
                $("#comment").prop('disabled', true);

                $('#aaq_id').hide();
                $("#aaq_id").prop('disabled', true);
            }
            $('.preload').show();

            setTimeout(() => {
                $('.preload').hide();
            }, 1000);
        });

        function changeType(type) {
            if (type == 1) {
                $('#answer').show();
                $("#answer").prop('disabled', false);

                $('#status_ans').show();
                $("#status_ans").prop('disabled', false);
                
                $('#comment').hide();
                $("#comment").prop('disabled', true);
                
                $('#aaq_id').hide();
                $("#aaq_id").prop('disabled', true);

            } else if (type == 2) {

                $('#answer').hide();
                $("#answer").prop('disabled', true);

                $('#aaq_id').show();
                $("#aaq_id").prop('disabled', false);

                $('#status_ans').hide();
                $("#status_ans").prop('disabled', true);

                $('#comment').hide();
                $("#comment").prop('disabled', true);

            } else if (type == 3) {
                $('#answer').hide();
                $("#answer").prop('disabled', true);

                $('#status_ans').hide();
                $("#status_ans").prop('disabled', true);

                $('#aaq_id').hide();
                $("#aaq_id").prop('disabled', true);

                $('#comment').show();
                $("#comment").prop('disabled', false);
            }
        }
    </script>
@endsection
