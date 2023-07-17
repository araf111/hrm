@extends('backend.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Slider Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Slider Management')</li>
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
                        <h5>@lang('Update Slider')</h5>
                    @else
                        <h5>@lang('Create Slider')</h5>
                    @endif
                </div>
                <!-- Form Start-->
                <form  id="submitForm">
                    @if(@$editData)
                    <input name="_method" type="hidden" value="PUT">
                    @endif
                    @csrf


                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="sliderTitleBng">@lang('Slider Title (Bangla)')<span style="color: red;"> *</span></label>
                                    <input type="text" id="sliderTitleBng" name="sliderTitleBng"  value="{{ old('sliderTitleBng') ?? $editData->sliderTitleBng ?? '' }}"
                                           class="form-control sliderTitleBng @error('sliderTitleBng') is-invalid @enderror"
                                           placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                    @error('sliderTitleBng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="sliderTitleEng">@lang('Slider Title (English)')<span style="color: red;"> *</span></label>
                                    <input type="text" id="sliderTitleEng" name="sliderTitleEng"  value="{{ old('sliderTitleEng') ?? $editData->sliderTitleEng ?? '' }}"
                                           class="form-control sliderTitleEng @error('sliderTitleEng') is-invalid @enderror"
                                           placeholder="@lang('Enter Title in English')" autocomplete="off">
                                    @error('sliderTitleEng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="readMoreLink">@lang('Read More Link')<span style="color: red;"> *</span></label>
                                    <input type="text" id="readMoreLink" name="readMoreLink"  value="{{ old('readMoreLink') ?? $editData->readMoreLink ?? '' }}"
                                           class="form-control readMoreLink @error('readMoreLink') is-invalid @enderror"
                                           placeholder="@lang('Enter Read More Link')" autocomplete="off">
                                    @error('readMoreLink')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="photo">@lang('Photo')<span style="color: red;"> *</span></label>
                                    <input type="file" accept="image/*" class="form-control photo photo_upload pl-1" name="photo" id="photo" accept=".png, .jpg, .jpeg">
                                    @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @isset($editData->photo)
                                        <img src="{{asset('public/frontend/images/slide')}}/{{$editData->photo}}" alt="Slider" width="50px">
                                    @endisset
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="logo">@lang('Logo')</label>
                                    <input type="file" accept="image/*" class="form-control logo_upload pl-1" name="logo" id="logo" accept=".png, .jpg, .jpeg">
                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    @isset($editData->logo)
                                        <img src="{{asset('public/frontend/images/slide')}}/{{$editData->logo}}" alt="Slider" width="50px">
                                    @endisset
                                </div>
                            </div>

                            @if (isset($editData))
                            <div class="col-sm-6 mt-4 pt-2">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="status" {{ $editData->status == 1 ? 'checked' : '' }} value="1" class="custom-control-input" id="active-status">
                                        <label class="custom-control-label" for="active-status">@lang('Make it Active/Inactive ?')</label>
                                      </div>
                                </div>
                            </div>
                            @endif

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    <a href="{{route('admin.landing_page.sliders.index') }}" class="btn btn-dark btn-sm ion-android-arrow-back text-white"> @lang('Back')</a>
                                    @if(@$editData->id)
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    @else
                                        <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
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

@endsection

@section('script')

    <script>
        $(document).ready(function(){
            $('#submitForm').validate({
                ignore:[],
                errorPlacement: function(error, element){
                    error.insertAfter(element);
                },
                errorClass:'text-danger',
                validClass:'text-success',

                submitHandler: function (form) {
                    event.preventDefault();
                    $('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
                    var formInfo = new FormData($("#submitForm")[0]);
                    $.ajax({
                        url : "{{(@$editData)?route('admin.landing_page.sliders.update',@$editData->id):route('admin.landing_page.sliders.store') }}",
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
                                   location.replace("{{route('admin.landing_page.sliders.index')}}");
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
                'sliderTitleBng' : {
                    required : true,
				    regex_bn:true,
                },
                'sliderTitleEng' : {
                    required : true,
				    regex_en:true,
                },
                'readMoreLink' : {
                    required : true,
                },
                'photo' : {
                    required : true,
                    extension: "jpg,jpeg,png",
                },
                'logo' : {
                    required : false,
                    extension: "jpg,jpeg,png",
                }
                
            }); 


        });
    </script>

@endsection