<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@extends('frontend.layouts.index')

@section('content')
@include('frontend.layouts.header')

<section class="breadcrumb_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h3>@lang('Petition Reports')</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="#">@lang('হোম')</a></li>
                    <li class="breadcrumb-item"><a href="#">@lang('Petition')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('Petition Reports')</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="col-md-12">
        {{-- <div class="card mt-5">
            <div class="card-header">
                <h5 class="d-inline-block float-left pt-2 mb-0">@lang('Petition Reports')</h5>
                <a style="float:right" class="btn btn-info btn-md d-inline-block" href="{{ url()->previous() }}"><i class="fas fa-backward"></i> @lang('Back')</a>
            </div>
        </div> --}}
        <div class="card mt-5 mb-5">
            <div class="card-body" style="padding:0px 50px;">
                
                <p class="mt-5">@lang('Honorable Chairman')</p>
                <p>@lang('Petition Committee') </p>
                <p>@lang('Bangladesh National Parliament') </p>
                <p>@lang('Adjacent to the Peoples Republic of Bangladesh') </p>
                

                <p class="my-5"></p>
                <p><strong>@lang('Applicant Name'):</strong> {{ $petitions->applicant_name }}</p>
                <p><strong>@lang('Applicant Designation'):</strong> {{ $petitions->applicant_designation }}</p>
                <p><strong>@lang('Address'):</strong> 
                    @lang('Union'): {{ $union->bn_name }}, 
                    @lang('Upazila'): {{ $petitions->applicantUpazila->bn_name }}, 
                    @lang('District'): {{ $petitions->applicantDistrict->bn_name }}, 
                    @lang('Division'): {{ $petitions->applicantDivision->bn_name }} <br/>
                    {{ $petitions->applicant_more_address }}</p>
               
                <p class="mt-5"><strong>@lang('Summary of the Subject Matter of the Petition'):</strong></p>
                <p>আরজ এই যে, {{ $petitions->description }}</p>
                
                <p class="mt-5"><strong>@lang('Prayer of the Applicant'):</strong></p>
                <p>প্রার্থনা এই যে, {{ $petitions->prayer }}</p>

                @isset($allData)
                <table class="table table-sm table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th width="5%" class="text-center">@lang('Serial')</th>
                        <th width="45%" class="text-center">@lang('Applicant Name')</th>
                        <th width="50%" class="text-center">@lang('Address')</th>
                    </tr>
                    </thead>
                    <tbody id="petition_table">
                        @isset($allData)
                            @foreach ($allData as $data)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $data[0] }} </td>
                                    <td>@lang('Union'): {{ $data[1] }}, 
                                        @lang('Upazila'): {{ $data[2] }}, <br/>
                                        @lang('District'): {{ $data[3] }}, 
                                        @lang('Division'): {{ $data[4] }}, <br/>
                                        {{ $data[5] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
                @endisset
                {{-- <p class="my-5"><strong>তারিখঃ </strong> {{ date('d F, Y', strtotime($petitions->created_at)) }} </p> --}}
                

                <p class="mt-5"> <strong>@lang('Counter-Signature of the MP Presenting') </strong></p>
                <p>
                    @if(session()->get('language') == 'bn')
                        {{digitDateLang($petitions->profileInfo->constituency->number) }},
                        {{$petitions->profileInfo->constituency->bn_name }},
                        {{ $petitions->profileInfo->nameBng }}
                    @else
                        {{$petitions->profileInfo->constituency->number }},
                        {{$petitions->profileInfo->constituency->name }}, 
                        {{ $petitions->profileInfo->nameEng }}
                    @endif
                </p>
                
                <p class="mt-5">
                    @if(isset($attachments) && count($attachments) > 0)
                        @foreach($attachments as $file)
                        <a href="{{ asset('public/frontend/petition/'.$file->attachment)  }}" target="_blank" class="btn btn-success mr-2">@lang('Attachment') - {{ digitDateLang($loop->iteration) }}</a>
                        @endforeach
                    @endif
                </p>
            </div>

        </div>

    </div>
</div>
<div class="divider"></div>
<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection

@section('scripts')

@endsection