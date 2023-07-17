<div class="row">
    <h4 class="col-md-12">
        @lang('Pole Question List')
    </h4>
</div>
<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="5%">@lang('Serial')</th>
            <th width="25%">@lang('Question')</th>
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
                <td>
                    {{ $list->question }}
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
                        href="{{ url('app-management/pull-question/edit') }}/{{ $list->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" style="display: contents;"
                        action="{{ url('app-management/pull-question/delete') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $list->id }}" />
                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-times"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
