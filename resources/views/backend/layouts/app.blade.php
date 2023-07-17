<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('hrm')</title>
    <link rel='icon' href='{{ asset('public/backend/img/parliament-logo.png') }}' type='image/x-icon' sizes="16x16" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet"
        href="{{ asset('public/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/plugins/datatables/dataTables.bootstrap4.css') }}">

    <link rel="stylesheet" href="{{ asset('public/backend') }}/plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="{{ asset('public/backend/css/colorpicker.css') }}" type="text/css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="{{ asset('public/backend') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('public/backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('public/backend/css/custom.css') }}">

    <style type="text/css">
        @font-face {
            font-family: 'nikosh';
            src: url("{{ asset('public/fonts/NikoshBAN.ttf') }}");
        }

        .nav-tabs .nav-item {
            margin-bottom: 0px;
        }

        input[type="file"] {
            padding: 0.175rem 0.75rem;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #000 !important;
        }

        .bg-gradient-success {
            background: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }

        .nav-link {
            font-family: 'nikosh';
        }

        .nav-sidebar {
            display: flex !important;
        }

        .badge {
            font-family: 'nikosh';
        }

        html * {
            font-family: 'nikosh', Poppins, sans-serif;
            ;
        }

        .fa,
        .far,
        .fas {
            font-family: "Font Awesome 5 Free";
        }

        a.btn-success,
        a.btn-warning,
        a.btn-primary,
        a.btn-secondary,
        a.btn-danger {
            color: #fff !important;
        }

        /*preloader*/
        .preload {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(35, 35, 35, 0.8);
        }

        /*ion*/
        .i-style {
            display: inline-block;
            padding: 10px;
            width: 2em;
            text-align: center;
            font-size: 2em;
            vertical-align: middle;
            color: #444;
        }

        .demo-icon {
            cursor: pointer;
        }

        /*swup*/
        .transition-fade {
            transition: 0.4s;
            opacity: 1;
        }

        html.is-animating .transition-fade {
            opacity: 0;
        }

        html.is-changing .transition-fade {
            /* CSS styles when changing  */
        }

        html.is-leaving .transition-fade {
            /* CSS styles when leaving  */
        }

        html.is-rendering .transition-fade {
            /* CSS styles when rendering  */
        }

        .swal2-overflow {
            overflow-x: visible;
            overflow-y: visible;

        }

        .myloader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{ asset('public/images/lottery.gif') }}') 50% 50% no-repeat rgba(249, 249, 249, 0.3);
        }

        .disabled_span {
            border: 1px solid #dad5d5;
            height: 25px;
            width: 25px;
            background: #efefef;
        }

        .spinner_loader {
            max-width: 35px;
        }

        .dashboard_canvas {
            min-height: 250px;
            height: 250px;
            max-height: 250px;
            max-width: 100%;
            overflow: auto;
        }

        .session_badge {
            background: #f5e30d;
            font-size: 16px;
            padding-right: 5px;
            padding-left: 5px;
        }

        /* remove X from locked tag */
        .locked-tag .select2-selection__choice__remove{
        display: none!important;
        }

        /* I suggest to hide  all selected tags from drop down list */
        .select2-results__option[aria-selected="true"]{
        display: none;
        }

        .nano_custom_date{
            background: #fff; 
            cursor: pointer; 
            padding: 5px 10px; 
            border: 1px solid #ccc; 
            width: 100%
        }

        .overflow_text_column {
            width: 15%;
            overflow:hidden; 
            white-space:nowrap; 
            text-overflow: ellipsis;
        }

    </style>


    <script src="{{ asset('public/backend/plugins/jquery/table2excel.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/jquery/jquery.min.js') }}"></script>
</head>

<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed control-sidebar-slide-open text-sm"
    style="height: auto;">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand" style="background: #58b1fc;">
            @include('backend.layouts.navbar')
        </nav>
        @include('backend.layouts.sidebar')
        <div class="content-wrapper" style="padding: 0px;">
            <main id="swup" class="transition-fade">
                @yield('content')
            </main>
        </div>
        <div class="clearfix"></div>
        <footer class="main-footer"
            style="background: white; border-top: 7px solid #f9f7f7; color: black; font-size: 12px; padding: 0px 15px 0px 15px;">
            <div class="footer_info">
                <div class="row">
                    <div class="col-sm-4 my-auto">
                        <strong>@lang('Planning & Implementation:')</strong>
                        <a href="https://cabinet.gov.bd/" target="_blank"><img
                                src="{{ asset('public/backend/img/byte-solution.png') }}"
                                style="height:30px; margin-right:15px;"></a>
                        
                    </div>
                    <div class="col-sm-4 my-auto text-center">
                        <strong>&#169; {{ digitDateLang(date('Y')) }} @lang('right_reserve')
                        </strong>
                    </div>
                    <div class="col-sm-4 my-auto text-right">
                        <strong>@lang('technical_support')</strong>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div class="preload" style="display: none;">
        <img src="{{ url('public/images/lottery.gif') }}" class="" alt=" Error">
    </div>

    <script src="{{ asset('public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
    <script src="{{ asset('public/backend/js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.js"></script>
    <script type="text/javascript" src="{{ asset('public/backend/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/backend/js/handlebars-v4.0.12.js') }}"></script>
    <script src="{{ asset('public/backend/js/demo.js') }}"></script>
    <script src="{{ asset('public/backend/js/colorpicker.js') }}"></script>
    <script src="{{ asset('public/backend') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('public/backend') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('public/backend') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>
    {{-- <script src="{{ asset('public/backend') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script> --}}
    <script src="{{ asset('public/backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/backend/js/validate.min.js') }}"></script>
    <script src="{{ asset('public/backend/js/additional-methods.js') }}"></script>
    <script src="{{ asset('public/backend/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('public/backend/js/notify.js') }}"></script>
    <script src="{{ asset('public/backend/js/nestable.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="{{ asset('public/backend/js/vfs_fonts.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="{{ asset('public/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ=="
        crossorigin="anonymous"></script>
    <script src="{{ asset('public/backend/') }}/plugins/swup/swup.min.js"></script>
    <script src="{{ asset('public/backend/') }}/plugins/swup/main.js"></script>
    {{-- <script src="{{ asset('public/backend/js/app.js') }}"></script> --}}
    <script>
        $(function() {
            $('.select2').select2();
            // bootstrap switch toggle
            // $("input[data-bootstrap-switch]").each(function(){
            //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
            // })
            // bootstrap switch toggle

            $('.textarea').summernote({
                height: 150,
            });

            $(".textareaWithoutImgVideo").summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript',
                        'subscript', 'clear'
                    ]],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
                ]
            });

            /* toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
              } */
        });

        // Remove extra space inside textarea
        $('document').ready(function() {
            $('textarea').each(function() {
                $(this).val($(this).val().trim());
            });
        });


        $(document).on("change", '.custom_image_upload', function(e) {

            var show_image = $(this).attr('data-image');

            $(show_image).html("");
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
            if (regex.test($(this).val().toLowerCase())) {
                if ($.browser.msie && parseFloat(jQuery.browser.version) <= 9.0) {
                    $(show_image).show();
                    $(show_image)[0].filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = $(this)
                        .val();
                } else {
                    if (typeof(FileReader) != "undefined") {
                        $(show_image).show();
                        $(show_image).append("<img height='100%' width='100%' />");
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(show_image + " img").attr("src", e.target.result);
                        }
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                }
            } else {
                alert("Please upload a valid image file.");
            }
        });


        $(document).on('click', '.delete', function() {
            var btn = this;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    var url = $(this).data('route');
                    var id = $(this).data('id');

                    $.get(url, {
                        id: id
                    }, function(result) {
                        Swal.fire(
                            'Deleted!',
                            'Record has been deleted.',
                            'success'
                        );
                        $(btn).closest('tr').fadeOut(1500);
                    });
                }

            })
        });
        $(document).on('click', '.destroy', function() {
            var btn = this;
            Swal.fire({
                title: '@lang("Are you sure?")',
                text: '@lang("You wont be able to revert this!")',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang("Yes")',
                cancelButtonText: '@lang("No")'
            }).then((result) => {
                console.log(result);
                if (result.value) {
                    var url = $(this).data('route');
                    var _token = "{{ csrf_token() }}";
                    $.ajax({
                        url: url,
                        type: "delete",
                        data: {
                            _token: _token
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    title: '',
                                    text: (response.message)?(response.message):"@lang('Data has been deleted!')",
                                    type: 'success'
                                }).then((result) => {
                                    $(btn).closest('tr').fadeOut(1500);
                                });
                            } else {
                                Swal.fire({
                                    title: (response.message)?(response.message):'@lang("Data cannot be deleted!")',
                                    confirmButtonText: '@lang("OK")',
                                });
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        title: '@lang("Your data is safe!")',
                        confirmButtonText: '@lang("OK")',
                    });
                }
            })
        });

        (function($, DataTable) {
            $.extend(true, DataTable.defaults, {
                language: {
                    "sProcessing": "@lang('Processing')",
                    "sLengthMenu": "@lang('Show') _MENU_ @lang('Data')",
                    "sZeroRecords": "@lang('No Data Found')",
                    "sEmptyTable": "@lang('No Data Found')",
                    "sInfo": "@lang('Showing') _START_ @lang('Of') _END_ @lang('Total') _TOTAL_ @lang('Data')",
                    "sInfoEmpty": "@lang('Showing') @lang('0') @lang('Of') @lang('0') @lang('Total') @lang('0') @lang('Data')",
                    "sInfoFiltered": "( _MAX_ @lang('Data') @lang('Filter From'))",
                    "sInfoPostFix": "",
                    "sSearch": "@lang('Search')",
                    "lengthMenu": "@lang('Show') <select>" +
                        "<option value='10'>@lang('1')@lang('0')</option>" +
                        "<option value='20'>@lang('2')@lang('0')</option>" +
                        "<option value='50'>@lang('5')@lang('0')</option>" +
                        "<option value='100'>@lang('1')@lang('0')@lang('0')</option>" +
                        "</select> @lang('Data')",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "paginate": {
                        "first": "@lang('1st')",
                        "last": "@lang('Last')",
                        "next": "@lang('Next')",
                        "previous": "@lang('Previous')",
                    }
                },
                "oAria": {
                    "sSortAscending": ": Activate to sort the column in ascending order",
                    "sSortDescending": ": Activate to sort the column in descending order"
                }
            })
        })(jQuery, jQuery.fn.dataTable);
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
            $(document).on('click', '.statuschange', function() {
                var id = ($(this).data("id"));
                var tabName = $(this).data("tabname");
                var _token = $(this).data("token");
                if ($("#status" + id).val() == '1') {
                    var status = 0;
                } else {
                    var status = 1;
                }

                $.ajax({
                    url: "{{ route('table.status.change') }}",
                    type: 'post',
                    data: {
                        'id': id,
                        'status': status,
                        'tablename': tabName,
                        '_token': _token
                    },
                    success: function(data) {
                        $('.notifyjs-corner').html('');
                        if (data == '1') {
                            $.notify("Active", {
                                globalPosition: 'top right',
                                className: 'success'
                            });
                        } else {
                            $.notify("Inactive", {
                                globalPosition: 'top right',
                                className: 'error'
                            });
                        }
                        $('#status' + id).val(status);
                    }
                });
            });
        });

        $('.daterangepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoUpdateInput: false,
                autoApply: true,
                locale: {
                    language: 'bn',
                    format: 'DD-MM-YYYY',
                    daysOfWeek: ["@lang('Sun')", "@lang('Mon')", "@lang('Tue')", "@lang('Wed')", "@lang('Thu')",
                        "@lang('Fri')", "@lang('Sat')"
                    ],
                    firstDay: 0
                },
                minDate: '01/01/1940',
            },
            function(start) {
                this.element.val(start.format('DD-MM-YYYY'));
                this.element.parent().parent().removeClass('has-error');
            },
            function(chosen_date) {
                this.element.val(chosen_date.format('DD-MM-YYYY'));
            });

        $('.daterangepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        })


        function similar(a, b) {
            var equivalency = 0;
            var minLength = (a.length > b.length) ? b.length : a.length;
            var maxLength = (a.length < b.length) ? b.length : a.length;
            for (var i = 0; i < minLength; i++) {
                if (a[i] == b[i]) {
                    equivalency++;
                }
            }
            var weight = equivalency / maxLength;
            return Math.round(weight * 100); // + "%";
        }
        /* ========================= */
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.validator.addMethod(
                "regex_en",
                function(value, element, regexp) {
                    var re = new RegExp("^[a-zA-Z0-9 ',\\.\\(\\)\\g]{1,4000}$");
                    return this.optional(element) || re.test(value);
                },
                "@lang('Write with English language')"
            );

            $.validator.addMethod(
                "regex_bn",
                function(value, element) {
                    var re = new RegExp("^[ঀ-৾ ',\\.\\(\\)\\g]{1,4000}$");
                    return this.optional(element) || re.test(value);
                },
                "@lang('Write with Bangla language')"
            );

            $.validator.addMethod(
                "regex_digit_lang",
                function(value, element) {
                    var lang = "{{session()->get('language')}}";
                    if(lang == 'bn'){
                        var regex_lang = '০-৯';
                    }else{
                        var regex_lang = '0-9';
                    }
                    var re = new RegExp("^["+regex_lang+" ',\\g]{1,4000}$");
                    return this.optional(element) || re.test(value);
                },
                "@lang('Write with English Digits')"
            );

            $.validator.addMethod(
                "validdob",
                function(value, element) {
                    var dob_split = value.split('/');
                    var day = parseInt(dob_split[0]);
                    var month = parseInt(dob_split[1]);
                    var year = parseInt(dob_split[2]);
                    var age = 25;

                    var mydate = new Date();
                    mydate.setFullYear(year, month - 1, day);

                    var currdate = new Date();
                    var setDate = new Date();

                    setDate.setFullYear(mydate.getFullYear() + age, month - 1, day);

                    if ((currdate - setDate) > 0) {
                        return true;
                    } else {
                        return false;
                    }
                },
                "Sorry, you must be 25 years of age to apply"
            );
        });
    </script>

    <script type="text/javascript">
        $(".pdf_link_data").click(function() {
            var file_open_input_field = $('.file_open_input_field').val();
            var fileurl = $('.fileurl').val();
            var file_url_type = $('.file_url_type').val();
            $(".url_link").val(file_open_input_field);
            $(".url_link_file").val(fileurl);
            $(".url_link_type").val(file_url_type);
            $('#myModal').modal('toggle');
        });
    </script>

    <script>
        var numbers = {
            '0': '০',
            '1': '১',
            '2': '২',
            '3': '৩',
            '4': '৪',
            '5': '৫',
            '6': '৬',
            '7': '৭',
            '8': '৮',
            '9': '৯'
        };

        function en2bnnumber(input) {
            var output = [];
            for (var i = 0; i < input.length; ++i) {
                if (numbers.hasOwnProperty(input[i])) {
                    output.push(numbers[input[i]]);
                } else {
                    output.push(input[i]);
                }
            }
            return output.join('');
        }

        function my_loader(type) {
            if (type == 'start') {
                $(".myloader").removeClass('d-none');
                $(".myloader").addClass('block');
            } else if (type == 'stop') {
                $(".myloader").removeClass('block');
                $(".myloader").addClass('d-none');
            }
        }
    </script>


    <script type="text/javascript">
        $(document).on('click', '.plusminuscollapse', function() {
            var hasclasss = $(this).hasClass('collapsed');
            if (hasclasss == true) {
                $(this).closest('h5').find('.plusminusbutton').removeClass('fa-minus').addClass('fa-plus');
                $('.plusminuscollapse').not(this).closest('h5').find('.plusminusbutton').removeClass('fa-minus')
                    .addClass('fa-plus');
            } else {
                $(this).closest('h5').find('.plusminusbutton').removeClass('fa-plus').addClass('fa-minus');
                $('.plusminuscollapse').not(this).closest('h5').find('.plusminusbutton').removeClass('fa-minus')
                    .addClass('fa-plus');
            }
        });

        function any_download_file(url) {
            const a = document.createElement('a')
            a.href = url
            a.download = url.split('/').pop()
            document.body.appendChild(a)
            a.click()
            document.body.removeChild(a)
        }
        /* reset form validation while typing/changing  */
        $(document).ready(function() {
            nanoResetFormControl();
            $(".readonly_date").keypress(function(e) {
                return false;
            });
            $(".readonly_date").keydown(function(e) {
                return false;
            });
        });

        function nanoResetFormControl() {
            $("input").change(function() {
                $(this).siblings('.text-danger, .invalid-feedback').empty();
                $(this).removeClass('is-invalid');
            });
            $("select").change(function() {
                $(this).siblings('.text-danger, .invalid-feedback').empty();
            });
            $("textarea").change(function() {
                $(this).siblings('.text-danger, .invalid-feedback').empty();
            });

            $(".file").change(function() {
                $(this).siblings('.text-danger, .invalid-feedback').empty();
            });

            $(".note-editor").on('change keyup paste', function() {
                $(this).siblings('.text-danger, .invalid-feedback').empty();
            });

            $(".datetimepicker-input").siblings('.input-group-append').on('click', function() {
                $(".datetimepicker-input").removeClass('is-invalid');
            });

        }

        /* =============================================== */
        @if(session()->get('language')=='bn')
            //for select2 in bangla
            var select2_language_object = {
                errorLoading:function(){
                    return"ফলাফলগুলি লোড করা যায়নি।"
                },
                inputTooLong:function(n){
                    var e=n.input.length-n.maximum;return 1!=e?"অনুগ্রহ করে "+e+" টি অক্ষর মুছে দিন।":"অনুগ্রহ করে "+e+" টি অক্ষর মুছে দিন।"
                },
                inputTooShort:function(n){
                    return n.minimum-n.input.length+" টি অক্ষর অথবা অধিক অক্ষর লিখুন।"
                },
                loadingMore:function(){
                    return"আরো ফলাফল লোড হচ্ছে ..."
                },
                maximumSelected:function(n){
                    var e=n.maximum+" টি আইটেম নির্বাচন করতে পারবেন।";
                    return 1!=n.maximum&&(e=n.maximum+" টি আইটেম নির্বাচন করতে পারবেন।"),e
                },
                noResults:function(){
                    return"কোন ফলাফল পাওয়া যায়নি।"
                },
                searching:function(){
                    return"অনুসন্ধান করা হচ্ছে ..."
                }
            };

            $.fn.select2.defaults.set('language', select2_language_object);
        @endif
        
        /* for language translation in javascript */
        
        String.prototype.replaceArray = function (find, replace) {
            var replaceString = this;
            for (var i = 0; i < find.length; i++) {
                // global replacement
                var pos = replaceString.indexOf(find[i]);
                while (pos > -1) {
                    replaceString = replaceString.replace(find[i], replace[i]);
                    pos = replaceString.indexOf(find[i]);
                }
            }
            return replaceString;
        };

        function nanoLangTranslate(number,type=null){
            var en = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "AM", "PM", "am", "pm", "cusec", "litre", "horse", "Jan", "Feb", "Mar", "Apr", "May", "Jun", 'Jul', "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", 'July', "August", "September", "October", "November", "December", "Saturday", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Weekend", "day", "week", "month", "year"];
            var bn = ["১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "এ.এম", "পি.এম", "এ.এম", "পি.এম", "কিউসেক", "লিটার/সে.", "অশ্বশক্তি", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", "শনিবার", "রবিবার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "সাপ্তাহিক ছুটি", "দিন", "সপ্তাহ", "মাস", "বছর"];

            if(type!=null){
                if(type=='bn'){
                    return number.replaceArray(en,bn);
                }
                else{
                    return number.replaceArray(bn,en);
                }
            }
            else{
                @php if (Session::get('language') == 'bn') { @endphp
                return number.replaceArray(en,bn);
            @php } else { @endphp
                return number.replaceArray(bn,en);
            @php } @endphp
            }
        }

        function capitalize(str) {
            strVal = '';
            str = str.split(' ');
            for (var chr = 0; chr < str.length; chr++) {
                strVal += str[chr].substring(0, 1).toUpperCase() + str[chr].substring(1, str[chr].length) + ' '
            }
            return strVal
        }

        // console.log(nanoLangTranslate('2021-09-20'));
        /*=================*/
        $(function () {
            $.fn.datepicker.dates['bn'] = {
                days: ["রবি", "সোম", "মঙ্গল", "বুধ", "বৃহঃ", "শুক্র", "শনি"],
                daysShort: ["রবি", "সোম", "মঙ্গল", "বুধ", "বৃহঃ", "শুক্র", "শনি"],
                daysMin: ["রবি", "সোম", "মঙ্গল", "বুধ", "বৃহঃ", "শুক্র", "শনি"],
                months: ["জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "অগাস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর"],
                monthsShort: ["জানু", "ফেব্রু", "মার্চ", "এপ্রি", "মে", "জুন", "জুলা", "অগা", "সেপ্টে", "অক্টো", "নভে", "ডিসে"],
                numbers: {
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
                },
                today: "আজ",
                clear: "Clear",
                format: "dd-mm-yyyy",
                titleFormat: "MM yyyy", 
                weekStart: 0
            };

            $(".datepicker_box").datepicker({
                language:'bn',
                autoclose:true,
                orientation:'auto',
                autoUpdateInput: false,
                beforeShow: function (input, inst) {
                    setTimeout(function () {
                        inst.dpDiv.css({
                            top: $(".datepicker_box").offset().top + 35,
                            left: $(".datepicker_box").offset().left
                        });
                    }, 0);
                }
            })
        });
        
        function toggleDatePicker(pickerID){
            $('#'+pickerID).on('apply.daterangepicker', function(ev, picker) {
                $('#'+pickerID).val(nanoLangTranslate($("#"+pickerID).val()));
            });
        }

        /* ================== */

         /* common daterange objects */

         var daterange_locale = {
                "applyLabel": '@lang("Apply")',
                "cancelLabel": '@lang("Cancel")',
                "fromLabel": '@lang("From")',
                "toLabel": '@lang("To")',
                "customRangeLabel": '@lang("Custom")',
                language: 'bn',
                format: 'DD-MM-YYYY',
                monthNames: ["@lang('January')", "@lang('February')", "@lang('March')", "@lang('April')", "@lang('May')", "@lang('June')", "@lang('July')", "@lang('August')", "@lang('September')", "@lang('October')", "@lang('November')", "@lang('December')"],
                daysOfWeek: ["@lang('Sun')", "@lang('Mon')", "@lang('Tue')", "@lang('Wed')", "@lang('Thu')",
                    "@lang('Fri')", "@lang('Sat')"
                ],
                firstDay: 0
            };
            var daterange_ranges = {
                '@lang("Today")': [moment(), moment()],
                '@lang("Yesterday")': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '@lang("Last 7 Days")': [moment().subtract(6, 'days'), moment()],
                '@lang("Last 30 Days")': [moment().subtract(29, 'days'), moment()],
                '@lang("This Month")': [moment().startOf('month'), moment().endOf('month')],
                '@lang("Last Month")': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            };
    </script>

<script>
    // onclick="resetForm(event, $(this));"
    function resetForm(e, thisobj) {
        thisform = thisobj.closest('form');
        selectbox_in_form = thisform.find('select');

        // completely remove selected when it has been assigned.
        selectbox_in_form.find('option:selected').removeAttr('selected');
        selectbox_in_form.val('');
        selectbox_in_form.change();

        delete selectbox_in_form;
        delete thisform;
    }

    var _showFileName = function(field_id,label_id){
        $('#'+field_id).change(function(){
            var pathwithfilename = $('#'+field_id).val();
            var filename = pathwithfilename.substring(12);
            $('#'+label_id).html(filename).css({
                'display':'inline-block'
            });
        });
    };
</script>
    @yield('script')

    @stack('page_scripts')
    @include('backend.layouts.notification')

</body>

</html>
