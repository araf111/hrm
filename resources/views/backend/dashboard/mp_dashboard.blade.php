      <style>
          .donut_box {
              padding: 5px !important;
          }

          #calendar {
              max-width: 1100px;
              margin: 40px auto;
          }

          .fc-toolbar-title {
              display: inline;
              padding: 15px;
          }

          @media (max-width: 768px) {
              .carousel-inner .carousel-item>div {
                  display: none;
              }

              .carousel-inner .carousel-item>div:first-child {
                  display: block;
              }
          }

          .carousel-inner .carousel-item.active,
          .carousel-inner .carousel-item-next,
          .carousel-inner .carousel-item-prev {
              display: flex;
          }

          /* display 3 */
          @media (min-width: 768px) {

              .carousel-inner .carousel-item-right.active,
              .carousel-inner .carousel-item-next {
                  transform: translateX(33.333%);
              }

              .carousel-inner .carousel-item-left.active,
              .carousel-inner .carousel-item-prev {
                  transform: translateX(-33.333%);
              }
          }

          .carousel-inner .carousel-item-right,
          .carousel-inner .carousel-item-left {
              transform: translateX(0);
          }
      </style>

      <link rel="stylesheet" href="{{ asset('public/backend/css/fullcalendar.min.css') }}">
      <script src="{{ asset('public/backend/js/fullcalendar.min.js') }}"></script>
      <div class="container-fluid">
          <ul class="nav nav-tabs">
              <li class="nav-item">
                  <a class="nav-link active" id="my_activity_tab" data-toggle="tab" href="#my_activity" onclick="load_dashboard_data(1)">@lang('My Activities')</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="my_and_parliament_tab" data-toggle="tab" href="#my_and_parliament_activity" onclick="load_dashboard_data()">
                      @lang('My & Parliament Activity')
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" id="parliament_tab" data-toggle="tab" href="#parliament_activity">@lang('Parliament Activity')</a>
              </li>
          </ul>
          <div class="tab-content">

              <div class="tab-pane container active" id="my_activity">
                  <div class="row">
                      <div class="col-12" id="orderofday_notice" style="margin-bottom: 20px;">
                          <div id='calendar'></div>

                      </div>
                      <!-- /.card -->
                      <div class="row" style="padding-left: 7px; padding-right: 7px; margin-bottom:20px; width: 100%;">
                          <div class="col-4">
                              <div class="card card-warning">
                                  <div class="card-header">
                                      <h3 class="card-title">সাক্ষাত গ্রহন</h3>
                                      <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                              <i class="fas fa-minus"></i>
                                          </button>
                                      </div>
                                  </div>
                                  <div class="card-body donut_box">
                                      <div class="dashboard_canvas">
                                          <table class="table table-sm table-bordered table-striped mb-4">
                                              <thead>
                                                  <tr>
                                                      <th>@lang('Serial')</th>
                                                      <th>@lang('Date')</th>
                                                      <th>@lang('Appointment With')</th>
                                                      <th>@lang('Appointment Time')</th>
                                                      <th>@lang('Given Time')- @lang('Place')</th>
                                                      <th>@lang('Status')</th>
                                                  </tr>
                                              </thead>
                                              <tbody class="sortable" id="appointment_request">

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="card card-warning">
                                  <div class="card-header">
                                      <h3 class="card-title">সাক্ষাত প্রদান</h3>

                                      <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                              <i class="fas fa-minus"></i>
                                          </button>

                                      </div>
                                  </div>
                                  <div class="card-body donut_box">
                                      <div class="dashboard_canvas">
                                          <table class="table table-sm table-bordered table-striped mb-4">
                                              <thead>
                                                  <tr>
                                                      <th>@lang('Serial')</th>
                                                      <th>@lang('Date')</th>
                                                      <th>@lang('Appointment With')</th>
                                                      <th>@lang('Appointment Time')</th>
                                                      <th>@lang('Given Time')- @lang('Place')</th>
                                                      <th>@lang('Status')</th>
                                                  </tr>
                                              </thead>
                                              <tbody class="sortable" id="appointment_received">

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="card card-warning">
                                  <div class="card-header">
                                      <h3 class="card-title">কমিটি সভা সময়সূচী</h3>
                                  </div>
                                  <div class="card-body donut_box">
                                      <div class="dashboard_canvas">
                                          <table class="table table-sm table-bordered table-striped mb-4">
                                              <thead>
                                                  <tr>
                                                      <th>@lang('Serial')</th>
                                                      <th>@lang('Date')</th>
                                                      <th>@lang('Committee Name')</th>
                                                      <th>@lang('Starting Time') - @lang('Ending Time')</th>
                                                      <th>@lang('Room Name')</th>
                                                  </tr>
                                              </thead>
                                              <tbody class="sortable" id="meeting_list">

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                          </div>
                      </div>
                      <div class="row" class="row" style="padding-left: 7px; padding-right: 7px; margin-bottom:20px; width: 100%;">                      
                              <div class="col-4">
                                  <select name="pole_id" id="pole_id" readonly class="form-control select2" style="width:100%">
                                      <option value="">@lang('Select Pole')</option>
                                      @foreach ($pole_list as $p)
                                      <option value="{{ $p->id }}">{{ $p->name }}
                                      </option>
                                      @endforeach
                                  </select>
                              </div>

                              <div class="col-2">
                                  <button type="button" class="btn btn-info" onClick="getPoleData()">@lang('Load Question')</button>
                              </div>
                          
                      </div>
                      <div class="row" class="row" style="padding-left: 7px; padding-right: 7px; margin-bottom:20px; width: 100%;">   
                      <div class="col-6">
                          <div id="pole_content">

                          </div>
                      </div>                   
                      <div class="col-6">
                          Other content
                      </div>                   
                      </div>
                  </div>

              </div>
              <div class="tab-pane container" id="my_and_parliament_activity">
                  <div class="row">
                      <!-- /.col -->
                      <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-newspaper"></i></span>

                              <div class="info-box-content">
                                  <span class="info-box-text">@lang('Orders of Day')</span>
                                  <span class="info-box-number" id="order_of_days_holder"></span>
                              </div>
                              <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                      </div>
                      <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-universal-access"></i></span>

                              <div class="info-box-content">
                                  <span class="info-box-text">@lang('Circulars')</span>
                                  {{-- <span class="info-box-number" id="circular_holder"><a href="javascript:void(0);"
                                onClick="generate_pdf()">@lang('Download')</a></span> --}}
                                  <span class="info-box-number"><a href="javascript:void(0)" onclick="any_download_file('{{ asset('public/backend/attachment/108-17-06-2021.pdf') }}')">@lang('Download')</a></span>
                              </div>
                              <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                      </div>
                      <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clock"></i></span>

                              <div class="info-box-content">
                                  <span class="info-box-text"><a href="{{ url('/admin/attendance/mp-attendance') }}">
                                          @lang('MP Attendance')</a></span>
                                  <span class="info-box-number" id="attendance_holder"> </span>
                              </div>
                              <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                      </div>
                      <!-- /.col -->

                      <!-- fix for small devices only -->
                      {{-- <div class="clearfix hidden-md-up"></div> --}}

                      <div class="col-12 col-sm-6 col-md-3">
                          <div class="info-box mb-3">
                              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-mug-hot"></i></span>

                              <div class="info-box-content">
                                  <span class="info-box-text"><a href="{{ url('/profile-activities/mp-leave/leave-application') }}">
                                          @lang('Leave Application') </a></span>
                                  <span class="info-box-number" id="leave_holder"> </span>
                              </div>
                              <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <!-- /.col -->
                      <!-- BAR CHART -->
                      <div class="col-12">
                          <div class="card card-success">
                              <div class="card-header">
                                  <h3 class="card-title">@lang('Summary of Total Submitted Notices')</h3>

                                  <div class="card-tools">
                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                          <i class="fas fa-minus"></i>
                                      </button>
                                  </div>
                              </div>
                              <div class="card-body">
                                  <div class="chart" id="barChart_holder">
                                      <canvas id="barChart" class="dashboard_canvas"></canvas>
                                  </div>
                              </div>
                              <!-- /.card-body -->
                          </div>
                      </div>
                      <div id="demo" class="carousel slide" data-interval="false">

                          <!-- The slideshow -->
                          <div class="carousel-inner">
                              <div class="carousel-item active">
                                  <div class="row" style="padding-left: 7px; padding-right: 7px;">
                                      @foreach ($allRules[0] as $r)
                                      <div class="col-4">
                                          <div class="card card-warning">
                                              <div class="card-header">
                                                  <h3 class="card-title">{{ $r->rule_name }} </h3>
                                                  <div class="card-tools">
                                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                          <i class="fas fa-minus"></i>
                                                      </button>

                                                  </div>
                                              </div>
                                              <div class="card-body donut_box">
                                                  <canvas id="donutChart_{{ $r->rule_number }}" class="dashboard_canvas"></canvas>
                                              </div>
                                              <!-- /.card-body -->
                                          </div>
                                      </div>
                                      @endforeach
                                  </div>

                              </div>
                              @if (count($allRules) > 1)
                              @for ($i = 1; $i < count($allRules); $i++) <div class="carousel-item">
                                  <div class="row" style="padding-left: 7px; padding-right: 7px;">
                                      @foreach ($allRules[$i] as $r)
                                      <div class="col-4">
                                          <div class="card card-warning">
                                              <div class="card-header">
                                                  <h3 class="card-title">{{ $r->rule_name }} </h3>
                                                  <div class="card-tools">
                                                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                          <i class="fas fa-minus"></i>
                                                      </button>

                                                  </div>
                                              </div>
                                              <div class="card-body donut_box">
                                                  <canvas id="donutChart_{{ $r->rule_number }}" class="dashboard_canvas"></canvas>
                                              </div>
                                              <!-- /.card-body -->
                                          </div>
                                      </div>
                                      @endforeach
                                  </div>

                          </div>
                          @endfor
                          @endif

                      </div>

                      <!-- Left and right controls -->
                      <a class="carousel-control-prev" href="#demo" data-slide="prev">
                          <span class="carousel-control-prev-icon"></span>
                      </a>
                      <a class="carousel-control-next" href="#demo" data-slide="next">
                          <span class="carousel-control-next-icon"></span>
                      </a>
                  </div>

                  <div class="row">
                      <!-- /.card -->
                      <div class="row" style="padding-left: 7px; padding-right: 7px; margin-bottom:20px;">
                          <div class="col-4">
                              <div class="card card-warning">
                                  <div class="card-header">
                                      <h3 class="card-title">ছুটির আবেদন</h3>
                                      <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                              <i class="fas fa-minus"></i>
                                          </button>
                                      </div>
                                  </div>
                                  <div class="card-body donut_box">
                                      <div id="mp_leave_list_holder" class="dashboard_canvas">

                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="card card-warning">
                                  <div class="card-header">
                                      <h3 class="card-title">সাক্ষাত সময়সূচী</h3>

                                      <div class="card-tools">
                                          <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                              <i class="fas fa-minus"></i>
                                          </button>

                                      </div>
                                  </div>
                                  <div class="card-body donut_box">
                                      <div id="mp_appointment_list_holder" class="dashboard_canvas">

                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                          </div>
                          <div class="col-4">
                              <div class="card card-warning">
                                  <div class="card-header">
                                      <h3 class="card-title">কমিটি সভা সময়সূচী</h3>
                                  </div>
                                  <div class="card-body donut_box">
                                      <div id="" class="dashboard_canvas">
                                          <table class="table table-sm table-bordered table-striped mb-4">
                                              <thead>
                                                  <tr>
                                                      <th>@lang('Name')</th>
                                                      <th>@lang('From')</th>
                                                      <th>@lang('To')</th>
                                                  </tr>
                                              </thead>
                                              <tbody class="sortable">
                                                  <tr>
                                                      <td>প্রধান মন্ত্রীর দাওয়াত</td>
                                                      <td>২৭ জুন ২০২১</td>
                                                      <td>২৮ জুন ২০২১</td>
                                                  </tr>
                                                  <tr>
                                                      <td>ঈদ পূনর্মিলনী</td>
                                                      <td>২৭ জুন ২০২১</td>
                                                      <td>২৮ জুন ২০২১</td>
                                                  </tr>
                                                  <tr>
                                                      <td>সাধারন আড্ডা</td>
                                                      <td>২৭ জুন ২০২১</td>
                                                      <td>২৮ জুন ২০২১</td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                              </div>
                          </div>

                      </div>
                  </div>

              </div>
          </div>
      </div>

      </div>
      <script src="{{ asset('public/backend') }}/plugins/chart.js/Chart.min.js"></script>
      <script>
          $(function() {
              load_dashboard_data(1);

          });

          function load_dashboard_data(type = null) {
              if (type != null && type == 1) {
                  console.log('my and parliament act.');
                  //mp_and_parliament
                  //$("#appointment_request").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
                  //$("#appointment_received").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
                  //$("#meeting_list").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
                  var session_id = $("#parliament_session_id").val();
                  var url = "{{ url('/dashboard_summary') }}/" + session_id + "/my_activity";
                  //var _token = "{{ csrf_token() }}";
                  $.ajax({
                      url: url,
                      type: "GET",
                      success: function(response) {
                          response = JSON.parse(response);
                          console.log(response);
                          $("#appointment_request").html(response.data.appointment_request_data);
                          $("#appointment_received").html(response.data.appointment_received_data);
                          $("#meeting_list").html(response.data.meeting_list);
                          //$('#calendar').fullCalendar( 'destroy' );
                          initializeCalendar(response.data.calendar_meeting_list);
                          //getPoleData();
                      }
                  });
              } else {
                  $("#order_of_days_holder").html(
                      '<img class="spinner_loader" src="{{ asset('public / images / lottery.gif ') }}">');
                  $("#attendance_holder").html(
                      '<img class="spinner_loader" src="{{ asset('public / images / lottery.gif ') }}">');
                  $("#leave_holder").html('<img class="spinner_loader" src="{{ asset('public / images / lottery.gif ') }}">');
                  $("#mp_leave_list_holder").html(
                      '<img class="spinner_loader" src="{{ asset('public / images / lottery.gif ') }}">');
                  $("#mp_appointment_list_holder").html(
                      '<img class="spinner_loader" src="{{ asset('public / images / lottery.gif ') }}">');
                  var session_id = $("#parliament_session_id").val();
                  var url = "{{ url('/dashboard_summary') }}/" + session_id + "/summary";
                  //var _token = "{{ csrf_token() }}";
                  $.ajax({
                      url: url,
                      type: "GET",
                      success: function(response) {
                          response = JSON.parse(response);
                          console.log(response);
                          $("#order_of_days_holder").html(response.data.order_of_days);
                          $("#attendance_holder").html(response.data.total_attendance);
                          $("#leave_holder").html(response.data.total_leave);
                          var submitted_notice_rules = [];
                          var submitted_notice_data = [];
                          for (var i = 0; i < response.data.notice_bar_chart.length; i++) {
                              submitted_notice_rules.push(response.data.notice_bar_chart[i].rule_number);
                              submitted_notice_data.push(response.data.notice_bar_chart[i].total_notices);
                          }
                          var noticeGraphData = {
                              labels: submitted_notice_rules,
                              datasets: [{
                                  label: '@lang("Total")',
                                  backgroundColor: 'rgba(60,141,188,0.4)',
                                  borderColor: 'rgba(60,141,188,0.8)',
                                  borderWidth: 1,
                                  pointRadius: false,
                                  pointColor: '#3b8bba',
                                  pointStrokeColor: 'rgba(60,141,188,1)',
                                  pointHighlightFill: '#fff',
                                  pointHighlightStroke: 'rgba(60,141,188,1)',
                                  data: submitted_notice_data
                              }]
                          }
                          var barChartCanvas = $('#barChart').get(0).getContext('2d')
                          var barChartData = $.extend(true, {}, noticeGraphData)
                          var temp0 = noticeGraphData.datasets[0]
                          barChartData.datasets[0] = temp0
                          console.log(submitted_notice_data);
                          var barChartOptions = {
                              responsive: true,
                              maintainAspectRatio: false,
                              datasetFill: false,
                              locale: 'test'
                          }

                          var graph_for_notice = new Chart(barChartCanvas, {
                              type: 'bar',
                              data: barChartData,
                              options: barChartOptions
                          });

                          //console.log(response.data.notice_donut_chart);
                          for (var key of Object.keys(response.data.notice_donut_chart)) {
                              var status_data = [];
                              var status_label = [];
                              var status_colors = [];
                              for (var x = 0; x < response.data.notice_donut_chart[key].length; x++) {
                                  status_data.push(response.data.notice_donut_chart[key][x].total_notices);
                                  status_label.push(response.data.notice_donut_chart[key][x].status_data
                                      .status_name);
                                  status_colors.push(response.data.notice_donut_chart[key][x].status_data
                                      .status_color);
                              }
                              var donutChartCanvas = 'canvas_' + key;
                              var donutData = 'donutData_' + key;
                              donutChartCanvas = (getContext() != undefined) ? $('#donutChart_' + key).get(0).getContext('2d') : '';
                              var donutData = {
                                  labels: status_label,
                                  datasets: [{
                                      data: status_data,
                                      backgroundColor: status_colors,
                                  }]
                              }
                              var donutOptions = {
                                  maintainAspectRatio: false,
                                  responsive: true,
                              }
                              //Create pie or douhnut chart
                              // You can switch between pie and douhnut using the method below.
                              new Chart(donutChartCanvas, {
                                  type: 'doughnut',
                                  data: donutData,
                                  options: donutOptions
                              })
                          }

                          //mp leave appliation list
                          $("#mp_leave_list_holder").html(response.data.mp_leaves);
                          $("#mp_appointment_list_holder").html(response.data.mp_appointments);

                      }
                  });
              }

          }

          function generate_pdf() {
              $("#circular_holder").html('');
              $("#circular_holder").html('<img class="spinner_loader" src="{{ asset('public / images / lottery.gif ') }}">');
              var session_id = $("#parliament_session_id").val();
              $.ajax({
                  type: "GET",
                  crossDomain: true,
                  url: "{{ url('/dashboard_pdf') }}/" + session_id + "/poripotro",
                  contentType: "application/json",
                  success: function(data) {
                      const linkSource = data;
                      const downloadLink = document.createElement("a");
                      const fileName = "poripotro_" + Date() + ".pdf";
                      downloadLink.href = linkSource;
                      downloadLink.download = fileName;
                      downloadLink.click();
                      $("#circular_holder").html(
                          '<a href="javascript:void(0);" onClick="generate_pdf()">{{ Lang::get('Download ') }}</a>'
                      );
                  },
                  error: function(res) {
                      $("#circular_holder").html(
                          '<a href="javascript:void(0);" onClick="generate_pdf()">{{ Lang::get('Download ') }}</a>'
                      );
                  }

              });
          }

          $(document).ready(function() {
              // The Calender
              $('#mp_calendar').datepicker({
                  inline: true,
              })
              //initializeCalendar([]);
          });

          /*  for calendar module */

          function initializeCalendar(eventsData = null) {
              var calendarEl = document.getElementById('calendar');
              //console.log(eventsData);
              @php
              if (session()-> get('language') == 'bn') {
                  @endphp
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
                  @php
              } else {
                  @endphp
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
                  @php
              }
              @endphp
              /* eventsData = [{
                            title: 'All Day Event',
                            start: '2021-07-01',
                            details:'<h3>Hello world...</h3><p>I am just testing my event...</p>'
                        },
                        {
                            title: 'Long Event',
                            start: '2021-07-07',
                            end: '2021-07-10',
                            details:'<h3>Hello world...</h3><p>I am just testing my event...</p>'
                        },
                        {
                            groupId: '999',
                            title: 'Repeating Event',
                            start: '2021-07-09T16:00:00',
                            details:'<h3>Hello world...</h3><p>I am just testing my event...</p>'
                        },
                        {
                            groupId: '999',
                            title: 'Repeating Event',
                            start: '2021-07-16T16:00:00',
                            details:'<h3>Hello world...</h3><p>I am just testing my event...</p>'
                        },
                        {
                            title: 'Conference',
                            start: '2021-07-11',
                            end: '2021-07-13',
                            details:'<h3>Hello world...</h3><p>I am just testing my event...</p>'
                        }
                    ]; */
              var calendar = new FullCalendar.Calendar(calendarEl, {
                      locale: esLocale,
                      initialView: 'dayGridMonth',
                      initialDate: '{{date("Y-m-01")}}',
                      headerToolbar: {
                          left: 'today',
                          center: 'prev,title,next',
                          right: 'dayGridMonth,timeGridWeek,timeGridDay'
                      },

                      /* headerToolbar:{
                          today: 'আজ',
                          month: 'month',
                          week: 'week',
                          day: 'day',
                          list: 'list',
                      }, */
                      events: eventsData,

                      eventClick: function(info) {
                          console.log(info.event);
                          $("#eventModalLabel").html(info.event.title);
                          if (info.event.extendedProps.room_name != undefined) {
                              $("#eventContainer").html(
                                  '<table class="table table-striped">' +
                                  '<tr><td>@lang("Date")</td><td>:</td><td>' + info.event.extendedProps.date_meeting +
                                  '</td></tr>' +
                                  '<tr><td>@lang("Committee")</td><td>:</td><td>' + info.event.extendedProps
                                  .committee_name + '</td></tr>' +
                                  '<tr><td>@lang("Time")</td><td>:</td><td>' + nanoLangTranslate(info.event.extendedProps.time_starting) +
                                  ' - ' + nanoLangTranslate(info.event.extendedProps.time_ending) + '</td></tr>' +
                                  '<tr><td>@lang("Room")</td><td>:</td><td>' + info.event.extendedProps.room_name +
                                  '</td></tr>' +
                                  '</table>'
                              );
                          } else {
                              $("#eventContainer").html(
                                  '<table class="table table-striped">' +
                                  '<tr><td>@lang("Date")</td><td>:</td><td>' + info.event.extendedProps.date_calendar +
                                  '</td></tr>' +
                                  '<tr><td>@lang("Person")</td><td>:</td><td>' + info.event.title +
                                  '</td></tr>' +
                                  '<tr><td>@lang("Time")</td><td>:</td><td>' + nanoLangTranslate(info.event.extendedProps.time_from) + ' - ' +
                                  nanoLangTranslate(info.event.extendedProps.time_to) + '</td></tr>' +
                                  '<tr><td>@lang("Place")</td><td>:</td><td>' + info.event.extendedProps.topics +
                                  '</td></tr>' +
                                  '</table>'
                              );
                          }

                          $("#eventModal").modal('show');
                          info.jsEvent.preventDefault(); // don't let the browser navigate
                      },

                      height: 650,
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

          });

          function getPoleData(id = 0) {
              var id = $("#pole_id").val();
              var url = "{{ url('/getpoles') }}/" + id;
              $.ajax({
                  url: url,
                  type: "GET",
                  success: function(response) {
                      $("#pole_content").html(response);
                  }
              });
          }
      </script>

      <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="eventModalLabel"> </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body" id="eventContainer">

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                      {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                  </div>
              </div>
          </div>
      </div>