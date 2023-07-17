<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
@isset($verticalMenus)
<div class="notice">
    <ul>
        @foreach ($verticalMenus as $data)
            <li>
                @if(session()->get('language') == 'bn')
                    <a href="{{$data->link}}"> <i class="fa fa-caret-right"></i> {{$data->nameBng}}</a> 
                @else
                    <a href="{{$data->link}}"> <i class="fa fa-caret-right"></i> {{$data->nameEng}}</a> 
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endisset