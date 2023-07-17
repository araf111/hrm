@extends('backend.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Bottom Section Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Bottom Section Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">

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
                                    <label class="control-label" for="sectionName">@lang('Section Name')</label>
                                    <input type="text" id="sectionName" name="sectionName"  value="{{ old('sectionName') ?? $editData->sectionName ?? '' }}"
                                        class="form-control sectionName @error('sectionName') is-invalid @enderror"
                                        placeholder="@lang('Enter Section Name')" autocomplete="off">
                                    @error('sectionName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header">
                                <h5>@lang('Bottom 1')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title1Bng">@lang('Title (Bangla)')</label>
                                            <input type="text" id="title1Bng" name="title1Bng"  value="{{ old('title1Bng') ?? $editData->title1Bng ?? '' }}"
                                                class="form-control title1Bng @error('title1Bng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title1Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title1Eng">@lang('Title (English)')</label>
                                            <input type="text" id="title1Eng" name="title1Eng"  value="{{ old('title1Eng') ?? $editData->title1Eng ?? '' }}"
                                                class="form-control title1Eng @error('title1Eng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title1Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content1Bng">
                                                @lang('Content (Bangla)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content1Bng" id="content1Bng" class="textareaWithoutImgVideo form-control content1Bng @error('content1Bng') is-invalid @enderror" placeholder="@lang('Enter Content in Bangla')">
                                                {{ old('content1Bng') ?? $editData->content1Bng ?? '' }}
                                            </textarea>

                                            <div id="content1BngError"></div>

                                            @error('content1Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content1Eng">
                                                @lang('Content (English)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content1Eng" id="content1Eng" class="textareaWithoutImgVideo form-control content1Eng @error('content1Eng') is-invalid @enderror" placeholder="@lang('Enter Content in English')">
                                                {{ old('content1Eng') ?? $editData->content1Eng ?? '' }}
                                            </textarea>
                                            <div id="content1EngError"></div>

                                            @error('content1Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header"><h3>
                                <h5>@lang('Bottom 2')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title2Bng">@lang('Title (Bangla)')</label>
                                            <input type="text" id="title2Bng" name="title2Bng"  value="{{ old('title2Bng') ?? $editData->title2Bng ?? '' }}"
                                                class="form-control title2Bng @error('title2Bng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title2Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title2Eng">@lang('Title (English)')</label>
                                            <input type="text" id="title2Eng" name="title2Eng"  value="{{ old('title2Eng') ?? $editData->title2Eng ?? '' }}"
                                                class="form-control title2Eng @error('title2Eng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title2Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content2Bng">
                                                @lang('Content (Bangla)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content2Bng" id="content2Bng" class="textareaWithoutImgVideo form-control content2Bng @error('content2Bng') is-invalid @enderror" placeholder="@lang('Enter Content in Bangla')">
                                                {{ old('content2Bng') ?? $editData->content2Bng ?? '' }}
                                            </textarea>
                                            <div id="content2BngError"></div>

                                            @error('content2Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content2Eng">
                                                @lang('Content (English)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content2Eng" id="content2Eng" class="textareaWithoutImgVideo form-control content2Eng @error('content2Eng') is-invalid @enderror" placeholder="@lang('Enter Content in English')">
                                                {{ old('content2Eng') ?? $editData->content2Eng ?? '' }}
                                            </textarea>
                                            <div id="content2EngError"></div>

                                            @error('content2Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>

                        <div class="card card-success">
                            <div class="card-header">
                                <h5>@lang('Bottom 3')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title3Bng">@lang('Title (Bangla)')</label>
                                            <input type="text" id="title3Bng" name="title3Bng"  value="{{ old('title3Bng') ?? $editData->title3Bng ?? '' }}"
                                                class="form-control title3Bng @error('title3Bng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title3Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title3Eng">@lang('Title (English)')</label>
                                            <input type="text" id="title3Eng" name="title3Eng"  value="{{ old('title3Eng') ?? $editData->title3Eng ?? '' }}"
                                                class="form-control title3Eng @error('title3Eng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title3Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content3Bng">
                                                @lang('Content (Bangla)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content3Bng" id="content3Bng" class="textareaWithoutImgVideo form-control content3Bng @error('content3Bng') is-invalid @enderror" placeholder="@lang('Enter Content in Bangla')">
                                                {{ old('content3Bng') ?? $editData->content3Bng ?? '' }}
                                            </textarea>
                                            <div id="content3BngError"></div>

                                            @error('content3Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content3Eng">
                                                @lang('Content (English)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content3Eng" id="content3Eng" class="textareaWithoutImgVideo form-control content3Eng @error('content3Eng') is-invalid @enderror" placeholder="@lang('Enter Content in English')">
                                                {{ old('content3Eng') ?? $editData->content3Eng ?? '' }}
                                            </textarea>
                                            <div id="content3EngError"></div>

                                            @error('content3Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>

                        <div class="card card-dark">
                            <div class="card-header">
                                <h5>@lang('Bottom 4')</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title4Bng">@lang('Title (Bangla)')</label>
                                            <input type="text" id="title4Bng" name="title4Bng"  value="{{ old('title4Bng') ?? $editData->title4Bng ?? '' }}"
                                                class="form-control title4Bng @error('title4Bng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title4Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="title4Eng">@lang('Title (English)')</label>
                                            <input type="text" id="title4Eng" name="title4Eng"  value="{{ old('title4Eng') ?? $editData->title4Eng ?? '' }}"
                                                class="form-control title4Eng @error('title4Eng') is-invalid @enderror"
                                                placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                            @error('title4Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content4Bng">
                                                @lang('Content (Bangla)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content4Bng" id="content4Bng" class="textareaWithoutImgVideo form-control content4Bng @error('content4Bng') is-invalid @enderror" placeholder="@lang('Enter Content in Bangla')">
                                                {{ old('content4Bng') ?? $editData->content4Bng ?? '' }}
                                            </textarea>
                                            <div id="content4BngError"></div>

                                            @error('content4Bng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label" for="content4Eng">
                                                @lang('Content (English)')
                                                <span style="color: red;"> *</span>
                                            </label>
                                            
                                            <textarea name="content4Eng" id="content4Eng" class="textareaWithoutImgVideo form-control content4Eng @error('content4Eng') is-invalid @enderror" placeholder="@lang('Enter Content in English')">
                                                {{ old('content4Eng') ?? $editData->content4Eng ?? '' }}
                                            </textarea>
                                            <div id="content4EngError"></div>

                                            @error('content4Eng')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                            </div>
                        </div>


                        <div class="row">
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
                                    <a href="{{route('admin.landing_page.bottom_sections.index') }}" class="btn btn-dark btn-sm ion-android-arrow-back text-white"> @lang('Back')</a>
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
                errorPlacement: function (error, element) {
                    if(element.hasClass('select2') && element.next('.select2-container').length) {
                        error.insertAfter(element.next('.select2-container'));
                    }else if(element.attr('name') == 'content1Bng'){
                        error.insertAfter('#content1BngError');
                    }else if(element.attr('name') == 'content1Eng'){
                        error.insertAfter('#content1EngError');
                    }else if(element.attr('name') == 'content2Bng'){
                        error.insertAfter('#content2BngError');
                    }else if(element.attr('name') == 'content2Eng'){
                        error.insertAfter('#content2EngError');
                    }else if(element.attr('name') == 'content3Bng'){
                        error.insertAfter('#content3BngError');
                    }else if(element.attr('name') == 'content3Eng'){
                        error.insertAfter('#content3EngError');
                    }else if(element.attr('name') == 'content4Bng'){
                        error.insertAfter('#content4BngError');
                    }else if(element.attr('name') == 'content4Eng'){
                        error.insertAfter('#content4EngError');
                    }else{
                        error.insertAfter(element);
                    }
                },
                errorClass:'text-danger',
                validClass:'text-success',

                submitHandler: function (form) {
                    event.preventDefault();
                    $('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
                    var formInfo = new FormData($("#submitForm")[0]);
                    $.ajax({
                        url : "{{(@$editData)?route('admin.landing_page.bottom_sections.update',@$editData->id):route('admin.landing_page.bottom_sections.store') }}",
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
                                   location.replace("{{route('admin.landing_page.bottom_sections.index')}}");
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
                'sectionName' : {
                    required : false,
                    regex_en:true,
                },
                'title1Bng' : {
                    required : false,
                    regex_bn:true,
                },
                'title1Eng' : {
                    required : false,
                    regex_en:true,
                },
                'content1Bng' : {
                    required : true,
                    regex_bn:true,
                },
                'content1Eng' : {
                    required : true,
                    regex_en:true,
                },
                'title2Bng' : {
                    required : false,
                    regex_bn:true,
                },
                'title2Eng' : {
                    required : false,
                    regex_en:true,
                },
                'content2Bng' : {
                    required : true,
                    regex_bn:true,
                },
                'content2Eng' : {
                    required : true,
                    regex_en:true,
                },
                'title3Bng' : {
                    required : false,
                    regex_bn:true,
                },
                'title3Eng' : {
                    required : false,
                    regex_en:true,
                },
                'content3Bng' : {
                    required : true,
                    regex_bn:true,
                },
                'content3Eng' : {
                    required : true,
                    regex_en:true,
                },
                'title4Bng' : {
                    required : false,
                    regex_bn:true,
                },
                'title4Eng' : {
                    required : false,
                    regex_en:true,
                },
                'content4Bng' : {
                    required : true,
                    regex_bn:true,
                },
                'content4Eng' : {
                    required : true,
                    regex_en:true,
                }
                
            }); 


        });
    </script>

@endsection