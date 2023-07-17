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
                    <li class="breadcrumb-item active">@lang('My Files')</li>
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
                    <a href="{{ route('admin.profile-activities.file-info.create') }}" class="btn btn-info float-right"><i class="fa fa-plus mr-2"></i> @lang('File Add')</a>
                </h4>
            </div>
            <div class="tab-vertical">
                <ul class="nav nav-tabs" id="myTab3" role="tablist">

                    <li class="nav-item"> <a class="nav-link active" id="filelist-tab" data-toggle="tab" href="#filelist" role="tab" aria-controls="profile" aria-selected="false">@lang('File List')</a> </li>

                    <li class="nav-item"> <a class="nav-link" id="ownsharedfile-tab" data-toggle="tab" href="#ownsharedfile" role="tab" aria-controls="home" aria-selected="true">@lang('List of Files Shared with Me')</a> </li>
                </ul>
                <div class="tab-content pt-0" id="myTabContent3 pt-0">
                    <div class="tab-pane fade show active" id="filelist" role="tabpanel" aria-labelledby="filelist-tab">
                        <div class="filelist-wrap">
                            <div class="card-body">
                                <div class="bar_wrap">
                                    <div class="bar_inner" style="float:right;">
                                        <div class="progress_bar mb-2" style="width:100%;height:15px;background:#E0E0E0;border-radius:15px;">
                                            <div class="inner_dive" style="{{$style}}"></div>
                                        </div>
                                        @php
                                        $tAllowance_bn = digitDateLang($tAllowance);
                                        $tUsed_bn = digitDateLang($tUsed);

                                        @endphp
                                        @if(session()->get('language')=='bn')
                                        <h4 class="text-left mb-2" style="font-weight:normal;font-size:13px;"><span style="color:#59C478">{{digitDateLang($totalLimitMB)}}</span> @lang('In MB') <span style="color:#59C478"> {{digitDateLang($tUsed)}}</span> @lang('MB used') <span style="color:#59C478">({{digitDateLang($complete)}}</span> @lang('full'))</h4>
                                        @else
                                        <h4 class="text-left mb-2" style="font-weight:normal;font-size:13px;"><span style="color:#59C478">{{$totalLimitMB}}</span>MB of <span style="color:#59C478">{{$tUsed}}</span>MB used <span style="color:#59C478">({{$complete}}</span> @lang('full'))</h4>
                                        @endif
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('Serial')</th>
                                                <th>@lang('File Name')</th>
                                                <th>@lang('Category')</th>
                                                <th>@lang('Date')</th>
                                                <th>@lang('File Type')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($allData) && count($allData) > 0)
                                            @foreach ($allData as $data)
                                            <tr>
                                                <td>{{ digitDateLang($loop->iteration) }}</td>

                                                <td>{{ $data->file_name }}</td>
                                                <td>
                                                    @if(session()->get('language')=='bn')
                                                    {{ $data->fileCategory->category_name_bn }}
                                                    @else
                                                    {{ $data->fileCategory->category_name_en }}
                                                    @endif
                                                </td>
                                                <td>{{ digitDateLang(date('d-m-Y', strtotime($data->created_at)))}}
                                                </td>
                                                <td style="text-align:center;">
                                                    @php
                                                    $info = new SplFileInfo($data->attachment);
                                                    $ext = $info->getExtension();
                                                    @endphp
                                                    .{{$ext}}

                                                    <a href="{{asset('public/backend/file_category_name/'.$data->attachment)}}" target="_blank" class="btn btn-sm btn-info">View</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.profile-activities.file-info.edit',$data->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                                                    {{-- <a href="javascript:;" class="btn btn-sm btn-danger destroy" onclick="fileRemove(this, {{$data->id}})"><i class="fa fa-trash"></i></a> --}}

                                                    <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.profile-activities.file-info.destroy', $data->id)}}"><i class="fa fa-trash"></i></a>

                                                    <a href="{{route('admin.profile-activities.file-share', $data->id)}}" class="btn btn-sm btn-info"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End Card Body  -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ownsharedfile" role="tabpanel" aria-labelledby="ownsharedfile-tab">
                        <div class="sharefilelist-wrap">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>@lang('Serial')</th>
                                                <th>@lang('File Name')</th>
                                                <th>@lang('Honorable Member of Parliament who shared')</th>
                                                <th>@lang('File Type')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($ownShared) && count($ownShared) > 0)
                                            @foreach ($ownShared as $data)
                                            <tr>
                                                <td>{{ digitDateLang($loop->iteration) }}</td>

                                                <td>{{ $data->file_name }}</td>
                                                <td>
                                                    @php
                                                    $name = DB::table('profiles')->where('user_id', $data->mp_id)->first();
                                                    @endphp
                                                    {{ $name->name_bn }}
                                                </td>
                                                <td style="text-align:center;">
                                                    @php
                                                    $info = new SplFileInfo($data->attachment);
                                                    $ext = $info->getExtension();
                                                    @endphp
                                                    .{{$ext}}
                                                </td>
                                                <td>
                                                    <a href="{{asset('public/backend/file_category_name/'.$data->attachment)}}" target="_blank" class="btn btn-sm btn-info">View</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End Card Body  -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function fileRemove(object, id) {
        var fileId = id;
        // alert(id);
        $.ajax({
            type: "GET",
            url: "{{route('admin.profile-activities.file-delete')}}",
            data: {
                id: fileId
            },

            success: function(data) {
                if (data.status == 'shared') {
                    toastr.info("", "This File Already Shared. So, You Can Not Delete this File");
                } else if (data.status == 'success') {
                    toastr.success("", "This File Item Successfully removed");
                    window.setTimeout(function() {
                        window.location.reload()
                    }, 1000);
                } else {
                    toastr.error("", "File Item Unable to remove");
                }
            },
            error: function(err) {
                toastr.error("", "File Item Unable to remove");
            }
        });

    }
</script>
@endsection