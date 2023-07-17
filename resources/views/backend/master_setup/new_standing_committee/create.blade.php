@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Standing Committee Forming Management')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Standing Committee Forming Management')</li>
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
                    <a href="{{ route('admin.master_setup.new_standing_committees.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Standing Committee List')</a>
                </h4>
                <h5>@lang('Standing Committee Forming')</h5>
            </div>
            <div class="card-body">
                <form id="createForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="" class="control-label">@lang('1').@lang('Enter Committee Name')<span class="text-danger"> *</span></label>
                            <input type="text" name="committee_name" placeholder="@lang('Enter Committee Name')" class='committee_name form-control form-control-sm @error('committee_name') is-invalid @enderror'>
                            @error('committee_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror        
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="parliament_id">@lang('2'). @lang('Select Parliament No') <span class="text-danger"> *</span></label>
                            <select name="parliament_id" id="parliament" class="@error('parliament_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="{{ $parliaments->id ?? null }}">{{ Lang::get($parliaments->parliament_number) ?? null }}</option>
                            </select>
                            @error('parliament_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror      
                        </div>  
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="ministry_id">@lang('3'). @lang('Select Ministry')</label>
                            <select name="ministry_id" id="ministry_id" class="@error('ministry_id') is-invalid @enderror form-control form-control-sm select2">
                                <option value="">@lang('Select Ministry')</option>
                                @if (isset($ministries) && count($ministries) > 0)
                                @foreach ($ministries as $data)
                                @if($data->id == old('ministry_id'))
                                <option selected value="{{ $data->id }}">{{ $data->name_bn }}</option>
                                @else
                                <option value="{{ $data->id }}">{{ $data->name_bn }}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                            @error('ministry_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror        
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="date_from">@lang('4'). @lang('Committee Forming Date') <span class="text-danger"> *</span></label>
                            <input type="text" value="" id="datepicker" name="date_from" class="date_from form-control form-control-sm @error('date_from') is-invalid @enderror" placeholder="@lang('Committee Forming Date')" autocomplete="off">
                            @error('date_from')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="date_to">@lang('5'). @lang('Committee Closing Date')</label>
                            <input type="text" id="datepicker2" value=""  name="date_to" class="date_to form-control form-control-sm @error('date_to') is-invalid @enderror" placeholder="@lang('Committee Closing Date')" autocomplete="off">
                            @error('date_to')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div> 
                        <div class="form-group col-sm-4">
                            <label class="control-label" for="date_to">@lang('6'). @lang('Committee Status')</label>
                            <select name="committeeStatus" id="committeeStatus" class="form-control form-control-sm">                          
                                <option value="1">@lang('Active')</option>
                                <option value="0">@lang('Inactive')</option>                                      
                            </select>                             
                        </div>  

                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <label class="control-label" for="user_id">@lang('7'). @lang('Add Standing Committee Member') </label>
                            </div>
                        </div>
                        <div id="add_extra_div">
                            <div class="remove_extra_div">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3 form-group">
                                            <select name="user_id[1]" class="@error('user_id') is-invalid @enderror form-control form-control-sm select2">
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
                                        <div class="col-sm-3 form-group">
                                            <select name="designation_id[1]" class="@error('designation_id') is-invalid @enderror form-control form-control-sm select2">
                                                <option value="">@lang('Select the Designation')</option>
                                                @if (isset($committee_designations) && count($committee_designations) > 0)
                                                @foreach ($committee_designations as $data)
                                                @if($data->id == old('id'))
                                                <option selected value="{{ $data->id }}">
                                                    @if(session()->get('language') =='bn')
                                                    {{ $data->name_bn }}
                                                    @else
                                                    {{ $data->name_en }}
                                                    @endif
                                                </option>
                                                @else
                                                <option value="{{ $data->id }}">
                                                    @if(session()->get('language') =='bn')
                                                    {{ $data->name_bn }}
                                                    @else
                                                    {{ $data->name_en }}
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
                                        <div class="col-sm-3 form-group">
                                            <select name="status[1]" class="form-control form-control-sm">                          
                                                <option value="1">@lang('Active')</option>
                                                <option value="0">@lang('Inactive')</option>                                      
                                            </select>
                                        </div> 
                                        <div class="col-sm-3 form-group">
                                            <i class="btn btn-info fa fa-plus-circle add_extra"></i> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-right">
                                <button type="submit" name="submit"  value="@lang('Submit')"  class="btn btn-success btn-sm">@lang('Save')</button> 
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                    <a href="{{ route('admin.master_setup.new_standing_committees.index') }}">@lang('Back')</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script id="extra_templete" type="text/x-handlebars-template">
    <div class="remove_extra_div">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-3 form-group">
                    <select name="user_id[@{{counter}}]" class="@error('user_id') is-invalid @enderror form-control form-control-sm select2">
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
                <div class="col-sm-3 form-group">
                    <select name="designation_id[@{{counter}}]" class="@error('designation_id') is-invalid @enderror form-control form-control-sm select2">
                        <option value="">@lang('Select the Designation')</option>
                        @if (isset($committee_designations) && count($committee_designations) > 0)
                        @foreach ($committee_designations as $data)
                        @if($data->id == old('id'))
                        <option selected value="{{ $data->id }}">
                            @if(session()->get('language') =='bn')
                            {{ $data->name_bn }}
                            @else
                            {{ $data->name_en }}
                            @endif
                        </option>
                        @else
                        <option value="{{ $data->id }}">
                            @if(session()->get('language') =='bn')
                            {{ $data->name_bn }}
                            @else
                            {{ $data->name_en }}
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
                <div class="col-sm-3 form-group">
                    <select name="status[@{{counter}}]" class="form-control form-control-sm">                          
                        <option value="1">@lang('Active')</option>
                        <option value="0">@lang('Inactive')</option>                                      
                    </select>
                </div> 
                <div class="col-sm-3 form-group">
                    <i class="btn btn-info fa fa-plus-circle add_extra"></i>  
                    <i class="btn btn-danger fa fa-minus-circle remove_extra"> </i>  
                </div> 
            </div>
        </div>
    </div>
</script> 

<script type="text/javascript">  
    $(document).ready(function(){  
        var counter = '10000';  
        $(document).on("click",".add_extra",function(){  
            var source = $("#extra_templete").html();  
            var template = Handlebars.compile(source);   
            var data= {counter:counter};   
            var html = template(data);   
            counter ++;  
            $("#add_extra_div").append(html);  
            $('.select2').select2(); 
        });   

        $(document).on("click", ".remove_extra", function (event) {  
            $(this).closest(".remove_extra_div").remove();         
        });   
    });   
</script> 
@endsection
@section('script')
<script>
    /// Date picker for Date of Birthklfk
        $('#datepicker').datepicker({
                uiLibrary: 'bootstrap'
            });
   
            $('#datepicker2').datepicker({
                uiLibrary: 'bootstrap'
            });
</script> 
    <script type="text/javascript">
        $(document).ready(function(){
            $.validator.addMethod("greaterThanDate", 
                function(value, element, params) {
                    var start_string = $("#datepicker").val();
                    var end_string = $("#datepicker2").val();
                    var start_time = new Date(start_string.replace(/-/g,'/'));
                    var end_time = new Date(end_string.replace(/-/g,'/'));
                    if((start_time >= end_time) || (start_time =='Invalid Date')|| (end_time =='Invalid Date')){
                        return false;
                    }else{
                        return true;
                    }
                },
                'কমিটি শেষ তারিখ,কমিটি গঠন তারিখ থেকে পরবর্তী যে কোন দিন হতে হবে।'
                );
        });
</script>
<script>
    $(document).ready(function(){
        $('#createForm').validate({
            ignore:[],
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            errorClass:'text-danger',
            validClass:'text-success',

            submitHandler: function (form) {
                event.preventDefault();

                $('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
                var formInfo = new FormData($("#createForm")[0]);
                
                $.ajax({
                    url : "{{route('admin.master_setup.new_standing_committees.store')}}",
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
            'committee_name' : {
                required : true
            },
            'date_from' : {
                required : true
            },            
            'date_to' : {
                greaterThanDate : $('.date_to').val()?true:false 
            },                        
        });


    });
</script> 
@endsection
@push('page_scripts')
@include('backend.includes.location_scripts')
@endpush
