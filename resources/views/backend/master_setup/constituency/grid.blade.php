<table id="dataTable" class="table table-sm table-bordered table-striped">
    <thead>
    <tr>
        <th>@lang('Serial')</th>
        <th>@lang('Parliament')</th>
        <th>@lang('Bangladesh Number')</th>
        <th>@lang('Constituency Name')</th>
        <th width="25%">@lang('Upazila')</th>
        <th width="25%">@lang('Union')</th>
        <th>@lang('Status')</th>
        <th class="text-center">@lang('Action')</th>
    </tr>
    </thead>
    <tbody>

    @php
        $i=1;
    @endphp

    @foreach($constituencies as $list)

        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ digitDateLang($list->parliamentNumber) }}</td>
            <td>{{ digitDateLang($list->number) }}</td>
            <td>
                @if(session()->get('language') =='bn')
                    {{ $list->bn_name }}
                @else
                    {{ $list->name }}
                @endif
            </td>
            <td>
                @php
  
                    $nameAddOnConstituency = [( isset( $list->upazila_id ) ) ? ( explode( ",", $list->upazila_id ) ) : array( '' )];

                    foreach ( $upazilas as $upazila ) {
                        if ( in_array( $upazila->id, $nameAddOnConstituency[0] ) ) {
                            if ( session()->get( 'language' ) == 'bn' ) {
                                echo( $upazila->bn_name .", " );
                            } else {
                                echo( $upazila->bn_name .", ");
                            }
                        }
                    }
                    
                @endphp

            </td>
            <td>
                @php
  
                    $nameAddOnConstituency = [( isset( $list->union_id ) ) ? ( explode( ",", $list->union_id ) ) : array( '' )];

                    foreach ( $unions as $union ) {
                        if ( in_array( $union->id, $nameAddOnConstituency[0] ) ) {
                            if ( session()->get( 'language' ) == 'bn' ) {
                                echo( $union->bn_name .", " );
                            } else {
                                echo( $union->bn_name .", ");
                            }
                        }
                    }
                    
                @endphp

            </td>
            <td>{!! activeStatus($list->status) !!}</td>
            <td class="text-center">
                <a class="btn btn-sm btn-success" href="{{route('admin.master_setup.constituencies.edit',$list->id)}}">
                    <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-sm btn-danger destroy" data-route="{{route('admin.master_setup.constituencies.destroy', $list->id)}}">

                    <i class="fa fa-trash"></i>
                </a>
            </td>
        </tr>
    @endforeach

    </tbody>
</table>
