@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Union Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Union Management')</li>
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
                        <div class="card-header text-right">
                            <a href="{{route('admin.master_setup.unions.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Add Union')</a>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="8%">@lang('Serial')</th>
                                        <th>@lang('Division')</th>
                                        <th>@lang('District')</th>
                                        <th>@lang('Upazila')</th>
                                        <th>@lang('Name (Bangla)')</th>
                                        <th>@lang('Name (English)')</th>
                                        {{-- <th>@lang('Latitude')</th>
                                        <th>@lang('Longitude')</th> --}}
                                        <th>@lang('Status')</th>
                                        <th width="10%" class="text-center">@lang('Action')</th>
                                    </tr>
                                </thead>
                            </table>
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
    $(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            filter: true,
            
            ajax: "{{route('admin.master_setup.unions.loadData')}}",
            columns: [
                {data: 'DT_RowIndex',name: 'DT_RowIndex',orderable: false, searchable: false},
                {data: 'division_id', name: 'division_id'},
                {data: 'district_id', name: 'district_id'},
                {data: 'upazila_id', name: 'upazila_id' },
                {data: 'bn_name', name: 'bn_name'},
                {data: 'name', name: 'name'},
                // {data: 'lat', name: 'lat' },
                // {data: 'lon', name: 'lon' },
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false,searchable: false}
            ]
        });
    });
    </script>

@endsection