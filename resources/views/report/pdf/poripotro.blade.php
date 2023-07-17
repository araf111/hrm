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

    {!! $record_list !!}

    
@include('report.pdf.footer')
