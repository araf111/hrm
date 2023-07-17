@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('MP Office Room Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('MP Office Room Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <a href="{{route('admin.master_setup.mp_office_room.index') }}" class="btn btn-sm btn-dark"> @lang('Back')</a>
                        </div>
                        <div class="card-body">
                            <strong>@lang('MP Name'):</strong> {{session()->get('language') == 'bn' ? $mpOfficeRoom->mp_name_bn : $mpOfficeRoom->mp_name_en }} <br/>
                            <strong>@lang('Constituency Area Name'):</strong> {{ session()->get('language') == 'bn' ? $mpOfficeRoom->consticuency_name_bn : $mpOfficeRoom->consticuency_name_en}} <br/>
                            <strong>@lang('Bulding Name'):</strong> @lang('Parliament Building') <br/>
                            <strong>@lang('Block'):</strong> {{digitDateLang($mpOfficeRoom->songshod_blocks_id)}} <br/>
                            <strong>@lang('Floor'):</strong> {{ digitDateLang($mpOfficeRoom->songshod_floors_id) }} <br/>
                            <strong>@lang('Room'):</strong> {{digitDateLang($mpOfficeRoom->room_ids)  }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>


@endsection
