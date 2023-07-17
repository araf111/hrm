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
                        <li class="breadcrumb-item active">@lang('Selected Member Chat')</li>
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
                        <h4 class='card-title'>@lang('Update Selected Member Chat')</h4>
                    @else
                        <h4 class='card-title'>@lang('Create Selected Member Chat')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('admin.app-management.selected-member-chat.index') }}"
                            class="btn btn-sm btn-info"><i class="fas fa-arrow-left"></i> @lang('Chat List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form enctype="multipart/form-data" id="parliamentForm" name="parliamentForm" method="POST" @if ($data->id) action="{{ route('admin.app-management.selected-member-chat.update', $data->id) }}">
                                                                    <input name="_method" type="hidden" value="PUT">
                    @else action="{{ route('admin.app-management.selected-member-chat.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="search_date">@lang('Date')<span style="color: red;">
                                            *</span></label>
                                    <input type="text" id="search_date" class="form-control datetimepicker-input"
                                        name="date" placeholder="@lang('Select Date')" readonly
                                        value="{{ $data->date != null ? $data->date : date('j F, Y') }}"
                                        autocomplete="off" maxlength="30" data-target="#reservationdate" />
                                    {{-- <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div> --}}

                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-8">
                            </div>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <label class="control-label" for="post">@lang('Post')<span style="color: red;">
                                            *</span></label>
                                    <textarea name="post" required class="form-control"
                                        id="post">{{ $data->post }}</textarea>

                                    @error('post')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="image">@lang('Attachment')</label>
                                    <input type="file" name="image" id="image" accept=".png, .jpg, .jpeg, .pdf, .doc"
                                        class="form-control" />

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        @if ($data->id)
                            @if (count($selectedProfileList))
                                @foreach ($selectedProfileList as $profile)
                                    <div class="row mb-3 mpRow{{ $profile['id'] }}">
                                        <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                                            <label class="control-label">@lang('Select MP')</label>
                                            <select name="upmp_id[]" class="form-control">
                                                @foreach ($profileList as $list)
                                                    @if ($profile['mp_id'] == $list->id)
                                                        <option value="{{ $list['id'] }}" selected>
                                                            @if (session()->get('language') == 'bn')
                                                                {{ $list['constituency']->bn_name . ' - ' . $list['name_bn'] }}
                                                            @else
                                                                {{ $list['constituency']->name . ' - ' . $list['name_eng'] }}
                                                            @endif
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-1" style="display: contents;">
                                            <button class="btn btn-lg btn-danger" onclick="removeMpPermission({{$profile->id}})"><i
                                                        class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if (count($selectedMemberList))
                                @foreach ($selectedMemberList as $member)
                                    <div class="row mb-3 memberRow{{ $member['id'] }}">
                                        <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                                            <label class="control-label">@lang('Selected Person')</label>
                                            <select name="upmember_id[]" class="form-control">
                                                @foreach ($memberList as $list)
                                                    @if ($member['member_id'] == $list->id)
                                                        <option value="{{ $list['id'] }}" selected>
                                                            {{ $list['name'] }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-1" style="display: contents;">
                                            <button class="btn btn-lg btn-danger" onclick="removeMemberPermission({{$member->id}})" type="submit"><i
                                                        class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                        <div id="more_mp">
                            <div class="row mb-3">
                                <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                                    <label class="control-label">@lang('Select MP')</label>
                                    <select name="mp_id[]" class="form-control select2">
                                        <option value="">@lang('Select Name')</option>
                                        @foreach ($profileList as $list)
                                            <option value="{{ $list['id'] }}">
                                                @if (session()->get('language') == 'bn')
                                                    {{ $list['constituency']->bn_name . ' - ' . $list['name_bn'] }}
                                                @else
                                                    {{ $list['constituency']->name . ' - ' . $list['name_eng'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1" style="display: contents;">
                                    <button type="button" class="btn btn-success addMp  btn-lg"> <i class="fa fa-plus">
                                        </i> </button>
                                </div>
                            </div>
                        </div>
                        <div id="more_member">
                            <div class="row mb-3">
                                <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                                    <label class="control-label">@lang('Selected Person')</label>
                                    <select name="member_id[]" class="form-control select2">
                                        <option value="">@lang('Select Name')</option>
                                        @foreach ($memberList as $list)
                                            <option value="{{ $list['id'] }}">
                                                {{ $list['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1" style="display: contents;">
                                    <button type="button" class="btn btn-success addMember  btn-lg"> <i class="fa fa-plus">
                                        </i> </button>
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
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a
                                            href="{{ route('admin.app-management.selected-member-chat.index') }}">@lang('Back')</a>
                                    </button>
                                    @if ($data->id)
                                        <button type="submit" class="btn btn-success btn-sm" name="parliamentForm" form="parliamentForm">@lang('Update')</button>
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
            $('.preload').show();
            setTimeout(() => {
                $('.preload').hide();
            }, 1000);
        });
        $('.addMp').click(function() {

            var loadMember = ` <div class="row mb-3 mpRow">
                                <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                                    <label class="control-label">@lang('Select MP')</label>
                                    <select name="mp_id[]"
                                        class="form-control select2">
                                        @foreach ($profileList as $list)
                                            <option value="{{ $list['id'] }}">
                                                @if (session()->get('language') == 'bn')
                                                    {{ $list['constituency']->bn_name . ' - ' . $list['name_bn'] }}
                                                @else
                                                    {{ $list['constituency']->name . ' - ' . $list['name_eng'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1" style="display: contents;"> <button type="button" class="btn btn-danger removeMp btn-lg"> <i class="fa fa-times"> </i> </button></div>
                            </div>`;

            $('#more_mp').append(loadMember);

        });

        $('.addMember').click(function() {

            var loadMember = ` <div class="row mb-3 memberRow">
                                <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                                    <label class="control-label">@lang('Selected Person')</label>
                                    <select name="member_id[]"
                                        class="form-control select2">
                                        @foreach ($memberList as $list)
                                            <option value="{{ $list['id'] }}">
                                                {{ $list['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1" style="display: contents;"> <button type="button" class="btn btn-danger removeMember btn-lg"> <i class="fa fa-times"> </i> </button></div>
                            </div>`;

            $('#more_member').append(loadMember);

        });
        function removeMemberPermission(id){
            $('.memberRow'+id).remove();
            $.ajax({
                url: "{{ url('app-management/selected-member-chat/chat_permision_delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: parseInt(id)
                }
            });
        }
        function removeMpPermission(id){
            $('.mpRow'+id).remove();
            $.ajax({
                url: "{{ url('app-management/selected-member-chat/chat_permision_delete') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: parseInt(id)
                }
            });
        }
        $(document).on("click", ".removeMember", function() {
            $(this).closest('.memberRow').remove();
        });
        $(document).on("click", ".removeMp", function() {
            $(this).closest('.mpRow').remove();
        });
    </script>
@endsection
