@include('backend.master_setup.mp_office_room.report.header')
<style type="text/css">
    body {
        font-family: 'nikosh', Poppins, sans-serif;
    }

    .notice_head_title {
        font-size: 20px;
        line-height: 20px;
        margin-bottom: 0px;
    }

    .notice_header_content {
        font-size: 16px;
        margin-top: 15px;
        margin-bottom: 15px;
    }

    table thead tr th {
        border-right: 1px solid #000000;
        border-bottom: 1px solid #000000;
        border-top: 1px solid #000000;
    }

    table thead tr:first-child {
        border-left: 1px solid #000000;
    }

    table tbody tr:last-child {
        border-right: 1px solid #000000;
        border-left: 1px solid #000000;
        border-bottom: 1px solid #000000;
    }
</style>
<body>    
    <h1 style="margin-left: 160px">{{ $common_header }}</h1>   
    @if(isset($mpOfficeRoom))
    <table class="table table-sm table-bordered table-striped">
        <thead>
            <tr style="border:1px solid;">
                <th width="5%">@lang('Serial')</th>
                <th>@lang('Constituency Area No')</th>
                <th>@lang('Photo')</th>
                <th>@lang('MP Name')</th>
                <th>@lang('Constituency Area Name')</th>
                <th>@lang('Block, Level & Room No')</th>
                <th width="5%">@lang('Status')</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($mpOfficeRoom as $list)
            <tr>
                <td valign="top">{{ digitDateLang($loop->iteration) }}</td>
                <td valign="top">{{ digitDateLang($list->constituencies_id) }}</td>
                <td valign="top">{{ digitDateLang($list->mp_id) ?? '' }}</td>
                <td valign="top">{{ digitDateLang($list->mp_name_bn) ?? '' }}</td>
                <td valign="top">{{ digitDateLang($list->consticuency_name_bn) ?? '' }}</td>
                <td valign="top">{{ digitDateLang($list->songshod_blocks_id.','. $list->songshod_floors_id.','. $list->room_ids) ?? '' }}</td>
                <td valign="top">{{ digitDateLang($list->status) ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        {!! $record_list !!}
    @endif

    @include('backend.master_setup.mp_office_room.report.footer')
