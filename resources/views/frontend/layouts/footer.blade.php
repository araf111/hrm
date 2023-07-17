<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@php
    $bottomSection = App\Model\Frontend\BottomSection::where( 'status', 1 )->orderBy( 'id', 'desc' )->get();
@endphp

<footer id="footer">
    <div class="top_footer">
        <div class="container">
            @foreach ($bottomSection as $bottomSection)
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        @if (session()->get('language') == 'bn')
                            @isset($bottomSection->title1Bng)
                                <h6 class="title">{{ $bottomSection->title1Bng }}</h6>
                            @endisset
                            {!! $bottomSection->content1Bng !!}
                        @else
                            @isset($bottomSection->title1Eng)
                                <h6 class="title">{{ $bottomSection->title1Bng }}</h6>
                            @endisset
                            {!! $bottomSection->content1Eng !!}
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        @if (session()->get('language') == 'bn')
                            @isset($bottomSection->title2Bng)
                                <h6 class="title">{{ $bottomSection->title2Bng }}</h6>
                            @endisset
                            {!! $bottomSection->content2Bng !!}
                        @else
                            @isset($bottomSection->title2Eng)
                                <h6 class="title">{{ $bottomSection->title2Eng }}</h6>
                            @endisset
                            {!! $bottomSection->content2Eng !!}
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        @if (session()->get('language') == 'bn')
                            @isset($bottomSection->title3Bng)
                                <h6 class="title">{{ $bottomSection->title3Bng }}</h6>
                            @endisset
                            {!! $bottomSection->content3Bng !!}
                        @else
                            @isset($bottomSection->title3Eng)
                                <h6 class="title">{{ $bottomSection->title3Eng }}</h6>
                            @endisset
                            {!! $bottomSection->content3Eng !!}
                        @endif
                    </div>

                    <div class="col-sm-12 col-md-4 col-lg-4">
                        @if (session()->get('language') == 'bn')
                            @isset($bottomSection->title4Bng)
                                <h6 class="title">{{ $bottomSection->title4Bng }}</h6>
                            @endisset
                            {!! $bottomSection->content4Bng !!}
                        @else
                            @isset($bottomSection->title4Eng)
                                <h6 class="title">{{ $bottomSection->title4Eng }}</h6>
                            @endisset
                            {!! $bottomSection->content4Eng !!}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="footer_mid">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="partner">
                        <h4>@lang('Technical Support:')</h4>
                        <a href="#"><img src="{{ asset('public/frontend/images/nanosoft.png') }}" width="150px"
                                alt=""></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="parliament-img mt-3">
                        <img src="{{ asset('public/frontend/images/parliament.png') }}" class="w-100" alt="">
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="partner">
                        <h4>@lang('Planning & Implementation:')</h4>
                        <a href="#"><img src="{{ asset('public/frontend/images/ict.png') }}" height="50px" alt=""></a>
                        <a href="#"><img src="{{ asset('public/frontend/images/a2i.png') }}" height="50px" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="copyright m-md-0 text-center text-md-left">&#169; {{ digitDateLang(date('Y')) }}
                        @lang('Bangladesh National Parliament')@lang('.') @lang('All rights reserved.')</p>
                </div>

            </div>
        </div>
    </div>
</footer>


<!-- END FOOTER
