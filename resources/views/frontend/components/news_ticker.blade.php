<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($newsTitles) 
<section id="news_ticker" class="px-5 py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center breaking-news">
                    {{-- <div class="d-flex flex-row flex-grow-1 flex-fill justify-content-center news"> --}}
                    <div class="d-flex news">
                        <span class="d-flex align-items-center">&nbsp;@lang('Heading:')</span>
                    </div>
                    <marquee class="news-scroll" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();"> 
                        @foreach($newsTitles as $data)
                            <span class="dot"></span> 
                            @if(session()->get('language') == 'bn')
                                <a href="{{$data->url}}">{{$data->newsTitleBng}}</a> 
                            @else
                                <a href="{{$data->url}}">{{$data->newsTitleEng}}</a> 
                            @endif
                        @endforeach
                    </marquee>
                </div>
            </div>
        </div>
    </div>
</section>
@endisset