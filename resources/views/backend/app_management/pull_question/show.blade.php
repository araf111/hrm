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
                                    <img src="{{ asset('public/backend/digital_support/' . $data->attachement) }}"
                                        class="control-label" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input  readonly class="form-check-input"
                                            {{ $data->type == 1 || $data->type == 0 ? 'checked' : '' }} value="1" required
                                            type="radio" id="customRadio1" name="type">
                                        <label for="customRadio1" class="form-check-label">@lang('Answer')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input  readonly class="form-check-input" value="2"
                                            {{ $data->type == 2 ? 'checked' : '' }} required type="radio"
                                            id="customRadio2" name="type">
                                        <label for="customRadio2"  class="form-check-label">@lang('Already Answered')</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input readonly class="form-check-input" value="3"
                                            {{ $data->type == 3 ? 'checked' : '' }} required type="radio"
                                            id="customRadio3" name="type">
                                        <label for="customRadio3" class="form-check-label">@lang('Decline')</label>
                                    </div>

                                    @if (count($already_answered_list))
                                        <p class="control-label" id="aaq_id">
                                            @foreach ($already_answered_list as $list)
                                                @if ($data->aaq_id == $list->id)
                                                    {{ $list->question }}
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif

                                    <p class="control-label" id="answer">{{ $data->answer }}</p>
                                    <p class="control-label" id="comment">{{ $data->comment }}</p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>

                        <div class="row" id="status_ans">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="status">@lang('Status')</label>
                                    <p class="control-label">
                                        @if ($data->status == 1)
                                            @lang('Publish')
                                        @endif
                                        @if ($data->status == 0)
                                            @lang('Unpublish')
                                        @endif
                                    </p>

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
                $('#status_ans').show();
                $('#aaq_id').hide();
                $('#comment').hide();
            } else if (type == 2) {

                $('#answer').hide();
                $('#aaq_id').show();
                $('#status_ans').hide();
                $('#comment').hide();
            } else if (type == 3) {
                $('#answer').hide();
                $('#aaq_id').hide();
                $('#status_ans').hide();
                $('#comment').show();
            } else {
                $('#status_ans').show();
                $('#answer').show();
                $('#comment').hide();
                $('#aaq_id').hide();
            }
            $('.preload').show();

            setTimeout(() => {
                $('.preload').hide();
            }, 1000);
        });

        function changeType(type) {
            if (type == 1) {
                $('#answer').show();
                $('#status_ans').show();
                $('#comment').hide();

                $('#aaq_id').hide();
            } else if (type == 2) {

                $('#answer').hide();
                $('#aaq_id').show();
                $('#status_ans').hide();
                $('#comment').hide();
            } else if (type == 3) {
                $('#answer').hide();
                $('#status_ans').hide();
                $('#aaq_id').hide();

                $('#comment').show();
            }
        }
    </script>
@endsection
