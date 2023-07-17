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
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="ministry_id">@lang('1'). @lang('Bulding Name') <span class="text-danger"> *</span></label>
                           <input class='form-control form-control-sm' type="text" value="@lang('Parliament Building')" readonly>   
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="ministry_id">@lang('2'). @lang('Select Block') <span class="text-danger"> *</span></label>
                            <select id="songshod_blocks_id" name="songshod_blocks_id" class="songshod_blocks_id form-control @error('songshod_blocks_id') is-invalid @enderror select2">
                                <option value="">@lang('Select Block Number')</option>
                                @foreach ($songshodBlock as $list)
                                {{-- @if($list->id==$data->block_id) --}}
                                <option selected value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                {{-- @else
                                <option value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option> --}}
                                {{-- @endif --}}
                                @endforeach
                            </select>

                            @error('ministry_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="songshod_floors_id">@lang('3'). @lang('Select Floor') <span class="text-danger"> *</span></label>
                            <select id="songshod_floors_id" name="songshod_floors_id" class="songshod_floors_id form-control @error('songshod_floors_id') is-invalid @enderror select2">
                                
                            </select>

                            @error('songshod_floors_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="songshod_rooms_id">@lang('4'). @lang('Select Room Number') <span class="text-danger"> *</span></label>
                            <select id="songshod_rooms_id" name="songshod_rooms_id[]" class="songshod_rooms_id[] songshod_rooms_id form-control @error('songshod_rooms_id') is-invalid @enderror select2" multiple>
                                
                            </select>

                            @error('songshod_rooms_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label class="control-label" for="parliament_session_id">@lang('5'). @lang('Parliament Session')<span class="text-danger"> *</span></label>
                        
                            <select id="parliament_session_id" name="parliament_session_id" class="parliament_session_id @error('parliament_session_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="">@lang('Select Parliament Session')</option>
                                @foreach($parliamentSession as $s)
                                <option value="{{$s->id}}">{{Lang::get($s->session_no)}}</option>
                                @endforeach
                            </select>
                            @error('parliament_session_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror  
                        </div>
                        <div class="col-sm-3 form-group">
                            <label class="control-label" for="user_id">@lang('6'). @lang('Select the Name') <span class="text-danger"> *</span></label>
                            <select name="user_id" class="user_id @error('user_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="">@lang('Select the Name')</option>
                                @if (isset($profiles) && count($profiles) > 0)
                                @foreach ($profiles as $data)
                                @if($data->user_id == old('user_id'))
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
                        <div class="form-group col-sm-2">
                            <label class="control-label" for="date_to">@lang('7'). @lang('Committee Status')</label>
                            <select name="status" id="status" class="form-control form-control-sm">                          
                                <option value="1">@lang('Active')</option>
                                <option value="0">@lang('Inactive')</option>                                      
                            </select>                             
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="allocation_date">@lang('8'). @lang('Allocation Date') <span class="text-danger"> *</span></label>
                            <input type="text" value="" id="datepicker" name="allocation_date" class="allocation_date form-control form-control-sm @error('allocation_date') is-invalid @enderror" placeholder="@lang('Allocation Date')" autocomplete="off">
                            @error('allocation_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="disallocation_date">@lang('9'). @lang('Disallocation Date')</label>
                            <input type="text" id="datepicker2" value=""  name="disallocation_date" class="disallocation_date form-control form-control-sm @error('disallocation_date') is-invalid @enderror" placeholder="@lang('Disallocation Date')" autocomplete="off">
                            @error('disallocation_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-right">
                                <button type="submit" name="submit"  value="@lang('Submit')"  class="btn btn-success btn-sm">@lang('Save')</button> 
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
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
<script type="text/javascript">
var booked_ids = @php echo json_encode($booked_ids , true); @endphp;

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
        
        $('#songshod_rooms_id').on('change', function () {
             var selectedRoom =  $(this).val();
                   for(var j=0; j<selectedRoom.length; j++){
                           
                        for(var i=0; i<booked_ids.length; i++){

                            if(selectedRoom[j]==booked_ids[i]){
                            // confirm('Selected room id is  already booked');
                            // Swal.fire('Selected room id is  already booked', '', 'warning');
                                    Swal.fire({
                                        title: '@lang("Room already bookeed")',
                                        text: "do you want to replace?",
                                        type: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'YES',
                                        cancelButtonText: 'NO'
                                    }).then((result) => {
                                        console.log(result);
                                        if (result.value) {
                                            //if you want to remove
                                            var url = "{{url('/admin/master-setup/mp_office_room/deletebyroom')}}";
                                            $.ajax({
                                                url: url,
                                                type: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    id:booked_ids[i],
                                                },

                                                // data: request_data,
                                                success: function(response) {
                                                    Swal.fire('Successfully removed', '', 'success');
                                                    // $('#songshod_rooms_id').html('');
                                                    // if (response !== '') {
                                                    //     $('#songshod_rooms_id').append(response);
                                                    // }
                                                }
                                            });

                                        } else {
                                            //if you dont want to remove
                                            // {{route('admin.master_setup.mp_office_room.destroy',$data->id)}}
                                            //Swal.fire('Your data is safe', '', 'success');
                                        }
                                        
                                    })
                                break;
                            }
                    
                        }
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
                    url : "{{route('admin.master_setup.mp_office_room.store')}}",
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
{{-- <script>
    $('#songshod_rooms_id').on('select',function () {
        console.log("Working");
        let room_id = $('#songshod_rooms_id').val();
        var id = parseInt(room_id);
        console.log(id);

        $.ajax({
       url: "{{ url('/admin/master-setup/allotedRoom')}}"+'/'+id,
       type: "POST",
       data: {
           _token: "{{ csrf_token() }}",
       },
       success: function(response) {
           response = JSON.parse(response);
           if (response.status == true) {
                alert("OK");
           } else {
               Swal.fire('@lang("No Data Found")', '', 'error');
               $('#list_container').html('');
           }
       }
   });


    });
</script> --}}

<script>
    

// $('#mySelect2').on('select2:select', function (e) {
//     var data = e.params.data;
//     console.log(data);
// });
</script>
@endsection
@push('page_scripts')
@include('backend.includes.location_scripts')
@endpush
