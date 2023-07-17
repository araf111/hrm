@extends('frontend.layouts.index') 
@section('content')

<!-- START HEADER -->
@include('frontend.layouts.header')

<section class="breadcrumb_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h3>@lang('Citizen Question')</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb justify-content-sm-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">@lang('হোম')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('Citizen Question')</li>
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
                <div class="content">
                    <h5>@lang('Citizen Question'):</h5>
                    <p>{{$citizenQuestion->citizenQuestion}}</p>
                    <h5>@lang('MP Answer'):</h5>
                    <p>{{$citizenQuestion->mpAnswer}}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="divider"></div>
<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection