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
<div id="main_content">
    <div class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>@lang('All Applications')</h4>
                </div>

                <div class="card-body">

                    <table id="other_records" class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">@lang('Serial')</th>
                                <th width="15%">@lang('Applicant Name')</th>
                                <th width="15%">@lang('Connection Type')</th>
                                <th width="15%">@lang('Connection Place')</th>
                                <th width="13%">@lang('Application Date')</th>
                                <th width="12%">@lang('Status')</th>
                                <th width="10%" class="text-center">@lang('Action')</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="details_content" class="content">

</div>
<script>
    var selected_items = [];
    var selected_stages = [];
    var selected_consent = '';
    $(document).ready(function() {
        load_data('other_records');     
    });

    function load_data(type) {
        var given_date = ($("#datepicker_search").val() != '') ? $("#datepicker_search").val() : '';
        var table_id = '';
        selected_items = [];
        selected_stages = [];
        selected_consent = '';
        table_id = 'other_records';
        console.log('table id: ' + table_id);
        var table = $('#' + table_id).DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            filter: true,
            ajax: {
                url: "{{ url('requisition/telephone_pabx_list') }}",
                dataType: "json",
                type: "GET",
                data: {
                    _token: "{{csrf_token()}}",
                }
            },
            "columnDefs": [{
                "orderable": false,
                "targets": [0],
            }],
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'applicant_id',
                    name: 'applicant_id'
                },
                {
                    data: 'connection_type',
                    name: 'connection_type'
                },
                {
                    data: 'connection_place',
                    name: 'connection_place'
                },
                {
                    data: 'date',
                    name: 'Date'
                },
                {
                    data: 'status',
                    name: 'Status'
                },
                {
                    data: 'action',
                    name: 'Action'
                },
            ]
        });

        $(document).on('click', '.select_data', function() {
            if (this.checked == false) {
                if (selected_items.indexOf($(this).data('id')) > -1) {
                    selected_items.splice(selected_items.indexOf($(this).data('id')), 1);
                }
                let index = selected_stages.map((item) => item.id).indexOf($(this).data('id'));
                if (index > -1) {
                    selected_stages.splice(index, 1);
                }
            } else {
                selected_items.push($(this).data('id'));
                selected_stages.push({
                    id: $(this).data('id'),
                    stage: $(this).data('stage')
                });
            }
            let ids = selected_stages.map(o => o.id);
            selected_stages = selected_stages.filter(({
                id
            }, index) => !ids.includes(id, index + 1));
            console.log(selected_stages);
        });
    }

    function view_data(id) {
        $('#main_content').hide();
        $('#details_content').show();
        $('#details_content').html('<center><img src="{{asset("public/images/lottery.gif")}}"></center>');
        $.ajax({
            url: "{{url('requisition/telephone_pabx_details/')}}/view/" + id,
            type: "GET",
            data: {
                _token: "{{csrf_token()}}",
                id: id
            },
            success: function(response) {
                //show details div
                $('#details_content').html(response);
            },
            error: function() {
                Swal.fire('@lang("Data Not Found!")', '', 'error');
                $('#main_content').show();
                $('#details_content').hide();
            }
        });
    }


    function go_back() {
        $('#main_content').show();
        $('#details_content').hide();
    }

    // function giveMassConsent() {
    //     Swal.fire({
    //         title: '@lang("Are You Sure?")',
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: '@lang("YES")',
    //         cancelButtonText: '@lang("NO")'
    //     }).then((result) => {
    //         if (result.value) {
    //             var url = "{{url('/admin/petition-management/setdata')}}";
    //             var _token = "{{csrf_token()}}";
    //             $.ajax({
    //                 url: url,
    //                 type: "POST",
    //                 data: {
    //                     _token: _token,
    //                     type: 'mass_consent',
    //                     id: selected_items,
    //                     //total_stage: '',
    //                     id_stages: selected_stages,
    //                     rule_number: 102,
    //                     user_consent: selected_consent,
    //                     stage_note: $("#stage_note").val()
    //                 },
    //                 success: function(response) {
    //                     if (response == 1) {
    //                         Swal.fire({
    //                             title: '@lang("Your Consent has been sent")',
    //                             type: 'success'
    //                         }).then((result) => {
    //                             location.reload();
    //                         });
    //                     } else {
    //                         Swal.fire('@lang("Technical Problem!")', '', 'error');
    //                     }
    //                 }
    //             });
    //         } else {
    //             //Swal.fire('Your data is safe', '', 'success');
    //         }
    //     })
    // }

</script>

<!-- The Modal -->
{{-- <div class="modal" id="consentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">@lang('Consent')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div id="consent_loader" class="d-none">
                    <center><img src="{{asset("public/images/lottery.gif")}}"></center>
                </div>
                <div id="consent_conent">
                    <div class="form-group" id="comment_container">
                        <div class="row">
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                <label class="control-label" for="stage_note">@lang('Comments')</label>
                            </div>
                            <div class="col-sm-12 col-md-10 col-lg-10">
                                <textarea id="stage_note" name="stage_note" class="form-control textareaWithoutImgVideo">

                                    </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p style="text-align:center;">
                            <a class="btn btn-lg btn-secondary consent_button" data-id="1">
                                <i class="fa fa-check"> </i> @lang('Agree')
                            </a>
                            &nbsp; &nbsp;
                            <a class="btn btn-lg btn-secondary consent_button" data-id="0">
                                <i class="fa fa-times"> </i> @lang('Disagree')
                            </a>
                        </p>

                    </div>
                    <div class="form-group" id="comment_container">
                        <div class="row">
                            <button type="buton" class="btn btn-success btn-sm" data-route="{{url('/admin/notice-management/notices/notice/setdata')}}" onClick="giveMassConsent()" style="margin:0 auto;">@lang('Submit')</button>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <!-- <button type="button" id="confirm_lottery" class="btn btn-info float-right d-none" onClick="start_lottery()">@lang('Confirm')</button> -->
                <button type="button" class="btn btn-danger float-left" data-dismiss="modal">@lang('Close')</button>
            </div>

        </div>
    </div>
</div> --}}
@endsection