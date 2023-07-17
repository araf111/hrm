<!-- 
 * Author M. Atoar Rahman
 * Date: 22/08/2021
 * Time: 11:40 AM
-->
<section id="projects" class="p-0">
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <h3 class="title"><i class="fas fa-signal"></i> @lang('Development Projects') </h3>
                </div>
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        @foreach ($projectCategories as $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-project{{$loop->iteration}}-tab" data-bs-toggle="pill" data-bs-target="#pills-project{{$loop->iteration}}" type="button" role="tab" aria-controls="pills-project{{$loop->iteration}}" aria-selected="true">
                                    @if(session()->get('language') == 'bn')
                                        {{$category->nameBng}}
                                    @else
                                        {{$category->nameEng}}
                                    @endif
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-12">
                    
                    <div class="tab-content pl-5" id="pills-tabContent">

                        @foreach ($projectCategories as $category)
                        <div class="tab-pane fade" id="pills-project{{$loop->iteration}}" role="tabpanel" aria-labelledby="pills-project{{$loop->iteration}}-tab">
                            <!--Start owl-carousel Project 1-->
                            <div class="owl-carousel owl-theme project-carousel">
                                @foreach ($projectCarousel as $item)
                                    @if ($item->category_id == $category->id)
                                        <div class="item">
                                            <img src="{{asset('public/frontend/images/project')}}/{{$item->photo}}" class="w-100" alt="{{ $item->titleBng }}" />
                                            <div class="content">
                                                <h4>
                                                    @if(session()->get('language') == 'bn')
                                                        {{ $item->titleBng }}</h4>
                                                    @else
                                                        {{ $item->titleEng }}</h4> 
                                                    @endif
                                                <a href="{{route('admin.landing_page.project_carousels.show', $item->id) }}">@lang('More')</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <!--End owl-carousel Project 1-->
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $(document).ready(function() {	
        $('.project-carousel').owlCarousel({
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
                }
            }
        });
        $("#pills-tab .nav-item:first .nav-link").addClass("active");
        $("#pills-tabContent .tab-pane:first").addClass("show active");
        
    });

</script>