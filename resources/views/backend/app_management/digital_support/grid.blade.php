<div class="row">
    <h4 class="col-md-12">
        @lang('My Askings List')
    </h4>
</div>
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
                    @if (session()->get('language') == 'bn')
                        {{ digitDateLang($list->profile->constituency['number'])}}, 
                        {{ $list->profile->constituency['bn_name']}}, 
                        {{$list->profile->nameBng }}
                    @else
                        {{ $list->profile->constituency['number']}}, 
                        {{ $list->profile->constituency['name']}},  
                        {{ $list->profile->nameEng }}
                    @endif
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
                        href="{{ url('app-management/digital-support-question/edit') }}/{{ $list->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" style="display: contents;"
                        action="{{ url('app-management/digital-support-question/delete') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $list->id }}" />
                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-times"></i></button>
                    </form>
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
        window.location.href = "{{ url('app-management/digital-support-question/search?date=') }}" + search_date;
    }
</script>
