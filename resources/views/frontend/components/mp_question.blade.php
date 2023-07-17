<!-- 
 * Author M. Atoar Rahman
 * Date: 29/08/2021
 * Time: 11:40 AM
-->
<section id="mp_question">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                <h3 class="title"><i class="fa fa-comments"></i> @lang('MPs Who Received the Maximum Questions')</h3>
                <div class="content">
                    @foreach ($getMaxQuestion as $data)
                        <div class="mp_content">
                            <img src="{{asset( 'public/backend/profile')}}/{{$data->photo}}" width="185px" alt="MP">
                            <h4>
                                @if(session()->get('language') == 'bn')
                                    {{$data->nameBng}}
                                @else
                                    {{$data->nameEng}}
                                @endif
                            </h4>
                            <p>
                                {!! \Illuminate\Support\Str::limit($data->citizenQuestion, $limit = 130, $end = '...') !!}
                            </p>
                            <a href="{{ route('citizen_questions.show', $data->questionId) }}">@lang('More') <i class="fa fa-angle-right"></i></a>
                        </div>
                    @endforeach
                    <a href="{{ route('allQuestion') }}">@lang('See All Questions') <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                <h3 class="title"><i class="fa fa-comments"></i> @lang('MPs Who Give the Maximum Answer')</h3>
                <div class="content">
                    @foreach ($getMaxAnswer as $data)
                        <div class="mp_content">
                            <img src="{{asset( 'public/backend/profile')}}/{{$data->photo}}" width="185px" alt="MP">
                            <h4>
                                @if(session()->get('language') == 'bn')
                                    {{$data->nameBng}}
                                @else
                                    {{$data->nameEng}}
                                @endif
                            </h4>
                            <p>{!! \Illuminate\Support\Str::limit($data->citizenQuestion, $limit = 130, $end = '...') !!}</p>
                            <a href="{{ route('citizen_questions.show', $data->questionId) }}">@lang('More') <i class="fa fa-angle-right"></i></a>
                        </div>
                    @endforeach

                    <a href="{{ route('allAnswer') }}">@lang('See All Answers') <i class="fa fa-angle-right"></i> </a>
                </div>
            </div>
        </div>
    </div>
</section>