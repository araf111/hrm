@extends('backend.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <style>
        #my_body {
            padding: 0px;
        }

        .carousel-control-next {
            background: rgba(0, 0, 0, 0.1);
            width: 50px;
            max-height: 60px;
            position: absolute;
            top: 44%;
            right: 1%;
        }

        .carousel-control-prev {
            background: rgba(0, 0, 0, 0.1);
            width: 50px;
            max-height: 60px;
            position: absolute;
            top: 44%;
            left: 1%;
        }

    </style>
    <div id="admin-dashboard">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0 text-white">@lang('Dashboard')</h5>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                            <li class="breadcrumb-item active">@lang('Dashboard')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content" style="padding-top: 10px;">
            <!--/. container-fluid -->
            @if ($usertype === 'mp')
                <div class="col-12">
                    <div class="info-box" style="min-height: 0;">
                        <div class="col-4">
                            <select name="parliament_id" id="parliament_id" readonly class="form-control select2"
                                style="width:100%">
                                <option value="">@lang('Select Parliament')</option>
                                @foreach ($parliament_list as $p)
                                    <option value="{{ $p->id }}">{{ $p->parliament_number_bn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select name="parliament_session_id" id="parliament_session_id" readonly
                                class="form-control select2" style="width:100%">
                                <option value="0">@lang('Parliament Session')</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-info" onClick="load_dashboard_data()">@lang('Load Data')</button>
                        </div>
                    </div>
                    <!-- /.info-box -->
                </div>
                @include('backend.dashboard.mp_dashboard');
            @elseif ($usertype === 'admin')
            <div class="col-12">
                <div class="info-box" style="min-height: 0;">
                    <div class="col-4">
                        <select name="parliament_id" id="parliament_id" readonly class="form-control select2"
                            style="width:100%">
                            <option value="">@lang('Select Parliament')</option>
                            @foreach ($parliament_list as $p)
                                <option value="{{ $p->id }}">{{ $p->parliament_number_bn }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <select name="parliament_session_id" id="parliament_session_id" readonly
                            class="form-control select2" style="width:100%">
                            <option value="0">@lang('Parliament Session')</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-info" onClick="load_dashboard_data()">@lang('Load Data')</button>
                    </div>
                </div>
                <!-- /.info-box -->
            </div>
            @include('backend.dashboard.admin_dashboard');
            @else
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small card -->
                            <?php $currentParliament = App\Model\Parliament::orderBy('id', 'ASC')->first();?>
                            <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ digitDateLang($currentParliament->parliament_number) }}</h3>
                
                                <p>@lang('Current Parliament')</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <a href="{{ url('master-setup/parliaments') }}" class="small-box-footer">
                                @lang('More') <i class="fas fa-arrow-circle-right"></i>
                            </a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <?php $mp = App\Model\V2Profile::where('parliamentNumber', $currentParliament->parliament_number)->count();?>
                            <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ digitDateLang($mp) }}</h3>
                
                                <p>@lang('Parliament Member')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person"></i>
                            </div>
                            <a href="{{ url('profile-activities/profiles') }}" class="small-box-footer">@lang('More') <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <?php $users = App\User::count();?>
                            <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ digitDateLang($users) }}</h3>
                
                                <p>@lang('Total User')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ url('user-management/user-info/list') }}" class="small-box-footer">@lang('More') <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    
                    </div>
                </div>
            @endif
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#parliament_id').on('change', function() {
                var parliament_id = $(this).val();
                var url = "{{ url('/parliament/parliament_session_list') }}/" + parliament_id;
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        console.log(response.parliament_session_list);
                        if(response.parliament_session_list.length>0){
                            $('#parliament_session_id').html('<option value="0">@lang("Select Parliament Session")</option>');
                            for(var i=0; i<response.parliament_session_list.length; i++){
                                $('#parliament_session_id').append('<option value="'+response.parliament_session_list[i].id+'">'+response.parliament_session_list[i].session_number_bn+'</option>');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
