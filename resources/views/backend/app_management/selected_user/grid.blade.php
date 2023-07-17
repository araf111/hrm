<div class="row">
    <h4 class="col-md-12">
        @lang('Selected Person List')
    </h4>
</div>
<div class="row">
    <div class="col-md-4">

        <div class="form-group">
            <label class="control-label" for="search_selected_type">@lang('Selected Type Name')</label>
            <select class="form-control required"
                id="search_selected_type" name="selected_type">
                <option value="">@lang('Selected Type Name')</option>
                @foreach ($type_list as $list)
                    <option value="{{ $list->id }}">
                        @if (session()->get('language') == 'bn')
                            {{ $list['name_bn'] }}
                        @else
                            {{ $list['name_en'] }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="search_name">@lang('Name')</label>
            <input type="text" required id="search_name" name="name" class="form-control"
                placeholder="@lang('Name')" />
        </div>
    </div>
    <div class="col-md-2" style="
    bottom: -30px;
">
        <button class="btn btn-success" onclick="searchByType()">@lang('Search')</button>
    </div>
    <div class="col-md-2">

    </div>
</div>
<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="10%">@lang('Serial')</th>
            <th width="10%">@lang('Name')</th>
            <th width="10%">@lang('Father Name')</th>
            <th width="10%">@lang('Designations')</th>
            <th width="10%">@lang('Permanent Address')</th>
            <th width="10%">@lang('Mobile') <br/>@lang('Email')</th>
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
                <td>{{ $list->name }}</td>
                <td>
                    {{ $list->father_name }}
                </td>
                <td>
                    {{ $list->designation }}
                </td>
                <td>
                    {{ $list->permanent_address }}
                </td>
                <td>
                    {{ $list->mobile_num }} <br />
                    {{ $list->email }}
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
                                href="{{ url('app-management/selected-user/edit') }}/{{ $list->id }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form method="POST" style="display: contents;" action="{{ url('app-management/selected-user/delete') }}">
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
     function searchByType(type){
        var search_name = $('#search_name').val();
        var search_selected_type = $('#search_selected_type').val();
        window.location.href = "{{ url('app-management/selected-user/search?type=') }}"+search_selected_type+"&name="+search_name;

     }
</script>
