<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($mpMessages) 
<section id="prime-minister-speaker" class="p-0">
    <div class="overlay">
        <div class="container">
            <div class="row">
                @foreach ($mpMessages as $data)
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <h3 class="title">
                        @if(session()->get('language') == 'bn')
                            {{$data->mpNameBng}}
                        @else
                            {{$data->mpNameEng}}
                        @endif
                    </h3>
                    <div class="message mt-2 mb-4">
                        <img src="{{asset('public/frontend/images/')}}/{{$data->photo}}" alt="Message">
                        <p>
                            @if(session()->get('language') == 'bn')
                                {!! \Illuminate\Support\Str::limit($data->messageBng, $limit = 220, $end = '...') !!}
                            @else
                                {!! \Illuminate\Support\Str::limit($data->messageEng, $limit = 200, $end = '...') !!}
                            @endif
                        </p>
                        <a href="{{route('admin.landing_page.mp_messages.show', $data->id)}}">@lang('Read More')</a>
                        
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endisset