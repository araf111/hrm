@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Telephone/Pabx Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Telephone/Pabx Management')</li>
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
                </div>
                <div class="tab-vertical">
                        <ul class="nav nav-tabs" id="myTab3" role="tablist">

                            <li class="nav-item"> <a class="nav-link active" id="filelist-tab" data-toggle="tab" href="#filelist" role="tab" aria-controls="profile" aria-selected="false">@lang('Applications for awaiting Approval')</a> </li>

                            <li class="nav-item"> <a class="nav-link" id="ownsharedfile-tab" data-toggle="tab" href="#ownsharedfile" role="tab" aria-controls="home" aria-selected="true">@lang('Approved Applications')</a> </li>
                        </ul>
                        <div class="tab-content pt-0" id="myTabContent3 pt-0">
                            <div class="tab-pane fade show active" id="filelist" role="tabpanel" aria-labelledby="filelist-tab">
                                <div class="filelist-wrap">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="dataTable" style="font-size:12px !important">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">@lang('Serial')</th>
                                                        <th>@lang('Applicant Name')</th>
                                                        <th>@lang('Connection Type')</th>
                                                        <th>@lang('Connection Place')</th>
                                                        <th>@lang('Application Date')</th>
                                                        <th>@lang('Approved by Admin Date')</th>
                                                        <th>@lang('Action')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($applyData) && count($applyData) > 0)
                                                        @foreach ($applyData as $data)
                                                    
                                                        <tr>
                                                            <td>{{ digitDateLang($loop->iteration) }}</td>  
                                                            <td>
                                                                @foreach ($profiles as $p)                                                                   
                                                                    @if ($p->user_id == $data->applicant_id)
                                                                        @if (session()->get('language') == 'bn')
                                                                            {{ digitDateLang($p->bangladesh_number) }}, {{ $p->voter_area_bng }}, {{ $p->nameBng }}
                                                                        @else 
                                                                            {{ $p->bangladesh_number }}, {{ $p->voter_area_eng }}, {{ $p->nameEng }}
                                                                        @endif
                                                                    
                                                                    @endif                                                                    
                                                                @endforeach  
                                                            </td>                                          
                                                            <td>{{ ($data->connection_type == 1) ? __('Telephone') : __('PABX')}}</td>
                                                            <td>{{ ($data->connection_place == 1) ? __('Office') : __('Residence')}}</td>                                                            
                                                            <td>{{ digitDateLang(nanoDateFormat($data->created_at))}}</td>
                                                            <td>{{ digitDateLang(nanoDateFormat($data->created_at))}}</td>
                                                            <td>
                                                                {{-- <a href="{{ route('admin.mp-id-card-application.serial_no-pdf',$data->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> @lang('See')</i></a> --}}
                                                                <a href="{{ route('admin.requisition.application-approval-deputy-action',$data->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i> @lang('Approval')</i></a>

                                                                {{-- <button type="button" class="btn btn-primary for_approval" data-toggle="modal" data-target="#exampleModal" onClick="getData(this,'{{$data['id']}}')"><i class="fas fa-paper-plane"></i> @lang('Approval')</button> --}}

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
                                            <table class="table table-bordered table-striped" id="dataTable" style="font-size:12px !important">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">@lang('Serial')</th>
                                                        <th>@lang('Applicant Name')</th>
                                                        <th>@lang('Connection Type')</th>
                                                        <th>@lang('Connection Place')</th>
                                                        <th>@lang('Application Date')</th>
                                                        <th>@lang('Approved by Admin Date')</th>
                                                        <th>@lang('Approved by Deputy Secretary Date')</th>
                                                        {{-- <th>@lang('Action')</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (isset($approveData) && count($approveData) > 0)
                                                        @foreach ($approveData as $data)
                                                        <tr>
                                                            <td>{{ digitDateLang($loop->iteration) }}</td>                                                            
                                                            <td>
                                                                @foreach ($profiles as $p)                                                                   
                                                                    @if ($p->user_id == $data->applicant_id)
                                                                        @if (session()->get('language') == 'bn')
                                                                            {{ digitDateLang($p->bangladesh_number) }}, {{ $p->voter_area_bng }}, {{ $p->nameBng }}
                                                                        @else 
                                                                            {{ $p->bangladesh_number }}, {{ $p->voter_area_eng }}, {{ $p->nameEng }}
                                                                        @endif
                                                                    
                                                                    @endif                                                                    
                                                                @endforeach  
                                                            </td>                                            
                                                            <td>{{ ($data->connection_type == 1) ? __('Telephone') : __('PABX')}}</td>
                                                            <td>{{ ($data->connection_place == 1) ? __('Office') : __('Residence')}}</td>                                                          
                                                            <td>{{ digitDateLang(nanoDateFormat($data->created_at))}}</td>
                                                            <td>{{ digitDateLang(nanoDateFormat($data->created_at))}}</td>
                                                            <td>{{ digitDateLang(nanoDateFormat($data->created_at))}}</td>
                                                            {{-- <td>
                                                                <a href="{{ route('admin.mp-id-card-application.serial_no-pdf',$data->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> @lang('See')</i></a>
                                                            </td> --}}
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
                    {{-- <form method="GET" action="{{ route('admin.mp-id-card-application.application-approaval-action',$data->id) }}" enctype="multipart/form-data"> --}}
                    <form method="GET" action="{{ route('admin.mp-id-card-application.application-approaval-action') }}" enctype="multipart/form-data">
                    <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">@lang('Approval')</button>
                                        <button type="button" name="draft" value="" class="btn btn-warning btn-sm"><a href="{{route('admin.mp-id-card-application.application-approval')}}">@lang('Back To list')</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>

@endsection

    @section('script')
    <script>
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    </script>
    <script>
        function getData(object, id){
            var app_id = id;
            // alert('hi');
            $.ajax({
                type : "GET",
                url : "{{route('admin.requisition.application-approaval-modal')}}",
                data : {id : app_id},

                success:function (data) {
                    // console.log(data);
                    $(".modal-body").html(data);
                    if(data.status == 'success'){
                        console.log('success');
                        // toastr.success("","Issue Item Remove Successfully");
                    }else if(data.status =='error'){
                        // toastr.error("","Issue Item Unable to remove");
                        console.log('error');
                    }else{
                        // toastr.error("","Issue Item Unable to remove");
                        console.log('error2');
                    }
                },
                error:function (err) {
                    // toastr.error("","Issue Item Unable to remove");
                    console.log(data);
                    console.log('error3');
                }
            });

        }
    </script>
@endsection
