@extends('backend.layouts.app')
@section('content')
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
                        <div style="padding: 10px">
                            <input type="radio" id="male" name="gender" value="male">
                            <label for="male">@lang('Honorable Member of Parliament')</label><br>

                            <input type="radio" id="female" name="gender" value="male">
                            <label for="male">@lang('Parliamentary Officer / Employee')</label><br>
                        </div>
                        <div class="card-body" id="parlament_div" style="display:none">
                            {{-- <form method="get" action="{{ url('mppbook') }}"> --}}
                            <form id="mppbook">
                                @csrf
                                <div class="form-row">
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
                                            class="form-control  form-control-sm @error('division_id') is-invalid @enderror"
                                            style="width:100%;">
                                            {!! divisionDropdown() !!}
                                        </select>
                                        @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group col-sm-3">
                                        <label for="" class="control-label">@lang('District')</label>
                                        <select name="district_id" id="district_id"
                                            class="form-control  form-control-sm @error('district_id') is-invalid @enderror"
                                            style="width:100%;">
                                            <option value="">@lang('Select District')</option>
                                        </select>
                                        @error('district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-3">
                                        <label for="" class="control-label">@lang('Constituency')</label>
                                        <select name="constituency_id" id="constituency_id"
                                            class="form-control  form-control-sm @error('constituency_id') is-invalid @enderror"
                                            style="width:100%;">
                                            <option value="">@lang('Select Constituency')</option>
                                        </select>
                                        @error('constituency_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-12" style="display:none">
                                        <label for="" class="control-label">@lang('Search by Name')</label>
                                        <input type="text" name="search_by"
                                            class="form-control form-control-sm @error('search_by') is-invalid @enderror"
                                            placeholder="@lang('Enter Name')">

                                        @error('search_by')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-2 mt-4">
                                        <button type="submit"
                                            class="btn btn-success btn-sm mt-2 px-4">@lang('Search')</button>
                                    </div>

                                </div>
                            </form>
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
                                        <button type="submit"
                                            class="btn btn-success btn-sm mt-2 px-4">@lang('Search')</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div id="tableShow">


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
        jQuery(document).ready(function() {
            jQuery('#mppbook').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    'url': "{{ route('admin.profile-activities.mpBook-info.show') }}",
                    // 'url': "{{ url('mppbook') }}",
                    'type': 'post',
                    'data': $('form')
                .serialize(), // Remember that you need to have your csrf token included
                    success: function(response) {
                        // Handle your response..
                        // window.location.href="{{ route('admin.user-management.menu-permission-info.list') }}";
                        // window.location.href="{{ route('admin.profile-activities.mpBook-info.index') }}";
                        // window.location.href="{{ url('mppbook') }}";
                        console.log(response)
                        $("#tableShow").html(response)
                    },
                    error: function(_response) {
                        // Handle error
                    }
                });
            });
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
@endsection
@push('page_scripts')
    @include('backend.includes.location_scripts')
@endpush
