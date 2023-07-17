<!-- 
 * Author M. Atoar Rahman
 * Date: 22/08/2021
 * Time: 11:40 AM
-->
@isset($aboutSection)
<section id="about_portal">
    <div class="container pb-5">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                <div class="video">
                    <img src="{{asset( 'public/frontend/images')}}/{{$aboutSection->videoBackground}}" width="60%" alt="">
                    <div class="content">
                      <a id="play-button" type="button"data-bs-toggle="modal" data-bs-target="#aboutModal">
                        <img src="{{asset( 'public/frontend/images')}}/{{$aboutSection->videoThumbnail}}" alt="">
                      </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                <h3><i class="fa fa-exclamation-circle"></i> 
                    @if(session()->get('language') == 'bn')
                        {{$aboutSection->titleBng}}
                    @else
                        {{$aboutSection->titleEng}}
                    @endif
                </h3>
                @if(session()->get('language') == 'bn')
                    {!!$aboutSection->contentBng!!}
                @else
                    {!!$aboutSection->contentEng!!}
                @endif
                {{-- <p>বাংলাদেশের সংসদ একটি অবিচ্ছিন্ন আইনসভা যা ৫০৫০ সদস্যের সমন্বয়ে গঠিত এবং প্রাপ্ত বয়স্ক ফ্র্যাঞ্চাইজির ভিত্তিতে ৩০০ টি আঞ্চলিক নির্বাচনী এলাকার ৩০০ সদস্য। বাকী ৫০ টি আসন একক স্থানান্তরযোগ্য ভোটের মাধ্যমে সংসদে আনুপাতিক প্রতিনিধিত্বের</p>
                <ul>
                    <li> বাংলাদেশের সংসদ একটি অবিচ্ছিন্ন আইনসভা যা ৫০৫০ সদস্যের</li>
                    <li>গণপ্রজাতন্ত্রী বাংলাদেশের সংবিধান আইনসভা অবিচ্ছিন্ন আইনসভা</li>
                    <li>অবিচ্ছিন্ন আইনসভা বাংলাদেশের সংসদ একটি অবিচ্ছিন্ন আইনসভা</li>
                    <li>গণপ্রজাতন্ত্রী  অবিচ্ছিন্ন আইনসভা বাংলাদেশের সংবিধান আইনসভা</li>
                </ul> --}}
            </div>
        </div>
    </div>
</section>
@endisset

<!-- Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button id="pause-button" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            @isset($aboutSection->videoLink)
            <iframe id="video" src="https://www.youtube.com/embed/{{$aboutSection->videoLink}}?enablejsapi=1&html5=1" frameborder="0" allowfullscreen height="330px" width="100%"></iframe>
            @endisset
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">

    var player;

    // this function gets called when API is ready to use
    function onYouTubePlayerAPIReady() {
        // create the global player from the specific iframe (#video)
        player = new YT.Player('video', {
            events: {
                // call this function when player is ready to use
                'onReady': onPlayerReady
            }
        });
    }
    function onPlayerReady(event) {
        // bind events
        var playButton = document.getElementById("play-button");
        playButton.addEventListener("click", function() {
            player.playVideo();
        });

        var pauseButton = document.getElementById("pause-button");
        pauseButton.addEventListener("click", function() {
            player.pauseVideo();
        });

        var stopButton = document.getElementById("stop-button");
        stopButton.addEventListener("click", function() {
            player.stopVideo();
        });

    }

    // Inject YouTube API script
    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/player_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

</script>