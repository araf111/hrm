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
    <div class="row py-5">
        <div class="col-sm-12 m-auto">
            <div class=" p-5 text-center">
                <h4 class="text-dark">@lang('Thank You for Submitting the Petition.')</h4>
                <p>@lang('Use NID Number and Mobile Number to Know the Latest Status of the Application.')</p>
                <a href="{{route('petitionsMonitoring') }}" class="btn btn-success mt-5">@lang('Petition Monitoring')</a>
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