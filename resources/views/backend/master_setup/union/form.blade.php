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


    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if (isset($editData))
                    <h4 class="card-title">@lang('Update Union')</h4>
                    @else
                    <h4 class="card-title">@lang('Create Union')</h4>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Form Start-->
                    <form  id="submitForm">
                        @if(@$editData)
                        <input name="_method" type="hidden" value="PUT">
                        @endif
                        @csrf

                        <div class="panel-body has-location-info">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Division')<span class="text-danger">*</span></label>
                                        <select id="division_id" class="form-control select2" name="division_id">
                                            {!!divisionDropdown(isset($editData) && $editData?$editData->division_id:null)!!}
                                        </select>
                                        <span id="division_id_msg" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('District')<span class="text-danger">*</span></label>
                                        <select id="district_id" class="form-control select2" name="district_id">
                                            <option value="">@lang('Select District')</option>
                                            @isset($editData)
                                                @foreach ($districtList as $list)
                                                    @if($list['id']==$editData->district_id or $list['id']==old('district_id'))
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
                                            @endisset
                                        </select>
                                        <span id="district_id_msg" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Upazila')<span class="text-danger">*</span></label>
                                        <select id="upazila_id" class="form-control select2" name="upazila_id">
                                            <option value="">@lang('Select Upazila')</option>
                                            @isset($editData)
                                                @foreach ($upazilaList as $list)
                                                    @if($list['id']==$editData->upazila_id or $list['id']==old('upazila_id'))
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
                                            @endisset
                                        </select>
                                        <span id="upazila_id_msg" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Name (Bangla)')<span class="text-danger">*</span></label>
                                        <input id="bn_name" type="text" name="bn_name" class="form-control form-control-sm bn_name" placeholder="@lang('Enter Union Name in Bangla')" value="{{(isset($editData) && $editData)?$editData->bn_name:''}}" />
                                        <span id="bn_name_msg" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Name (English)')<span class="text-danger">*</span></label>
                                        <input id="name" type="text" name="name" class="form-control form-control-sm name" placeholder="@lang('Enter Union Name in English')" value="{{(isset($editData) && $editData)?$editData->name:''}}" />
                                        <span id="name_msg" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Latitude')</label>
                                        <input type="text" name="lat" class="form-control form-control-sm" value="{{(isset($editData) && $editData)?$editData->lat:''}}" placeholder="@lang('Enter Latitude')" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Longitude')</label>
                                        <input type="text" name="lon" class="form-control form-control-sm" value="{{(isset($editData) && $editData)?$editData->lon:''}}" placeholder="@lang('Enter Longitude')" />
                                    </div>
                                </div>

                                @if (isset($editData))
                                <div class="col-sm-3 mt-4">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="status" {{ $editData->status == 1 ? 'checked' : '' }} value="1" class="custom-control-input" id="active-status">
                                            <label class="custom-control-label" for="active-status">@lang('Make it Active/Inactive ?')</label>
                                          </div>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <a href="{{route('admin.master_setup.unions.index') }}" class="btn btn-dark btn-sm ion-android-arrow-back text-white"> @lang('Back')</a>
                                    @if(@$editData->id)
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    @else
                                        <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </form>
                    <!--Form End-->
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

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

        });
    </script>
    <script>
        $(document).ready(function(){

            $('#submitForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                var division_id           = $('#division_id').val();
                var district_id           = $('#district_id').val();
                var upazila_id            = $('#upazila_id').val();
                var bn_name               = $('#bn_name').val();
                var name                  = $('#name').val();

                if(division_id.length==0){
                    $('#division_id_msg').text('The Division Field is Required!');
                    $('[aria-labelledby="select2-division_id-container"]').addClass('focusedInput');
                    scrollTop("#division_id");
                }else if(district_id.length==0){
                    $('#district_id_msg').text('The District Field is Required!');
                    $('[aria-labelledby="select2-district_id-container"]').addClass('focusedInput');
                    scrollTop("#district_id");
                }else if(upazila_id.length==0){
                    $('#upazila_id_msg').text('The Upazila Field is Required!');
                    $('[aria-labelledby="select2-upazila_id-container"]').addClass('focusedInput');
                    scrollTop("#upazila_id");
                }else if(bn_name.length==0){;
                        $('#bn_name_msg').text('The Name Field is Required!');
                        $('#bn_name').addClass('focusedInput');
                        scrollTop("#bn_name");
                }else if(name.length==0){
                        $('#name_msg').text('The Name Field is Required!');
                        $('#name').addClass('focusedInput');
                        scrollTop("#name");
                } else {             
                    $.ajax({
                        type: 'POST',
                        url: "{{(@$editData)?route('admin.master_setup.unions.update',@$editData->id):route('admin.master_setup.unions.store') }}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                    .then(function(data) {
                        if(data.status == 'success'){
                                toastr.success("",data.message);
                                $('.preload').hide();
                                setTimeout(function(){
                                location.replace("{{route('admin.master_setup.unions.index')}}");
                            }, 1450);
                            }else if(data.status == 'error'){
                                toastr.error("",data.message);
                                $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                                $('.preload').hide();
                            }else{
                                toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
                                $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                                $('.preload').hide();
                            }
                    })
                    .catch(function(error) {
                        Swal.fire('Error!!!', '', 'error');
                    });
                }
            });

            $('#submitForm').validate({
                ignore:[],
                errorPlacement: function(error, element){
                    error.insertAfter(element);
                },
                errorClass:'text-danger',
                validClass:'text-success',

            });

            jQuery.validator.addClassRules({
                'bn_name' : {
                    required : true,
                    regex_bn:true,
                },
                'name' : {
                    required : true,
                    regex_en:true,
                },
                
            });


        });
    </script>

@endsection
