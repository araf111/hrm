@extends('backend.layouts.app')
@section('content')
    <style>
        .hides {
            display: none
        }

        .displays label {
            display: block;
        }

        .displays .select2 {
            width: 100% !important;
        }

        .displays {
            visibility: visible
        }

    </style>
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
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if ($data->id)
                        <h4 class="card-title">@lang('Update Telephone / PABX application')</h4>
                    @else
                        <h4 class="card-title">@lang('Create Telephone / PABX application')</h4>
                    @endif
                </div>
                <form id="ministryForm" name="ministryForm" method="POST" @if ($data->id) action="{{ route('admin.requisition.telephone_pabx_application.update', $data->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                @else
                action="{{ route('admin.requisition.telephone_pabx_application.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="connection_type">@lang('Connection Type')<span
                                        style="color: red;"> *</span></label>
                                <select id="connection_type" name="connection_type" onchange="option()"
                                    class="form-control @error('connection_type') is-invalid @enderror">
                                    <option value="">@lang('Select Connection Type')</option>
                                    <option {{ (old('connection_type') || $data->connection_type==1) ? 'selected' : '' }} value="1">@lang('Telephone')</option>
                                    <option {{ (old('connection_type') || $data->connection_type==2) ? 'selected' : '' }} value="2">@lang('Pabx')</option>
                                </select>

                                @error('connection_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="connection_place">@lang('Connection Place')<span
                                        style="color: red;"> *</span></label>
                                <select id="connection_place" onchange="option()" name="connection_place"
                                    class="form-control @error('connection_place') is-invalid @enderror">
                                    <option value="">@lang('Select Connection Place')</option>
                                    <option {{ (old('connection_place') || $data->connection_place==1) ? 'selected' : '' }} value="1">@lang('Official')</option>
                                    <option {{ (old('connection_place') || $data->connection_place==2) ? 'selected' : '' }} value="2">@lang('Residential')</option>
                                </select>

                                @error('connection_place')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row hides" id="require_connection_place_portion">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="require_connection_place">@lang('Connection Place')<span style="color: red;"> *</span></label>
                                <select id="require_connection_place" name="require_connection_place"
                                    class="form-control @error('require_connection_place') is-invalid @enderror select2">
                                    <option value="">@lang('Select Connection Place')</option>
                                    <option {{ (old('require_connection_place') || $data->require_connection_place==1) ? 'selected' : '' }} value="1">@lang('In the allotted flat in the Parliament building')</option>
                                    <option {{ (old('require_connection_place') || $data->require_connection_place==2) ? 'selected' : '' }} value="2">@lang('At residence')</option>
                                </select>

                                @error('require_connection_place')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                    </div>
                    <div class="row" id="mp_building_details">
                    </div>
                    <div class="row hides" id="building_type_portion">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="building_type">@lang('Select the building name')<span
                                        style="color: red;"> *</span></label>
                                <select id="building_type" name="building_type"
                                    class="form-control @error('building_type') is-invalid @enderror select2">
                                    @php
                                        $building_type = $data->building_type;
                                    @endphp
                                    @if ($building_type == 0)
                                        <option selected value="0">@lang('Hostel Building')</option>
                                    @else
                                        <option value="0">@lang('Hostel Building')</option>
                                    @endif
                                    @if ($building_type == 1)
                                        <option selected value="1">@lang('SongShod Bhaban')</option>
                                    @else
                                        <option value="1">@lang('SongShod Bhaban')</option>
                                    @endif
                                </select>

                                @error('building_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4 hides" id="hostel_portion">
                            <div class="form-group">
                                <label class="control-label" for="hostel_building">@lang('Building Name')<span
                                        style="color: red;"> *</span></label>
                                <select id="hostel_building" name="hostel_building"
                                    class="form-control @error('hostel_building') is-invalid @enderror select2">
                                    <option value="">@lang('Selected The Building Name')</option>
                                    @foreach ($hostelBuilding as $list)
                                        @if ($list->id == $data->hostel_building)
                                            <option selected value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        @else
                                            <option value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('hostel_building')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 hides" id="hostel_portion_building">
                            <div class="form-group">
                                <label class="control-label" for="hblock_id">@lang('Floor No')<span style="color: red;">
                                        *</span></label>
                                <select id="hblock_id" name="hblock_id"
                                    class="form-control @error('block_id') is-invalid @enderror select2">
                                    <option value="">@lang('Select Floor Number')</option>
                                    @foreach ($hostelFloor as $list)
                                        @if ($list->id == $data->hblock_id)
                                            <option selected value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        @else
                                            <option value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('hblock_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 hides" id="hostel_portion_room">
                            <div class="form-group">
                                <label class="control-label" for="hroom_id">@lang('Room')<span style="color: red;">
                                        *</span></label>
                                <select id="hroom_id" name="hroom_id"
                                    class="form-control @error('hroom_id') is-invalid @enderror select2">
                                    <option value="">@lang('Select Room Number')</option>
                                    @foreach ($hostelRooms as $list)
                                        @if ($list->id == $data->hroom_id)
                                            <option selected value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->number_bn : $list->number }}
                                            </option>
                                        @else
                                            <option value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->number_bn : $list->number }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('hroom_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="songshod_portion" class="row hides">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="block_id">@lang('Block No')<span style="color: red;">
                                        *</span></label>
                                <select id="block_id" name="block_id"
                                    class="form-control @error('block_id') is-invalid @enderror select2">
                                    <option value="">@lang('Select Block')</option>
                                    @foreach ($songshodBlock as $list)
                                        @if ($list->id == $data->block_id)
                                            <option selected value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        @else
                                            <option value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('block_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="floor_id">@lang('Floor')<span style="color: red;">
                                        *</span></label>
                                <select id="floor_id" name="floor_id"
                                    class="form-control @error('floor_id') is-invalid @enderror select2">
                                    {{-- <option value="">@lang('Select Floor Number')</option> --}}
                                    @foreach ($songshodFloor as $list)
                                        @if ($list->id == $data->floor_id)
                                            <option selected value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option>
                                        {{-- @else
                                            <option value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            </option> --}}
                                        @endif
                                    @endforeach
                                </select>

                                @error('floor_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="room_id" class="control-label" for="room_id">@lang('Office Room No')<span
                                        style="color: red;"> *</span></label>
                                <select id="room_id" name="room_id"
                                    class="form-control @error('room_id') is-invalid @enderror select2">
                                    {{-- <option value="">@lang('Select Room Number')</option> --}}
                                    @foreach ($songshodRoom as $list)
                                        @if ($list->id == $data->room_id)
                                            <option selected value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->room_bn : $list->room }}
                                            </option>
                                        {{-- @else
                                            <option value="{{ $list->id }}">
                                                {{ session()->get('language') == 'bn' ? $list->room_bn : $list->room }}
                                            </option> --}}
                                        @endif
                                    @endforeach
                                </select>

                                @error('room_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row hides" id="own_address_portion">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label" for="own_address">@lang('Address to provide the connection')<span style="color: red;"> *</span></label>
                                <input type="text" id="own_address" name="own_address" onkeydown="removeSpecials(event)"
                                    value="{{ old('own_address', $data->own_address) }}"
                                    class="form-control @error('own_address') is-invalid @enderror"
                                    placeholder="@lang('Enter the address to provide the connection')"
                                    autocomplete="off" maxlength="30">

                                @error('own_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div id="house_id">
                    </div>
                    <div class="row hides" id='allownes'>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="telphone_expenses">@lang('Would you like to cash the telephone allowance')<span style="color: red;"> *</span></label>
                                <select name="want_renew" id="want_renew" class="form-control">
                                    <option {{ (old('want_renew') || $data->want_renew==1) ? 'selected' : '' }} value="1">@lang('Yes')</option>
                                    <option {{ (old('want_renew') || $data->want_renew==2) ? 'selected' : '' }} value="2">@lang('No')</option>
                                </select>

                                @error('telphone_expenses')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group text-right">
                            @if ($data->id)
                                <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                            @else
                                <button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                            @endif
                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                <a
                                    href="{{ route('admin.requisition.telephone_pabx_application.index') }}">@lang('Back')</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>

    <script>

        $('#building_type').change(function() {
            let building_type = $(this).val();
            
            if (building_type == 1) {
                $('#songshod_portion').addClass('displays');
                $('#songshod_portion').removeClass('hides');
                $('#hostel_portion').addClass('hides');
                $('#hostel_portion').removeClass('displays');
                $('#hostel_portion_building').addClass('hides');
                $('#hostel_portion_building').removeClass('displays');
                $('#hostel_portion_room').addClass('hides');
                $('#hostel_portion_room').removeClass('displays');


                $("#require_connection_place").prop('disabled', true);
                $("#hostel_building").prop('disabled', true);
                $("#hblock_id").prop('disabled', true);
                $("#hroom_id").prop('disabled', true);
                $("#own_address").prop('disabled', true);
 
                $("#block_id").prop('disabled', false);
                $("#floor_id").prop('disabled', false);
                $("#room_id").prop('disabled', false);

            } else if(building_type == 0) {
                $('#songshod_portion').addClass('hides');
                $('#songshod_portion').removeClass('displays');
                $('#hostel_portion').addClass('displays');
                $('#hostel_portion').removeClass('hides');
                $('#hostel_portion_building').addClass('displays');
                $('#hostel_portion_building').removeClass('hides');
                $('#hostel_portion_room').addClass('displays');
                $('#hostel_portion_room').removeClass('hides');

                $("#require_connection_place").prop('disabled', true);
                $("#block_id").prop('disabled', true);
                $("#floor_id").prop('disabled', true);
                $("#room_id").prop('disabled', true);
                $("#own_address").prop('disabled', true);

                $("#hostel_building").prop('disabled', false);
                $("#hblock_id").prop('disabled', false);
                $("#hroom_id").prop('disabled', false);

            }
        })
        
        $('#block_id').change(function() {
            if ($(this).val() == '') {
                $('#floor_id').html('');
            } else {
                var url = "{{url('/admin/master-setup/committee_room/floor')}}"+'/'+$(this).val();
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {
                        $('#floor_id').html('');
                        if (response !== '') {
                            $('#floor_id').append(response);
                        }
                    }
                });
            }
        })

        $('#floor_id').change(function() {
            
            if ($(this).val() == '') {
                $('#room_id').html('');
            } else {
                var url = "{{url('/admin/master-setup/committee_room/room')}}/"+$('#block_id').val()+"/"+$(this).val() ;
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {
                        $('#room_id').html('');
                        if (response !== '') {
                            $('#room_id').append(response);
                        }
                    }
                });
            }
        })

        $('#hostel_building').change(function() {
            let building_id = $(this).val();
            $.ajax({
                url: "{{ url('/requisition/getHostelFloor') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    building_id: building_id,
                },
                success: function(res) {
                    if (res == 0) {
                        alert('No Floor Found')
                    } else {
                        $('#hblock_id').html(res);
                    }

                }

            })
        })

        $('#hblock_id').change(function() {
            let building_id = $(this).val();
            $.ajax({
                url: "{{ url('/requisition/getHostelRoom') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    floor_id: building_id,
                },
                success: function(res) {
                    $('#hroom_id').html(res);
                }

            })
        })

        function option() {
            let connection_type = $('#connection_type').val();
            let connection_place = $('#connection_place').val();
            let building_type = $('#building_type').val();

            if(connection_type == 2){
                $('#allownes').addClass('hides')
            }else{
                $('#allownes').removeClass('hides');
            }

            if (connection_type == 1 && connection_place == 2) {
                $('#require_connection_place_portion').addClass('displays');
                $('#require_connection_place_portion').removeClass('hides');
                $('#building_type_portion').removeClass('displays');
                $('#building_type_portion').addClass('hides');
                $('#hostel_portion').removeClass('displays');
                $('#hostel_portion').addClass('hides');
                $('#hostel_portion_building').removeClass('displays');
                $('#hostel_portion_building').addClass('hides');
                $('#hostel_portion_room').removeClass('displays');
                $('#hostel_portion_room').addClass('hides');
                $('#songshod_portion').removeClass('displays');
                $('#songshod_portion').addClass('hides');
                $('#own_address_portion').addClass('hides');

                // Enable OR Disable
                $("#hostel_building").prop('disabled', true);
                $("#hblock_id").prop('disabled', true);
                $("#hroom_id").prop('disabled', true);
                $("#block_id").prop('disabled', true);
                $("#floor_id").prop('disabled', true);
                $("#room_id").prop('disabled', true);
                $("#require_connection_place").prop('disabled', false);

            } else if (connection_type == 1 && connection_place == 1) {
                $('#require_connection_place_portion').removeClass('displays');
                $('#require_connection_place_portion').addClass('hides');
                $('#building_type_portion').addClass('displays');
                $('#building_type_portion').removeClass('hides');
                $('#hostel_portion').addClass('displays');
                $('#hostel_portion').removeClass('hides');
                $('#hostel_portion_building').addClass('displays');
                $('#hostel_portion_building').removeClass('hides');
                $('#hostel_portion_room').addClass('displays');
                $('#hostel_portion_room').removeClass('hides');
                $('#own_address_portion').addClass('hides');

                // Enable OR Disable
                $("#require_connection_place").prop('disabled', true);
                $("#block_id").prop('disabled', true);
                $("#floor_id").prop('disabled', true);
                $("#room_id").prop('disabled', true);
                $("#own_address").prop('disabled', true);
                $("#hostel_building").prop('disabled', false);
                $("#hblock_id").prop('disabled', false);
                $("#hroom_id").prop('disabled', false);

            } else if (connection_type == 2 && connection_place == 1) {
                $('#require_connection_place_portion').removeClass('displays');
                $('#require_connection_place_portion').addClass('hides');
                $('#building_type_portion').addClass('displays');
                $('#building_type_portion').removeClass('hides');
                $('#hostel_portion').addClass('displays');
                $('#hostel_portion').removeClass('hides');
                $('#hostel_portion_building').addClass('displays');
                $('#hostel_portion_building').removeClass('hides');
                $('#hostel_portion_room').addClass('displays');
                $('#hostel_portion_room').removeClass('hides');
                $('#own_address_portion').addClass('hides');

                // Enable OR Disable
                $("#require_connection_place").prop('disabled', true);
                $("#block_id").prop('disabled', true);
                $("#floor_id").prop('disabled', true);
                $("#room_id").prop('disabled', true);
                $("#own_address").prop('disabled', true);
                $("#hostel_building").prop('disabled', false);
                $("#hblock_id").prop('disabled', false);
                $("#hroom_id").prop('disabled', false);

            } else if (connection_type == 2 && connection_place == 2) {
                $('#require_connection_place_portion').addClass('displays');
                $('#require_connection_place_portion').removeClass('hides');
                $('#own_address_portion').addClass('hides');
                $('#own_address_portion').removeClass('displays');
                $('#building_type_portion').addClass('hides');
                $('#building_type_portion').removeClass('displays');
                $('#songshod_portion').addClass('hides');
                $('#songshod_portion').removeClass('displays');
                $('#allownes').removeClass('hides');

                // Enable OR Disable
                $("#hostel_building").prop('disabled', true);
                $("#hblock_id").prop('disabled', true);
                $("#hroom_id").prop('disabled', true);
                $("#block_id").prop('disabled', true);
                $("#floor_id").prop('disabled', true);
                $("#room_id").prop('disabled', true);
                $("#require_connection_place").prop('disabled', false);

            } else {
                $('#require_connection_place_portion').removeClass('displays');
                $('#require_connection_place_portion').addClass('hides');
            }

        }
        
        $('#require_connection_place').change(function() {
            let require_connection_place = $(this).val();
            if (require_connection_place == 2) {
                $('#mp_building_details').hide();
                $('#own_address_portion').addClass('displays');
                $('#own_address_portion').removeClass('hides');
                $('#building_type_portion').removeClass('displays');
                $('#building_type_portion').addClass('hides');
                $('#hostel_portion').removeClass('displays');
                $('#hostel_portion').addClass('hides');
                $('#hostel_portion_building').removeClass('displays');
                $('#hostel_portion_building').addClass('hides');
                $('#hostel_portion_room').removeClass('displays');
                $('#hostel_portion_room').addClass('hides');
                
                $("#own_address").prop('disabled', false);

            } else if (require_connection_place == 1) {
                $('#mp_building_details').show();
                
                $('#own_address_portion').addClass('hides');
                $("#own_address").prop('disabled', true);
                
                $.ajax({
                    // url: "{{ url('/requisition/getBuildingDetailsOfMp') }}",
                    url: "{{ url('/requisition/getHouseInfo') }}",
                    method: 'GET',
                    data: {
                        "token": "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        if (res == 0) {
                            alert('No House Found')
                        } else {

                            //var text = '<p>এলাকা : <strong>' + res[0].area_bn+ '</strong>. ফ্ল্যাট সাইজ : <strong>' + res[0].flat_bn_name+'</strong></p>';
                            $('#mp_building_details').html(res);
                        }
                    }

                })
            } else {
                $('#mp_building_details').hide();
                $('#own_address_portion').removeClass('displays');
                $('#own_address_portion').addClass('hides');
                $('#building_type_portion').removeClass('displays');
                $('#building_type_portion').addClass('hides');
                $('#hostel_portion').removeClass('displays');
                $('#hostel_portion').addClass('hides');
                $('#hostel_portion_building').removeClass('displays');
                $('#hostel_portion_building').addClass('hides');
                $('#hostel_portion_room').removeClass('displays');
                $('#hostel_portion_room').addClass('hides');
            }
        })

        var edit_data_connection_type = "{{ $data->connection_type }}";
        var edit_data_connection_place = "{{ $data->connection_place }}";
        var edit_data_require_connection_place = "{{ $data->require_connection_place }}";
        var edit_data_building_type = "{{ $data->building_type }}";
        var edit_data_hostel_building = "{{ $data->hostel_building }}";
        var edit_data_hblock_id = "{{ $data->hblock_id }}";
        var edit_data_hroom_id = "{{ $data->hroom_id }}";
        var edit_data_block_id = "{{ $data->block_id }}";
        var edit_data_floor_id = "{{ $data->floor_id }}";
        var edit_data_room_id = "{{ $data->room_id }}";
        var edit_data_own_address = "{{ $data->own_address }}";
        var edit_data_want_renew = "{{ $data->want_renew }}";

        if(edit_data_connection_type==1 && edit_data_connection_place==1 && edit_data_building_type==0){
            $('#building_type_portion').addClass('displays');
            $('#building_type_portion').removeClass('hides');
            
            $('#hostel_portion').addClass('displays');
            $('#hostel_portion').removeClass('hides');

            $('#hostel_portion_building').addClass('displays');
            $('#hostel_portion_building').removeClass('hides');
            
            $('#hostel_portion_room').addClass('displays');
            $('#hostel_portion_room').removeClass('hides');

            $('#allownes').removeClass('hides'); 
        }
        if(edit_data_connection_type==2 && edit_data_connection_place==1 && edit_data_building_type==0){
            $('#building_type_portion').addClass('displays');
            $('#building_type_portion').removeClass('hides');
            
            $('#hostel_portion').addClass('displays');
            $('#hostel_portion').removeClass('hides');

            $('#hostel_portion_building').addClass('displays');
            $('#hostel_portion_building').removeClass('hides');
            
            $('#hostel_portion_room').addClass('displays');
            $('#hostel_portion_room').removeClass('hides');

            $('#allownes').removeClass('hides');
        }
        if(edit_data_connection_type==1 && edit_data_connection_place==1 && edit_data_building_type==1){
            $('#building_type_portion').addClass('displays');
            $('#building_type_portion').removeClass('hides');

            $('#songshod_portion').addClass('displays');
            $('#songshod_portion').removeClass('hides');

            $('#allownes').removeClass('hides'); 
        }
        if(edit_data_connection_type==2 && edit_data_connection_place==1 && edit_data_building_type==1){
            $('#building_type_portion').addClass('displays');
            $('#building_type_portion').removeClass('hides');

            $('#songshod_portion').addClass('displays');
            $('#songshod_portion').removeClass('hides');

            $('#allownes').removeClass('hides');
        }

        if(edit_data_connection_type==1 && edit_data_connection_place==2 && edit_data_require_connection_place==2){
            $('#require_connection_place_portion').addClass('displays');
            $('#require_connection_place_portion').removeClass('hides');
            
            $('#own_address_portion').addClass('displays');
            $('#own_address_portion').removeClass('hides');

            $('#allownes').removeClass('hides');
        }

        if(edit_data_connection_type==2 && edit_data_connection_place==2 && edit_data_require_connection_place==1){
            $('#require_connection_place_portion').addClass('displays');
            $('#require_connection_place_portion').removeClass('hides');

            $('#allownes').removeClass('hides');
        }

        if(edit_data_connection_type==1 && edit_data_connection_place==2 && edit_data_require_connection_place==1){
            $('#require_connection_place_portion').addClass('displays');
            $('#require_connection_place_portion').removeClass('hides');

            $('#allownes').removeClass('hides');
        }

        if(edit_data_connection_type==2 && edit_data_connection_place==2 && edit_data_require_connection_place==2){
            $('#require_connection_place_portion').addClass('displays');
            $('#require_connection_place_portion').removeClass('hides');
            
            $('#own_address_portion').addClass('displays');
            $('#own_address_portion').removeClass('hides');

            $('#allownes').removeClass('hides');
        }

        // console.log('connection_type: '+ connection_type);
        // console.log('connection_place: '+ connection_place);
        // console.log('require_connection_place: '+ require_connection_place);
        // console.log('building_type: '+ building_type);
        // console.log('hostel_building: '+ hostel_building);
        // console.log('hblock_id: '+ hblock_id);
        // console.log('hroom_id: '+ hroom_id);
        // console.log('room_id: '+ room_id);
        // console.log('floor_id: '+ floor_id);
        // console.log('block_id: '+ block_id);
        // console.log('own_address: '+ own_address);
        // console.log('want_renew: '+ want_renew);


    </script>
    
    @if($errors->has('connection_type') || $errors->has('connection_place'))
        <script>
            $('#building_type_portion').addClass('hides');
            $('#building_type_portion').removeClass('displays');
            $('#allownes').addClass('hides');
            $('#allownes').removeClass('displays');
        </script>
    @endif

    @if($errors->has('hostel_building') || $errors->has('hblock_id') || $errors->has('hroom_id'))
        <script>
            $('#require_connection_place_portion').addClass('hides');
            $('#require_connection_place_portion').removeClass('displays');

            $('#building_type_portion').addClass('displays');
            $('#building_type_portion').removeClass('hides');

            $('#hostel_portion').addClass('displays');
            $('#hostel_portion').removeClass('hides');

            $('#hostel_portion_building').addClass('displays');
            $('#hostel_portion_building').removeClass('hides');

            $('#hostel_portion_room').addClass('displays');
            $('#hostel_portion_room').removeClass('hides');

            $('#songshod_portion').addClass('hides');
            $('#songshod_portion').removeClass('displays');

            $('#own_address_portion').addClass('hides');
            $('#own_address_portion').removeClass('displays');

            $('#allownes').addClass('displays');
            $('#allownes').removeClass('hides');

            $("#require_connection_place").prop('disabled', true);
            $("#block_id").prop('disabled', true);
            $("#floor_id").prop('disabled', true);
            $("#room_id").prop('disabled', true);
            $("#own_address").prop('disabled', true);

        </>

    @elseif($errors->has('block_id') || $errors->has('floor_id') || $errors->has('room_id'))
        <script>
            $('#require_connection_place_portion').addClass('hides');
            $('#require_connection_place_portion').removeClass('displays');

            $('#building_type_portion').addClass('displays');
            $('#building_type_portion').removeClass('hides');

            $('#songshod_portion').addClass('displays');
            $('#songshod_portion').removeClass('hides');

            $('#own_address_portion').addClass('hides');
            $('#own_address_portion').removeClass('displays');

            $('#allownes').addClass('displays');
            $('#allownes').removeClass('hides');

            $("#require_connection_place").prop('disabled', true);
            $("#hostel_building").prop('disabled', true);
            $("#hblock_id").prop('disabled', true);
            $("#hroom_id").prop('disabled', true);
            $("#own_address").prop('disabled', true);

        </script>
    @elseif($errors->has('require_connection_place'))
        <script>
            $('#require_connection_place_portion').addClass('displays');
            $('#require_connection_place_portion').removeClass('hides');

            $('#allownes').addClass('displays');
            $('#allownes').removeClass('hides');

            $("#hostel_building").prop('disabled', true);
            $("#hblock_id").prop('disabled', true);
            $("#hroom_id").prop('disabled', true);
            $("#block_id").prop('disabled', true);
            $("#floor_id").prop('disabled', true);
            $("#room_id").prop('disabled', true);

        </script>

    @elseif($errors->has('own_address'))
    <script>
        $('#require_connection_place_portion').addClass('displays');
        $('#require_connection_place_portion').removeClass('hides');

        $('#own_address_portion').addClass('displays');
        $('#own_address_portion').removeClass('hides');

        $('#allownes').addClass('displays');
        $('#allownes').removeClass('hides');

        $("#hostel_building").prop('disabled', true);
        $("#hblock_id").prop('disabled', true);
        $("#hroom_id").prop('disabled', true);
        $("#block_id").prop('disabled', true);
        $("#floor_id").prop('disabled', true);
        $("#room_id").prop('disabled', true);

    </script>
    @endif

@endsection
