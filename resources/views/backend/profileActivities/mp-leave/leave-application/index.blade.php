@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h6>@lang('MP Leave')</h6>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Activities')</li>
                        <li class="breadcrumb-item active">@lang('Leave List')</li>

                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-dark float-left">@lang('MP Leave List')</h5>
                            <a href="{{route('admin.profile-activities.mp-leave.leave-application.create')}}"
                               class="btn btn-sm btn-info float-right"><i class="fas fa-plus mr-2"></i>@lang('Leave Application')
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-sm table-bordered table-striped mb-4">
                                <thead>
                                    <tr>
                                        <th width="5%">@lang('Serial')</th>
                                        <th width="10%">@lang('Application Date')</th>
                                        <th>@lang('From Date')</th>
                                        <th>@lang('To Date')</th>
                                        <th width="8%">@lang('Total Leave')</th>
                                        <th>@lang('Leave Reason')</th>
                                        <th>@lang('Status')</th>
                                        <th width="12%" class="text-center">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" class="sortable">

                                <?php
                                    $total_sum = 0;
                                ?>
                                @foreach($allLeaves as $list)
                                    <tr data-id="{{$list->id}}">
                                        <td>{{ digitDateLang($loop->iteration)}}</td>

                                        <td class="text-center">
                                            {{ $list->submission_date != null ? digitDateLang(date('d-m-Y',strtotime($list->submission_date))) : '--' }}
                                        </td>

                                        <td>{{ digitDateLang(date('d-m-Y', strtotime($list->from_date)))}}</td>
                                        <td>{{ digitDateLang(date('d-m-Y', strtotime($list->to_date)))}}</td>
                                        <td>{{digitDateLang($leave_t = round((strtotime($list->to_date)- strtotime($list->from_date)) / (60 * 60 * 24))+1)}}</td>
                                        <td>{{(session()->get('language') == 'bn')?(@$list->holiday_reasons->name_bn):@$list->holiday_reasons->name}}</td>

                                        @if($list->status==0)
                                            <td> @lang('Waiting to send')</td>
                                        @elseif($list->status==1)
                                            <td>@lang('Waiting for approval')</td>
                                        @elseif($list->status==2)
                                            <td>@lang('Approved')</td>
                                        @elseif($list->status==3)
                                            <td>@lang('Reject')</td>
                                        @else
                                            <td></td>
                                        @endif


                                        @if($list->status==0)
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-success" href="{{route('admin.profile-activities.mp-leave.leave-application.edit',$list)}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn btn-sm btn-success" href="{{route('admin.profile-activities.mp-leave.leave-application.show',$list->id)}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.profile-activities.mp-leave.leave-application.destroy',$list->id)}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        @elseif($list->status==1)
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-success" href="{{route('admin.profile-activities.mp-leave.leave-application.show',$list->id)}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                {{-- <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.profile-activities.mp-leave.leave-application.destroy',$list->id)}}">
                                                    <i class="fa fa-trash"></i>
                                                </a> --}}
                                            </td>
                                        @elseif($list->status==2)
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-success" href="{{route('admin.profile-activities.mp-leave.leave-application.show',$list->id)}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                {{-- <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.profile-activities.mp-leave.leave-application.destroy',$list->id)}}">
                                                    <i class="fa fa-trash"></i>
                                                </a> --}}
                                            </td>
                                        @elseif($list->status==3)
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-success" href="{{route('admin.profile-activities.mp-leave.leave-application.show',$list->id)}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                {{-- <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.profile-activities.mp-leave.leave-application.destroy',$list->id)}}">
                                                    <i class="fa fa-trash"></i>
                                                </a> --}}
                                            </td>
                                        @else
                                            <td></td>
                                        @endif



                                    </tr>
                                    <?php
                                        if($list->status==2){
                                            $total_sum = $total_sum + $leave_t;
                                        }
                                    ?>
                                @endforeach
                                </tbody>
                            </table>
                            <span class="mt-2">@lang('Total Approved Leave Received') : {{Lang::get($total_sum)}} @lang('Days')</span>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(function(){
            $("#sortable").sortable({
                update:function(event, ui){
                    var jsonSortable = [];
                    jsonSortable.length = 0;
                    $("#sortable tr").each(function (index, value){
                        let item = {};
                        item.id = $(this).data("id");
                        jsonSortable.push(item);
                    });

                    var jsondata = JSON.stringify(jsonSortable);
                    $.ajax({
                        url: "",
                        type: "get",
                        data: {jsondata:jsondata},
                        dataType: 'json',
                        success: function (data) {

                        }
                    });
                }
            }).disableSelection();
        })
    </script>
@endsection
