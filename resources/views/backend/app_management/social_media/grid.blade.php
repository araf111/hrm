<div class="row">
    <h4 class="col-md-12">
        @lang('Social Media List')
    </h4>
</div>
<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="10%">@lang('Serial')</th>
            <th width="10%">@lang('Post')</th>
            <th width="10%">@lang('Making Date')</th>
            <th width="10%">@lang('Attachment')</th>
            <th width="10%">@lang('Status')</th>
            <th width="10%" sorted="disable">@lang('Share')</th>
            <th width="10%" class="text-center">@lang('Action')</th>

        </tr>
    </thead>
    <tbody>

        @php
            $i = 1;
        @endphp

        @foreach ($items as $list)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $list->post }}</td>
                <td>
                    {{ $list->date }}
                </td>
                <td>
                    @if (isset($list->image))

                        <a href="{{ asset('public/backend/chat_document/' . $list->image) }}" target="_blank"
                            class="btn btn-success mr-2">View Attachment</a>

                    @endif
                </td>
                <td>
                    @if ($list->status == 1)
                        @lang('Active')
                    @elseif($list->status==0)
                        @lang('Inactive')
                    @endif
                </td>
                <td class="text-center">
                    <a class="btn btn-sm" href="https://www.facebook.com/sharer.php?u={{ $list->post }}">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" focusable="false" width="1em" height="1em"
                            style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512">
                            <path
                                d="M480 257.35c0-123.7-100.3-224-224-224s-224 100.3-224 224c0 111.8 81.9 204.47 189 221.29V322.12h-56.89v-64.77H221V208c0-56.13 33.45-87.16 84.61-87.16c24.51 0 50.15 4.38 50.15 4.38v55.13H327.5c-27.81 0-36.51 17.26-36.51 35v42h62.12l-9.92 64.77H291v156.54c107.1-16.81 189-109.48 189-221.31z"
                                fill-rule="evenodd" fill="#626262" />
                        </svg>
                    </a>
                    <a class="btn btn-sm" href="https://twitter.com/intent/tweet?text={{ $list->post }}">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" focusable="false" width="1em" height="1em"
                            style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512">
                            <path
                                d="M496 109.5a201.8 201.8 0 0 1-56.55 15.3a97.51 97.51 0 0 0 43.33-53.6a197.74 197.74 0 0 1-62.56 23.5A99.14 99.14 0 0 0 348.31 64c-54.42 0-98.46 43.4-98.46 96.9a93.21 93.21 0 0 0 2.54 22.1a280.7 280.7 0 0 1-203-101.3A95.69 95.69 0 0 0 36 130.4c0 33.6 17.53 63.3 44 80.7A97.5 97.5 0 0 1 35.22 199v1.2c0 47 34 86.1 79 95a100.76 100.76 0 0 1-25.94 3.4a94.38 94.38 0 0 1-18.51-1.8c12.51 38.5 48.92 66.5 92.05 67.3A199.59 199.59 0 0 1 39.5 405.6a203 203 0 0 1-23.5-1.4A278.68 278.68 0 0 0 166.74 448c181.36 0 280.44-147.7 280.44-275.8c0-4.2-.11-8.4-.31-12.5A198.48 198.48 0 0 0 496 109.5z"
                                fill="#626262" />
                        </svg>
                    </a>
                    <a class="btn btn-sm" href="https://www.instagram.com/">

                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            aria-hidden="true" focusable="false" width="1em" height="1em"
                            style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"
                            preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512">
                            <path
                                d="M349.33 69.33a93.62 93.62 0 0 1 93.34 93.34v186.66a93.62 93.62 0 0 1-93.34 93.34H162.67a93.62 93.62 0 0 1-93.34-93.34V162.67a93.62 93.62 0 0 1 93.34-93.34h186.66m0-37.33H162.67C90.8 32 32 90.8 32 162.67v186.66C32 421.2 90.8 480 162.67 480h186.66C421.2 480 480 421.2 480 349.33V162.67C480 90.8 421.2 32 349.33 32z"
                                fill="#626262" />
                            <path d="M377.33 162.67a28 28 0 1 1 28-28a27.94 27.94 0 0 1-28 28z" fill="#626262" />
                            <path
                                d="M256 181.33A74.67 74.67 0 1 1 181.33 256A74.75 74.75 0 0 1 256 181.33m0-37.33a112 112 0 1 0 112 112a112 112 0 0 0-112-112z"
                                fill="#626262" />
                        </svg>
                    </a>
                </td>
                <td class="text-center">
                    <a class="btn btn-sm btn-success"
                        href="{{ url('app-management/social-media/edit') }}/{{ $list->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" style="display: contents;"
                        action="{{ url('app-management/social-media/delete') }}">
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
        window.location.href = "{{ url('app-management/social-media/search?date=') }}" + search_date;
    }
</script>
