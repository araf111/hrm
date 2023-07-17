@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Citizen Question Management')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Citizen Question Management')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>@lang('Citizen Question')</h4>
            </div>
            
            <div class="card-body">
                <table id="dataTable" class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">@lang('Rule')</th>
                            <th width="20%">@lang('From')</th>
                            <th>@lang('Question')</th>
                            <th width="15%">@lang('Date')</th>
                            {{-- <th width="7%">@lang('Status')</th> --}}
                            <th>@lang('Answer')</th>
                            <th width="5%" class="text-center">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(auth()->user()->usertype === 'mp')
                            @foreach ($citizenQuestions as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->citizenName }}</td>
                                <td>
                                    {!! \Illuminate\Support\Str::limit($data->citizenQuestion, $limit = 130, $end = '...') !!}</td>
                                <td>{{ digitDateLang(nanoDateFormat($data->created_at)) }}</td>
                                <td class="text-center">
                                    @if ($data->mpAnswer!='')
                                    <span style="color: rgb(0, 167, 75); font-size:20px;"><i class="fa fa-check-circle"></i></span>
                                    @else
                                        
                                    @endif
                                </td>
                                {{-- <td>{!! activeStatus($data->status) !!}</td> --}}
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info" href="{{url('citizen-question/questions', $data->id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection