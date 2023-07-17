@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Number Counter Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Number Counter Management')</li>
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
                            <a href="{{route('admin.landing_page.number_counters.create')}}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> @lang('Add New')</a>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="8%">@lang('Serial')</th>
                                    <th>@lang('Title (Bangla)')</th>
                                    <th>@lang('Title (English)')</th>
                                    <th>@lang('Number')</th>
                                    <th>@lang('Status')</th>
                                    <th width="10%" class="text-center">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($numberCounters as $data)
                            
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->titleBng}}</td>
                                        <td>{{$data->titleEng}}</td>
                                        <td>{{$data->number}}</td>
                                        <td>{!! activeStatus($data->status) !!}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="{{route('admin.landing_page.number_counters.edit', $data->id)}}">
                                                 <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.landing_page.number_counters.destroy', $data->id)}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            
                                </tbody>
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


