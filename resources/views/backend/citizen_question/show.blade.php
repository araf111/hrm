@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Citizen Question Management')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Citizen Question Management')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="col-md-12">
        <div class="card"><div class="card-header">
                <h4 style="display: block; float:left">@lang('Citizen Question')</h4>
                <a  style="display: block; float:right" href="{{url('citizen-question/questions')}}" class="btn btn-sm btn-info"> @lang('Back')</a>
            </div>
            
            <div class="card-body">
                <p><strong>@lang('Citizen Name'): </strong>{{ $viewData->citizenName }}</p>
                <p><strong>@lang('Citizen Mobile Number'): </strong>{{ $viewData->citizenMobile }}</p>
                <p><strong>@lang('Question'): </strong>{{ $viewData->citizenQuestion }}</p>
                <p><strong>@lang('MP Answer'): </strong>{{ $viewData->mpAnswer }}</p>
            </div>
            <form  id="submitForm" class="{{ $viewData->mpAnswer!=''? 'd-none': '' }}">
                @csrf
                <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <input id="questionId" type="hidden" value="{{ $viewData->id }}">
                        <div class="form-group">
                            <label class="control-label" for="mpAnswer">
                                @lang('Answer')
                                <span style="color: red;"> *</span>
                            </label>
                            
                            <textarea rows="5" name="mpAnswer" id="mpAnswer" class="form-control mpAnswer @error('mpAnswer') is-invalid @enderror" placeholder="@lang('Enter Answer')">
                                {{ old('mpAnswer') ?? $editData->mpAnswer ?? '' }}
                            </textarea>

                            @error('mpAnswer')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group text-right">
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                <button id="answerSubmitBtn" type="button" class="btn btn-success btn-sm">@lang('Save')</button>

                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#answerSubmitBtn').on('click', function () {
            var id = $("#questionId").val();
            var mpAnswer = $("#mpAnswer").val();
            
            $.ajax({
                url: '{{url("citizen-question/questions/answer") }}',
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    mpAnswer: mpAnswer,
                },
                success:function(data){
                    if(data.status == 'success'){
                        toastr.success("",data.message);
                        $('.preload').hide();
                        
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
            
        });
    }); 

</script>

@endsection