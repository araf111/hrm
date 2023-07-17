<!-- 
 * Author M. Atoar Rahman
 * Date: 23/08/2021
 * Time: 11:40 AM
-->
<section id="mp_search" class="p-0">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="map">
                        <img src="{{asset( 'public/frontend/images/map.png')}}" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="mp_search text-center">
                        <h4>@lang('Search Your MP')</h4>
                        <form>
                            <div class="form-group mb-3">
                                <div class="form-group">
                                    <select id="division_id" name="division_id" class="form-control select2 @error('division_id') is-invalid @enderror">
                                        {!! divisionDropdown() !!}
                                    </select>

                                    @error('division_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="form-group">
                                    <select id="district_id" name="district_id" class="form-control select2 @error('district_id') is-invalid @enderror">
                                        <option value="">@lang('Select District')</option>
                   
                                    </select>

                                    @error('district_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="form-group">
                                    <select id="upazila_id" name="upazila_id" class="form-control select2 @error('upazila_id') is-invalid @enderror">
                                        <option value="">@lang('Select Upazila')</option>
        
                                    </select>

                                    @error('upazila_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <p class="orClass">@lang('OR')</p>
                            <div class="input-group mb-3">
                                <select id="mp_id" name="mp_id" class="form-control select2 @error('mp_id') is-invalid @enderror">
                                    <option value="">@lang('Select MP')</option>
                                    @foreach ($profileData as $data)
                                        <option  value="{{$data['userId']}}">
                                            @if(session()->get('language') =='bn')
                                                {{$data['nameBng']}} - {{ digitDateLang($data['bangladeshNumber'])}}, {{ $data['voterAreaBng'] }}
                                            @else
                                            {{$data['nameEng']}} - {{ digitDateLang($data['bangladeshNumber'])}}, {{ $data['voterAreaEng'] }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                                @error('mp_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button id="submitBtn" class="btn btn-search"  type="button">@lang('Search')</button>
                            </div>
                            
                          </form>
                          <!-- Modal -->
                        <div class="modal fade" id="mpModal" tabindex="-1" aria-labelledby="mpModalLabel" aria-hidden="true">
                            <form  id="submitForm">
                                @csrf
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            {{-- <h5 style="font-size: 18px;" id="mpModalLabel"></h5> --}}
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row" style="text-align: left;">
                                                    {{-- <input type="hidden" id="mp_user_id" name="mp_id" class="form-control" value=""> --}}

                                                    <div class="col-12">
                                                        <label class="control-label" for="mp_user_id">
                                                            @lang('MP')
                                                            <span style="color: red;"> *</span>
                                                        </label> 
                                                    </div> 
                                                    <div class="col-12 mb-3">
                                                        <select id="mp_user_id" name="mp_id" class="form-control  @error('mp_user_id') is-invalid @enderror">
                                                            
                                                        </select>

                                                        @error('mp_user_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                <div class="col-12 mb-3">
                                                    <label class="control-label" for="citizenName">
                                                        @lang('Name')
                                                        <span style="color: red;"> *</span>
                                                    </label>   

                                                    <input type="text" id="citizenName" name="citizenName" class="form-control formOnInput" placeholder="@lang('Enter Name')" value="{{ old('citizenName')}}">
                                                    
                                                    @error('citizenName')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="control-label" for="citizenMobile">
                                                        @lang('Mobile No.')
                                                        <span style="font-size:10px;"> (@lang('Optional'))</span>
                                                    </label>   

                                                    <input type="number" id="citizenMobile" name="citizenMobile" class="form-control formOnInput" placeholder="@lang('Enter Mobile No.')" value="{{ old('citizenMobile')}}">
                                                    
                                                    @error('citizenMobile')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-12"> 
                                                    <label class="control-label" for="citizenQuestion">
                                                        @lang('Question')
                                                        <span style="color: red;"> *</span>
                                                    </label>

                                                    <textarea name="citizenQuestion" id="citizenQuestion" class="form-control citizenQuestion formOnInput @error('citizenQuestion') is-invalid @enderror" placeholder="@lang('Enter Message in Bangla')">
                                                        {{ old('citizenQuestion') }}
                                                    </textarea>

                                                    @error('citizenQuestion')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                                            <button id="questionSubmitBtn" type="button" class="btn btn-success btn-sm">@lang('Save')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {

        $('select[name="division_id"]').on('change', function () {
            var division_id = $(this).val();

            $('select[name="district_id"]').empty();
            $('select[name="district_id"]').append('<option value="">@lang('Select District')</option>');

            $('select[name="upazila_id"]').empty();
            $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

            if (division_id > 0) {
                $.ajax({
                    url: '{{url("districtByDivision")}}',
                    data:{division_id:division_id},
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        //$('#loader').css("visibility", "visible");
                    },
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('select[name="district_id"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('select[name="district_id"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    },
                    complete: function () {
                        //$('#loader').css("visibility", "hidden");
                    }
                });
            } else {

                $('select[name="district_id"]').empty();
                $('select[name="district_id"]').append('<option value="">@lang('Select District')</option>');

                $('select[name="upazila_id"]').empty();
                $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

            }

        });

        $('select[name="district_id"]').on('change', function () {
            var district_id = $(this).val();

            $('select[name="upazila_id"]').empty();
            $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

            if (district_id > 0) {
                $.ajax({
                    url: '{{url("upazilaByDistric")}}',
                    data:{district_id:district_id},
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        //$('#loader').css("visibility", "visible");
                    },
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('select[name="upazila_id"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('select[name="upazila_id"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    },
                    complete: function () {
                        //$('#loader').css("visibility", "hidden");
                    }
                });
            } else {

                $('select[name="upazila_id"]').empty();
                $('select[name="upazila_id"]').append('<option value="">@lang('Select Upazila')</option>');

            }

        });

    });
</script>
<script>
$(document).ready(function () {

    $('#submitBtn').on('click', function () {
        var mp_id = $('#mp_id').val();
        var division_id = $("#division_id").val();
        var district_id = $("#district_id").val();
        var upazila_id = $("#upazila_id").val();
        
        $.ajax({
            url: '{{route("mpList")}}',
            type: "GET",
            dataType: "json",
            data: {
                mp_id: mp_id,
                division_id: division_id,
                district_id: district_id,
                upazila_id: upazila_id,
            },
            success: function (result) {

                $.each(result.data, function (k, val) {
                    '<?php if(session()->get('language') =='bn'){ ?>'
                    $('#mp_user_id').append('<option value="' + val.user_id + '">'+ val.voterAreaBng +', ' + val.nameBng + '</option>');
                    '<?php }else{ ?>'
                    $('#mp_user_id').append('<option value="' + val.user_id + '">'+ val.voterAreaEng +', ' + val.nameEng + '</option>');
                    '<?php } ?>'
                });

                

                // $('#mpModalLabel').text(result.data.nameBng +' - '+ result.data.voterAreaBng );
                // $('#mp_user_id').val(result.data.user_id);
                // console.log(result.data);
            },
            complete: function () {
                //$('#loader').css("visibility", "hidden");
            }
        });
        if(mp_id > 0){
            $("#mpModal").modal('show');
        }else if(division_id>0 || district_id>0 || upazila_id>0){
            $("#mpModal").modal('show');
        }
        
        
    });


    $('#questionSubmitBtn').on('click', function () {
        // var mp_id = $('#mp_id').val();
        var mp_id = $('#mp_user_id').val();
        var citizenName = $("#citizenName").val();
        var citizenMobile = $("#citizenMobile").val();
        var citizenQuestion = $("#citizenQuestion").val();

        if(citizenName.length==0){
            toastr.error('The Name Field is Required!');
            $('#citizenName').addClass('focusedInput');
        }
        else if(citizenMobile.length!=0){
            if (citizenMobile.length < 11) {
                toastr.error('The Mobile No. is Invalid!');
                $('#citizenMobile').addClass('focusedInput');
            }else if(citizenQuestion.length==0){
                toastr.error('The Question Field is Required!');
                $('#citizenQuestion').addClass('focusedInput');
            }else{
                $.ajax({
                    url: '{{route('citizen_questions.store') }}',
                    type: "POST",
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        mp_id: mp_id,
                        citizenName: citizenName,
                        citizenMobile: citizenMobile,
                        citizenQuestion: citizenQuestion,
                    },
                    success:function(data){
                        if(data.status == 'success'){
                            toastr.success("",data.message);
                            $('.preload').hide();
                            $("#mpModal").modal('hide');
                            
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
        }
        else if(citizenQuestion.length==0){
            toastr.error('The Question Field is Required!');
            $('#citizenQuestion').addClass('focusedInput');
        }else{
            $.ajax({
                url: '{{route('citizen_questions.store') }}',
                type: "POST",
                dataType: "json",
                data: {
                    _token: "{{ csrf_token() }}",
                    mp_id: mp_id,
                    citizenName: citizenName,
                    citizenMobile: citizenMobile,
                    citizenQuestion: citizenQuestion,
                },
                success:function(data){
                    if(data.status == 'success'){
                        toastr.success("",data.message);
                        $('.preload').hide();
                        $("#mpModal").modal('hide');
                        
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

    $('#citizenMobile').keydown(function(e){
        var $this = $(this);
        var val = $this.val();
        if( val.length>10 && e.keyCode != 8 ){        
            e.preventDefault();
        }
    });

    $('.formOnInput').on('keyup', function () {
        if ($.trim($('.formOnInput').val()).length) {
            $(this).removeClass('focusedInput');
        }
    });
});

</script>


