@include('report.pdf.header')
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

    .table {
  width: 100%;
}

.table th,
.table td {
  padding: 0.1rem; 
  max-width:100%;
  vertical-align: middle;
  border-top: 1px solid #eceeef;
}

.table thead th {
    background: #efefef;
  vertical-align: middle;
  border-bottom: 2px solid #eceeef;
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
}

.table tbody + tbody {
  border-top: 2px solid #eceeef;
}
</style>

<body>
  {{--  <div class="header_section" style="text-align:center;">
        {!! $notice_head !!}
    </div>
  --}}
    @if(isset($summary_view))
    <table class="table table-sm table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">@lang('Serial')</th>
                <th width="30%">@lang('Topic')</th>
                <th width="15%">@lang('Total')</th>
                <th width="30%">@lang('Mp')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary_list as $list)
            <tr>
                <td valign="top">{{ digitDateLang($loop->iteration) }}</td>
                <td valign="top">{{ digitDateLang($list->bill_topic) }}</td>
                <td valign="top">{{ digitDateLang($list->total_notice) ?? '' }}</td>
                <td valign="top">{{ $list->mp_names ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        {!! $record_list !!}
    @endif


    @include('report.pdf.footer')