<div class="row">
    <h4 class="col-md-12">
        @lang('Selection Type List')
    </h4>
</div>
<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="10%">@lang('Serial')</th>
            <th width="20%">@lang('Types Of Selected Person') <br/>(Bangla)</th>
            <th width="20%">@lang('Types Of Selected Person') <br/>(English)</th>
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
                <td>{{ $list->name_bn }}</td>
                <td>
                    {{ $list->name_en }}
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
                                href="{{ url('app-management/selected-type/edit') }}/{{ $list->id }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form method="POST" style="display: contents;" action="{{ url('app-management/selected-type/delete') }}">
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
     $(function () {
        $('#reservationdate').datetimepicker({
            format: 'DD MMMM, YYYY'
        });
     })
     function searchByDate(type){
        var search_date = $('#search_date').val();
        if (type == 2) {
            window.location.href = "{{ route('admin.appointment-management.appointment-request.acceptedList')}}/"+search_date;
        } else if (type == 3) {
            window.location.href = "{{ route('admin.appointment-management.appointment-request.rejectedList')}}/"+search_date;
        
        } else if (type == 1) {
            window.location.href = "{{ route('admin.appointment-management.appointment-request.index')}}/"+search_date;
        
        }
     }
</script>
