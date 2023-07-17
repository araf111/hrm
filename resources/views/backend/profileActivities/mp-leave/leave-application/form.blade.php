@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">@lang('Leave application To The Honorable Speaker')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Activities')</li>
                        <li class="breadcrumb-item active">@lang('Leave Application')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="container-fluid">
        <div style="margin-bottom: 60px" class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <!-- Form Start-->
                <form id="mpLeaveForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-5">
                                <label class="control-label" for="from_date">@lang('From Date')<span
                                        style="color: red;"> *</span></label>
                                <input type="text" id="from_date" placeholder="@lang('Select Date')" autocomplete="off"
                                       class="readonly_date nano_custom_date from_date" name="from_date"
                                       value="{{(@$editData->from_date)?(date('d-m-Y',strtotime(@$editData->from_date))):''}}">
                            </div>


                            <div class="col-sm-12 col-md-4 col-lg-5">
                                <label class="control-label" for="from_date">@lang('To Date')<span style="color: red;"> *</span></label>
                                <input type="text" id="select_to_date" onfocusout="calculateDay()"
                                       placeholder="@lang('Select Date')" autocomplete="off"
                                       class="readonly_date nano_custom_date to_date" name="to_date"
                                       value="{{(@$editData->to_date)?(date('d-m-Y',strtotime(@$editData->to_date))):''}}">
                            </div>

                            <div class="col-sm-12 col-md-4 col-lg-2">
                                <div class="form-group">
                                    <label class="control-label" for="Auto Calculation">@lang('Total Leave')</label>
                                    <input class="form-control total_day form-control-sm" id="total_day" type="text"
                                           placeholder="@lang('Auto Calculation')" readonly>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="holiday_matters">@lang('Leave Reason')<span
                                            style="color: red;"> *</span></label>

                                    <div class="form-group col-sm-6">
                                        <select name="holiday_reason_id"
                                                class="form-control form-control-sm holiday_reason_id select2">
                                            <option value="" selected>@lang('Select the leave reason')</option>
                                            @foreach($holiday_reasons as $holiday_reason)
                                                <option
                                                    value="{{$holiday_reason->id}}" {{(@$editData) && $holiday_reason->id == $editData->holiday_reason_id? 'selected': '' }}>
                                                    {{(session()->get('language') == 'bn')?($holiday_reason->name_bn):$holiday_reason->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="Note">@lang('Note')<span
                                            style="color: red;"></span></label>
                                    <textarea rows="5" id="note" name="note" placeholder="@lang('Leave Details')"
                                              class="form-control note @error('note') is-invalid @enderror">
                                            @if(isset($editData))
                                            {{ $editData->note ?? old('note') }}
                                        @endif
                                        </textarea>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="control-label" for="attachment">@lang('Attachments')</label>
                                    <input type="file" class="form-control attach_file" name="attach_file"
                                           id="attachment"
                                           multiple="">
                                </div>
                                @if(@$editData)
                                    <div class="form-group">
                                        <span>@lang('Previous file name')</span>
                                        <input class="form-control form-control-sm"
                                               value="@if(isset($editData)){{ $editData->attach_file}}@endif">
                                    </div>
                                @endif

                                @error('attach_file')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <small id="file_size_text" class="text-muted">
                                    (.pdf/.jpg/.png file only, file size max 10MB)
                                </small>
                            </div>
                            <div class="col-sm-2">
                                <div class="text-center mt-lg-4 mt-sm-2">
                                    @if (@$editData['attach_file'])
                                        <a href="{{ asset('public/backend/images/leave-file/'.@$editData['attach_file']) }}"
                                           target="_blank">
                                            <i class="fa fa-paperclip fa-3x" aria-hidden="true"
                                               style="color: #0c0c0c"></i>
                                        </a>
                                    @else

                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-right">
                                @if(@$user_type =='mp')
                                    <button type="submit" name="mpsubmit" value="1"
                                            class="btn btn-success btn-sm">@lang('Send')</button>
                                    <button type="submit" name="mpsubmit" value="0"
                                            class="btn btn-success btn-sm">{{@$editData? app('translator')->get('Update'): app('translator')->get('Save')}}  </button>
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{route('admin.profile-activities.mp-leave.leave-application.index')}}">@lang('Go back to the list')</a>
                                    </button>
                                @else

                                    <button type="submit"
                                            class="btn btn-success btn-sm">{{@$editData? app('translator')->get('Update'): app('translator')->get('Save')}}  </button>
                                    <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                    <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                        <a href="{{route('admin.profile-activities.mp-leave.leave-application.index')}}">@lang('Go back to the list')</a>
                                    </button>
                                @endif

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
        var from_date = @php echo json_encode($applied_date, true); @endphp;
        var to_date = @php echo json_encode($to_date, true); @endphp;

        var currentFromValue = $('#from_date').val();
        var currentToValue = $('#select_to_date').val();


        $('#from_date').on('focusout', function () {
            var input_from_date = $("input#from_date").val();
            console.log(input_from_date);
            input_from_date = input_from_date.substring(6, 10) + '-' + input_from_date.substring(3, 5) + '-' + input_from_date.substring(0, 2);
            for (i = 0; i < from_date.length; i++) {
                if (input_from_date == from_date[i]) {

                    $(this).val(currentFromValue);

                    @if(session()->get('language')=='bn')
                    // alert('You have previously applied for leave with this date !!');
                    toastr.error('আপনি ইতিমধ্যে এই তারিখে ছুটির জন্য আবেদন করেছেন !!');
                    @else
                    // alert('You have previously applied for leave with this date !!!');
                    toastr.error('You have previously applied for leave with this date !!');
                    @endif
                    $('#from_date').empty();
                    return false;

                }
            }
        });

        $('#select_to_date').on('focusout', function () {
            var input_to_date = $("input#select_to_date").val();
            input_to_date = input_to_date.substring(6, 10) + '-' + input_to_date.substring(3, 5) + '-' + input_to_date.substring(0, 2);
            for (i = 0; i < to_date.length; i++) {
                if (input_to_date == to_date[i]) {

                    $(this).val(currentToValue);

                    @if(session()->get('language')=='bn')
                    toastr.error('আপনি ইতিমধ্যে এই তারিখে ছুটির জন্য আবেদন করেছেন !!');
                    @else
                    toastr.error('You have previously applied for leave with this date !!!');
                    @endif
                        return false;

                }
            }
        });


        $(function () {
            let from_date = $('#from_date');
            let to_date = $('#select_to_date');
            var start = moment(); //.subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                @if(session()->get('language')=='bn')
                setTimeout(function () {
                    $('#from_date span').html(nanoLangTranslate(start.format('D-MM-YYYY')));
                }, 1500);

                @else
                $('#from_date span').html(start.format('D-MM-YYYY'));
                @endif
            }

            $(from_date).daterangepicker({
                autoUpdateInput: false,
                autoApply: false,
                showDropdowns: true,
                startDate: "{{ (isset($editData->from_date) && $editData->from_date!='' && $editData->from_date!='0000-00-00')?date('d-m-Y',strtotime($editData->from_date)):date('d-m-Y') }}",
                //endDate: end,
                minDate: '{{date('d-m-Y')}}',
                singleDatePicker: true,
                locale: daterange_locale,
                //ranges: daterange_ranges
            }, cb);
            cb(start, end);

            $(from_date).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });

            function cb_to_date(start, end) {
                @if(session()->get('language')=='bn')
                setTimeout(function () {
                    $('#select_to_date span').html(nanoLangTranslate(start.format('D-MM-YYYY')));
                }, 1500);

                @else
                $('#select_to_date span').html(start.format('D-MM-YYYY'));
                @endif
            }

            $(to_date).daterangepicker({
                autoApply: false,
                autoUpdateInput: false,
                showDropdowns: true,
                startDate: "{{ (isset($editData->to_date) && $editData->to_date!='' && $editData->to_date!='0000-00-00')?date('d-m-Y',strtotime($editData->to_date)):date('d-m-Y') }}",
                //endDate: end,
                minDate: '{{date('d-m-Y')}}',
                singleDatePicker: true,
                locale: daterange_locale,
                //ranges: daterange_ranges
            }, cb_to_date);
            cb_to_date(start, end);

            $(to_date).on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            })

        });

        function calculateDay() {
            let select_from_date = $('input#from_date');
            let select_to_date = $('input#select_to_date');
            let calculate_day = $("input#total_day");

            var startdate = select_from_date.val().substring(3, 5) + '-' + select_from_date.val().substring(0, 2) + '-' + select_from_date.val().substring(6, 10);
            var enddate = select_to_date.val().substring(3, 5) + '-' + select_to_date.val().substring(0, 2) + '-' + select_to_date.val().substring(6, 10);
            var from_date = Date.parse(startdate);
            var to_date = Date.parse(enddate);

            if (from_date > to_date) {
                select_from_date.val("");
                select_to_date.val("");
                calculate_day.val('');
                return false;
            }
            if (from_date && to_date) {
                const diffTime = Math.abs(to_date - from_date);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                @if(session()->get('language')=='bn')
                $("input#total_day").val(digitDateLang(diffDays + 1));
                @else
                $("input#total_day").val((diffDays + 1));
                @endif
            }
        }

        @if(isset($editData))
        calculateDay();

        @endif

        function digitDateLang(input) {
            var numbers = {
                '.': '.',
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
            };
            var output = [];
            input = input.toString();
            for (var i = 0; i < input.length; ++i) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('');
        }


        $(document).ready(function () {

            //return false;
            $('form#mpLeaveForm').validate({
                ignore: [],
                errorPlacement: function (error, element) {
                    if (element.hasClass("holiday_reason_id")) {
                        error.insertAfter(element.next());
                    } else {
                        error.insertAfter(element);
                    }

                },
                errorClass: 'text-danger',
                validClass: 'text-success',

                submitHandler: function (form) {
                    event.preventDefault();
                    $('[type="submit"]').attr('disabled', 'disabled').css('cursor', 'not-allowed');
                    var formInfo = new FormData($("#mpLeaveForm")[0]);

                    $.ajax({
                        url: "{{isset($editData) ? url('/profile-activities/mp-leave/leave-application-update',$editData):route('admin.profile-activities.mp-leave.leave-application.store')}}",
                        data: formInfo,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('.preload').show();
                        },

                        success: function (data) {
                            if (data.status == 'success') {
                                toastr.success("", data.message);
                                $('.preload').hide();
                                setTimeout(function () {
                                    location.replace(data.reload_url);

                                }, 2000);
                            } else if (data.status == 'error') {
                                toastr.error("", data.message);
                                $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                                $('.preload').hide();
                            } else if (data.status == 'v_error') {
                                $('span.text-danger').text('');
                                for (var key in data.error) {
                                    $('span.' + key).text(data.message[key]);
                                }
                                $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                                $('.preload').hide();
                            } else {
                                toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {
                                    globalPosition: 'top right',
                                    className: 'error',
                                    autoHideDelay: 10000
                                });
                                $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                                $('.preload').hide();
                            }
                        },
                        error: function (err) {
                            $('.preload').hide();
                            console.log(err);
                            $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                        }
                    });
                }
            });

            jQuery.validator.addClassRules({
                'from_date': {
                    required: true,
                },
                'to_date': {
                    required: true,
                },
                'holiday_reason_id': {
                    required: true,
                },
                'attach_file': {
                    extension: "jpg,jpeg,png,pdf",
                }

            });


        });


    </script>

@endsection


