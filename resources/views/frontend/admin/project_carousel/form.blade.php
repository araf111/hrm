@extends('backend.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Project Slide Management')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Project Slide Management')</li>
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
                        <h5>@lang('Update Project Slide')</h5>
                    @else
                        <h5>@lang('Create Project Slide')</h5>
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
                                    <label class="control-label" for="titleBng">@lang('Title (Bangla)')<span style="color: red;"> *</span></label>
                                    <input type="text" id="titleBng" name="titleBng"  value="{{ old('titleBng') ?? $editData->titleBng ?? '' }}"
                                           class="form-control titleBng @error('titleBng') is-invalid @enderror"
                                           placeholder="@lang('Enter Title in Bangla')" autocomplete="off">
                                    @error('titleBng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="titleEng">@lang('Title (English)')<span style="color: red;"> *</span></label>
                                    <input type="text" id="titleEng" name="titleEng"  value="{{ old('titleEng') ?? $editData->titleEng ?? '' }}"
                                           class="form-control titleEng @error('titleEng') is-invalid @enderror"
                                           placeholder="@lang('Enter Title in English')" autocomplete="off">
                                    @error('titleEng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="contentBng">
                                        @lang('Content (Bangla)')
                                        <span style="color: red;"> *</span>
                                    </label>
                                    
                                    <textarea name="contentBng" id="contentBng" class="textareaWithoutImgVideo form-control contentBng @error('contentBng') is-invalid @enderror" placeholder="@lang('Enter Content in Bangla')">
                                        {{ old('contentBng') ?? $editData->contentBng ?? '' }}
                                    </textarea>

                                    <div id="contentBngError"></div>

                                    @error('contentBng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="contentEng">
                                        @lang('Content (English)')
                                        <span style="color: red;"> *</span>
                                    </label>
                                    
                                    <textarea name="contentEng" id="contentEng" class="textareaWithoutImgVideo form-control contentEng @error('contentEng') is-invalid @enderror" placeholder="@lang('Enter Content in English')">
                                        {{ old('contentEng') ?? $editData->contentEng ?? '' }}
                                    </textarea>

                                    <div id="contentEngError"></div>

                                    @error('contentEng')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label" for="category_id">
                                        @lang('Category')
                                        <span style="color: red;"> *</span>
                                    </label>
                                    <select id="category_id" name="category_id" class="category_id @error('category_id') is-invalid @enderror form-control form-control-sm select2">
                                        <option value="">@lang('Select Category')</option>
                                        @foreach ($categories as $data)
                                            @if(session()->get('language') == 'bn')
                                                @if(isset($editData))
                                                    <option {{ $editData->category_id == $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nameBng }}</option>
                                                @else 
                                                    <option {{ old('category_id') == $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nameBng }}</option>
                                                @endif
                                            @else
                                                @if(isset($editData))
                                                    <option {{ $editData->category_id == $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nameBng }}</option>
                                                @else 
                                                    <option {{ old('category_id') == $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->nameBng }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
    
                                    @error('category_id')
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
                                        <img src="{{asset('public/frontend/images/project')}}/{{$editData->photo}}" alt="project" width="50px">
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
                                    <a href="{{route('admin.landing_page.project_carousels.index') }}" class="btn btn-dark btn-sm ion-android-arrow-back text-white"> @lang('Back')</a>
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
                    }else if(element.attr('name') == 'contentBng'){
                        error.insertAfter('#contentBngError');
                    }else if(element.attr('name') == 'contentEng'){
                        error.insertAfter('#contentEngError');
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
                        url : "{{(@$editData)?route('admin.landing_page.project_carousels.update',@$editData->id):route('admin.landing_page.project_carousels.store') }}",
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
                                   location.replace("{{route('admin.landing_page.project_carousels.index')}}");
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
                'titleBng' : {
                    required : true,
                    regex_bn:true,
                },
                'titleEng' : {
                    required : true,
                    regex_en:true,
                },
                'contentBng' : {
                    required : true,
                    regex_bn:true,
                },
                'contentEng' : {
                    required : true,
                    regex_en:true,
                },
                'category_id' : {
                    required : true,
                },
                'photo' : {
                    required : true,
                    extension: "jpg,jpeg,png",
                }
                
            }); 


        });
    </script>

@endsection