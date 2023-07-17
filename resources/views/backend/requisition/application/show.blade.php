@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Telephone / PABX application')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Telephone / PABX application')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="float-left">@lang('Application Information')</h6>
                                <button type="button" class="float-right btn btn-dark btn-sm ion-android-arrow-back">
                                    <a class="text-white" href="{{ route('admin.requisition.telephone_pabx_application.index') }}">@lang('Back')</a>
                                </button>
                            </div>
                            <div class="card-body">
                                <table id="other_records" class="table table-sm table-bordered table-striped">
                                    <thead class="px-3">
                                        <tr>
                                            <th>@lang('Title')</th>
                                            <th>@lang('Details')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="px-3">
                                        <tr>
                                            <td>@lang('Applicant')</td>
                                            <td>
                                                @php
                                                    foreach($profileData as $p){
                                                        if($p->user_id == $viewData->applicant_id){
                                                            if(session()->get('language') == 'bn'){
                                                                echo digitDateLang($p->constituencyNumber) . ', '. $p->voter_area_bng . ', ' . $p->nameBng;
                                                            }else{
                                                                echo digitDateLang($p->constituencyNumber) . ', '. $p->voter_area_Eng . ', ' . $p->nameEng;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Connection Type')</td>
                                            <td>
                                                @if ($viewData->connection_type == 1)
                                                    @lang('Telephone')
                                                @else
                                                    @lang('Pabx')
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Connection Place')</td>
                                            <td>
                                                @if ($viewData->connection_place == 1)
                                                    @lang('Official')
                                                @else
                                                    @lang('Residential')
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($viewData->connection_place == 1)
                                            <tr>
                                                <td>@lang('Building')</td>
                                                <td>
                                                    @if ($viewData->building_type == 1)
                                                        @lang('SongShod Bhaban')
                                                    @else
                                                        @lang('Hostel Building')
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
            
                                        @isset($viewData->block_id)
                                            <tr>
                                                <td>@lang('Block No')</td>
                                                <td>
                                                    @foreach ($songshodBlock as $list)
                                                    @if ($list->id == $viewData->block_id)
                                                        {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                                    @endif
                                                @endforeach
                                                </td>
                                            </tr>
                                        @endisset
            
                                        @isset($viewData->floor_id)
                                            <tr>
                                                <td>@lang('Floor')</td>
                                                <td>
                                                    @foreach ($songshodFloor as $list)
                                                        @if ($list->id == $viewData->floor_id)
                                                            {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endisset
            
                                        @isset($viewData->room_id)
                                            <tr>
                                                <td>@lang('Office Room No')</td>
                                                <td>
                                                    @foreach ($songshodRoom as $list)
                                                        @if ($list->id == $viewData->room_id)
                                                            {{ session()->get('language') == 'bn' ? $list->room_bn : $list->room }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endisset
            
                                        @isset($viewData->hostel_building)
                                            <tr>
                                                <td>@lang('Building Name')</td>
                                                <td>
                                                    @foreach ($hostelBuilding as $list)
                                                    @if ($list->id == $viewData->hostel_building)
                                                        {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                                    @endif
                                                @endforeach
                                                </td>
                                            </tr>
                                        @endisset
            
                                        @isset($viewData->hblock_id)
                                            <tr>
                                                <td>@lang('Floor No')</td>
                                                <td>
                                                    @foreach ($hostelFloor as $list)
                                                    @if ($list->id == $viewData->hblock_id)
                                                        {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                                    @endif
                                                @endforeach
                                                </td>
                                            </tr>
                                        @endisset
            
                                        @isset($viewData->hroom_id)
                                            <tr>
                                                <td>@lang('Room')</td>
                                                <td>
                                                    @foreach ($hostelRooms as $list)
                                                    @if ($list->id == $viewData->hroom_id)
                                                        {{ session()->get('language') == 'bn' ? $list->number_bn : $list->number }}
                                                    @endif
                                                @endforeach
                                                </td>
                                            </tr>
                                        @endisset
            
                                        @isset($viewData->require_connection_place)
                                            <tr>
                                                <td>@lang('Place')</td>
                                                <td>
                                                    @if ($viewData->require_connection_place == 1)
                                                        @lang('In the allotted flat in the Parliament building')
                                                    @else
                                                        @lang('At residence')
                                                    @endif
                                                </td>
                                            </tr>
                                        @endisset

                                        @isset($viewData->own_address)
                                            <tr>
                                                <td>@lang('Address')</td>
                                                <td>{{ $viewData->own_address }}</td>
                                            </tr>
                                        @endisset
            
                                        <tr>
                                            <td>@lang('Would you like to cash the telephone allowance')</td>
                                            <td>
                                                @if ($viewData->want_renew == 1)
                                                    @lang('Yes')
                                                @else
                                                    @lang('No')
                                                @endif
                                                
                                            </td>
                                        </tr>
            
                                        <tr>
                                            <td>@lang('Application Date')</td>
                                            <td>{{ digitDateLang(nanoDateFormat($viewData->created_at)) }}</td>
                                        </tr>
                                        
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