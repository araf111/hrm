<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($videoGalleries) 
<section id="video_gallery">
    <h3 class="title text-center">@lang('Video Gallery') <i class="fa fa-video"></i></h3>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="video-content justify-content-between">
                    <div class="large-video" style="width: 60%">
                    @isset($latestVideo->youtubeLink)
                        <iframe id="vid_frame" src="https://www.youtube.com/embed/{{$latestVideo->youtubeLink}}?autoplay=0&amp;rel=0&amp;showinfo=0&amp;autohide=1" style="border: none; height: 422px" width="100%" allow="autoplay; encrypted-media; " allowfullscreen="true" controls=""></iframe>
                    @endisset
                    </div>
    
                    <div style="width: 39%" class="small-video-single">
                        @foreach ($videoGalleries as $data)
                            <div class="smaall-video-content">
                                <div class="small-video">
                                    <a href="javascript:void(0);" class="vid-item" onclick="document.getElementById('vid_frame').src='https://www.youtube.com/embed/{{$data->youtubeLink}}?autoplay=1&amp;rel=0&amp;showinfo=0&amp;autohide=1'">
                                    <span class="vid-thumb">
                                        <img src="{{asset( 'public/frontend/images')}}/{{$data->photo}}" width="100%" height="150px">
                                        <div class="playBtn"><i class="fa fa-play-circle"></i></div>
                                    </span>
                                    </a>
                                </div>
                                <p>
                                    @if(session()->get('language') == 'bn')
                                        {{$data->titleBng}}
                                    @else
                                        {{$data->titleEng}}
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>
@endisset

{{-- 
<section id="video_gallery">
    <h3 class="title text-center">ভিডিও গ্যালারি <i class="fa fa-video"></i></h3>
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div class="feature-video">
                    <img src="{{asset( 'public/frontend/images/sheikh-hasina1.jpg')}}">
                    <h4>প্রধানমন্ত্রী: শেখ হাসিনা</h4>
                    <div class="play-icon" onclick="playVideo('https://www.youtube.com/embed/LHZ3ZyLMSgA?autoplay=1')">
                        <i class="fa fa-play-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="small-video">
                    <img src="{{asset( 'public/frontend/images/sheikh-hasina2.png')}}">
                    
                    <div class="play-icon" onclick="playVideo('https://www.youtube.com/embed/nCPn8CtsBZI?autoplay=1')">
                        <i class="fa fa-play-circle"></i>
                    </div>
                </div>
                <div class="small-video">
                    <img src="{{asset( 'public/frontend/images/sheikh-hasina3.png')}}">
                   
                    <div class="play-icon" onclick="playVideo('https://www.youtube.com/embed/qD1aoRMTMM8?autoplay=1')">
                        <i class="fa fa-play-circle"></i>
                    </div>
                </div>
                <div class="small-video">
                    <img src="{{asset( 'public/frontend/images/sheikh-hasina4.png')}}">
                    
                    <div class="play-icon" onclick="playVideo('https://www.youtube.com/embed/01fYtQX9ijQ?autoplay=1')">
                        <i class="fa fa-play-circle"></i>
                    </div>
                </div>
            </div>
            <div id="videoPlayer" class="video-player d-none">
                <div class="player">
                    <iframe id="myVideo" width="660" height="371" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div class="close-icon">
                        <i class="fa fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section> --}}

<!-- SCRIPT --> 

{{-- <script type="text/javascript">

    function playVideo(video){
        $("#videoPlayer").removeClass("d-none");
        $("#myVideo").attr("src", video);
    }

    $(document).on('click', '.close-icon', function() {
        $('#myVideo').attr('src', '');
        $("#videoPlayer").addClass("d-none");
    });
    
</script> --}}

