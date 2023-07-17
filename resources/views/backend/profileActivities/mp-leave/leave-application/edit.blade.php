@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Leave Header')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Appointment Management')</li>
                        <li class="breadcrumb-item active">@lang('Leave Application')</li>
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

                </div>
                
                <!-- Form Start-->
                <form  id="mpLeaveForm" method="POST" enctype="multipart/form-data" >
                    @csrf

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-4 col-lg-4">
                                    <label class="control-label" for="from_date">@lang('From Date')<span style="color: red;"> *</span></label>
                                    <div class="input-group date" id="from_date" data-target-input="nearest">
                                        <input type="text" value="{{ $editData->from_date}}"  class="form-control datetimepicker-input @error('date') is-invalid @enderror from_date" name="from_date" id="datepicker"  placeholder="@lang('Select Date')" data-target="#from_date" autocomplete="off" />
                                        <div class="input-group-append" data-target="#from_date" data-toggle="datetimepicker">

                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>

                                    @error('from_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{route('admin.profile-activities.mp-leave.leave-application.index')}}">@lang('Go back to the list')</a>
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    </div>



@endsection
@section('script')
    <script>

        $(document).ready(function(){
            //Date picker
            $('#from_date').datetimepicker({
                startDate: new Date(),
                format: 'DD-MM-YYYY'
            });

            $('#to_date').datetimepicker({
                startDate: new Date(),
                format: 'DD-MM-YYYY'
            });

            $("form").click(function(){
                var startdate = $("input.from_date").val().substring(3, 5)+'/'+$("input.from_date").val().substring(0, 2)+'/'+$("input.from_date").val().substring(6, 10);
                var enddate = $("input.to_date").val().substring(3, 5)+'/'+$("input.to_date").val().substring(0, 2)+'/'+$("input.to_date").val().substring(6, 10);
                var from_date = Date.parse(startdate);
                var to_date = Date.parse(enddate);
                if(from_date && to_date){
                    const diffTime = Math.abs(to_date - from_date);
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    $("input.total_day").val(diffDays);
                }
            });

            //return false;
            $('form#mpLeaveForm').validate({
                ignore:[],
                errorPlacement:function (error, element ){
                    error.insertAfter(element)
                },
                errorClass:'text-danger',
                validClass:'text-success',

                submitHandler: function (form) {

                    event.preventDefault();
                    $('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
                    var formInfo = new FormData($("#mpLeaveForm")[0]);
                    $.ajax({
                        url : "{{isset($editData) ? route('admin.profile-activities.mp-leave.leave-application.update',$editData):route('admin.profile-activities.mp-leave.leave-application.store')}}",
                        data : formInfo,
                        type : "POST",
                        processData: false,
                        contentType: false,
                        beforeSend : function(){
                            $('.preload').show();
                        },

                        success:function (data) {
                            console.log(data);
                            if(data.status == 'success'){
                                toastr.success("",data.message);
                                $('.preload').hide();
                                setTimeout(function () {
                                    location.replace(data.reload_url);

                                },2000);
                            }else if(data.status =='error'){
                                toastr.error("",data.message);
                                $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                                $('.preload').hide();
                            }else{
                                toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
                                $('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
                                $('.preload').hide();
                            }
                        }
                    });
                }
            });

            jQuery.validator.addClassRules({
                'from_date': {
                    required: true,
                },
                'to_date': {
                    required: true,
                },
                'holiday_reason_id': {
                    required: true,
                },
                'attach_file': {
                    extension: "jpg,jpeg,png,pdf",
                }

            });



        });
    </script>



@endsection


