@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('For the Honorable Speaker')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Activities')</li>
                        <li class="breadcrumb-item active">@lang('Leave approval')</li>

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
                        <div class="card-body">
                            <div class="content">
                                <div class="col-md-12">
                                    <div class="card">
                                            <div class="card-header">
                                                <h6>@lang('Honorable Members of Parliament')</h6>
                                            </div>
                                        <div class="card-body" id="tabs">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="" data-toggle="tab"
                                                       href="#allpending_leave">@lang('All Approved Waiting List')</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="all_received_leave" data-toggle="tab"
                                                       href="#allApprovedLeave">@lang('All Approved leave List')</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="all_reject_leave" data-toggle="tab"
                                                       href="#allRejectedLeave">@lang('All Rejected Leave List')</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="allpending_leave">
                                                    <table id="my_notices_table"
                                                           class="table table-sm table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>@lang('Serial')</th>
                                                            <th width="15%">@lang('Constituency No., Name')</th>
                                                            <th width="20%">@lang('Name of Honorable Member')</th>
                                                            <th width="10%">@lang('From Date')</th>
                                                            <th width="10%">@lang('To Date')</th>
                                                            <th width="8%%">@lang('Total Leave')</th>
                                                            <th width="15%">@lang('Leave Reason')</th>
                                                            <th width="15%">@lang('Attachments')</th>
                                                            <th width="10%" class="text-center">@lang('Action')</th>
                                                        </tr>
                                                        </thead>


                                                        <tbody>
                                                        @foreach($allLeaves as $list)
                                                            <tr data-id="{{$list->id}}" data-note="{{$list->note}}">
                                                                <td>{{Lang::get($loop->iteration)}}</td>

                                                                <td class="text-center">
                                                                    {{digitDateLang(@$list->profileInfo['number'])}}
                                                                    {{(session()->get('language') =='bn')?(@$list->profileInfo['bn_name']):@$list->profileInfo['name']}}
                                                                </td>
                                                                <td>{{(session()->get('language') =='bn')?(@$list->profileInfo['name_bn']):@$list->profileInfo['name_eng']}}</td>
                                                                <td class="text-center">{{digitDateLang(date('d-m-Y', strtotime($list->from_date)))}}</td>
                                                                <td class="text-center">{{ digitDateLang(date('d-m-Y', strtotime($list->to_date)))}}</td>
                                                                <td class="text-center">{{digitDateLang($leave_t = round((strtotime($list->to_date)- strtotime($list->from_date)) / (60 * 60 * 24))+1)}}</td>
                                                                <td>{{(session()->get('language') == 'bn')?(@$list->holiday_reasons->name_bn):@$list->holiday_reasons->name}}</td>

                                                                <td class="text-center">
                                                                    @if ($list['attach_file'])
                                                                        <a href="{{ asset('public/backend/images/leave-file/'.$list['attach_file']) }}" target="_blank">
                                                                            <i class="fa fa-paperclip fa-2x" aria-hidden="true" style="color: #0c0c0c"></i>
                                                                        </a>
                                                                    @else
                                                                        <img src="{{ asset('public/backend/images/leave-file/defult-image.png') }}" width="120px" height="100" >
                                                                    @endif

                                                                </td>

                                                                <td class="text-center">
                                                                    <button style="background-color:#FFDA96" {{$list['status'] ==1? '': 'disabled'}} class="btn btn-sm  action_btn" data-id="{{$list->id}}">@lang('Action')</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="allApprovedLeave">
                                                    <table id="received_notices_table"
                                                           class="table table-sm table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th width="5%">@lang('Serial')</th>
                                                            <th width="15%">@lang('Constituency No., Name')</th>
                                                            <th width="20%">@lang('Name of Honorable Member')</th>
                                                            <th width="10%">@lang('From Date')</th>
                                                            <th width="10%">@lang('To Date')</th>
                                                            <th width="8%%">@lang('Total Leave')</th>
                                                            <th width="15%">@lang('Leave Reason')</th>
                                                            <th width="15%">@lang('Attachments')</th>
                                                            <th width="10%">@lang('Action')</th>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($allapproveLeaves as $list)
                                                            <tr>
                                                                <td>{{ digitDateLang($loop->iteration) }}</td>

                                                                <td class="text-center">
                                                                    <span>{{digitDateLang(@$list->profileInfo['number'])}} , </span>
                                                                    {{(session()->get('language') =='bn')?(@$list->profileInfo['bn_name']):@$list->profileInfo['name']}}
                                                                </td>
                                                                <td>{{(session()->get('language') =='bn')?(@$list->profileInfo['name_bn']):@$list->profileInfo['name_eng']}}</td>
                                                                <td>{{ digitDateLang(date('d-m-Y', strtotime($list->from_date)))}}</td>
                                                                <td>{{ digitDateLang(date('d-m-Y', strtotime($list->to_date)))}}</td>
                                                                <td>{{ digitDateLang($leave_t = round((strtotime($list->to_date)- strtotime($list->from_date)) / (60 * 60 * 24))+1)}}</td>
                                                                <td>{{(session()->get('language') == 'bn')?(@$list->holiday_reasons->name_bn):@$list->holiday_reasons->name}}</td>

                                                                <td class="text-center">
                                                                    @if ($list['attach_file'])
                                                                        <a href="{{ asset('public/backend/images/leave-file/'.$list['attach_file']) }}" target="_blank">
                                                                            <i class="fa fa-paperclip fa-2x" aria-hidden="true" style="color: #0c0c0c"></i>
                                                                        </a>
                                                                    @else
                                                                        <img src="{{ asset('public/backend/images/leave-file/defult-image.png') }}" width="120px" height="100" >
                                                                    @endif

                                                                </td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-success" href="{{url('profile-activities/leave-submit/approve-show-data',$list->id)}}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>

                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="tab-pane" id="allRejectedLeave">
                                                    <table id="rejected_notices_table"
                                                           class="table table-sm table-bordered table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th width="5%">@lang('Serial')</th>
                                                            <th width="15%">@lang('Constituency No., Name')</th>
                                                            <th width="20%">@lang('Name of Honorable Member')</th>
                                                            <th width="10%">@lang('From Date')</th>
                                                            <th width="10%">@lang('To Date')</th>
                                                            <th width="8%%">@lang('Total Leave')</th>
                                                            <th width="15%">@lang('Leave Reason')</th>
                                                            <th width="15%">@lang('Remarks')</th>
                                                            <th width="10%">@lang('Action')</th>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($all_reject_leave as $list)
                                                            <tr>
                                                                <td>{{ digitDateLang($loop->iteration) }}</td>

                                                                <td class="text-center">
                                                                    <span>{{digitDateLang(@$list->profileInfo['number'])}} , </span>
                                                                    {{(session()->get('language') =='bn')?(@$list->profileInfo['bn_name']):@$list->profileInfo['name']}}
                                                                </td>
                                                                <td>{{(session()->get('language') =='bn')?(@$list->profileInfo['name_bn']):@$list->profileInfo['name_eng']}}</td>
                                                                <td>{{ digitDateLang(date('d-m-Y', strtotime($list->from_date)))}}</td>
                                                                <td>{{ digitDateLang(date('d-m-Y', strtotime($list->to_date)))}}</td>
                                                                <td>{{ digitDateLang($leave_t = round((strtotime($list->to_date)- strtotime($list->from_date)) / (60 * 60 * 24))+1)}}</td>
                                                                <td>{{(session()->get('language') == 'bn')?(@$list->holiday_reasons->name_bn):@$list->holiday_reasons->name}}</td>


                                                                <td>{{$list->remarks}}</td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-success" href="{{url('profile-activities/leave-submit/reject-show-data',$list->id)}}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>

                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <!-- Modal -->
                                            <div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document" id="modal-wrapper">
                                                    <div style="background-color:#f1f1f1" class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-center ">
                                                           <h5 style="font-size: 1.2rem"> @lang('Honorable Member'): <span class="mp_name"></span></h5>
                                                            <h5 style="font-size: 1.2rem">@lang('Constituency'): <span class="seat_name"></span></h5>
                                                             <h5 style="font-size: 1.2rem">@lang('Leave Application') :
                                                                 <span class="from_date"></span>
                                                                 @lang('From') <span class="to_date"></span>
                                                                 @lang('Total'): <span class="total_leave"> @lang('Day')</span>
                                                             </h5>
                                                            <h5>@lang('Subject'): <span class="reason"></span></h5>
                                                            <h5>@lang('Notes') : </h5>

                                                            <p> <span class="note text-bold"></span></p>

                                                            <h5>@lang('Leave approval') : </h5>
                                                            <h6>@lang('Comments')</h6>
                                                            <textarea class="modal-textarea form-control remarks"></textarea>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button type="button" onclick="submitAction(2)" class="btn btn-success">@lang('Approved')</button>
                                                            <button type="button" onclick="submitAction(3)" class="btn btn-danger">@lang('Reject')</button>
                                                            <button type="button" data-dismiss="modal" class="btn btn-primary">@lang('List-return')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            $("#sortable").sortable({
                update: function (event, ui) {
                    var jsonSortable = [];
                    jsonSortable.length = 0;
                    $("#sortable tr").each(function (index, value) {
                        let item = {};
                        item.id = $(this).data("id");
                        jsonSortable.push(item);
                    });

                    var jsondata = JSON.stringify(jsonSortable);
                    $.ajax({
                        url: "",
                        type: "get",
                        data: {jsondata: jsondata},
                        dataType: 'json',
                        success: function (data) {

                        }
                    });
                }
            }).disableSelection();
        });

        var la_id;

        function submitAction(status){
            if(status && la_id){
                var data = { id: la_id, status: status, remarks: $('textarea.remarks').val() };
                $.ajax({
                    url : "{{ url('/profile-activities/leave-submit/leave-approval-submit') }}",
                    data : data,
                    type : "GET",
                    beforeSend : function(){
                        $('div#actionModal').modal('hide');
                        $('.preload').show();
                    },
                    success:function (data) {
                        if(data.status == 'success'){
                            toastr.success("",data.message);
                            $('.preload').hide();
                            setTimeout(function () {
                                window.top.location = window.top.location;

                            },2000);
                        }else if(data.status =='error'){
                            toastr.error("",data.message);
                            $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                            $('.preload').hide();
                        }else{
                            console.log(error);
                            toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
                            $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                            $('.preload').hide();
                        }
                    },
                    error:function (err) {
                        $('.preload').hide();
                        console.log(err);
                        $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                    }
                });
            }
        }

        $(document).ready(function(){
            $('button.action_btn').click(function(){
                la_id = $(this).closest('tr').data('id');
                var seat_name = $(this).closest('tr').find('td:nth-child(2)').text();
                var mp_name = $(this).closest('tr').find('td:nth-child(3)').text();
                var from_date = $(this).closest('tr').find('td:nth-child(4)').text();
                var to_date = $(this).closest('tr').find('td:nth-child(5)').text();
                var total_leave = $(this).closest('tr').find('td:nth-child(6)').text();
                var reason = $(this).closest('tr').find('td:nth-child(7)').text();
                var note = $(this).closest('tr').data('note');
                $('span.seat_name').text(seat_name);
                $('span.mp_name').text(mp_name);
                $('span.from_date').text(from_date);
                $('span.to_date').text(to_date);
                $('span.total_leave').text(total_leave);
                $('span.reason').text(reason);
                $('span.note').text(note);
                $('div#actionModal').modal('show');
            });
        });

        $(function(){
            $("#tabs").tabs({
                event:"click"
            })
        });


    </script>
@endsection
