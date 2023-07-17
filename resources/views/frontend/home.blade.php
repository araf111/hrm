
@extends('frontend.layouts.index') 
@section('content')
<link rel="stylesheet" href="{{ asset('public/backend/css/fullcalendar.min.css') }}">
<script src="{{ asset('public/backend/js/fullcalendar.min.js') }}"></script>
<style>
    .fc-toolbar-title{
        display:inline;
        padding:15px;
    }
    .fc-toolbar-chunk>.fc-button-group{
        display: none !important;
    }
    .fc-scrollgrid-sync-table>tobdy>tr>td{
        min-height: 30px !important;
        max-height: 30px !important;
        overflow:hidden;
    }
    .fc .fc-toolbar.fc-header-toolbar {
        margin-bottom: 0.5em;
        background: #91278e;
        color: #fff;
        padding: 5px;
    }
    .fc-event-container{
        display:none;
    }
    .highlight{
        background-color:red;
    }
    .fc .fc-daygrid-day-top {
        display: inherit;
        flex-direction: row-reverse;
        /* height: 21px; */
        text-align: center;
        vertical-align: middle;
        position: absolute;
        right: 0;
        left: 0;
        bottom: 25px;
    }
    .fc .fc-daygrid-body-unbalanced .fc-daygrid-day-events {
        position: absolute;
        min-height: auto;
        width: 100%;
    }
    .fc-h-event .fc-event-title-container {
        flex-grow: 1;
        flex-shrink: 1;
        min-width: 0;
        height: 60px;
    }
    .fc-daygrid-event {
        position: initial;
        white-space: nowrap;
        margin-top: 0px !important;
        min-height: 67px;
        font-size: .85em;
        font-size: var(--fc-small-font-size,.85em);
    }
    .fc-daygrid-event-harness a{
        /* background:#91278e !important; */
        border: none;
        border-radius: 0;
        cursor: pointer;
    }
    .fc .fc-daygrid-day-frame {
        position: relative;
        min-height: 67px;
    }
</style>
<!-- HEADER -->
@include('frontend.layouts.header')

<!-- NEWS -->
@include('frontend.components.news_ticker')

<!-- SLIDER -->
@include('frontend.components.slider')

<!-- ABOUT SECTION -->
@include('frontend.components.about_section')

<!-- PRIME MINISTER SPEAKER MESSAGE -->
@include('frontend.components.mp_message')

<!-- COUNTER -->
@include('frontend.components.number_counter')

<!-- PROJECT -->
@include('frontend.components.project')

<!-- MP QUESTION -->
@include('frontend.components.mp_question')

<!-- CITIZEN QUESTION -->
@include('frontend.components.citizen_question')

<section id="orderofday_notice">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-lg-8 mb-4">
                <h3 class="title">@lang('Order Of The Day')</h3>
                <div id="OOD_holder" class="text-center">
                    <img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">
                </div>
                <div class="orderofday" id="orderOfDay_container">
                    <div id='OrderCalendar'></div>
                </div>
                {{-- <h3 class="title">@lang('Order Of The Day')</h3>
                <div id="OOD_holder">
                    <img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">
                </div>
                <div class="orderofday" id="orderOfDay_container">
                    <input id="daterangepicker" type="hidden">
                    <div id="daterangepicker-container" class="embedded-daterangepicker"></div>
                    
                </div> --}}
                
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 mb-4">
                <h3 class="title">@lang('Parliament Notice')</h3>

                @include('frontend.components.notice_vertical_menu')

            </div>
        </div>
    </div>
</section>

<!-- VIDEO GALLERY -->
@include('frontend.components.video_gallery')

<!-- MOBILE APPS -->
@include('frontend.components.mobile_apps')

<!-- LATEST NEWS -->
@include('frontend.components.latest_news')

<!-- START FOOTER -->
@include('frontend.layouts.footer')

@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function() {	
        load_order_of_day();
        /* var picker = $('#daterangepicker').daterangepicker({
            "parentEl": "#daterangepicker-container",
            //"minDate":'{{date("d-m-Y")}}',
            "autoApply": true,
            "singleDatePicker": true,
            "locale": daterange_locale,
        });
        // range update listener
        picker.on('apply.daterangepicker', function(ev, picker) {
            $("#daterangepicker-result").html('Selected date range: ' + picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        });
        // prevent hide after range selection
        picker.data('daterangepicker').hide = function () {};
        // show picker on load
        picker.data('daterangepicker').show(); */
    });

    function load_order_of_day() {
        $("#orderOfDay_container").hide();
        $("#OOD_holder").show();
        $.ajax({
            url: "{{ url('/home/orderofday') }}",
            type: "GET",
            success: function(response) {
                //console.log(response);
                response = JSON.parse(response);
                $("#orderOfDay_container").show();
                $("#OOD_holder").hide();
                initializeCalendar(response.data.order_list);
            },
            error: function(res) {
                $("#orderOfDay_container").show();
                $("#OOD_holder").hide();
            }

        });
    }

    function initializeCalendar(eventsData = null) {
              var calendarEl = document.getElementById('OrderCalendar');
              //console.log(eventsData);
              @php if(session()->get('language')=='bn'){ @endphp
              const esLocale = {
                    code: "bn",
                    week: {
                    dow: 0, // Sunday is the first day of the week.
                    doy: 6, // The week that contains Jan 1st is the first week of the year.
                    },
                    buttonText: {
                    prev: "পেছনে",
                    next: "পরবর্তী",
                    today: "আজ",
                    month: "মাস",
                    week: "সপ্তাহ",
                    day: "দিন",
                    list: "লিষ্ট",
                    },
                    weekText: "সপ্তাহ",
                    allDayText: "সারাদিন",
                    moreLinkText: "আরো...",
                    noEventsText: "কোন ইভেন্ট নাই",
                }
                @php }else{ @endphp
                    const esLocale = {
                    code: "en",
                    week: {
                    dow: 0, // Sunday is the first day of the week.
                    doy: 6, // The week that contains Jan 1st is the first week of the year.
                    },
                    buttonText: {
                    prev: "Prev",
                    next: "Next",
                    today: "Today",
                    month: "Month",
                    week: "Week",
                    day: "Day",
                    list: "List",
                    },
                    weekText: "Week",
                    allDayText: "Whole Day",
                    moreLinkText: "More...",
                    noEventsText: "No Event Available",
                }
                @php } @endphp
              
              var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: esLocale,
                      initialView: 'dayGridMonth',
                      initialDate: '{{date("Y-m-01")}}',
                      headerToolbar: {
                         left: 'today',
                          center: 'prev,title,next',
                          right: 'dayGridMonth,timeGridWeek,timeGridDay'
                      },
                      events: eventsData,

                      eventClick: function(info) {
                            event_download_link(info);
                            info.jsEvent.preventDefault(); 
                      },

                      eventClassNames: 'orderDates',

                      dateClick: function(info) {
                        //alert('Date: ' + info.dateStr);
                        //alert('Resource ID: ' + info.title);                        
                    },

                      height: 500,
                      header: {
                          left: 'title',
                          center: '',
                          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek prevYear,prev,next,nextYear'
                      }
                  }

              );
              calendar.render();
          }

          document.addEventListener('DOMContentLoaded', function() {
              //initializeCalendar([]);
              $(".fc-event-title").html(' ');
          });
          
          $(document).ready(function(){
              setTimeout(function(){
                //$(".fc-event-title").html('<i class="fa fa-file-pdf"></i>');
                $(".fc-event-title").html(' ');
              },2000)
          });

        function event_download_link(url) {
            $("#orderOfDay_container").hide();
            $("#OOD_holder").show();
            const a = document.createElement('a')
            a.href = url.event.extendedProps.doc_link
            a.download = url.event.extendedProps.doc_link.split('/').pop()
            document.body.appendChild(a)
            a.click()
            document.body.removeChild(a)
            $("#orderOfDay_container").show();
            $("#OOD_holder").hide();
        }

</script>
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderContainer">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection