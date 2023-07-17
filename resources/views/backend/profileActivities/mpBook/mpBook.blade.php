@extends('backend.layouts.app')
@section('content')
    @if (isset($data))
        <div class="card-body">
            <table id="dataTable" class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">@lang('Bangladesh number and constituency')</th>
                        <th width="20%">@lang('Honourable Parliament Members Name')</th>

                        <th width="15%">@lang('Address')</th>
                        <th width="15%">@lang('Telephone and email')</th>
                        {{-- <th width="15%">@lang('Residential Telephone')</th>

                                    <th width="15%">@lang('Official Address')</th>
                                    <th width="15%">@lang('Residential Address')</th> --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($data as $list)

                        <tr>
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            <td>
                                @if (session()->get('language') == 'bn')
                                    {{ $list->voter_area_bn }}
                                @else
                                    {{ $list->voter_area_en }}
                                @endif
                            </td>
                            {{-- <td>Mr/Mrs. {{$list->name_eng}} <br/>( {{$list->designation->name}} )</td> --}}
                            <td>
                                @if (session()->get('language') == 'bn')
                                    {{ $list->name_bn }}
                                @else
                                    {{ $list->name_eng }}
                                @endif
                            </td>

                            <td>
                                (@lang('A')) {{ $list->parmanent_address }}
                                <br>
                                (@lang('B')) {{ $list->residential_address }}
                                <br>
                                (@lang('C')) {{ $list->office_address }}
                            </td>
                            <td>{{ $list->official_phone }} <br> {{ $list->residential_phone }}</td>
                            {{-- <td>{{$list->residential_phone}}</td>

                                        <td>{{$list->office_address}}</td>
                                        <td>{{$list->residential_address}}</td> --}}

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    @endif
