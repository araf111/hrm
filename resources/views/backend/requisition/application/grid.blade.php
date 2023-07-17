<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="8%">@lang('Serial')</th>
            <th>@lang('Connection Type')</th>
            <th>@lang('Connection Place')</th>
            <!-- <th>@lang('Number of Mobile')</th> -->
            <th width="15%" class="text-center">@lang('Status')</th>
            <th width="15%" class="text-center">@lang('Action')</th>
        </tr>
    </thead>
    <tbody>


        @foreach($data as $list)
        <tr>
            <td>{{digitDateLang($loop->iteration)}}</td>
            <td>@if($list->connection_type == 1)
                    @lang('Telephone')
                @else
                    @lang('Pabx')
                @endif
            </td>
            <td>@if($list->connection_place == 1)
                    @lang('Official')
                @else
                    @lang('Residential')
                @endif
            </td>
            <td class="text-center">@if($list->status == 0)
                    <span class="btn btn-warning">@lang('Pending')</span>
                @elseif ($list->status == 1)
                    <span class="btn btn-warning">@lang('Pending')</span>
                @elseif ($list->status == 2)
                    <span class="btn btn-danger">@lang('Rejected')</span>
                @elseif ($list->status == 5)
                <span class="btn btn-info">@lang('Approved')</span>
                @endif
            </td>
            <!-- <td>{{digitDateLang($list->telphone_expenses)}}</td>
            <td>{{digitDateLang($list->cashing_allowance)}}</td>
            <td>{!! activeStatus($list->status) !!}</td>-->
            <td class="text-center">
                <a class="btn btn-sm btn-info" href="{{route('admin.requisition.telephone_pabx_application.show',$list->id)}}">
                    <i class="fa fa-eye"></i>
                </a>
                <a class="btn btn-sm btn-success" href="{{route('admin.requisition.telephone_pabx_application.edit',$list->id)}}">
                    <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.requisition.telephone_pabx_application.destroy', $list->id)}}">
                    <i class="fa fa-trash"></i>
                </a>
            </td> 
        </tr>
        @endforeach

    </tbody>
</table>