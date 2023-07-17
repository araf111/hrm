<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($numberCounters) 
<section id="number-counter"  data-animation="fadeInUp " data-animation-delay="0.01s " style="animation-delay: 0.01s; opacity: 1;">
    <div class="container">
        <div class="row"  id="counter">
            @foreach ($numberCounters as $data)
            <div class="col-sm-12 col-md-2 col-lg-2 mb-4">
                <div class="counter-box">
                    <p><span class="counter counter-value" data-count="{{$data->number}}">0</span><br/>
                        @if(session()->get('language') == 'bn')
                            {{$data->titleBng}}
                        @else
                            {{$data->titleEng}}
                        @endif
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endisset

<!-- SCRIPT --> 
<script type="text/javascript">
    var a = 0;
    $(window).scroll(function () {
        var oTop = $("#counter").offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $(".counter-value").each(function () {
                var $this = $(this),
                    countTo = $this.attr("data-count");
                $({
                    countNum: $this.text(),
                }).animate(
                    {
                        countNum: countTo,
                    },
                    {
                        duration: 7000,
                        easing: "swing",
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $this.text(this.countNum);
                        },
                    }
                );
            });
            a = 1;
        }
    });
</script>