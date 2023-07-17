<div class="row">
    <h4 class="col-md-12">
        @lang('Selected Member Chat List')
    </h4>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {{-- <label>@lang('Select Date'):</label> --}}
            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                <input type="text" id="search_date" class="form-control datetimepicker-input" name="search_date"
                    placeholder="@lang('Select Date')"@if ($date != '')
                    value="{{$date}}"
                    @endif  autocomplete="off" maxlength="30"
                    data-target="#reservationdate" />
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <button class="btn btn-success" onclick="searchByDate()">@lang('Search')</button>
    </div>
    <div class="col-md-6">

    </div>
</div>
<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="10%">@lang('Serial')</th>
            <th width="10%">@lang('Post')</th>
            <th width="10%">@lang('Making Date')</th>
            <th width="10%">@lang('Attachment')</th>
            <th width="10%">@lang('Status')</th>
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
                    <a class="btn btn-sm btn-success"
                        href="{{ url('app-management/selected-member-chat/edit') }}/{{ $list->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" style="display: contents;"
                        action="{{ url('app-management/selected-member-chat/delete') }}">
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
        window.location.href = "{{ url('app-management/selected-member-chat/search?date=') }}" + search_date;
    }
</script>
