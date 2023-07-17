@extends('frontend.layouts.index') 
@section('content')

<!-- START HEADER -->
@include('frontend.layouts.header')

<section class="breadcrumb_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h3>@lang('Latest News')</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="#">হোম</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('Latest News')</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section class="content_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <img src="{{asset('public/frontend/images/')}}/{{$latestNews->photo}}" alt="Message" width="250px" style="display: block; float: left;margin-right: 15px;">
                <h3 class="title mt-2">
                    @if(session()->get('language') == 'bn')
                        {{$latestNews->titleBng}}
                    @else
                        {{$latestNews->titleEng}}
                    @endif
                </h3>
                <p>{{digitDateLang(nanoDateFormat($latestNews->created_at))}}</p>
                <p class="content">
                    @if(session()->get('language') == 'bn')
                        {!!$latestNews->contentBng!!}
                    @else
                        {!!$latestNews->contentEng!!}
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>
<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection