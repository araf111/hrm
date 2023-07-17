@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Mobile Application Setup')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Pull List')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @if ($data->id)
                        <h4 class='card-title'>@lang('Pole List')</h4>
                    @else
                        <h4 class='card-title'>@lang('Pole List')</h4>
                    @endif
                    <div class="text-right">
                        <a href="{{ route('admin.app-management.pull-list.index') }}" class="btn btn-sm btn-info"><i
                                class="fas fa-arrow-left"></i> @lang('Pole List')</a>
                    </div>
                </div>
                <!-- Form Start-->
                <form enctype="multipart/form-data" id="parliamentForm" name="parliamentForm" method="POST" @if ($data->id) action="{{ route('admin.app-management.pull-list.update', $data->id) }}">
                                                                                            <input name="_method" type="hidden" value="PUT">
                    @else action="{{ route('admin.app-management.pull-list.store') }}"> @endif @csrf <input type="hidden" id="id" name="id" value="{{ $data->id }}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="answer">@lang('Pole Name'):</label>
                                    <div class="control-label col-sm-6">{{ $data->name }}</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="answer">@lang('From Date'):</label>
                                    <div class="control-label col-sm-6">{{ digitDateLang(nanoDateFormat($data->fromDate)) }}</div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="answer">@lang('To Date'):</label>
                                    <div class="control-label col-sm-6">{{ digitDateLang(nanoDateFormat($data->toDate)) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label" for="answer">@lang('Question'):</label>
                                    
                                    @php
                                        $i = 0;
                                    @endphp
                                    @if (count($data->questions) > 0)
                                        <p class="control-label aaq_id">
                                            @foreach ($data->questions as $item)
                                                {{ ++$i }}. {!! $item->questions->question.'<br>' !!}
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label" for="answer">@lang('User Role'):</label>
                                    
                                    @php
                                        $i = 0;
                                    @endphp
                                    @if (count($role_names) > 0)
                                        <p class="control-label aaq_id">
                                            @foreach ($role_names as $item)
                                                {{ ++$i }}. {!! $item->name_bn.'<br>' !!}
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                            </div>

                        </div>

                        <div class="row" id="status_ans">
                            <div class="col-sm-4">
                                <div class="form-group row">
                                    <label class="control-label col-sm-3" for="status">@lang('Status')</label>
                                    <div class="control-label col-sm-6">
                                        @if ($data->status == 1)
                                            @lang('Published')
                                        @endif
                                        @if ($data->status == 0)
                                            @lang('Unpublished')
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    </div>

@endsection
