@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Constituency Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Constituency Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if ($data->id)
                        <h4 class="card-title">@lang('Update Constituency')</h4>
                    @else
                        <h4 class="card-title">@lang('Create Constituency')</h4>
                    @endif
                </div>
                <!-- Form Start-->
                <form id="ConstituencyForm" name="ConstituencyForm" method="POST"
                      @if($data->id)
                      action="{{ route('admin.master_setup.constituencies.update', $data->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    @else
                        action="{{ route('admin.master_setup.constituencies.store') }}">
                    @endif
                    @csrf

                    <input type="hidden" id="id" name="id" value="{{$data->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="number">@lang('Bangladesh Number')<span
                                            style="color: red;"> *</span></label>
                                    <input type="number" id="number" name="number" value="{{old('number', $data->number)}}"
                                           class="form-control @error('number') is-invalid @enderror"
                                           placeholder="@lang('Enter Bangladesh Number')" autocomplete="off" maxlength="15">

                                    @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="bn_name">@lang('Name (Bangla)')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="bn_name" name="bn_name" value="{{old('bn_name', $data->bn_name)}}"
                                           class="form-control bn_name @error('bn_name') is-invalid @enderror"
                                           placeholder="@lang('Enter Name in Bangla')" autocomplete="off" maxlength="30">

                                    @error('bn_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Name (English)')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="name" name="name" value="{{old('name', $data->name)}}"
                                           class="form-control name @error('name') is-invalid @enderror"
                                           placeholder="@lang('Enter Name in English')" autocomplete="off" maxlength="30">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="parliamentNumber">@lang('Parliament No.')<span
                                            style="color: red;"> *</span></label>
                                    <select id="parliamentNumber" name="parliamentNumber" class="form-control select2 @error('parliamentNumber') is-invalid @enderror">
                                        <option value="">@lang('Select Parliament No.')</option>
                                        @foreach ($parliamentList as $list)
                                            @if($list['parliament_number']==$data->parliamentNumber or $list['parliament_number']==old('parliamentNumber'))
                                                <option selected
                                                        value="{{$list['parliament_number']}}">{{ Lang::get($list['parliament_number']) }}</option>
                                            @else
                                                <option  value="{{$list['parliament_number']}}">{{ Lang::get($list['parliament_number']) }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('parliamentNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="division_id">@lang('Division')</label>
                                    <select id="division_id" name="division_id" class="form-control select2 @error('division_id') is-invalid @enderror">
                                        <option value="">@lang('Select Division')</option>
                                        @foreach ($divisionList as $list)
                                            @if($list['id']==$data->division_id or $list['id']==old('division_id'))
                                                <option selected
                                                        value="{{$list['id']}}">
                                                        @if(session()->get('language') =='bn')
                                                            {{$list['bn_name']}}
                                                        @else
                                                            {{$list['name']}}
                                                        @endif
                                                    </option>
                                            @else
                                                <option  value="{{$list['id']}}">
                                                    @if(session()->get('language') =='bn')
                                                        {{$list['bn_name']}}
                                                    @else
                                                        {{$list['name']}}
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('division_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="district_id">@lang('District')</label>
                                    <select id="district_id" name="district_id" class="form-control select2 @error('district_id') is-invalid @enderror">
                                        <option value="">@lang('Select District')</option>
                                        @foreach ($districtList as $list)
                                            @if($list['id']==$data->district_id or $list['id']==old('district_id'))
                                                <option selected
                                                        value="{{$list['id']}}">
                                                        @if(session()->get('language') =='bn')
                                                            {{$list['bn_name']}}
                                                        @else
                                                            {{$list['name']}}
                                                        @endif
                                                    </option>
                                            @else
                                                <option  value="{{$list['id']}}">
                                                    @if(session()->get('language') =='bn')
                                                        {{$list['bn_name']}}
                                                    @else
                                                        {{$list['name']}}
                                                    @endif
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('district_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="upazila_id">@lang('Upazila/City Corporations')</label>
                                    <select id="upazila_id" name="upazila_id" multiple="multiple" class="form-control select2 @error('upazila_id') is-invalid @enderror">
                                        <option value="">@lang('Select Upazila')</option>


                                        @php
                                            $nameAddOnConstituency = [( isset( $data->upazila_id ) ) ? ( explode( ",", $data->upazila_id ) ) : array( '' )];
                                        @endphp
                                        @foreach ( $upazilaList as $upazila ) 
                                            @if ( in_array( $upazila->id, $nameAddOnConstituency[0] ) ) 
                                                <option selected
                                                    value="{{$upazila['id']}}">
                                                    @if(session()->get('language') =='bn')
                                                        {{$upazila['bn_name']}}
                                                    @else
                                                        {{$upazila['name']}}
                                                    @endif
                                                </option>
                                            @endif
                                                
                                        @endforeach    
                    
        
                                    </select>
                                    <input name="upazila_ids[]" type="hidden" id="upazila_ids">

                                    @error('upazila_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="union_id">@lang('Union/Ward')</label>
                                    <select id="union_id" name="union_id" multiple="multiple" class="form-control select2 @error('union_id') is-invalid @enderror">
                                        <option value="">@lang('Select Union')</option>


                                        @php
                                            $nameAddOnConstituency = [( isset( $data->union_id ) ) ? ( explode( ",", $data->union_id ) ) : array( '' )];
                                        @endphp
                                        @foreach ( $unionList as $union ) 
                                            @if ( in_array( $union->id, $nameAddOnConstituency[0] ) ) 
                                                <option selected
                                                    value="{{$union['id']}}">
                                                    @if(session()->get('language') =='bn')
                                                        {{$union['bn_name']}}
                                                    @else
                                                        {{$union['name']}}
                                                    @endif
                                                </option>
                                            @endif
                                                
                                        @endforeach    
                    
        
                                    </select>
                                    <input name="union_ids[]" type="hidden" id="union_ids">

                                    @error('union_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" name="status" id="status" value="1">
                        @if($data->id)
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="status">@lang('Status') <span style="color: red;"> *</span></label>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="1" id="status_1"
                                               name="status" @if($data->status==1) {{"checked"}} @endif checked>
                                        <label for="status_1" class="custom-control-label">@lang('Active')</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" value="0" id="status_0"
                                               name="status" @if($data->status==0) {{"checked"}} @endif>
                                        <label for="status_0" class="custom-control-label">@lang('Inactive')</label>
                                    </div>
                                    <div>
                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror

                                    </div>

                                </div>
                            </div>
                        @endif

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{route('admin.master_setup.constituencies.index') }}">@lang('Back')</a>
                                    </button>
                                    
                                    @if($data->id)
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    @else
                                        <button type="reset" class="btn btn-danger btn-sm" onclick="resetForm(event, $(this));">@lang('Clear')</button>
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('#upazila_id').on("change", function(e) {
                $("#upazila_ids").val($(this).val());
            });

            $('#union_id').on("change", function(e) {
                $("#union_ids").val($(this).val());
            });


            // Get District List By Division Id:
            $('select[name="division_id"]').on('change', function () {
                var division_id = $(this).val();

                $('select[name="district_id"]').empty();
                $('select[name="district_id"]').append('<option value="">@lang('Select District')</option>');

                $('select[name="upazila_id"]').empty();
                $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

                if (division_id > 0) {
                    $.ajax({
                        url: '{{url("districtListByDivisionId")}}',
                        data:{division_id:division_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[name="district_id"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('select[name="district_id"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });
                } else {

                    $('select[name="district_id"]').empty();
                    $('select[name="district_id"]').append('<option value="">@lang('Select District')</option>');

                    $('select[name="upazila_id"]').empty();
                    $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

                }

            });


            // Get Upazila List By District Id:
            $('select[name="district_id"]').on('change', function () {
                var district_id = $(this).val();

                $('select[name="upazila_id"]').empty();
                $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

                if (district_id > 0) {
                    $.ajax({
                        url: '{{url("upazilaListByDistricId")}}',
                        data:{district_id:district_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[name="upazila_id"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('select[name="upazila_id"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });
                } else {

                    $('select[name="upazila_id"]').empty();
                    $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

                }

            });

            // Get Union List By Upazila Id:
            $('select[name="upazila_id"]').on('change', function () {
                var upazila_id = $(this).val();

                $('select[name="union_id"]').empty();
                $('select[name="union_id"]').append('<option value="">@lang('Select Union')</option>');

                if (upazila_id.length > 0) {
                    $.ajax({
                        url: '{{url("unionListByUpazilaId")}}',
                        data:{upazila_id:upazila_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[name="union_id"]').append('<option value="' + val.id + '">' + val.bn_name + ' - ' + val.upazilaNameBng + '</option>');
                                '<?php }else{ ?>'
                                $('select[name="union_id"]').append('<option value="' + val.id + '">' + val.name + ' - ' + val.upazilaNameEng +  '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });
                } else {

                    $('select[name="union_id"]').empty();
                    $('select[name="union_id"]').append('<option value="">@lang('Select Union')</option>');

                }

            });


            $('#ConstituencyForm').validate({
                ignore:[],
                errorPlacement: function(error, element){
                    error.insertAfter(element);
                },
                errorClass:'text-danger',
                validClass:'text-success',
            });
            jQuery.validator.addClassRules({
                'bn_name' : {
                    regex_bn:true,
                },
                'name' : {
                    regex_en : true,
                }
            });


        });
    </script>

@endsection
