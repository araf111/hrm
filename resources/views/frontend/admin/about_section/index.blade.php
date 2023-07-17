<!-- 
 * Author M. Atoar Rahman
 * Date: 22/08/2021
 * Time: 11:40 AM
-->
@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('About Section Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('About Section Management')</li>
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
                            <a href="{{route('admin.landing_page.about_sections.create')}}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> @lang('Add New')</a>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="8%">@lang('Serial')</th>
                                    <th>@lang('Title (Bangla)')</th>
                                    <th>@lang('Title (English)')</th>
                                    <th>@lang('Content (Bangla)')</th>
                                    <th>@lang('Content (English)')</th>
                                    <th>@lang('Youtube Video ID')</th>
                                    <th>@lang('Video Thumbnail')</th>
                                    <th>@lang('Video Background')</th>
                                    <th>@lang('Status')</th>
                                    <th width="10%" class="text-center">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                            
                                @foreach($aboutSections as $data)
                            
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->titleBng}}</td>
                                        <td>{{$data->titleEng}}</td>
                                        <td>
                                            {!! \Illuminate\Support\Str::limit($data->contentBng, $limit = 130, $end = '...') !!}
                                        </td>
                                        <td>
                                            {!! \Illuminate\Support\Str::limit($data->contentEng, $limit = 130, $end = '...') !!}
                                        </td>
                                        <td>{{$data->videoLink}}</td>
                                        <td>
                                            <img src="{{asset('public/frontend/images')}}/{{$data->videoThumbnail}}" alt="Video Thumbnail" width="50px">
                                        </td>
                                        <td>
                                            <img src="{{asset('public/frontend/images')}}/{{$data->videoBackground}}" alt="Video Background" width="50px">
                                        </td>
                                        <td>{!! activeStatus($data->status) !!}</td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info" href="{{route('admin.landing_page.about_sections.edit', $data->id)}}">
                                                 <i class="fa fa-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.landing_page.about_sections.destroy', $data->id)}}">
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


