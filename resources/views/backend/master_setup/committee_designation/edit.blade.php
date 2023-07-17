@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Committee Designation Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Committee Designation Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('Update Committee Designation')</h5>
                    <h4 class="card-title w-100"><a href="{{ route('admin.master_setup.committee_designation.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Committee Designation List')</a></h4> 
                </div>
                <div class="card-body">
                    <form id="createForm">
                        @csrf
                        @if (isset($committeeDesignation))
                        @method('PUT')
                        @endif 
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                <label for="" class="control-label"><span class="text-danger"> *</span>@lang('Designation Name (BN)')</label>
                                <input id="name_bn" type="text" name="name_bn" placeholder="@lang('Enter Designation')" class='name_bn form-control form-control-sm' value="{{$committeeDesignation->name_bn}}">        
                            </div>                            
                            <div class="from-group col-sm-6 col-md-3 col-lg-3">     
                                <label for="" class="control-label"><span class="text-danger"> *</span>@lang('Designation Name (EN)')</label>                               
                                <input id="name_en" type="text" name="name_en" placeholder="@lang('Enter Designation')" class='name_en form-control form-control-sm' value="{{$committeeDesignation->name_en}}">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="" class="control-label">@lang('Select Status')</label>
                                <select name="status" id="status" class="form-control form-control-sm">                          
                                    <option value="1" {{ ($committeeDesignation->status == 1)?('selected'):'' }}>@lang('Active')</option>
                                    <option value="0" {{ ($committeeDesignation->status == 0)?('selected'):'' }}>@lang('Inactive')</option>                                      
                                </select>                             
                                
                            </div>                 
                        </div>                
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    {{-- <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button> --}}
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{ route('admin.master_setup.committee_designation.index') }}">@lang('Back')</a>
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
                    url : "{{route('admin.master_setup.committee_designation.update',$committeeDesignation->id)}}",
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
            'name_bn' : {
                required : true,
                regex_bn:true,
            },
            'name_en' : {
                required : true,
                regex_en:true,
            },
            
        });


    });
</script>
@endsection
