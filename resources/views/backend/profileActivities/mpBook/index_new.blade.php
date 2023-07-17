@extends('backend.layouts.app')
@section('content')
<style>
    @media print {
    .myDivToPrint {
        background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
    }
    .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate{
        display:none !important;
    }
}
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('MP Book Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('MP Book Management')</li>
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
                        <div class="row" style="padding: 15px;">
                            <div class="col-sm-3">
                                <input type="radio" id="male" name="gender" value="male">
                                <label id="first_item" for="male">@lang('Honorable Member of Parliament')</label><br>
                            </div>
                            <div class="col-sm-3">
                                <input type="radio" id="female" name="gender" value="male">
                                <label for="male">@lang('Parliamentary Officer / Employee')</label><br>
                            </div>
                        </div>

                        <div class="card-body" id="parlament_div" style="display:none">
                            {{-- <form method="get" action="{{ url('mppbook') }}"> --}}
                            <form id="mppbook">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('Parliament')</label>
                                        <select name="parliament_id" id="parliament_id" readonly
                                            class="form-control select2" style="width:100%">
                                            @foreach ($parliament_list as $p)
                                                <option value="{{ $p->parliament_number }}" @if ($p->parliment_number == $current_parliament_number) {{ 'selected' }} @endif>
                                                    {{ $p->parliament_number_bn }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('Bangladesh Number')</label>
                                        <input type="text" class="form-control form-control-sm" id="bd_no" name="bd_no"
                                            placeholder="@lang('Bangladesh Number')">
                                        {{-- <select name="designation_id" id="" class="form-control form-control-sm @error('designation_id') is-invalid @enderror">
                                            {!! designationDropdown() !!}
                                        </select> --}}
                                        @error('designation_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-3">
                                        <label for="" class="control-label">@lang('Division')</label>
                                        <select name="division_id" id="division_id"
                                            class="form-control select2  form-control-sm @error('division_id') is-invalid @enderror"
                                            style="width:100%;">
                                            {!! divisionDropdown() !!}
                                        </select>
                                        @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('District')</label>
                                        <select name="district_id" id="district_id"
                                            class="form-control select2  form-control-sm @error('district_id') is-invalid @enderror"
                                            style="width:100%;">
                                            <option value="">@lang('District')</option>
                                        </select>
                                        @error('district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('Constituency')</label>
                                        <select name="constituency_id" id="constituency_id"
                                            class="form-control select2  form-control-sm @error('constituency_id') is-invalid @enderror"
                                            style="width:100%;">
                                            <option value="">@lang('Constituency')</option>
                                        </select>
                                        @error('constituency_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2" style="display:none">
                                        <label for="" class="control-label">@lang('Search by Name')</label>
                                        <input type="text" name="search_by"
                                            class="form-control form-control-sm @error('search_by') is-invalid @enderror"
                                            placeholder="@lang('Enter Name')">

                                        @error('search_by')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-1 mt-4">
                                        <button type="button" onclick="load_data()" class="btn btn-success btn-sm mt-2"
                                            style="padding-top: 0px !important;">@lang('Search')</button>
                                    </div>

                                </div>
                            </form>
                            <div class="clearfix">
                                &nbsp;
                            </div>
                            <div class="myloader d-none"></div>
                            <div id="list_container" class="myDivToPrint">
                                <div class="col-12 text-center">
                                    
                                        {{-- <button id="printable_version" class="btn btn-info d-none" onclick="PrintElem('list_container');" >Printable Version</button> --}}

                                </div>
                                <div class="clerafix">&nbsp;</div>
                                <table id="list_mp_table" class="table  table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>@lang("Serial")</th> --}}
                                            <th style="width:25%">@lang("Name")</th>
                                            <th>@lang("Bangladesh No.")</th>
                                            <th>@lang("Constituency")</th>
                                            <th>@lang("Phone")</th>
                                            <th class="overflow_text_column">@lang("Address")</th>
                                            <th>@lang("Action")</th>
                                        </tr>
                                    </thead>

                                </table>
                                <div class="clearfix">&nbsp;</div>
                                <div class="text-center">
                                    <button type="button" id="printable_version" class="btn btn-info d-none" onClick=load_all_report('pdf')>
                                        @lang("All Profile")</button>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card-body" id="employee_div" style="display:none">
                            <form method="POST" action="{{ route('admin.profile-activities.mpbooks.index') }}">
                                @csrf
                                <div class="form-row">

                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('Wings')</label>
                                        <select name="designation_id" id=""
                                            class="form-control form-control-sm @error('designation_id') is-invalid @enderror">
                                            <option value="">@lang('Select Wings')</option>
                                        </select>
                                        @error('designation_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('Branches')</label>
                                        <select
                                            class="form-control form-control-sm @error('division_id') is-invalid @enderror">
                                            <option value="">@lang('Select Branches')</option>
                                        </select>
                                        @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-2">
                                        <label for="" class="control-label">@lang('Division')</label>
                                        <select
                                            class="form-control form-control-sm @error('district_id') is-invalid @enderror">
                                            <option value="">@lang('Select Division')</option>
                                        </select>
                                        @error('district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="form-group col-sm-2 mt-4">
                                        <button type="button"
                                            class="btn btn-success btn-sm mt-2 px-4">@lang('Search')</button>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>


@endsection
@section('script')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $("#first_item").trigger('click');
            }, 1000);
        });

        document.getElementById("male").addEventListener("click", function() {
            document.getElementById("employee_div").style.display = "none"
            document.getElementById("parlament_div").style.display = "block"
        });

        document.getElementById("female").addEventListener("click", function() {
            document.getElementById("parlament_div").style.display = "none"
            document.getElementById("employee_div").style.display = "block"
        });
    </script>
    <script>
        function load_data() {
            var table = $('#list_mp_table').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                filter: true,
                ajax: {
                    url: "{{ url('/profile-activities/listmp/mpbook') }}",
                    dataType: "json",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        bd_no: $('#bd_no').val(),
                        division_id: $("#division_id").val(),
                        parliamentNumber: $("#parliament_id").val(),
                        district_id: $("#district_id").val(),
                        constituency_id: $("#constituency_id").val(),
                        //parliament_id: $("#parliament_id").val()
                    }
                },
                /* "columnDefs": [{
                    "orderable": false,
                    "targets": [0,5]
                }], */
                /* "rowCallback": function( row, data, index ) {
                    console.log(index);
                } , */      

                columns: [/* {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        
                    }, */
                    
                    {
                        data: 'mp_name',
                        name: 'v2_profiles.nameBng'
                    },
                    {
                        data: 'bangladesh_number',
                        name: 'constituencies.number'
                    },
                    @php if (session()->get('language') == 'bn') { @endphp
                    {
                        data: 'voter_area_bng',
                        name: 'constituencies.bn_name'
                    },
                    @php }else{ @endphp
                        {
                        data: 'voter_area_bng',
                        name: 'constituencies.name'
                    },
                    @php } @endphp
                    {
                        data: 'personalMobile',
                        name: 'personalMobile'
                    },
                    {
                        data: 'present_address',
                        name: 'present_address'
                    },

                    {
                        data: 'action',
                        name: 'Action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#printable_version").removeClass('d-none');
            $("#printable_version").addClass('block');

            /* $('#list_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
            $.ajax({
                url: "{{ url('/profile-activities/listmp/mpbook') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    bd_no: $('#bd_no').val(),
                    division_id: $("#division_id").val(),
                    parliamentNumber: $("#parliament_id").val(),
                    district_id: $("#district_id").val(),
                    constituency_id: $("#constituency_id").val(),
                    //parliament_id: $("#parliament_id").val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == true) {
                        $('#list_container').html(response.data);
                        $("#list_mp_table").DataTable({
                            "ordering": false
                        });






                    } else {
                        Swal.fire('@lang("No Data Found")', '', 'error');
                        $('#list_container').html('');
                    }
                }
            }); */

        }

        function load_report(type, id) {
            console.log(type, id);
            if (type == 'pdf') {
                my_loader('start');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                $.ajax({
                    type: "POST",
                    crossDomain: true,
                    data: JSON.stringify({
                        doctype: type,
                        profile_id: id
                    }),
                    url: "{{ url('/profile-activities/profiledoc') }}",
                    contentType: "application/json",
                    success: function(data) {
                        const linkSource = data;
                        const downloadLink = document.createElement("a");
                        const fileName = "profile_" + id + ".pdf";
                        downloadLink.href = linkSource;
                        //window.location.href = downloadLink;
                        downloadLink.download = fileName;
                        downloadLink.click();
                        my_loader('stop');
                    },
                    error: function(res) {
                        my_loader('stop');
                    }
                });
            } else {

            }

        }

        function load_all_report(type) {
            if (type == 'pdf') {
                my_loader('start');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });
                $.ajax({
                    type: "POST",
                    crossDomain: true,
                    data: JSON.stringify({
                        doctype: type,
                        bd_no: $('#bd_no').val(),
                        division_id: $("#division_id").val(),
                        parliamentNumber: $("#parliament_id").val(),
                        district_id: $("#district_id").val(),
                        constituency_id: $("#constituency_id").val(),
                    }),
                    url: "{{ url('/profile-activities/profiledoc/all') }}",
                    contentType: "application/json",
                    success: function(data) {
                        const linkSource = data;
                        const downloadLink = document.createElement("a");
                        const fileName = "all_mpbook.pdf";
                        downloadLink.href = linkSource;
                        //window.location.href = downloadLink;
                        downloadLink.download = fileName;
                        downloadLink.click();
                        my_loader('stop');
                    },
                    error: function(res) {
                        my_loader('stop');
                    }
                });
            } else {

            }

        }

        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');
            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title + '</h1>');
            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');
            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/
            mywindow.print();
            mywindow.close();
            return true;
        }
    </script>
@endsection
@push('page_scripts')
    @include('backend.includes.location_scripts')
@endpush
