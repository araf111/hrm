<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@extends('frontend.layouts.index')
<style>
    .focusedInput {
        border-color: rgb(247 60 60) !important;
        outline: 0;
        outline: thin dotted \9;
        -moz-box-shadow: 0 0 3px rgba(255, 0, 0);
        box-shadow: 0 0 3px rgba(255,0,0) !important;
    }
    .menu_bar .btn-login{margin-top: 3px;}
</style>
@section('content')

@include('frontend.layouts.header')

<section class="breadcrumb_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h3>@lang('Petition Application Form')</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="#">@lang('হোম')</a></li>
                    <li class="breadcrumb-item"><a href="#">@lang('Petition')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('Petition Application Form')</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


    <!-- Content Header (Page header) -->
    <div class="content-header mt-5">
        <div class="container text-center">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h4 class="my-3 text-dark">@lang('Petition Application Form') (@lang('Rule-102'))</h4>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container mb-5">
        <div class="col-md-12">
        <div class="card p-5">
            <p>@lang('Honorable Chairman')<br/>
                @lang('Petition Committee') <br/>
                    @lang('Bangladesh National Parliament')<br/>
                        @lang('Adjacent to the Peoples Republic of Bangladesh')</p>

                <form method="POST" enctype="multipart/form-data" id="petitionCreateForm" class="form-horizontal mt-3"  action="javascript:void(0)">
                <div class="row mt-4">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group mb-3">
                            <label class="control-label" for="applicant_name">@lang('Applicant Name') <span class="text-danger"> *</span></label>

                            <div class="input-group">
                                <input type="text" class="form-control formOnInput @error('applicant_name') is-invalid @enderror" name="applicant_name" id="applicant_name" value="{{old('applicant_name')}}" placeholder="@lang('Enter Applicant Name')" />
                                
                            </div>

                            <span id="applicant_name_msg" class="text-danger"></span>
                            @error('applicant_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group mb-3">
                            <label class="control-label" for="applicant_designation">@lang('Applicant Designation') <span class="text-danger"> *</span></label>

                            <div class="input-group">
                                <input type="text" required class="form-control formOnInput @error('applicant_designation') is-invalid @enderror" name="applicant_designation" id="applicant_designation" value="{{old('applicant_designation')}}" placeholder="@lang('Enter Applicant Designation')" />
                                
                            </div>
                            <span id="applicant_designation_msg" class="text-danger"></span>
                            @error('applicant_designation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <input type="hidden" name="rule_number" value="102">
                
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label class="control-label" for="parliament_session">@lang('Address') <span class="text-danger"> *</span></label>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group mb-3">
                            <select id="applicant_division_id" name="applicant_division_id" class="form-control formOnSelect @error('applicant_division_id') is-invalid @enderror select2">
                                <option value="">@lang('Select Division')</option>
                                @foreach ($divisions as $data)
                                    @if($data['id']==old('applicant_division_id'))
                                        <option selected
                                                value="{{$data['id']}}">
                                                @if(session()->get('language') =='bn')
                                                    {{$data['bn_name']}}
                                                @else
                                                    {{$data['name']}}
                                                @endif
                                        </option>
                                    @else
                                        <option  value="{{$data['id']}}">
                                            @if(session()->get('language') =='bn')
                                                {{$data['bn_name']}}
                                            @else
                                                {{$data['name']}}
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <span id="applicant_division_id_msg" class="text-danger"></span>
                            @error('applicant_division_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group mb-3">
                            <select id="applicant_district_id" name="applicant_district_id" class="form-control formOnSelect @error('applicant_district_id') is-invalid @enderror  select2">
                                <option value="">@lang('Select District')</option>

                            </select>
                            <span id="applicant_district_id_msg" class="text-danger"></span>
                            @error('applicant_district_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group mb-3">
                            <select id="applicant_upazila_id" name="applicant_upazila_id" class="form-control formOnSelect @error('applicant_upazila_id') is-invalid @enderror  select2">
                                <option value="">@lang('Upazila/City Corporations')</option>

                            </select>
                            <span id="applicant_upazila_id_msg" class="text-danger"></span>
                            @error('applicant_upazila_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-3">
                        <div class="form-group mb-3">
                            <select id="applicant_union" name="applicant_union" class="form-control select2 @error('applicant_union') is-invalid @enderror">
                                <option value="">@lang('Union/Ward')</option>
                                  
                            </select>
                            <span id="applicant_union_msg" class="text-danger"></span>
                            @error('applicant_union')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control formOnInput @error('applicant_union') is-invalid @enderror" name="applicant_union" id="applicant_union" value="{{old('applicant_union')}}" placeholder="@lang('Enter Union')" />
                                
                            </div>
                            <span id="applicant_union_msg" class="text-danger"></span>
                            @error('applicant_union')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group mb-3">
                            <textarea id="applicant_more_address" name="applicant_more_address" class="form-control @error('applicant_more_address') is-invalid @enderror" placeholder="@lang('Write More')">
                                {{old('applicant_more_address')}} 
                                </textarea>

                            @error('applicant_more_address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label" for="description">@lang('Summary of the Subject Matter of the Petition') <span class="text-danger"> *</span></label>
                        
                            <textarea rows="8" id="description" name="description" class="form-control formOnInput @error('description') is-invalid @enderror">
                            {{old('description')}}
                            </textarea>
                            <span id="description_msg" class="text-danger"></span>
                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="control-label" for="prayer">@lang('Prayer of the Applicant') <span class="text-danger"> *</span></label>
                        
                            <textarea rows="8" id="prayer" name="prayer" class="form-control formOnInput @error('prayer') is-invalid @enderror">
                            {{old('prayer')}}
                            </textarea>
                            <span id="prayer_msg" class="text-danger"></span>
                            @error('prayer')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12">
                        <!-- radio -->
                        <label class="control-label" for="description">
                            @lang('Will The Applicant Be More Than One?')
                        </label>
                        <div class="form-group mb-3 clearfix">
                            <div class="icheck-primary d-inline mr-4">
                                <input type="radio" id="radioPrimary2" value="1" name="type" checked>
                                <label for="radioPrimary2">
                                    @lang('Yes')
                                </label>
                            </div>
                            <div class="icheck-primary d-inline">
                                <input type="radio" id="radioPrimary3" value="2" name="type"
                                    {{ $data->type == 2 ? 'checked' : '' }}>
                                <label for="radioPrimary3">
                                    @lang('No')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="applicant">
                    <div class="row mb-3">
                        <div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="control-label" for="parliament_session">@lang('Name, Address and Signature of the Applicants') <span class="text-danger"> *</span></label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-3">
                                        
                                        <div class="input-group">
                                            <input type="text" class="form-control formOnInput @error('multi_name') is-invalid @enderror" name="applicant_list[name][]" id="multi_name_0" value="{{old('multi_name')}}" placeholder="@lang('Enter Applicant Name')" />
                                            
                                        </div>
                                        <span id="multi_name_0_msg" class="text-danger"></span>
                                        @error('multi_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control formOnInput @error('signature') is-invalid @enderror" name="applicant_list[signature][]" id="signature_0" value="{{old('signature')}}" placeholder="@lang('Signature')" />
                                            
                                        </div>
                                        <span id="signature_0_msg" class="text-danger"></span>
                                        @error('signature')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group mb-3">
                                        <select id="division_id_0" name="applicant_list[division][]" class="form-control division_id formOnSelect @error('division_id') is-invalid @enderror  select2">
                                            <option value="">@lang('Select Division')</option>
                                            @foreach ($divisions as $data)
                                                @if($data['id']==old('division_id'))
                                                    <option selected
                                                            value="{{$data['id']}}">
                                                            @if(session()->get('language') =='bn')
                                                                {{$data['bn_name']}}
                                                            @else
                                                                {{$data['name']}}
                                                            @endif
                                                    </option>
                                                @else
                                                    <option  value="{{$data['id']}}">
                                                        @if(session()->get('language') =='bn')
                                                            {{$data['bn_name']}}
                                                        @else
                                                            {{$data['name']}}
                                                        @endif
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <span id="division_id_0_msg" class="text-danger"></span>
                                        @error('division_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group mb-3">
                                        <select id="district_id_0" name="applicant_list[district][]" class="form-control district_id formOnSelect @error('district_id') is-invalid @enderror  select2">
                                            <option value="">@lang('Select District')</option>

                                        </select>
                                        <span id="district_id_0_msg" class="text-danger"></span>
                                        @error('district_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group mb-3">
                                        <select id="upazila_id_0"  name="applicant_list[upazila][]" class="form-control upazila_id formOnSelect @error('upazila_id') is-invalid @enderror  select2">
                                            <option value="">@lang('Select Upazila')</option>

                                        </select>
                                        <span id="upazila_id_0_msg" class="text-danger"></span>
                                        @error('upazila_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group mb-3">
                                        <select id="union_id_0"  name="applicant_list[union][]" class="form-control union_id formOnSelect @error('union_id') is-invalid @enderror  select2">
                                            <option value="">@lang('Select Union')</option>

                                        </select>
                                        <span id="union_id_0_msg" class="text-danger"></span>
                                        @error('union_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                
                                {{-- <div class="col-sm-12 col-md-3 col-lg-3">
                                    <div class="form-group mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control formOnInput @error('union') is-invalid @enderror" name="applicant_list[union][]" id="union_id_0" value="{{old('union')}}" placeholder="@lang('Enter Union')" />
                                            
                                        </div>
                                        <span id="union_id_0_msg" class="text-danger"></span>
                                        @error('union')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <textarea id="more_address_0" name="applicant_list[more_address][]" class="form-control @error('more_address') is-invalid @enderror" placeholder="@lang('Write More')">
                                            {{old('more_address')}} 
                                            </textarea>

                                        @error('more_address')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-1" style="display: contents;">
                            <button type="button" class="btn btn-success addApplicant  btn-lg"> <i class="fa fa-plus"> </i> </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group mb-3">
                            <label class="control-label" for="mp_name">@lang('Parliament Member Information') <span class="text-danger"> *</span> <span style="font-size: 10px;">(@lang('In Terms of the Applicant Address'))</span></label>
                        
                            <select id="mp_name" name="mp_name" class="@error('mp_name') is-invalid @enderror form-control formOnSelect select2">
                                <option value="">@lang('Select MP Name')</option>

                                {{-- @foreach ($profileDatas as $data)
                                    <option value="{{ $data->user_id }}">{{ $data->name_bn }}</option>
                                @endforeach --}}

                            </select>
                            <span id="mp_name_msg" class="text-danger"></span>
                            @error('mp_name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group mb-3">
                            <label class="control-label" for="attachment">@lang('Attachment (if any)')</label>

                            <div class="file p-0">
                                <input type="file" class="form-control attachment_upload pl-1" name="attachment[]" id="attachment" multiple accept=".png, .jpg, .jpeg, .pdf, .doc, .docx, .txt">
                            </div>

                            @error('attachment')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group text-center mt-4">
                            <button type="button" id="modalBtn" class="btn btn-success mt-2">@lang('Next Step')</button>                                    
                        </div>
                    </div>
                </div>




  
            <!-- Modal -->
            <div class="modal fade" id="petitionModal" tabindex="-1" aria-labelledby="petitionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="petitionModalLabel">@lang('Applicant')</h5>
                        <h6 class="modal-title d-none" id="otpModalLabel">@lang('Enter OTP number that send to your given mobile number')</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3 contactInfo">
                            <div class="input-group">
                                <input type="number" min="0" inputmode="numeric" pattern="[0-9]*" class="form-control formOnInput @error('applicant_nid') is-invalid @enderror" name="applicant_nid" id="applicant_nid" value="{{old('applicant_nid')}}" placeholder="@lang('Enter NID No.')" />
                                
                            </div>
                            <span id="applicant_nid_msg" class="text-danger"></span>
                            @error('applicant_nid')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 contactInfo">
                            <div class="input-group" data-target-input="nearest">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span style="border-bottom-right-radius: 0; border-top-right-radius: 0;">+88</span>
                                    </div>
                                </div>
                                <input type="number" min="0" inputmode="numeric" pattern="[0-9]*" class="form-control formOnInput @error('applicant_mobile') is-invalid @enderror" name="applicant_mobile" id="applicant_mobile" value="{{old('applicant_mobile')}}" placeholder="@lang('Enter Mobile No.')" />
                                
                            </div>
                            <span id="applicant_mobile_msg" class="text-danger"></span>
                            @error('applicant_mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 contactInfo">
                            <div class="input-group">
                                <input type="email" class="form-control formOnInput @error('applicant_email') is-invalid @enderror" name="applicant_email" id="applicant_email" value="{{old('applicant_email')}}" placeholder="@lang('Enter Email')" />
                                
                            </div>
                            <span id="applicant_email_msg" class="text-danger"></span>
                            @error('applicant_email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 otpInfo d-none">
                            <div class="input-group">
                                <input type="text" class="form-control formOnInput @error('otp_number') is-invalid @enderror" name="otp_number" id="otp_number" value="{{old('otp_number')}}" placeholder="@lang('Enter OTP')" />
                                
                            </div>
                            <span id="otp_number_msg" class="text-danger"></span>
                            @error('otp_number')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group mb-3 otpView d-none">

                            <button type="button" id="otpViewBtn" class="btn btn-success">@lang('Resend OTP')</button>

                            <div class="d-none" style="float: right;
                            font-weight: 700;
                            border: 1px solid;
                            padding: 5px 15px;" id="otpView"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="backBtn" class="btn btn-dark d-none">@lang('Back')</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="button" id="submitBtn" class="btn btn-success">@lang('Next Step')</button>
                        <button type="submit" id="finalSubmitBtn" class="btn btn-success d-none">@lang('Send')</button>
                    </div>
                </div>
                </div>
            </div>

             <!-- Modal -->

            </form> 
        </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- START FOOTER -->
    @include('frontend.layouts.footer')

    @endsection

    @section('scripts')


    <script>
        $(function(){

            $('input[type=radio][name=type]').change(function() {

                if (this.value != '2') {
                    $('#applicant').show();
                    $('#radioPrimary2').val(1);

                } else if (this.value == '2') {
                    $('#applicant').hide();
                    $('#radioPrimary2').val(0);

                }

            });


            $('.formOnInput').on('keyup', function () {
                if ($.trim($('.formOnInput').val()).length) {
                    $(this).removeClass('focusedInput');
                }
            });

            $('.formOnSelect').on('change', function () {
                $('.select2-selection').removeClass('focusedInput');
            });

            function scrollTop(id){
                $('html, body').animate({
                    scrollTop: $(id).offset().top - 100
                }, 200);
            }

            $('#applicant_name, #applicant_designation, #description, #prayer, #multi_name_0, #signature_0, #applicant_email, #otp_number').on('input', function () {
                var $this = $(this);
                var val = $this.val();
                if (val.length >0) {
                    $('#applicant_name_msg, #applicant_designation_msg, #description_msg, #prayer_msg, #multi_name_0_msg, #signature_0_msg, #applicant_email_msg, #otp_number_msg').text(''); 
                    $(this).removeClass('focusedInput');
                }
            });

            $('#applicant_division_id, #applicant_district_id, #applicant_upazila_id, #division_id_0, #district_id_0, #upazila_id_0, #mp_name').on('change', function () {
                var $this = $(this);
                var val = $this.val();
                if (val.length >0) {
                    $('#applicant_division_id_msg, #applicant_district_id_msg, #applicant_upazila_id_msg,  #division_id_0_msg, #district_id_0_msg, #upazila_id_0_msg,  #mp_name_msg').text(''); 
                    $(this).removeClass('focusedInput');
                }
            }); 
            
            $('#applicant_union').on('change', function () {
                var $this = $(this);
                var val = $this.val();
                if (val.length >0) {
                    $('#applicant_union_msg').text(''); 
                    $('[aria-labelledby="select2-applicant_union-container"]').removeClass('focusedInput');
                }
            });

            $('#union_id_0').on('change', function () {
                var $this = $(this);
                var val = $this.val();
                if (val.length >0) {
                    $('#union_id_0_msg').text(''); 
                    $('[aria-labelledby="select2-union_id_0-container"]').removeClass('focusedInput');
                }
            });

            $('#applicant_email').on('change', function () {
                var $this = $(this);
                var val = $this.val();
                if (val.length >0) {
                    $('#applicant_email_msg').text(''); 
                    $(this).removeClass('focusedInput');
                }
            });

            $('#modalBtn').on('click', function () {
                var applicant_name          = $('#applicant_name').val();
                var applicant_designation   = $('#applicant_designation').val();
                var applicant_division_id   = $('#applicant_division_id').val();
                var applicant_district_id   = $('#applicant_district_id').val();
                var applicant_upazila_id    = $('#applicant_upazila_id').val();
                var applicant_union         = $('#applicant_union').val();
                var description             = $('#description').val();
                var prayer                  = $('#prayer').val();

                var mp_name                 = $('#mp_name').val();
                var attachment              = $('#attachment').val();

                var multi_applicant         = $('#radioPrimary2').val();
                var multi_name_0            = $('#multi_name_0').val();
                var signature_0             = $('#signature_0').val();
                var division_id_0           = $('#division_id_0').val();
                var district_id_0           = $('#district_id_0').val();
                var upazila_id_0            = $('#upazila_id_0').val();
                var union_id_0              = $('#union_id_0').val();

                if(applicant_name.length==0){
                    // toastr.error('The Name Field is Required!');
                    $('#applicant_name_msg').text('The Name Field is Required!');
                    $('#applicant_name').addClass('focusedInput');
                    scrollTop("#applicant_name");
                }else if(applicant_designation.length==0){
                    // toastr.error('The Designation Field is Required!');
                    $('#applicant_designation_msg').text('The Designation Field is Required!');
                    $('#applicant_designation').addClass('focusedInput');
                    scrollTop("#applicant_designation");
                }else if(applicant_division_id.length==0){
                    // toastr.error('The Division Field is Required!');
                    $('#applicant_division_id_msg').text('The Division Field is Required!');
                    $('[aria-labelledby="select2-applicant_division_id-container"]').addClass('focusedInput');
                    scrollTop("#applicant_division_id");
                }else if(applicant_district_id.length==0){
                    // toastr.error('The District Field is Required!');
                    $('#applicant_district_id_msg').text('The District Field is Required!');
                    $('[aria-labelledby="select2-applicant_district_id-container"]').addClass('focusedInput');
                    scrollTop("#applicant_district_id");
                }else if(applicant_upazila_id.length==0){
                    // toastr.error('The Upazila Field is Required!');
                    $('#applicant_upazila_id_msg').text('The Upazila Field is Required!');
                    $('[aria-labelledby="select2-applicant_upazila_id-container"]').addClass('focusedInput');
                    scrollTop("#applicant_upazila_id");
                }else if(applicant_union.length==0){
                    // toastr.error('The Union Field is Required!');
                    $('#applicant_union_msg').text('The Union Field is Required!');
                    $('[aria-labelledby="select2-applicant_union-container"]').addClass('focusedInput');
                    scrollTop("#applicant_union");
                }else if(description.length==0){
                    // toastr.error('The Description Field is Required!');
                    $('#description_msg').text('The Description Field is Required!');
                    $('#description').addClass('focusedInput');
                    scrollTop("#description");
                }else if(prayer.length==0){
                    // toastr.error('The Prayer Field is Required!');
                    $('#prayer_msg').text('The Prayer Field is Required!');
                    $('#prayer').addClass('focusedInput');
                    scrollTop("#prayer");


                }else if(multi_applicant == 1){

                    if(multi_name_0.length==0){
                        // toastr.error('The Name Field is Required!');
                        $('#multi_name_0_msg').text('The Name Field is Required!');
                        $('#multi_name_0').addClass('focusedInput');
                        scrollTop("#multi_name_0");
                    }else if(signature_0.length==0){
                        // toastr.error('The Signature Field is Required!');
                        $('#signature_0_msg').text('The Signature Field is Required!');
                        $('#signature_0').addClass('focusedInput');
                        scrollTop("#signature_0");
                    }else if(division_id_0.length==0){
                        // toastr.error('The Division Field is Required!');
                        $('#division_id_0_msg').text('The Division Field is Required!');
                        $('[aria-labelledby="select2-division_id_0-container"]').addClass('focusedInput');
                        scrollTop("#division_id_0");
                    }else if(district_id_0.length==0){
                        // toastr.error('The District Field is Required!');
                        $('#district_id_0_msg').text('The District Field is Required!');
                        $('[aria-labelledby="select2-district_id_0-container"]').addClass('focusedInput');
                        scrollTop("#district_id_0");
                    }else if(upazila_id_0.length==0){
                        // toastr.error('The Upazila Field is Required!');
                        $('#upazila_id_0_msg').text('The District Field is Required!');
                        $('[aria-labelledby="select2-upazila_id_0-container"]').addClass('focusedInput');
                        scrollTop("#upazila_id_0");
                    }else if(union_id_0.length==0){
                        // toastr.error('The Union Field is Required!');
                        $('#union_id_0_msg').text('The Union Field is Required!');
                        $('[aria-labelledby="select2-union_id_0-container"]').addClass('focusedInput');
                        scrollTop("#union_id_0");
                    }else if(mp_name.length==0){
                        // toastr.error('The MP Field is Required!');
                        $('#mp_name_msg').text('The MP Field is Required!');
                        $('[aria-labelledby="select2-mp_name-container"]').addClass('focusedInput');
                    }else{
                            $('#petitionModal').modal('show');
                    }


                }else if(mp_name.length==0){
                    // toastr.error('The MP Field is Required!');
                    $('#mp_name_msg').text('The MP Field is Required!');
                    $('[aria-labelledby="select2-mp_name-container"]').addClass('focusedInput');
                }else if(attachment.length !=0){

                    var files = $('#attachment')[0].files;
                    var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

                    for (i = 0; i < files.length; i++) {

                        if(!((files[i].type == match[0]) || (files[i].type == match[1]) || (files[i].type == match[2]) || (files[i].type == match[3]) || (files[i].type == match[4]) || (files[i].type == match[5]) || (files[i].type == match[6]))){

                            toastr.error('Sorry, only PDF, DOC, DOCX, JPG, JPEG, & PNG files are allowed to upload.');
                            $('#attachment').val('');
                            
                        }else{
                            $('#petitionModal').modal('show');
                        }

                    }

                }else{
                    $('#petitionModal').modal('show');
                }
                
            });

            var originalOtp = '';

            $('#submitBtn').on('click', function () {
                
                var applicant_nid       = $('#applicant_nid').val();
                var applicant_mobile    = $('#applicant_mobile').val();
                var applicant_email     = $('#applicant_email').val();

                if(applicant_nid.length==0){
                    // toastr.error('The NID Field is Required!');
                    $('#applicant_nid_msg').text('The NID Field is Required!');
                    $('#applicant_nid').addClass('focusedInput');
                }else if (applicant_nid.length < 10) {
                    // toastr.error('The NID No. is Invalid!');
                    $('#applicant_nid_msg').text('The NID No. is Invalid!');
                    $('#applicant_nid').addClass('focusedInput');
                }else if(applicant_mobile.length==0){
                    // toastr.error('The Mobile Field is Required!');
                    $('#applicant_mobile_msg').text('The Mobile Field is Required!');
                    $('#applicant_mobile').addClass('focusedInput');
                }else if (applicant_mobile.length < 11) {
                    // toastr.error('The Mobile No. is Invalid!');
                    $('#applicant_mobile_msg').text('The Mobile No. is Invalid!');
                    $('#applicant_mobile').addClass('focusedInput');
                }else if(applicant_email.length==0){
                    // toastr.error('The E-mail Field is Required!');
                    $('#applicant_email_msg').text('The E-mail Field is Required!');
                    $('#applicant_email').addClass('focusedInput');
                }else if(IsEmail(applicant_email)==false){
                    // toastr.error('Enter valid E-mail!');
                    $('#applicant_email_msg').text('Enter valid E-mail!');
                    $('#applicant_email').addClass('focusedInput');
                }else{
                    $.ajax({
                        url: "{{url('petitionsContactInfo')}}",
                        type: "POST",
                        data: {
                            _token: "{{csrf_token()}}",
                            applicant_mobile: applicant_mobile
                        },
                        success: function (response) {
                           originalOtp = response.data;
                            
                        }
                    });

                    $(this).addClass('d-none');
                    $('.contactInfo').addClass('d-none');
                    $('#petitionModalLabel').addClass('d-none');

                    $('#otpModalLabel').removeClass('d-none');
                    $('#backBtn').removeClass('d-none');
                    $('#finalSubmitBtn').removeClass('d-none');
                    $('.otpInfo').removeClass('d-none');
                    $('.otpView').removeClass('d-none');
                }
            });



            $('#applicant_nid').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#applicant_nid_msg').text('The NID Number Should be Min:10 and Max:17'); 
                }
                if (val.length >= 9) {
                    $('#applicant_nid_msg').text(''); 
                }
                if( val.length>16 && e.keyCode != 8 ){   
                    e.preventDefault();
                }

            });
            
            $('#applicant_mobile').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#applicant_mobile_msg').text('The Mobile Number Should be 11 Digit'); 
                }
                if (val.length >= 10) {
                    $('#applicant_mobile_msg').text(''); 
                }
                if( val.length>10 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });

            function IsEmail(email) {
                var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test(email)) {
                    return false;
                }else{
                    return true;
                }
            }

            $('#backBtn').on('click', function () {
                $('#submitBtn').removeClass('d-none');
                $('#petitionModalLabel').removeClass('d-none');
                $('.contactInfo').removeClass('d-none');
                $('.otpInfo').addClass('d-none');
                $('#backBtn').addClass('d-none');
                $('#finalSubmitBtn').addClass('d-none');
                $('#otpModalLabel').addClass('d-none');
                $('.otpView').addClass('d-none');
            });




            $('#otpViewBtn').on('click', function () {

                var applicant_mobile    = $('#applicant_mobile').val();
                $.ajax({
                    url: '{{url("petitionOtpView")}}',
                    data:{applicant_mobile:applicant_mobile},
                    type: "GET",
                    dataType: "json",

                    success: function (response) {
                        $('#otpView').html(response.data.otp_number)
                        
                    }
                })
                
            });




            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });

            $('#petitionCreateForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var otp_number = $('#otp_number').val();
                
                if(otp_number.length==0){
                    // toastr.error('The OTP Field is Required!');
                    $('#otp_number_msg').text('The OTP Field is Required!');
                    $('#otp_number').addClass('focusedInput');

                }else if(otp_number != originalOtp){
                    $('#otp_number_msg').text('Your OTP Is Invalid');
                    $('#otp_number').addClass('focusedInput');
                }else{  

                    $.ajax({
                    type: 'POST',
                    url: "{{ url('petitionInsert') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (response) => {
                        if (response == 1) {
                            $('#petitionModal').modal('hide');
                            Swal.fire({
                                confirmButtonText: '@lang("OK")',
                                text: '@lang("Thank You for Submitting the Petition. Use NID Number and Mobile Number to Know the Latest Status of the Application.")',
                                type: 'success'
                            }).then((result) => {
                                location.replace("{{url('/petition/welcome')}}");
                            });
                        } else {
                            Swal.fire('Server Error!!!', '', 'error');
                        }
                    },
                    error: function(data) {
                        Swal.fire('something went wrong', '', 'error');
                        //my_loader('stop');
                    }
                });



                    /* $.ajax({
                        _token: "{{csrf_token()}}",
                        type: 'POST',
                        url: "{{url('petitionInsert')}}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                    .then(function(response) {
                        if (response == 1) {
                            $('#petitionModal').modal('hide');
                            Swal.fire({
                                confirmButtonText: '@lang("OK")',
                                text: '@lang("Thank You for Submitting the Petition. Use NID Number and Mobile Number to Know the Latest Status of the Application.")',
                                type: 'success'
                            }).then((result) => {
                                location.replace("{{url('/petition/welcome')}}");
                            });
                        } else {
                            Swal.fire('Server Error!!!', '', 'error');
                        }
                    })
                    .catch(function(error) {
                        Swal.fire('Error!!!', '', 'error');
                    }); */
                }
            });

            $('#division_id_0').on('change', function () {
                var division_id = $(this).val();
 
                $('#district_id_0').empty();
                $('#district_id_0').append('<option value="">@lang('Select District')</option>');

                $.ajax({
                    url: '{{url("districtByDivision")}}',
                    data:{division_id:division_id},
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('#district_id_0').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('#district_id_0').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    }
                });

            });

            $('#district_id_0').on('change', function () {
                var district_id = $(this).val();

                $('#upazila_id_0').empty();
                $('#upazila_id_0').append('<option value="">@lang('Select Upazila')</option>');

                $.ajax({
                    url: '{{url("upazilaByDistric")}}',
                    data:{district_id:district_id},
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('#upazila_id_0').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('#upazila_id_0').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    }
                });

            });

            var incrementValue = 1;

            $('select[id="division_id_'+incrementValue+'"]').on('change', function () {
                var division_id = $(this).val();
 

                $('select[id="district_id_'+incrementValue+'"]').empty();
                $('select[id="district_id_'+incrementValue+'"]').append('<option value="">@lang('Select District')</option>');


                $.ajax({
                    url: '{{url("districtByDivision")}}',
                    data:{division_id:division_id},
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('select[id="district_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('select[id="district_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    }
                });

            });

            $('select[id="district_id_'+incrementValue+'"]').on('change', function () {
                var district_id = $(this).val();

                $('select[id="upazila_id_'+incrementValue+'"]').empty();
                $('select[id="upazila_id_'+incrementValue+'"]').append('<option value="">@lang('Select Upazila')</option>');


                $.ajax({
                    url: '{{url("upazilaByDistric")}}',
                    data:{district_id:district_id},
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('select[id="upazila_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('select[id="upazila_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    }
                });


            });

            //Add Applicant
            $('.addApplicant').click(function(){

                incrementValue++;

                var loadMember = '<div class="row mb-3 applicantRow"><div class="col-sm-11 ml-2 p-3" style="background: #f7f7f7"><div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><div class="form-group mb-3"><div class="input-group"> <input type="text" id="multi_name_'+incrementValue+'" class="form-control @error("multi_name") is-invalid @enderror" name="applicant_list[name][]" value="{{old("multi_name")}}" placeholder="@lang("Enter Applicant Name")" /></div>@error("multi_name") <span class="text-danger">{{ $message }}</span> @enderror</div></div><div class="col-sm-12 col-md-6 col-lg-6"><div class="form-group mb-3"><div class="input-group"> <input type="text" class="form-control @error("signature") is-invalid @enderror" name="applicant_list[signature][]" id="signature_'+incrementValue+'" value="{{old("signature")}}" placeholder="@lang("Signature")" /></div>@error("signature") <span class="text-danger">{{ $message }}</span> @enderror</div></div><div class="col-sm-12 col-md-3 col-lg-3"><div class="form-group mb-3"> <select id="division_id_'+incrementValue+'" name="applicant_list[division][]" class="form-control @error("division_id") is-invalid @enderror select2"><option value="">@lang("Select Division")</option> @foreach ($divisions as $data) @if($data["id"]==old("division_id"))<option selected value="{{$data["id"]}}"> @if(session()->get("language") =="bn") {{$data["bn_name"]}} @else {{$data["name"]}} @endif</option> @else<option value="{{$data["id"]}}"> @if(session()->get("language") =="bn") {{$data["bn_name"]}} @else {{$data["name"]}} @endif</option> @endif @endforeach </select>@error("division_id") <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="col-sm-12 col-md-3 col-lg-3"><div class="form-group mb-3"> <select id="district_id_'+incrementValue+'" name="applicant_list[district][]" class="form-control @error("district_id") is-invalid @enderror select2"><option value="">@lang("Select District")</option> </select>@error("district_id") <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="col-sm-12 col-md-3 col-lg-3"><div class="form-group mb-3"> <select id="upazila_id_'+incrementValue+'" name="applicant_list[upazila][]" class="form-control @error("upazila_id") is-invalid @enderror select2"><option value="">@lang("Select Upazila")</option></select>@error("upazila_id") <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div><div class="col-sm-12 col-md-3 col-lg-3"><div class="form-group mb-3"><select id="union_id_'+incrementValue+'"  name="applicant_list[union][]" class="form-control union_id formOnSelect @error("union_id") is-invalid @enderror  select2"><option value="">@lang('Select Union')</option></select><span id="union_id_0_msg" class="text-danger"></span>@error("union_id") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror </div></div><div class="col-sm-12 col-md-12 col-lg-12"><div class="form-group mb-3"><textarea id="more_address_'+incrementValue+'" name="applicant_list[more_address][]" class="form-control @error("more_address") is-invalid @enderror" placeholder="@lang("Write More")"> {{old("more_address")}} </textarea>@error("more_address") <span class="text-danger">{{ $message }}</span> @enderror</div></div></div></div><div class="col-sm-1" style="display: contents;"> <button type="button" class="btn btn-danger removeApplicant btn-lg"> <i class="fa fa-times"> </i> </button></div></div>';

                $('#applicant').append(loadMember);

                $(".select2").select2({});

                $('select[id="division_id_'+incrementValue+'"]').on('change', function () {
                    var division_id = $(this).val();

                    $('select[id="district_id_'+incrementValue+'"]').empty();
                    $('select[id="district_id_'+incrementValue+'"]').append('<option value="">@lang('Select District')</option>');

                    $.ajax({
                        url: '{{url("districtByDivision")}}',
                        data:{division_id:division_id},
                        type: "GET",
                        dataType: "json",
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[id="district_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('select[id="district_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                                '<?php } ?>'
                            });
                        }
                    });


                });

                $('select[id="district_id_'+incrementValue+'"]').on('change', function () {
                    var district_id = $(this).val();

                    $('select[id="upazila_id_'+incrementValue+'"]').empty();
                    $('select[id="upazila_id_'+incrementValue+'"]').append('<option value="">@lang('Select Upazila')</option>');


                    $.ajax({
                        url: '{{url("upazilaByDistric")}}',
                        data:{district_id:district_id},
                        type: "GET",
                        dataType: "json",
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[id="upazila_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('select[id="upazila_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.name + '</option>');
                                '<?php } ?>'
                            });
                        }
                    });

                });

                $('select[id="upazila_id_'+incrementValue+'"]').on('change', function () {
                    var upazila_id = $(this).val();

                    $('select[id="union_id_'+incrementValue+'"]').empty();
                    $('select[id="union_id_'+incrementValue+'"]').append('<option value="">@lang('Select Union')</option>');


                    $.ajax({
                        url: '{{url("unionListByUpazila")}}',
                        data:{upazila_id:upazila_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[id="union_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('select[id="union_id_'+incrementValue+'"]').append('<option value="' + val.id + '">' + val.name +  '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });

                });
            });

            //Remove Applicant
            $(document).on("click", ".removeApplicant", function() {
                $(this).closest('.applicantRow').remove();
            });


            $('#applicant_division_id').on('change', function () {
                var division_id = $(this).val();

                $('#applicant_district_id').empty();
                $('#applicant_district_id').append('<option value="">@lang('Select District')</option>');

                $.ajax({
                    url: '{{url("districtByDivision")}}',
                    data:{division_id:division_id},
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('#applicant_district_id').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('#applicant_district_id').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    }
                });

            });


            $('#applicant_district_id').on('change', function () {
                var district_id = $(this).val();

                $('#applicant_upazila_id').empty();
                $('#applicant_upazila_id').append('<option value="">@lang('Select Upazila')</option>');

                $.ajax({
                    url: '{{url("upazilaByDistric")}}',
                    data:{district_id:district_id},
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        $.each(result.data, function (k, val) {
                            '<?php if(session()->get('language') =='bn'){ ?>'
                            $('#applicant_upazila_id').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                            '<?php }else{ ?>'
                            $('#applicant_upazila_id').append('<option value="' + val.id + '">' + val.name + '</option>');
                            '<?php } ?>'
                        });
                    }
                });

            });

             // Get Union List By Upazila Id:
             $('#applicant_upazila_id').on('change', function () {
                var applicant_upazila_id = $(this).val();

                $('select[name="applicant_union"]').empty();
                $('select[name="applicant_union"]').append('<option value="">@lang('Select Union')</option>');

                if (applicant_upazila_id.length > 0) {
                    $.ajax({
                        url: '{{url("unionListByUpazila")}}',
                        data:{upazila_id:applicant_upazila_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('select[name="applicant_union"]').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('select[name="applicant_union"]').append('<option value="' + val.id + '">' + val.name +  '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });
                } else {

                    $('select[name="applicant_union"]').empty();
                    $('select[name="applicant_union"]').append('<option value="">@lang('Select Union')</option>');

                }

            });

            $('#upazila_id_0').on('change', function () {
                var upazila_id = $(this).val();

                $('#union_id_0').empty();
                $('#union_id_0').append('<option value="">@lang('Select Union')</option>');

                if (upazila_id.length > 0) {
                    $.ajax({
                        url: '{{url("unionListByUpazila")}}',
                        data:{upazila_id:upazila_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('#union_id_0').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('#union_id_0').append('<option value="' + val.id + '">' + val.name +  '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });
                } else {

                $('#union_id_0').empty();
                $('#union_id_0').append('<option value="">@lang('Select Union')</option>');

                }

            });


            $('#upazila_id_0').on('change', function () {
                var upazila_id = $(this).val();

                $('#union_id_0').empty();
                $('#union_id_0').append('<option value="">@lang('Select Union')</option>');

                if (upazila_id.length > 0) {
                    $.ajax({
                        url: '{{url("unionListByUpazila")}}',
                        data:{upazila_id:upazila_id},
                        type: "GET",
                        dataType: "json",
                        beforeSend: function () {
                            //$('#loader').css("visibility", "visible");
                        },
                        success: function (result) {
                            $.each(result.data, function (k, val) {
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                $('#union_id_0').append('<option value="' + val.id + '">' + val.bn_name + '</option>');
                                '<?php }else{ ?>'
                                $('#union_id_0').append('<option value="' + val.id + '">' + val.name +  '</option>');
                                '<?php } ?>'
                            });
                        },
                        complete: function () {
                            //$('#loader').css("visibility", "hidden");
                        }
                    });
                } else {

                $('#union_id_0').empty();
                $('#union_id_0').append('<option value="">@lang('Select Union')</option>');

                }

            });



            

            


            

        });

    </script>
    <script>
        $(document).ready(function () {
            
            $('#applicant_upazila_id').on('change', function () {
                var division_id = $("#applicant_division_id").val();
                var district_id = $("#applicant_district_id").val();
                var upazila_id = $("#applicant_upazila_id").val();

                $('#mp_name').empty();
                
                $.ajax({
                    url: '{{route("mpListByDDU")}}',
                    type: "GET",
                    dataType: "json",
                    data: {
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                    },
                    success: function (result) {
                        // console.log(result.data);
                        if(result.data != ''){
                            $.each(result.data, function (k, val) {
                                var nameEng = val.nameEng.toLowerCase();
                                var voterAreaEng = val.voterAreaEng.toLowerCase();
                                '<?php if(session()->get('language') =='bn'){ ?>'
                                    $('#mp_name').append('<option value="' + val.user_id + '">'+ val.bangladesh_number + ', ' + val.voterAreaBng + ', '+ val.nameBng + '</option>');
                                '<?php }else{ ?>'
                                    $('#mp_name').append('<option value="' + val.user_id + '">'+ val.bangladesh_number + ', ' + capitalize(voterAreaEng) + ', '+ capitalize(nameEng) + '</option>');
                                '<?php } ?>'
                            });
                        }else{
                            $('#mp_name').append('<option value="">'+'@lang("MP Not Found !")'+'</option>');
                        }
                    },
                    complete: function () {
                        //$('#loader').css("visibility", "hidden");
                    }
                });                
            });
        });
    </script>

@endsection

    