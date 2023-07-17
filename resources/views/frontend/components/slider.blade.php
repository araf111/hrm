<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($sliders) 
<section id="banner" class="p-0">
	<div class="container-flutter">
		<div class="row m-0 p-0">
			<div class="col-12 m-0 p-0">
				<div id="carouselSlide" class="carousel carousel-dark slide" data-bs-ride="carousel">
					<div class="carousel-inner">
						
						@foreach($sliders as $data)
						<div class="carousel-item" data-bs-interval="10000">
							<img src="{{asset( 'public/frontend/images/slide')}}/{{$data->photo}}" class="d-block w-100" alt="Slide">
							<div class="carousel-caption d-none d-md-block">
								<h3 class="title">
									@if(session()->get('language') == 'bn')
										{{$data->sliderTitleBng}}
									@else
										{{$data->sliderTitleEng}}
									@endif
								</h3>
								@if(session()->get('language') == 'bn')
									<a href="{{$data->readMoreLink}}" class="btn btn-lg btn-slide mt-3">@lang('More') <i class="fas fa-angle-right"></i></a>
								@else
									<a href="{{$data->readMoreLink}}" class="btn btn-lg btn-slide mt-3">@lang('More') <i class="fas fa-angle-right"></i></a>
								@endif
							</div>
							<img class="suborno_joyonti_100years" src="{{asset( 'public/frontend/images/slide')}}/{{$data->logo}}" alt="">
						</div>
						@endforeach
						
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carouselSlide" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carouselSlide" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
@endisset
<!-- END SECTION BANNER -->

<script>
	$(document).ready(function(){
		$("#carouselSlide .carousel-item:first").addClass("active");
	});
</script>