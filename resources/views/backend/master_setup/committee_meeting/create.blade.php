@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Committee Meeting Management')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Committee Meeting Management')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title w-100">
                    <a href="{{ route('admin.master_setup.committee_meeting.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Committee Meeting List')</a>
                </h4>
                <h5>@lang('Add Committee Meeting')</h5>
            </div>
            <div class="card-body">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="new_standing_committees_id">@lang('1'). @lang('Select Committee Name') <span class="text-danger"> *</span></label>
                            <select name="new_standing_committees_id" id="new_standing_committees_id" class="new_standing_committees_id @error('new_standing_committees_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="">@lang('Select Committee Name')</option>
                                @if (isset($newStandingCommittee) && count($newStandingCommittee) > 0)
                                @foreach ($newStandingCommittee as $data)
                                @if($data->id == old('new_standing_committees_id'))
                                <option selected value="{{ $data->id }}">{{ $data->committee_name }}</option>
                                @else
                                <option value="{{ $data->id }}">{{ $data->committee_name }}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            @error('new_standing_committees_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror        
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="committee_rooms_id">@lang('2'). @lang('Select Committee Room') <span class="text-danger"> *</span></label>
                            <select name="committee_rooms_id" id="committee_rooms_id" class="committee_rooms_id @error('committee_rooms_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="">@lang('Select Committee Room')</option>
                                @if (isset($committeeRoom) && count($committeeRoom) > 0)
                                    @foreach ($committeeRoom as $data)
                                        @if($data->id == old('committee_rooms_id'))
                                            <option selected value="{{ $data->id }}">{{ session()->get('language') == 'bn' ? $data->name_bn : $data->name_en }}</option>
                                        @else
                                            <option value="{{ $data->id }}">{{ session()->get('language') == 'bn' ? $data->name_bn : $data->name_en }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('committee_rooms_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror        
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="date_to">@lang('3'). @lang('Committee Status')</label>
                            <select name="status" id="status" class="form-control form-control-sm">                          
                                <option value="1">@lang('Active')</option>
                                <option value="0">@lang('Cancel')</option>                                    
                            </select>
                        </div>                         
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="date_meeting">@lang('4'). @lang('Select Date') <span class="text-danger"> *</span></label>
                            {{-- <input type="text" id="datepicker" value=""  name="date_meeting" class="date_meeting form-control form-control-sm @error('date_meeting') is-invalid @enderror" placeholder="" autocomplete="off"> --}}
                            <input type="text" id="datepicker" class="readonly_date nano_custom_date" name="date_meeting">

                            @error('date_meeting')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="time_starting">@lang('5'). @lang('Select Starting time') <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="time" id="time_starting" class="time_starting w-100 form-control form-control-sm @error('time_starting') is-invalid @enderror" name="time_starting" value=""/>
                            </div>
                            @error('time_starting')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="time_ending">@lang('6'). @lang('Select Ending time')</label>
                            <div class="input-group">
                                <input type="time" id="time_ending" class="time_ending form-control form-control-sm @error('time_ending') is-invalid @enderror" name="time_ending" value=""/>
                            </div>
                            @error('time_ending')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-sm">@lang('Submit')</button>
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                    <a href="{{ route('admin.master_setup.committee_meeting.index') }}">@lang('Back')</a>
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
        /// Date picker for Date of Birthklfk

        $('#datepicker').daterangepicker({
            startDate: "{{ date('d-m-Y') }}",
            minDate:"{{ date('d-m-Y') }}",
            singleDatePicker: true,
            locale: daterange_locale,
        });
        
    </script> 
    <script type="text/javascript">
        $(document).ready(function(){
            $.validator.addMethod("greaterThanTime", 
                function(value, element, params) {
                    if($("#time_ending").val() == ''){
                        return true;
                    }
                    var start_string = '2020-10-10 '+$("#time_starting").val();
                    var end_string = '2020-10-10 '+$("#time_ending").val();
                    var start_time = new Date(start_string.replace(/-/g,'/'));
                    var end_time = new Date(end_string.replace(/-/g,'/'));
                    if((start_time >= end_time) || (start_time =='Invalid Date')|| (end_time =='Invalid Date')){
                        return false;
                    }else{
                        return true;
                    }
                },
                'মিটিং শেষ সময়,মিটিং শুরু সময়ের থেকে বেশী হতে হবে। '
                );
        });
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
                        url : "{{route('admin.master_setup.committee_meeting.store')}}",
                        data : formInfo,
                        type : "POST",
                        processData: false,
                        contentType: false,
                        beforeSend : function(){
                            $('.preload').show();
                            
                        },
                        success:function(data){
                            //console.log(formInfo);
                            //console.log(formInfo.FormData.__proto);
                            
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
                'new_standing_committees_id' : {
                    required : true
                },
                'committee_rooms_id' : {
                    required : true
                },
                'date_meeting' : {
                    required : true
                },
                'time_starting' : {
                    required : true
                },
                'time_ending' : {                                   
                    greaterThanTime: $('.time_ending').val()
                }           
            });     
        });
    </script>
@endsection
