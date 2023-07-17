<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($mobileApp) 
<section id="mobileApps">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <img width="75%" src="{{asset( 'public/frontend/images')}}/{{$mobileApp->photo}}" alt="MP Portal">
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <h3 class="title">
                    @if(session()->get('language') == 'bn')
                        {{$mobileApp->titleBng}}
                    @else
                        {{$mobileApp->titleEng}}
                    @endif
                </h3>
                <p>
                    @if(session()->get('language') == 'bn')
                        {{$mobileApp->contentBng}}
                    @else
                        {{$mobileApp->contentEng}}
                    @endif
                </p>
                <div class="store-icon">
                    <a href="{{ $mobileApp->googlePlayLink }}" target="_blank">
                        <img class="mb-2" src="{{asset( 'public/frontend/images')}}/{{$mobileApp->googlePlayLogo}}" alt="Google Play Store">
                    </a>
                    <a href="{{ $mobileApp->appStoreLink }}" target="_blank">
                        <img class="mb-2" src="{{asset( 'public/frontend/images')}}/{{$mobileApp->appStoreLogo}}" alt="App Store">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endisset