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
</section><section id="mp_question">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="content">
                    @foreach ($allQuestion as $data)
                        <div class="mp_content">
                            <img src="{{asset( 'public/backend/profile')}}/{{$data->photo}}" style="width:120px" alt="MP">
                            <h4>
                                @if(session()->get('language') == 'bn')
                                    {{$data->nameBng}}
                                @else
                                    {{$data->nameEng}}
                                @endif
                            </h4>
                            <p>
                                {!! \Illuminate\Support\Str::limit($data->citizenQuestion, $limit = 130, $end = '...') !!}
                            </p>
                            <a href="{{ route('citizen_questions.show', $data->questionId) }}">@lang('More') <i class="fa fa-angle-right"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<div class="divider"></div>
<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection