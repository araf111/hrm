@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Attendance Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Attendance Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        {{-- <div class="card-header text-right">
                        <a href="{{route('admin.attendance.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Add Attendance')</a>
                    </div> --}}
                        <div class="card-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item" >
                                    <a class="nav-link active" id="list_order_button" data-toggle="tab"
                                        href="#list_import" style="border: none;">@lang('List Attendance')</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane container active" id="list_import">
                                    <div class="row">
                                        {{-- 3 columns with summary will be here.... --}}
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-1"
                                            for="list_parliament_session_id">@lang('Date')<span
                                                style="color: red;"></span></label>
                                        <div class="col-3">
                                            <div id="reportrange"
                                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                        <div class="col-4 d-none">
                                            <input type="hidden" name="list_mp_id" id="list_mp_id" value="{{authInfo()->id}}">
                                        </div>
                                        <div class="col-2">
                                            <select name="parliament_session_id" id="parliament_session_id" readonly
                                                class="form-control select2" style="width:100%">
                                                <option value="">@lang('Parliament Session')</option>
                                                @foreach ($session_list as $s)
                                                    <option value="{{ $s->id }}">{{ $s->session_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-info" onClick="load_data()">@lang('Show Attendances')</button>
                                        </div>
                                    </div>
                                    <div id="list_container">
                                        <table id="list_import_table" class="table table-sm table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>@lang('Date')</th>
                                                    <th>@lang('MP')</th>
                                                    <th>@lang('Check Type')</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <script>
        $(document).ready(function() {
            setTimeout(function(){
                load_data();
            },1000);
            setTimeout(function(){
                $('#reservationdate, #list_order_date, #importDate').datetimepicker({
                    format: 'DD-MM-YYYY',
                    maxDate: "{{ date('Y-m-d') }}"
                });
            }, 4000);
            
            $(".readonly_date").keypress(function(e) {
                return false;
            });
            $(".readonly_date").keydown(function(e) {
                return false;
            });

            $('#checkin_timepicker, #checkout_timepicker').datetimepicker({
                format: 'LT'
            })
        });

        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $('#import_file_upload').submit(function(e) {
                console.log('click upload');
                e.preventDefault();
                var formData = new FormData(this);
                //formData.append('import_date', $("#import_date").val());
                $('#load_container').html(
                    '<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/admin/attendance/import-attendance') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        this.reset();
                        if (data.success) {
                            Swal.fire('@lang("Data Imported Successfully")', '', 'success');
                        } else {
                            Swal.fire('@lang("something wrong")', '', 'warning');
                        }
                    },
                    error: function(data) {
                        $('#import_container').html('<center>something wrong</center>');
                    }
                });

            });
            $('#maunal_entry').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                //formData.append('import_date', $("#import_date").val());
                $('#load_container').html(
                    '<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/admin/attendance/save-attendance') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        //this.reset();
                        if (data.success) {
                            Swal.fire({
                                title: '@lang("Data Saved Successfully")',
                                type: 'success'
                            }).then((result) => {
                                $("#add_order_button").click();
                            });
                        } else {
                            Swal.fire('@lang("something wrong")', '', 'warning');
                        }
                    },
                    error: function(data) {
                        $('#import_container').html('<center>something wrong</center>');
                    }
                });

            });
        });

        function load_data() {
            $('#list_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
            $.ajax({
                url: "{{ url('/admin/attendance/list-attendance') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    date: nanoLangTranslate($('#reportrange').text().trim(),'en'),
                    mp_id: $("#list_mp_id").val(),
                    parliament_session_id: $("#parliament_session_id").val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == true) {
                        $('#list_container').html(response.data);
                        $("#list_orders_table").DataTable({

                        });
                    } else {
                        //Swal.fire('@lang("No Data Found")', '', 'error');
                        $('#list_container').html('<p><center>@lang("No Data Found")</center></p>');
                    }
                }
            });

        }
    </script>

    <script type="text/javascript">
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb_range(start, end) {
                @if(session()->get('language')=='bn')
                $('#reportrange span').html(nanoLangTranslate(start.format('D-MM-YYYY')) + ' ~ ' + nanoLangTranslate(end.format('D-MM-YYYY')));
                @else
                $('#reportrange span').html(start.format('D-MM-YYYY') + ' ~ ' + end.format('D-MM-YYYY'));
                @endif
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                singleDatePicker: false,
                locale: daterange_locale,
                ranges: daterange_ranges
            }, cb_range);
            cb_range(start, end);

        });
    </script>

@endsection
