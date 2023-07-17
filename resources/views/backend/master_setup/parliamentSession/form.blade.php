@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Parliament Session Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Parliament Session Management')</li>
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
                        <h4 class="card-title">@lang('Update Parliament Session')</h4>
                    @else
                        <h4 class="card-title">@lang('Create Parliament Session')</h4>
                    @endif
                </div>
                <!-- Form Start-->
                <form id="parliamentForm" name="parliamentForm" method="POST" enctype="multipart/form-data" 
                      @if($data->id)
                      action="{{ route('admin.master_setup.parliament_sessions.update', $data->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    @else
                        action="{{ route('admin.master_setup.parliament_sessions.store') }}">
                    @endif
                    @csrf

                    <input type="hidden" id="id" name="id" value="{{$data->id}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="parliament_id">@lang('Parliament No.')<span
                                            style="color: red;"> *</span></label>
                                    <select id="parliament_id" name="parliament_id" class="form-control select2 @error('parliament_id') is-invalid @enderror">
                                        <option value="">@lang('Select Parliament No.')</option>
                                        @foreach ($parliamentList as $list)
                                            @if($list['id']==$data->parliament_id or $list['id']==old('parliament_id'))
                                                <option selected
                                                        value="{{$list['id']}}" data-from="{{$list['date_from']}}" data-to="{{$list['date_to']}}">{{ Lang::get($list['parliament_number']) }}</option>
                                            @else
                                                <option  value="{{$list['id']}}" date-from="{{$list['date_from']}}" date-to="{{$list['date_to']}}">{{ Lang::get($list['parliament_number']) }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('parliament_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="session_no">@lang('Session No.')<span
                                            style="color: red;"> *</span></label>
                                           <select id="session_no" name="session_no" class="form-control select2 @error('session_no') is-invalid @enderror">
                                                <option value="">@lang('Select Session No.')</option>
                                                @foreach($session_list as $list)
                                                    @if($list['id']==$data->session_no or $list['id']==old('session_no'))
                                                    <option selected value="{{$list['name']}}">@php echo Lang::get($list['name']) @endphp </option>
                                                    @else
                                                    <option value="{{$list['name']}}">@php echo Lang::get($list['name']) @endphp </option>
                                                    @endif
                                                @endforeach
                                           </select>

                                    @error('session_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="declare_date">@lang('Declare Date')<span
                                            style="color: red;"> *</span></label>
                                    <!-- <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input @error('declare_date') is-invalid @enderror"
                                               name="declare_date"
                                               value="{{old('declare_date', $data->declare_date)}}"
                                               placeholder="@lang('Select Date')" autocomplete="off" maxlength="30"
                                               data-target="#reservationdate"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->
                                    <input type="text" id="declare_date" class="readonly_date nano_custom_date" name="declare_date">

                                    @error('declare_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="date_from">@lang('Date From')<span
                                            style="color: red;"> *</span></label>
                                    <!-- <div class="input-group date" id="reservationdatefrom" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input @error('date_from') is-invalid @enderror"
                                               name="date_from"
                                               value="{{old('date_from', $data->date_from)}}"
                                               placeholder="@lang('Select Date')" autocomplete="off" maxlength="30"
                                               data-target="#reservationdatefrom"/>
                                        <div class="input-group-append" data-target="#reservationdatefrom" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->
                                    <input type="text" id="date_from" class="readonly_date nano_custom_date" name="date_from" value="{{old('date_from', $data->date_from)}}">

                                    @error('date_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="date_to">@lang('Date To')<span
                                            style="color: red;"> *</span></label>
                                    <!-- <div class="input-group date" id="reservationdateto" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input @error('date_to') is-invalid @enderror"
                                               name="date_to"
                                               value="{{old('date_to', $data->date_to)}}"
                                               placeholder="@lang('Select Date')" autocomplete="off" maxlength="30"
                                               data-target="#reservationdateto"/>
                                        <div class="input-group-append" data-target="#reservationdateto" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div> -->
                                    <input type="text" id="date_to" class="readonly_date nano_custom_date" name="date_to" value="{{old('date_to', $data->date_to)}}">

                                    @error('date_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <label class="control-label" for="attachment">@lang('Attachment (if any)')</label>
                                    <!-- <input type="file" class="form-control attachment_upload" name="attachment" id="attachment"> -->
                                    <button type="button" class="btn btn-sm btn-info"
                                            onclick="document.getElementById('attachment').click()">
                                            @lang('Choose Files')</button>
                                        <input type="file" class="form-control attachment_upload pl-1" name="attachment"
                                            id="attachment" accept=".doc, .docx, .txt, .pdf" style="display:none">
                                            <span id="photo_name"></span>
                                    @if($data->id)
                                        @foreach($attachments as $file)
                                        <a class="badge badge-dark text-white d-inline-block float-left mt-2 mr-2" href="{{ asset('public/backend/attachment/'.$file->attachment)  }}" target="_blank">@lang('Previous Attachment') - {{ Lang::get($loop->iteration) }}</a>
                                        @endforeach
                                    @endif

                                    @error('attachment')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if($data->id)
                            <div class="form-group col-sm-4 mt-auto">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="status" {{ $data->status == 1 ? 'checked' : '' }} value="1" class="custom-control-input" id="active-status">
                                    <label class="custom-control-label" for="active-status">@lang('Make it active ?')</label>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group text-right">
                                    @if($data->id)
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
                                        <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                    @endif
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{route('admin.master_setup.parliament_sessions.index') }}">@lang('Back')</a>
                                    </button>
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
@section('script')
    <script>
        $(function () {
            $(".readonly_date").keypress(function(e) {
                return false;
            });
            $(".readonly_date").keydown(function(e) {
                return false;
            });
            
            var start_from = moment(new Date("{{$next_session_date}}")).format('D-MM-YYYY'); 
            var end_from = moment(new Date("{{$upto_parliament_date}}")).format('D-MM-YYYY');

            var existing_date_from = "{{(isset($data->date_from))? $data->date_from:''}}";
            var existing_date_to = "{{(isset($data->date_to))? $data->date_to:''}}";

            var starting_date = (existing_date_from=='')?moment(new Date("{{$next_session_date}}")).format('D-MM-YYYY'):moment(new Date(existing_date_from)).format('D-MM-YYYY');
            
            var ending_date = (existing_date_to=='')?moment(new Date("{{$next_session_date}}")).format('D-MM-YYYY'):moment(new Date(existing_date_to)).format('D-MM-YYYY');
            
            var start_to = moment(new Date("{{$next_session_date}}")).format('D-MM-YYYY'); 
            var end_to = moment(new Date("{{$upto_parliament_date}}")).format('D-MM-YYYY');
            var current_date = moment();

            $('#date_from').daterangepicker({
                startDate: starting_date,
                minDate:starting_date,
                maxDate:end_from,
                singleDatePicker: true,
                locale: daterange_locale
            });

            $('#date_to').daterangepicker({
                startDate: ending_date,
                minDate:ending_date,
                maxDate:end_to,
                singleDatePicker: true,
                locale: daterange_locale
            });

            $('#declare_date').daterangepicker({
                startDate: current_date,
                minDate:current_date,
                maxDate:end_to,
                singleDatePicker: true,
                locale: daterange_locale
            });
            
            _showFileName('attachment','photo_name');

            $("#date_from").on('change',function(){              
                var min_date_to = moment($(this).val(), "DD-MM-YYYY").add(1, 'days').format('DD-MM-YYYY'); 
                $('#date_to').daterangepicker({
                    startDate: min_date_to,
                    minDate:min_date_to,
                    maxDate:end_to,
                    singleDatePicker: true,
                    locale: daterange_locale
                });
            });

            /* $("#parliament_id").on('change',function(){              
                var parliament_date_from = moment($(this).data('from'), "DD-MM-YYYY").add(1, 'days').format('DD-MM-YYYY'); 
                var parliament_date_to = moment($(this).data('to'), "DD-MM-YYYY").add(1, 'days').format('DD-MM-YYYY'); 
                $('#date_to').daterangepicker({
                    startDate: min_date_to,
                    minDate:min_date_to,
                    maxDate:end_to,
                    singleDatePicker: true,
                    locale: daterange_locale
                });
            }); */




        })
    </script>
@endsection

