@extends('backend.layouts.app')
@section('content')
<style>
    @media print {
        body {
            margin: 0;
            color: #000;
            background-color: #fff;
        }
    }
</style>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="float-left">
                    <a href="{{route('admin.profile-activities.mp-leave.leave-application.index')}}" class="btn btn-sm btn-info float-right"><i class="ion-android-arrow-back mr-2"></i>@lang('Go back to the list')
                    </a>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Profile Activities')</li>
                    <li class="breadcrumb-item active">@lang('Leave Details')</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-10 col-md-10">
                <div id="printable_section" style="border:2px solid #568c0a" class="card">
                    <div class="card-body text-center">
                        <h5 style="font-size: 1.2rem"> @lang('Honorable Member'):
                            {{(session()->get('language') =='bn')?(@$showData->profileInfo['name_bn']):@$showData->profileInfo['name_eng']}}
                        </h5>
                        <h5 style="font-size: 1.2rem">@lang('Constituency'):
                            {{digitDateLang(@$showData->profileInfo['number'])}} ,
                            {{(session()->get('language') =='bn')?(@$showData->profileInfo['bn_name']):@$showData->profileInfo['name']}}
                        </h5>

                        <div class="mb-2">
                            <span style="font-size: 1.2rem">@lang('Leave Application') : </span>
                            <span style="font-size: 1.2rem">{{ digitDateLang(date('d-m-Y', strtotime($showData->from_date)))}}</span>&nbsp;&nbsp;@lang('From')&nbsp;&nbsp;
                            <span style="font-size: 1.2rem"> {{ digitDateLang(date('d-m-Y', strtotime($showData->to_date)))}}</span>&nbsp;&nbsp;
                            @lang('Total') : {{digitDateLang($leave_t = round((strtotime($showData->to_date)- strtotime($showData->from_date)) / (60 * 60 * 24))+1)}} @lang('Day')</span>
                        </div>

                        <div class="mb-2">
                            <span>@lang('Subject')&nbsp;:&nbsp;</span>
                            {{(session()->get('language') == 'bn')?(@$showData->holiday_reasons->name_bn):@$showData->holiday_reasons->name}}
                        </div>


                        <div class="note mb-1">
                            <h5>@lang('Notes') : </h5>
                            <p class="text-justify text-center">{{($showData->note)}}</p>
                        </div>


                        <div class="pb-2 mt-2">
                            @if (@$showData['attach_file'])
                            <p> <span class="text-bold">@lang('File Attachment')</span></p>
                            <span class="mr-2">@lang('Document Attachment')</span>
                            <span>{{isset($showData)? $showData->attach_file: '' }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="{{ asset('public/backend/images/leave-file/'.@$showData['attach_file']) }}" target="_blank">
                                <i class="fa fa-file-pdf fa-2x" aria-hidden="true" style="color: #0c0c0c"></i>
                            </a>
                            
                            @endif
                        </div>
                    </div>
                </div>
                <!-- <input type="button" value="click" onclick="printDiv()"> -->
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
    function printDiv() {
        var divContents = document.getElementById("printable_section").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        //a.document.write('<body > <h1>Div contents are <br>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }
</script>
@endsection