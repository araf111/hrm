<table style="width:100%">
    <tr>
        <td><span>@lang('Honourable Parliament Members Name')</span> : {{$data->mp_name}}</td>
        <td></td>
    </tr>
    <tr>
        <td><span>@lang('Voter Area No, Name')</span> : {{$data->constituency_name}}</td>
        <td></td>
    </tr>
    {{-- <tr>
        <td><span>@lang('User')</span> : {{$data->sticker_for == 'Own' ? 'নিজ' : 'পরিবার'}}</td>
        <td></td>
    </tr> --}}
    </table>

    <table style="width:100%">
    {{-- <tr>
        <td><span>@lang('Registration No')</span> : {{$data->car_reg_no}}</td>
        <td></td>
        <td><span>@lang('Car Brand')</span> : {{$data->car_brand}}</td>
        <td></td>
    </tr> --}}


    </table>
    <table style="width:100%">
        {{-- {{ dd($data) }} --}}
       <?php $connection_type = $data->connection_type ?>
        @if ($connection_type == 1)
        <tr>
            <td><span>@lang('Telephone/Pabx number')</span> : </td>
            <td>
                <input type="hidden" name="application_id" value="{{$data->id}}">
                <input type="text" value="{{ $number->num_of_telephone }}" name="telephoneOrPabx_no">
            </td>
        </tr> 
        @elseif($connection_type == 2)
        <tr>
            <td><span>@lang('Telephone/Pabx number')</span> : </td>
            <td>
                <input type="hidden" name="application_id" value="{{$data->id}}">
                <input type="text" value="{{ $number->num_of_pabx }}" name="telephoneOrPabx_no">
            </td>
        </tr>
        @else
        <tr>
            <td><span>@lang('Telephone/Pabx number')</span> : </td>
            <td>
                <input type="hidden" name="application_id" value="{{$data->id}}">
                <input type="text" placeholder="Enter number" name="telephoneOrPabx_no">
            </td>
        </tr>
            
        @endif

    </table>