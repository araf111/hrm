@extends('frontend.layouts.index') 
@section('content')

<!-- START HEADER -->
@include('frontend.layouts.header')

<section class="breadcrumb_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    @if(session()->get('language') == 'bn')
                        <h3>{{$project->titleBng}}</h3>
                    @else
                        <h3>{{$project->titleEng}}</h3>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('হোম')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('Project')</li>
                  </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<section id="mp_question">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <img style="display: block; float:left; width:30%; margin-right:15px;" src="{{asset('public/frontend/images/project')}}/{{$project->photo}}" alt="{{$project->titleEng}}">
                @if(session()->get('language') == 'bn')
                    <h4>{{$project->titleBng}}</h4>
                    <p>{{$project->contentBng}}</p>
                @else
                    <h4>{{$project->titleEng}}</h4>
                    <p>{{$project->contentEng}}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>
<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection