<div class="row">
    <h4 class="col-md-12">
        @lang('Asking Answer List')
    </h4>
</div>

<ul class="nav nav-tabs" style="margin:10px">
    <li class="nav-item">
        <a class="nav-link default_tab {{ $listType == 1 ? 'active' : 'bg-info' }} " data-toggle="tab" href="#pending"
            onClick="load_data('pending')">@lang('New Asking')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link default_tab {{ $listType == 2 ? 'active' : 'bg-success' }}" data-toggle="tab" href="#approved"
            onClick="load_data('approved')">@lang('Already Answered')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link default_tab {{ $listType == 3 ? 'active' : 'bg-danger ' }}" data-toggle="tab" href="#rejected"
            onClick="load_data('rejected')">@lang('Not Answer')</a>
    </li>

</ul>
<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="5%">@lang('Serial')</th>
            <th>@lang('MP')</th>
            <th>@lang('Asking Question')</th>
            <th width="15%">@lang('Attachment')</th>
            <th width="15%">@lang('Date')</th>
            <th width="15%" class="text-center">@lang('Action')</th>

        </tr>
    </thead>
    <tbody>

        @php
            $i = 1;
        @endphp

        @foreach ($items as $list)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
                    @foreach ($profiles as $profile)
                        @if ($list->mp_id == $profile->user_id) 
                            @if (session()->get('language') == 'bn')
                                {{ digitDateLang($profile->constituencyNumber)}}, 
                                {{ $profile->voter_area_bng}}, 
                                {{ $profile->nameBng }}
                            @else
                                {{ $profile->constituencyNumber}}, 
                                {{ $profile->voter_area_eng}},  
                                {{ $profile->nameEng }}
                            @endif
                        @endif
                    @endforeach
                </td>
                <td>
                    {{ $list->question }}
                </td>
                <td>
                    @if (isset($list->attachement))

                        <a href="{{ asset('public/backend/digital_support/' . $list->attachement) }}" target="_blank"
                            class="btn btn-success mr-2">@lang('View Attachment')</a>

                    @endif
                </td>
                <td>
                    {{ digitDateLang(date('d M Y, h:i a', strtotime($list->created_at))) }}
                </td>
                <td class="text-center">
                    <a class="btn btn-sm btn-success"
                        href="{{ url('app-management/digital-support-ans/show') }}/{{ $list->id }}">
                        @lang('View')
                    </a>
                    <a class="btn btn-sm btn-info"
                        href="{{ url('app-management/digital-support-ans/edit') }}/{{ $list->id }}">
                        @lang('Solution')
                    </a>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
<script>
    $(function() {
        $('#reservationdate').datetimepicker({
            format: 'DD MMMM, YYYY'
        });
    })

    function searchByDate() {
        var search_date = $('#search_date').val();
        window.location.href = "{{ url('app-management/digital-support-ans/search?date=') }}" + search_date;
    }
</script>
