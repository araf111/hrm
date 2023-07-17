<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($latestNews) 
<section id="latestNews" class="p-0">
    <div class="overlay">
        <div class="container">
            <h3 class="title text-center mb-4">@lang('Latest News')</h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="owl-carousel owl-theme latestNews-carousel">

                        @foreach ($latestNews as $data)
                        <div class="item">
                            <img src="{{asset('public/frontend/images/')}}/{{$data->photo}}" class="w-100" alt="" />
                            <div class="content">
                                <h4 class="news-title">
                                    @if(session()->get('language') == 'bn')
                                        {{$data->titleBng}}
                                    @else
                                        {{$data->titleEng}}
                                    @endif
                                </h4>
                                <p>
                                    @if(session()->get('language') == 'bn')
                                        {!! \Illuminate\Support\Str::limit($data->contentBng, $limit = 220, $end = '...') !!}
                                    @else
                                        {!! \Illuminate\Support\Str::limit($data->contentEng, $limit = 200, $end = '...') !!}
                                    @endif
                                </p>
                                <p class="date">{{digitDateLang(nanoDateFormat($data->created_at))}}</p>
                                <a class="readMore" href="{{route('admin.landing_page.latest_news.show', $data->id)}}">@lang('Read More') <i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endisset

<!-- SCRIPT --> 

<script type="text/javascript">
    $(document).ready(function() {	
        $('.latestNews-carousel').owlCarousel({
            loop: true,
            autoplay:true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                items: 1,
                nav: true
                },
                600: {
                items: 3,
                nav: false
                },
                1000: {
                items: 3,
                nav: true,
                loop: false,
                margin: 20
                }
            }
        })
        
    });
</script>