@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Standing Committee Forming Management')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Standing Committee Forming Management')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">               
                <h4 class="card-title w-100">
                    <a href="{{ route('admin.master_setup.new_standing_committees.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Standing Committee List')</a>
                </h4>
                <h5>@lang('Standing Committee')</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="div col-sm-6 col-md-3 col-lg-4">
                        <label for="" class="control-label">@lang('1').@lang('Committee Name'):</label>
                        <label for="">{{ $editData->committee_name }}</label>
                    </div>
                    <div class="div col-sm-6 col-md-3 col-lg-4">
                        <label class="control-label" for="parliament_id">@lang('2'). @lang('Parliament No'):
                        <label for="">@lang($parliaments->parliament_number)</label>
                    </div>
                    @if (isset($ministries) && count($ministries) > 0)
                    @foreach ($ministries as $data)
                    @endforeach
                    @endif
                    <div class="div col-sm-6 col-md-3 col-lg-4">
                        <label class="control-label" for="ministry_id">@lang('3'). @lang('Ministry'):</label>                           
                            <label for="">{{ $data->name_bn }}</label>
                    </div>
                </div>                                       
                <div class="row">
                    <div class="div col-sm-6 col-md-3 col-lg-4">
                        <label class="control-label" for="date_from">@lang('4'). @lang('Committee Forming Date'):</label> 
                        <label for="">{{ digitDateLang(date('d-m-y',strtotime($editData->date_from))) }}</label>
                    </div>
                    <div class="div col-sm-6 col-md-3 col-lg-4">
                        <label class="control-label" for="date_to">@lang('5'). @lang('Committee Closing Date'):</label>
                        <label for="">{{ digitDateLang(date('d-m-y',strtotime($editData->date_to)))}}</label>
                    </div>
                    @if (isset($ministries) && count($ministries) > 0)
                    @foreach ($ministries as $data)
                    @endforeach
                    @endif
                    <div class="div col-sm-6 col-md-3 col-lg-4">
                        <label class="control-label" for="date_to">@lang('6'). @lang('Committee Status'):</label>
                        <label for=""> @lang('Active') </label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <h5 style="align-content: center">@lang('Standing Committee Members')</h5>
                    <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">@lang('Serial')</th>
                                    <th width="30%">@lang('Name')</th>
                                    <th width="15%">@lang('Designation')</th>
                                    <th width="5%">@lang('Status')</th>                                 
                                </tr>
                            </thead>
                            <tbody>
                                @php  $i = 0;  @endphp
                               {{-- {{   echo var_export($standingCommitteeMember, true); }} --}}
                                @foreach ($standingCommitteeMembers as $standingCommitteeMember)
                                    
                                <tr align="center">
                                    <td>{{ digitDateLang($loop->iteration) }}</td>
                                    @foreach ($profiles as $data)
                                        @if ($standingCommitteeMember->user_id == $data->user_id)
                                        @foreach ($constituencies as $constituency )
                                            @if ($constituency->id == $data->constituency_id)
                                            <td>@lang($data->constituency_id),{{ $constituency->bn_name }}, {{ (session()->get('language') =='bn')?$data->name_bn:$data->name_eng}}</td>
                                            @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @foreach ($committee_designations as $data)                                    
                                        @if($standingCommitteeMember->designation_id==$data->id) 
                                        <td>{{ (session()->get('language') =='bn')?$data->name_bn:$data->name_en}}</td>                   
                                        @endif 
                                        @endforeach
                                        <td>@if ($standingCommitteeMember->status == 1)
                                            @lang('Active') 
                                            @else
                                            @lang('Inactive')
                                            @endif
                                        </td>
                                </tr>
                                @php  $i++ ;  @endphp
                                @endforeach  
                            </tbody>
                        </table>
                </div>            
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 mt-2">
                        <div class="form-group text-center">
                            <button type="submit" onclick="alert('This feature will be coming soon')" class="btn btn-success btn-sm">@lang('Print')</button>
                            {{-- <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button> --}}
                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                <a href="{{ route('admin.master_setup.new_standing_committees.index') }}">@lang('Back')</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(function() {
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD',
        });
        $('#reservationdate2').datetimepicker({
            format: 'YYYY-MM-DD',
        });

        $('#addMore').click(function(){
            var loadMp = '<div id="childDiv" class="row mb-2">{{-- user_id[] --}}<div class="col-sm-12 col-md-6 col-lg-4"> <select id="standing_committee" name="user_id[]" class="@error('user_id') is-invalid @enderror form-control form-control-sm select2"> <option value="">@lang('Select the Name')</option> @if (isset($profiles) && count($profiles) > 0) @foreach ($profiles as $data) @if($data->user_id==old('user_id')) <option selected value="{{$data->user_id}}"> @if(session()->get('language')=='bn'){{$data->name_bn}}@else{{$data->name_eng}}@endif </option> @else <option value="{{$data->user_id}}"> @if(session()->get('language')=='bn'){{$data->name_bn}}@else{{$data->name_eng}}@endif </option> @endif @endforeach @endif </select> @error('user_id') <span class="text-danger">{{$message}}</span> @enderror </div><div class="col-sm-12 col-md-6 col-lg-4">{{-- designation_id[]--------------}}<select id="standing_committee" name="designation_id[]" class="@error('designation_id') is-invalid @enderror form-control form-control-sm select2"> <option value="">@lang('Select the Designation')</option> @if (isset($committee_designations) && count($committee_designations) > 0) @foreach ($committee_designations as $data) @if($data->id==old('id')) <option selected value="{{$data->id}}"> @if(session()->get('language')=='bn'){{$data->name_bn}}@else{{$data->name_eng}}@endif </option> @else <option value="{{$data->id}}"> @if(session()->get('language')=='bn'){{$data->name_bn}}@else{{$data->name_eng}}@endif </option> @endif @endforeach @endif </select> @error('user_id') <span class="text-danger">{{$message}}</span> @enderror </div><div class="form-group col-sm-4"> <select name="status[]" id="status" class="form-control form-control-sm"> <option value="1">@lang('Active')</option> <option value="0">@lang('Inactive')</option> </select> </div></div></div>';

            $('#divAdd').append(loadMp);
            $('.select2').select2();
        });
    })
</script>
@endsection