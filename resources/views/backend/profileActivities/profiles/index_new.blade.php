@extends('backend.layouts.app')
@section('content')
<style>
    .navbar-nav {
            display: inherit !important;
        }
</style>
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
    
    <div class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if(authInfo()->usertype=='admin')
                    <h4 class="card-title w-100">@lang('Parliament Member List')
                        <a href="{{ route('admin.profile-activities.v2profiles.create') }}"
                            class="btn btn-info float-right"><i class="fa fa-plus mr-2"></i> 
                            @lang('Add Parliament Member')</a>
                    </h4>
                    {{-- <h4 class="card-title w-100">
                        <a href="#" class="btn btn-success float-right mt-2">@lang('Update Information')</a>
                    </h4> --}}
                    @endif
                </div>
                <div class="card-body">
                    {{-- <form method="get" action="{{ url('mppbook') }}"> --}}
                    <form id="mppbook">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-sm-2">
                                <label for="" class="control-label">@lang('Parliament')</label>
                                <select name="parliament_id" id="parliament_id" readonly class="form-control select2"
                                    style="width:100%">
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
                    <div id="list_container" class="table-responsive">
                        <table id="list_mp_table" class="table table-sm table-bordered table-striped"> <thead> <tr><th>@lang("ID")</th><th>@lang("Name")</th><th>@lang("Bangladesh No.")</th><th>@lang("Constituency")</th> <th>@lang("Phone")</th><th>@lang("Action")</th></tr></thead>

                        </table>
                    </div>
                </div>
                <div id="parlament_div">
                    
                </div>
                <div id="employee_div">
                    
                </div>
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                setTimeout(function() {
                    load_data();
                }, 1000);
            });

        })
    </script>
    <script>
        function load_data() {
            var table = $('#list_mp_table').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            filter: true,
            ajax: {
                url: "{{ url('/profile-activities/listmp/profile') }}",
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
           /*  "columnDefs": [{
                "orderable": false,
                "targets": [0]
            }], */
            columns: [
               /*  {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false, 
                    searchable: false
                }, */
                {
                    data: 'profileID',
                    name: 'profileID'
                },
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
                    data: 'action',
                    name: 'Action',
                    orderable: false, 
                    searchable: false
                },
            ]
        });
            /* $('#list_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
            $.ajax({
                url: "{{ url('/profile-activities/listmp/profile') }}",
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
    </script>
@endsection
@push('page_scripts')
    @include('backend.includes.location_scripts')
@endpush
