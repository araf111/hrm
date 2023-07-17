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
</style>
@section('content')
@include('frontend.layouts.header')

<section class="breadcrumb_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h3>@lang('Petition Monitoring')</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="#">@lang('হোম')</a></li>
                    <li class="breadcrumb-item"><a href="#">@lang('Petition')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('Petition Monitoring')</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


    <div class="container mb-5">
        <div class="row mt-5 py-5">
            <div id="petitionMonitoring" class="col-sm-12 col-md-6 col-lg-6 m-auto">
                <div class="card p-4">
                <h4 class="text-center">@lang('Petition Monitoring')</h4>
                <hr/>
                <form id="petitionMonitoringForm" method="POST" enctype="multipart/form-data" class="form-horizontal mt-3"  action="javascript:void(0)">

                        <div class="form-group mb-3">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <input type="number"
                                    min="0" inputmode="numeric" pattern="[0-9]*" 
                                    class="form-control formOnInput"
                                    name="petition_nid" 
                                    id="petition_nid" 
                                    placeholder="@lang('Enter NID No.')">

                                <span id="petition_nid_msg" class="text-danger"></span>
                                @error('petition_nid')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="input-group" data-target-input="nearest">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span style="border-bottom-right-radius: 0; border-top-right-radius: 0;">+88</span>
                                        </div>
                                    </div>
                                    <input type="number"
                                        min="0" inputmode="numeric" pattern="[0-9]*" 
                                        class="form-control formOnInput"
                                        name="petition_mobile" 
                                        id="petition_mobile" 
                                        placeholder="@lang('Enter Mobile No.')">
                                </div>
                                <span id="petition_mobile_msg" class="text-danger"></span>
                                @error('petition_mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group text-center mt-3">
                                    <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                    <button id="modalBtn" type="button" class="btn btn-success btn-sm">@lang('Send')</button>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="petitionModal" tabindex="-1" aria-labelledby="petitionModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h6 class="modal-title" id="otpModalLabel">@lang('Enter OTP number that send to your given mobile number')</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control formOnInput @error('otp_number') is-invalid @enderror" name="otp_number" id="otp_number" value="{{old('otp_number')}}" placeholder="@lang('Enter OTP')" />
                                        
                                    </div>
                                    <span id="otp_number_msg" class="text-danger"></span>
                                    @error('otp_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="form-group mb-3">

                                    <button type="button" id="otpViewBtn" class="btn btn-success">@lang('Resend OTP')</button>

                                    <div class="d-none" style="float: right;
                                    font-weight: 700;
                                    border: 1px solid;
                                    padding: 5px 15px;" id="otpView"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="backBtn" class="btn btn-dark d-none">@lang('Back')</button>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">@lang('Cancel')</button>
                                <button id="submitBtn" type="button" class="btn btn-success btn-sm">@lang('Send')</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    <!-- Modal -->
                </div>
            </div>
            <div id="petitionMonitoringIndex" class="d-none col-sm-12 col-md-12 col-lg-12 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="d-inline-block float-left pt-2 mb-0">@lang('Petition Monitoring')</h5>
                        
                        <a href="{{ url('petition/monitoring') }}" style="float:right" id="backBtn" type="button" class="btn btn-dark btn-sm"><i class='fas fa-backward'></i> @lang('Back')</a>
        
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body" style="padding: 50px;">
                        <h4 class="text-center mb-5">@lang('Petition Reports List')</h4>
                        
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr>
                                <th width="8%">@lang('Serial')</th>
                                <th>@lang('Applicant Name')</th>
                                <th>@lang('Applicant NID No.')</th>
                                <th>@lang('Applicant Mobile No.')</th>
                                <th>@lang('Date and Time')</th>
                                <th width="10%" class="text-center">@lang('Status')</th>
                                <th width="10%" class="text-center">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody id="petition_table">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="petitionMonitoringView" class="d-none col-sm-12 col-md-12 col-lg-12 m-auto">

            </div>
        </div>
    </div>
    <!-- Start Modal for Error Message -->
    <div class="modal fade" id="modalErrorMsg" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-danger">@lang('Sorry !')</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="errorMsg text-danger"></p>
                </div>
                
            </div>
        </div>
    </div>
    <!-- End Modal for Error Message -->
    <div class="divider"></div>

    <!-- START FOOTER -->
    @include('frontend.layouts.footer')

    @endsection

    @section('scripts')

    <script>
        $(function(){

            $('.formOnInput').on('keyup', function () {
                if ($.trim($('.formOnInput').val()).length) {
                    $(this).removeClass('focusedInput');
                }
            });

            $('#otp_number').on('input', function () {
                var $this = $(this);
                var val = $this.val();
                if (val.length >0) {
                    $('#otp_number_msg').text(''); 
                    $(this).removeClass('focusedInput');
                }
            });

            $('#petition_nid').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#petition_nid_msg').text('The NID Number Should be Min:10 and Max:17'); 
                }
                if (val.length >= 9) {
                    $('#petition_nid_msg').text(''); 
                }
                if( val.length>16 && e.keyCode != 8 ){   
                    e.preventDefault();
                }

            });
            
            $('#petition_mobile').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#petition_mobile_msg').text('The Mobile Number Should be 11 Digit'); 
                }
                if (val.length >= 10) {
                    $('#petition_mobile_msg').text(''); 
                }
                if( val.length>10 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });

            var originalOtp ='';

            $('#modalBtn').on('click', function () {
                var petition_nid       = $('#petition_nid').val();
                var petition_mobile    = $('#petition_mobile').val();

                if(petition_nid.length==0){
                    // toastr.error('The NID Field is Required!');
                    $('#petition_nid_msg').text('The NID Field is Required!');
                    $('#petition_nid').addClass('focusedInput');
                }else if (petition_nid.length < 10) {
                    // toastr.error('The NID No. is Invalid!');
                    $('#petition_nid_msg').text('The NID No. is Invalid!');
                    $('#petition_nid').addClass('focusedInput');
                }else if(petition_mobile.length==0){
                    // toastr.error('The Mobile Field is Required!');
                    $('#petition_mobile_msg').text('The Mobile Field is Required!');
                    $('#petition_mobile').addClass('focusedInput');
                }else if (petition_mobile.length < 11) {
                    // toastr.error('The Mobile No. is Invalid!');
                    $('#petition_mobile_msg').text('The Mobile No. is Invalid!');
                    $('#petition_mobile').addClass('focusedInput');
                }else{
                    $.ajax({
                        url: '{{ url('petitionCheck') }}',
                        data: {
                            petition_nid: petition_nid,
                            petition_mobile: petition_mobile,
                        },
                        type: "GET",
                        dataType: "json",

                        success: function(response) {
                            originalOtp = response.data;
                            if(response.status){
                                $('#petitionModal').modal('show');
                                $('#otpView').html('')
                                $('#otp_number').val('')
                            }else{
                                $('#modalErrorMsg').modal('show');
                                $('.errorMsg').text('@lang("No Petition Has Been Requested in the NID and Mobile Number !!")');
                            }
                        }
                    })
                    
                }
            });

            $('#otpViewBtn').on('click', function () {

                var applicant_mobile    = $('#petition_mobile').val();
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

        
            
            $('#submitBtn').on('click', function () {
                
                var petition_nid       = $('#petition_nid').val();
                var petition_mobile    = $('#petition_mobile').val();
                var otp_number = $('#otp_number').val();

                if(otp_number.length==0){
                    // toastr.error('The OTP Field is Required!');
                    $('#otp_number_msg').text('The OTP Field is Required!');
                    $('#otp_number').addClass('focusedInput');

                }else if(originalOtp != otp_number){
                    $('#otp_number_msg').text('Your OTP Is Invalid');
                    $('#otp_number').addClass('focusedInput');
                }else{
                    $.ajax({
                        url: '{{url("petitionsMonitoringGetData")}}',
                        type: "GET",
                        dataType: "json",
                        data:{petition_nid:petition_nid, petition_mobile:petition_mobile, otp_number:otp_number},

                        success: function (response) {
                       
                            var jsonData = response.data;
                            var url = "../petitions";
                            if(jsonData !=0){
                                $('#petitionModal').modal('hide');
                                $('#petitionMonitoring').addClass('d-none');
                                $('#petitionMonitoringIndex').removeClass('d-none');
                                $('#petition_table').empty();

                                $.each(jsonData, function(i, item) {
                                    if(jsonData[i].mp_consent == 1){
                                        var status = "@lang('Received')";
                                    }else if(jsonData[i].mp_consent == 0){
                                        var status = "@lang('Disagree')";
                                    }else if(jsonData[i].status == 6){
                                        var status = "@lang('Send to Speaker')";
                                    }else if(jsonData[i].status == 1){
                                        var status = "@lang('Received')";
                                    }else if(jsonData[i].status == 5){
                                        var status = "@lang('Send to Committee')";
                                    }else{
                                        var status = "@lang('Pending')";
                                    }
                                    $('<tr>').html(
                                        
                                        "<td>" + (i+1) + "</td>" +
                                        "<td>" + jsonData[i].applicant_name + "</td>" +
                                        "<td>" + nanoLangTranslate(jsonData[i].applicant_nid) + "</td>" +
                                        "<td>" + nanoLangTranslate(jsonData[i].applicant_mobile) + "</td>" +
                                        "<td>" + nanoLangTranslate(moment(jsonData[i].created_at).format('DD MMM YYYY, LT')) + "</td>" +
                                        "<td class='text-center'>" + status + "</td>" +
                                        "<td class='text-center'><a href="+ url +'/'+ jsonData[i].id +" class='petitionViewBtn btn btn-success btn-sm' data-id=" + jsonData[i].id + "> @lang('More')</a></td>"
                                    ).appendTo('#petition_table');
                                });
                            }else{
                                $('#petitionModal').modal('hide');
                                $('#modalErrorMsg').modal('show');
                                $('.errorMsg').text('@lang("OTP Number Invalid !!")');
                            }
                            
                        
                        }
                    })
                }
                $('#backBtn').on('click', function () {
                    $('#petitionMonitoring').removeClass('d-none');
                    $('#petitionMonitoringIndex').addClass('d-none');
                }); 
                
                
                

            });
        });
    </script>
@endsection