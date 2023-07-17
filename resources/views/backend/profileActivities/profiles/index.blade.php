@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Profile Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="myloader d-none"></div>
    <div class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">@lang('Parliament Member List')
                        <a href="{{ route('admin.profile-activities.v2profiles.create') }}"
                            class="btn btn-info float-right"><i class="fa fa-plus mr-2"></i> @lang('Add Parliament
                            Member')</a>
                    </h4>
                    <h4 class="card-title w-100">
                        <a href="#" class="btn btn-success float-right mt-2">@lang('Update Information')</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable_test" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>@lang('Serial')</th>
                                    <th>@lang('Name')</th>
                                    {{-- <th>@lang('Constituency')</th> --}}
                                    <th>@lang('Bangladesh No.')</th>
                                    {{-- <th>@lang('Ministry')</th> --}}
                                    <th>@lang('Parliament No.')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($allData) && count($allData) > 0)
                                    @foreach ($allData as $data)
                                        <tr>
                                            <td>{{ digitDateLang($loop->iteration) }}</td>
                                            <td>
                                                @if (session()->get('language') == 'bn')
                                                    {{ $data->nameBng }}
                                                @else
                                                    {{ $data->nameEng }}
                                                @endif
                                            </td>
                                            {{-- <td>{{ $data['constituency']->name }}</td> --}}
                                            <td>{{ digitDateLang($data->constituencyNumber) }}</td>
                                            {{-- <td>{{ $data['ministryInfo']->name_bn }}</td> --}}
                                            <td>{{ Lang::get('12th') }}</td>
                                            <td>{!! activeStatus($data->status) !!}</td>
                                            <td>
                                                <a href="{{ route('admin.profile-activities.v2profiles.edit', $data->profileID) }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.profile-activities.v2profiles.show', $data->profileID) }}"
                                                    class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                                    <button type="button" class="btn btn-info" onClick="load_report('pdf','{{$data->profileID}}')">@lang('PDF')</button>
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
    </div>
    <script>
        $(document).ready(function() {
            $("#dataTable_test").dataTable({
                "ordering": false
               /*  aoColumnDefs: [{
                    bSortable: true,
                    aTargets: [2]
                }] */

            })
        })
    </script>
     <script>
        function load_report(type,id) {
            console.log(type,id);
            if (type == 'pdf') {
                my_loader('start');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    }
                });
                $.ajax({
                    type: "POST",
                    crossDomain: true,
                    data: JSON.stringify({
                        doctype:type,
                        profile_id:id
                    }),
                    url: "{{url('/profile-activities/profiledoc')}}",
                    contentType: "application/json",
                    success: function(data) {
                        const linkSource = data;
                        const downloadLink = document.createElement("a");
                        const fileName = "profile_"+id+".pdf";
                        downloadLink.href = linkSource;
                        //window.location.href = downloadLink;
                        downloadLink.download = fileName;
                        downloadLink.click();
                        my_loader('stop');
                    },
                    error:function(res){
                        my_loader('stop');
                    }
                });
            } else {
                
            }

        }
    </script>
@endsection
