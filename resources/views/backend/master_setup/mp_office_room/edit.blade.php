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
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title w-100">
                    <a href="{{ route('admin.master_setup.mp_office_room.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Office Room List')</a>
                </h4>
                <h5>@lang('Office Room Allotation')</h5>
            </div>
            <div class="card-body">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
                    @if (isset($mpOfficeRoom))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="ministry_id">@lang('1'). @lang('Bulding Name') <span class="text-danger"> *</span></label>
                           <input class='form-control form-control-sm' type="text" value="@lang('Parliament Building')" readonly>   
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="ministry_id">@lang('2'). @lang('Select Block') <span class="text-danger"> *</span></label>
                            <select id="songshod_blocks_id" name="songshod_blocks_id" class="songshod_blocks_id form-control @error('songshod_blocks_id') is-invalid @enderror select2">
                                <option value="">@lang('Select Block Number')</option>
                                @if (isset($songshodBlock) && count($songshodBlock) > 0)
                                @foreach ($songshodBlock as $list)
                                    @if($list->id == $mpOfficeRoom->songshod_blocks_id)                    

                                    <option selected value="{{$list->id}}">{{(session()->get('language') =='bn') ? $list->name_bn : $list->name}}</option>
                                    @else
                                    <option value="{{ $list->id }}">{{ (session()->get('language') =='bn') ? $list->name_bn : $list->name }}</option> 
                                    @endif 
                                @endforeach
                                @endif
                            </select>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="ministry_id">@lang('3'). @lang('Select Floor') <span class="text-danger"> *</span></label>
                            <select id="songshod_floors_id" name="songshod_floors_id" class="songshod_floors_id form-control @error('songshod_floors_id') is-invalid @enderror select2">
                                @if (isset($songshodFloor) && count($songshodFloor) > 0)
                                @foreach ($songshodFloor as $list)
                                    @if($list->id == $mpOfficeRoom->songshod_floors_id)                    

                                        <option selected value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                        {{-- @else
                                        <option value="{{ $list->id }}">{{ $list->name_bn }}</option>  --}}
                                    @endif 
                                @endforeach
                                @endif
                            </select>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="ministry_id">@lang('4'). @lang('Select Room Number') <span class="text-danger"> *</span></label>
                            <select id="songshod_rooms_id" name="songshod_rooms_id[]" class="songshod_rooms_id[] songshod_rooms_id form-control @error('songshod_rooms_id') is-invalid @enderror select2" multiple>
                                @if (isset($songshodRoom) && count($songshodRoom) > 0)
                                @foreach ($songshodRoom as $data)
                                
                                <option value="{{ $data->id }}" @if(in_array($data->id,$mp_rooms_array)) {{ 'selected' }} @endif>{{ $data->room_bn }}</option>
                               
                                @endforeach
                                @endif 
                            </select>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label class="control-label" for="date_to">@lang('5'). @lang('Parliament Session')<span class="text-danger"> *</span></label>
                            <select name="parliament_session_id" id="parliament_session_id" readonly class="form-control select2" style="width:100%">
                                <option value="">@lang('Parliament Session')</option>
                                @foreach($parliamentSession as $s)
                                <option value="{{$s->id}}" {{ ($s->id)?('selected'):'' }} >{{Lang::get($s->session_no)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label class="control-label" for="ministry_id">@lang('5'). @lang('Select the Name') <span class="text-danger"> *</span></label>
                            <select name="user_id" class="user_id @error('user_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="">@lang('Select the Name')</option>
                                @if (isset($profiles) && count($profiles) > 0)
                                @foreach ($profiles as $data)
                                @if($data->user_id == $mpOfficeRoom->mp_id))
                                <option selected value="{{ $data->user_id }}">
                                    @if(session()->get('language') =='bn')
                                    {{ $data->name_bn }}
                                    @else
                                    {{ $data->name_eng }}
                                    @endif
                                </option>
                                @else
                                <option value="{{ $data->user_id }}">
                                    @if(session()->get('language') =='bn')
                                    {{ $data->name_bn }}
                                    @else
                                    {{ $data->name_eng }}
                                    @endif
                                </option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="date_to">@lang('6'). @lang('Status')</label>
                            <select name="status" id="status" class="form-control form-control-sm">                          
                                <option value="1" {{($mpOfficeRoom->status == 1)?('selected'):''}}>@lang('Active')</option>
                                <option value="0" {{($mpOfficeRoom->status == 0)?('selected'):''}}>@lang('Inactive')</option>                                    
                            </select>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="allocation_date">@lang('8'). @lang('Allocation Date') <span class="text-danger"> *</span></label>
                            <input type="text" value="{{ $mpOfficeRoom->allocation_date }}" id="datepicker" name="allocation_date" class="allocation_date form-control form-control-sm @error('allocation_date') is-invalid @enderror" placeholder="@lang('Allocation Date')" autocomplete="off">
                            @error('allocation_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="disallocation_date">@lang('9'). @lang('Disallocation Date')</label>
                            <input type="text" id="datepicker2" value="{{ $mpOfficeRoom->disallocation_date }}"  name="disallocation_date" class="disallocation_date form-control form-control-sm @error('disallocation_date') is-invalid @enderror" placeholder="@lang('Disallocation Date')" autocomplete="off">
                            @error('disallocation_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-right">
                                <button type="submit" name="submit"  value="@lang('Submit')"  class="btn btn-success btn-sm">@lang('Update')</button> 
                                <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                    <a href="{{ route('admin.master_setup.mp_office_room.index') }}">@lang('Back')</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap'
    });
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap'
    });
    $(document).ready(function(){
        $("#songshod_blocks_id").on('change', function() {
            if ($(this).val() == '') {
                $('#songshod_floors_id').html('');
            } else {
                var url = "{{url('/admin/master-setup/committee_room/floor')}}"+'/'+$(this).val();
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {
                        $('#songshod_floors_id').html('');
                        if (response !== '') {
                            $('#songshod_floors_id').append(response);
                        }
                    }
                });
            }

        });
        $("#songshod_floors_id").on('change', function() {
            if ($(this).val() == '') {
                $('#songshod_rooms_id').html('');
            } else {
                var url = "{{url('/admin/master-setup/committee_room/room')}}/"+$('#songshod_blocks_id').val()+"/"+$(this).val() ;
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {
                        $('#songshod_rooms_id').html('');
                        if (response !== '') {
                            $('#songshod_rooms_id').append(response);
                        }
                    }
                });
            }

        });
        $("#songshod_rooms_id").on('change', function() {
            if ($(this).val() == '') {
            } else {
                var url = "{{url('/admin/master-setup/committee_room/phonepabx')}}/"+$('#songshod_blocks_id').val()+"/"+ $('#songshod_floors_id').val()+"/"+$(this).val() ;
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {             
                    //    console.log(response);
                        response = JSON.parse(response);
                        if (response !== '') {
                            $('#telephone').val(response.phone);
                            $('#pabx').val(response.pabx);
                        }
                    }
                });
            }

        });
    })
</script>


<script>
    $(document).ready(function(){
        $('#createForm').validate({
            ignore:[],
            errorPlacement: function (error, element) {
                if(element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                }else{
                    error.insertAfter(element);
                }
            },
            errorClass:'text-danger',
            validClass:'text-success',

            submitHandler: function (form) {
                event.preventDefault();

                $('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
                var formInfo = new FormData($("#createForm")[0]);
                
                $.ajax({
                    url : "{{route('admin.master_setup.mp_office_room.update',$mpOfficeRoom->id)}}",
                    data : formInfo,
                    type : "POST",
                    processData: false,
                    contentType: false,
                    beforeSend : function(){
                        $('.preload').show();
                        
                    },
                    success:function(data){
                        
                        if(data.status == 'success'){
                            toastr.success("",data.message);
                            $('.preload').hide();
                            setTimeout(function(){
                                location.replace(data.reload_url);
                            }, 2000);
                        }else if(data.status == 'error'){
                            toastr.error("",data.message);
                            $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                            $('.preload').hide();
                        }else{
                            toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
                            $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                            $('.preload').hide();
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
                        $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                        $('.preload').hide();
                    }
                });
            }
        });
        jQuery.validator.addClassRules({
            'songshod_rooms_id[]' : {
                required : true
            },
            'parliament_session_id' : {
                required : true
            },
            'songshod_floors_id' : {
                required : true
            },
            'allocation_date' : {
                required : true
            },
            'user_id' : {
                required : true
            }                       
        });
    });
</script> 
@endsection
@push('page_scripts')
@include('backend.includes.location_scripts')
@endpush
