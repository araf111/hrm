@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('File Management')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Your Files')</li>
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
                <h4 class="card-title w-100 mb-2">@lang('Name Of File') : {{$singleData->file_name}}</h4>
                <h6 class="card-title w-100">
                    @if(session()->get('language')=='bn')
                    ফাইলটি নিম্নের {{digitDateLang(count($mpData))}} জন মাননীয় সংসদ সদস্যের সাথে শেয়ার করা আছে
                    @else
                    @lang('The file is shared with the following') {{digitDateLang(count($mpData))}} @lang('Members of Parliament')
                    @endif
                </h6>

                <a href="{{ route('admin.profile-activities.file-info.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('File List')</a>
            </div>
            <div class="card-body">
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>@lang('Serial')</th>
                                <th>@lang('Voter Area No, Name')</th>
                                <th>@lang('Name of Honorable of Parliament')</th>
                                <th width="12%" class="text-center">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($mpData) && count($mpData) > 0)
                            @foreach ($mpData as $data)
                            <tr>
                                <td>{{ digitDateLang($loop->iteration) }}</td>

                                <td>
                                    @if(session()->get('language')=='bn')
                                    {{ digitDateLang($data->constituency->number) }} {{ $data->constituency->bn_name }}
                                    @else
                                    {{ digitDateLang($data->constituency->number) }} {{ $data->constituency->name }}
                                    @endif

                                </td>
                                <td>
                                    @if(session()->get('language')=='bn')
                                    {{ $data->name_bn }}
                                    @else
                                    {{ $data->name_eng }}
                                    @endif
                                </td>
                                <td>
                                    {{-- <form action="{{ route('admin.profile-activities.share-info-delete', $singleData->id) }}" enctype="multipart/form-data">
                                    <input type="hidden" name="mp_id" value="{{$data->user_id}}">
                                    <button class="btn btn-sm btn-danger" onClick="issueRemove(this,'{{$issueAttachment[$i]->id}}')"><i class="fas fa-minus-circle"></i> @lang('Remove')</button>
                                    </form> --}}
                                    {{--<form action="" enctype="multipart/form-data"> --}}
                                    <input type="hidden" name="mp_id" id="mp_id" value="{{$data->user_id}}">
                                    <button class="btn btn-sm btn-danger delete" data-route="{{route('admin.profile-activities.share-info-delete', $singleData->id)}}"><i class="fas fa-minus-circle"></i> @lang('Remove')</button>
                                    {{-- </form>
                                    <a class="btn btn-sm btn-danger delete" data-route="{{route('admin.profile-activities.share-info-delete', $singleData->id)}}"><i class="fa fa-trash"></i></a> --}}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <table id="dataTable2" class="table table-sm table-bordered table-striped mt-4 mb-4">
                    <thead>
                        <tr>
                            <th width="8%">@lang('Serial')</th>
                            <th>@lang('Voter Area No, Name')</th>
                            <th>@lang('MP Name')</th>
                            <th width="10%" class="text-center">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (isset($allMemberData) && count($allMemberData) > 0)
                        @foreach ($allMemberData as $data)
                        <tr>
                            <td>{{ digitDateLang($loop->iteration) }}</td>
                            <td>
                                    @if(session()->get('language')=='bn')
                                    {{ digitDateLang($data->constituency->number) }} {{ $data->constituency->bn_name }}
                                    @else
                                    {{ digitDateLang($data->constituency->number) }} {{ $data->constituency->name }}
                                    @endif

                                </td>
                                <td>
                                    @if(session()->get('language')=='bn')
                                    {{ $data->name_bn }}
                                    @else
                                    {{ $data->name_eng }}
                                    @endif
                                </td>
                            <td class=" text-center">
                                <form action="{{ route('admin.profile-activities.share-info-entry', $singleData->id) }}" enctype="multipart/form-data">
                                    <input type="hidden" name="mp_id" value="{{$data->user_id}}">
                                    @php

                                    $share_status = DB::table('file_shares')->where('file_info_id',$share_id)->where('share_with',$data->user_id)->where('deleted_at', null)->first();
                                    @endphp

                                    @if($share_status)
                                    <button class="btn btn-sm btn-info" disabled><i class="fa fa-plus" aria-hidden="true"></i> @lang('Shared')</button>
                                    @else
                                    <button class="btn btn-sm btn-success pr-3 pl-3"><i class="fa fa-plus" aria-hidden="true"></i> @lang('Add')</button>
                                    @endif

                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#dataTable2').DataTable({

        });
    });

    function shareRemove(object, id) {
        var shareId = id;
        var mp_id = $('#mp_id').val();
        // alert(shareId + '==' + mp_id);
        $.ajax({
            type: "GET",
            url: '',
            data: {
                id: shareId,
                mp_id: mp_id
            },

            success: function(data) {
                if (data.status == 'success') {
                    // console.log(data.fileId);
                    // toastr.success("", "Issue Item Remove Successfully");
                } else if (data.status == 'error') {
                    toastr.error("", "Issue Item Unable to remove");
                } else {
                    toastr.error("", "Issue Item Unable to remove");
                }
            },
            error: function(err) {
                toastr.error("", "Issue Item Unable to remove");
            }
        });

    }
</script>

<script>
    $(document).on('click', '.delete', function() {
        var btn = this;
        //   alert('Yes');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            console.log(result);
            if (result.value) {
                var url = $(this).data('route');
                var mp_id = $('#mp_id').val();
                var _token = "{{csrf_token()}}";
                $.ajax({
                    url: url,
                    type: "delete",
                    data: {
                        _token: _token,
                        mp_id: mp_id
                    },
                    success: function(response) {
                        // console.log(response.status);
                        if (response.status == 'success') {
                            Swal.fire({
                                title: 'Delete',
                                text: "Data has been deleted!",
                                type: 'success'
                            }).then((result) => {
                                $(btn).closest('tr').fadeOut(1500);
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            });
                        } else {
                            Swal.fire('Data can not delete', '', 'error');
                        }
                    }
                });
            } else {
                Swal.fire('Your data is safe', '', 'success');
            }
        })
    });
</script>

@endsection