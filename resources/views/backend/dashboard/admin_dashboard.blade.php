      <style>
          .donut_box {
              padding: 5px !important;
          }

      </style>
      <div class="container-fluid">
          <div class="row">
              {{-- @foreach ($active_users as $activity)
                {{$activity->user->name}};
            @endforeach --}}
              <!-- /.col -->
              <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                      <span class="info-box-icon bg-danger elevation-1"> <i class="fa fa-newspaper" aria-hidden="true"></i>
                         <i class="fas fa-newspaper-o"></i></span>

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
                          <span class="info-box-number" ><a href="javascript:void(0)" onclick="any_download_file('{{ asset('public/backend/attachment/108-17-06-2021.pdf')}}')">@lang('Download')</a></span>
                                  
                      </div>
                      <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
              </div>
              <div class="col-12 col-sm-6 col-md-3">
                  <div class="info-box mb-3">
                      <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-clock"></i></span>

                      <div class="info-box-content">
                        <span class="info-box-text"><a href="{{url('/admin/attendance/mp-attendance')}}">@lang('MP Attendance') </a></span>
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
                          <span class="info-box-text">@lang('Leave Application')</span>
                          <span class="info-box-number" id="leave_holder"> </span>
                      </div>
                      <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
              </div>
              {{-- <div class="col-12 col-sm-6 col-md-3">
                  <h4>@lang('Active Users(24 hrs)')</h4>
                <div class="info-box-content">
                    <div id="active_user_holder"> </div>
                </div>
              </div> --}}
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
                                                  <button type="button" class="btn btn-tool"
                                                      data-card-widget="collapse">
                                                      <i class="fas fa-minus"></i>
                                                  </button>

                                              </div>
                                          </div>
                                          <div class="card-body donut_box">
                                              <canvas id="donutChart_{{ $r->rule_number }}"
                                                  class="dashboard_canvas"></canvas>
                                          </div>
                                          <!-- /.card-body -->
                                      </div>
                                  </div>
                              @endforeach
                          </div>

                      </div>
                      @if (count($allRules) > 1)
                          @for ($i = 1; $i < count($allRules); $i++)
                              <div class="carousel-item">
                                  <div class="row" style="padding-left: 7px; padding-right: 7px;">
                                      @foreach ($allRules[$i] as $r)
                                          <div class="col-4">
                                              <div class="card card-warning">
                                                  <div class="card-header">
                                                      <h3 class="card-title">{{ $r->rule_name }} </h3>
                                                      <div class="card-tools">
                                                          <button type="button" class="btn btn-tool"
                                                              data-card-widget="collapse">
                                                              <i class="fas fa-minus"></i>
                                                          </button>

                                                      </div>
                                                  </div>
                                                  <div class="card-body donut_box">
                                                      <canvas id="donutChart_{{ $r->rule_number }}"
                                                          class="dashboard_canvas"></canvas>
                                                  </div>
                                                  <!-- /.card-body -->
                                              </div>
                                          </div>
                                      @endforeach
                                  </div>

                              </div>
                          @endfor
                      @endif
                      {{-- <div class="carousel-item">
                          <div class="row" style="padding-left: 7px; padding-right: 7px;">
                              <div class="col-4">
                                  <div class="card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">@lang('Rule') {{ digitDateLang('62') }} </h3>
                                          <div class="card-tools">
                                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                  <i class="fas fa-minus"></i>
                                              </button>

                                          </div>
                                      </div>
                                      <div class="card-body donut_box">
                                          <canvas id="donutChart_62" class="dashboard_canvas"></canvas>
                                      </div>
                                      <!-- /.card-body -->
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">@lang('Rule') {{ digitDateLang('68') }} </h3>
                                          <div class="card-tools">
                                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                  <i class="fas fa-minus"></i>
                                              </button>

                                          </div>
                                      </div>
                                      <div class="card-body donut_box">
                                          <canvas id="donutChart_68" class="dashboard_canvas"></canvas>
                                      </div>
                                      <!-- /.card-body -->
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">@lang('Rule') {{ digitDateLang('71') }} </h3>
                                          <div class="card-tools">
                                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                  <i class="fas fa-minus"></i>
                                              </button>

                                          </div>
                                      </div>
                                      <div class="card-body donut_box">
                                          <canvas id="donutChart_71" class="dashboard_canvas"></canvas>
                                      </div>
                                      <!-- /.card-body -->
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="carousel-item">
                          <div class="row" style="padding-left: 7px; padding-right: 7px;">
                              <div class="col-4">
                                  <div class="card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">@lang('Rule') {{ digitDateLang('78') }} </h3>
                                          <div class="card-tools">
                                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                  <i class="fas fa-minus"></i>
                                              </button>

                                          </div>
                                      </div>
                                      <div class="card-body donut_box">
                                          <canvas id="donutChart_78" class="dashboard_canvas"></canvas>
                                      </div>
                                      <!-- /.card-body -->
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">@lang('Rule') {{ digitDateLang('82') }} </h3>
                                          <div class="card-tools">
                                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                  <i class="fas fa-minus"></i>
                                              </button>

                                          </div>
                                      </div>
                                      <div class="card-body donut_box">
                                          <canvas id="donutChart_82" class="dashboard_canvas"></canvas>
                                      </div>
                                      <!-- /.card-body -->
                                  </div>
                              </div>
                              <div class="col-4">
                                  <div class="card card-warning">
                                      <div class="card-header">
                                          <h3 class="card-title">@lang('Rule') {{ digitDateLang('131') }} </h3>
                                          <div class="card-tools">
                                              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                  <i class="fas fa-minus"></i>
                                              </button>

                                          </div>
                                      </div>
                                      <div class="card-body donut_box">
                                          <canvas id="donutChart_131" class="dashboard_canvas"></canvas>
                                      </div>
                                      <!-- /.card-body -->
                                  </div>
                              </div>
                          </div>
                      </div> --}}
                  </div>

                  <!-- Left and right controls -->
                  <a class="carousel-control-prev" href="#demo" data-slide="prev">
                      <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#demo" data-slide="next">
                      <span class="carousel-control-next-icon"></span>
                  </a>
              </div>
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
      <script src="{{ asset('public/backend') }}/plugins/chart.js/Chart.min.js"></script>
      <script>
          $(function() {
              //-------------
              //- DONUT CHART -
              //-------------
              // Get context with jQuery - using jQuery's .get() method.


              //2nd donut chart
              /* var donutChartCanvas2 = $('#donutChart2').get(0).getContext('2d')
              var donutData2 = {
                  labels: [
                      'Chrome',
                      'IE',
                      'FireFox',
                      'Safari',
                      'Opera',
                      'Navigator',
                  ],
                  datasets: [{
                      data: [700, 500, 400, 600, 300, 100],
                      backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                  }]
              }
              var donutOptions2 = {
                  maintainAspectRatio: false,
                  responsive: true,
              }
              //Create pie or douhnut chart
              // You can switch between pie and douhnut using the method below.
              new Chart(donutChartCanvas2, {
                  type: 'doughnut',
                  data: donutData2,
                  options: donutOptions2
              }) */

              //-------------
              //- BAR CHART -
              //-------------


              load_dashboard_data();
          });

          function load_dashboard_data() {
              $("#order_of_days_holder").html(
                  '<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
              $("#attendance_holder").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
              //$("#leave_holder").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
              //$("#active_user_holder").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
              $("#mp_leave_list_holder").html(
                  '<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
              $("#mp_appointment_list_holder").html(
                  '<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
              var session_id = $("#parliament_session_id").val();
              var url = "{{ url('/dashboard_summary') }}/" + session_id + "/summary";
              //var _token = "{{ csrf_token() }}";
              $.ajax({
                  url: url,
                  type: "GET",
                  /* data: {
                      _token: _token,
                  }, */
                  success: function(response) {
                      response = JSON.parse(response);
                      console.log(response);
                      $("#order_of_days_holder").html(response.data.order_of_days);
                      $("#attendance_holder").html(response.data.total_attendance);
                      //$("#leave_holder").html(response.data.total_leave);
                      //$("#active_user_holder").html(response.data.active_users);
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
                              /* backgroundColor: [
                                  'rgba(255, 99, 132, 0.2)',
                                  'rgba(255, 159, 64, 0.2)',
                                  'rgba(255, 205, 86, 0.2)',
                                  'rgba(75, 192, 192, 0.2)',
                                  'rgba(54, 162, 235, 0.2)',
                                  'rgba(153, 102, 255, 0.2)',
                                  'rgba(201, 203, 207, 0.2)'
                              ],
                              borderColor: [
                                  'rgb(255, 99, 132)',
                                  'rgb(255, 159, 64)',
                                  'rgb(255, 205, 86)',
                                  'rgb(75, 192, 192)',
                                  'rgb(54, 162, 235)',
                                  'rgb(153, 102, 255)',
                                  'rgb(201, 203, 207)'
                              ], */
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
                          //console.log(key,response.data.notice_donut_chart[key])
                          //donut chart
                          var status_data = [];
                          var status_label = [];
                          var status_colors = [];
                          for (var x = 0; x < response.data.notice_donut_chart[key].length; x++) {
                              status_data.push(response.data.notice_donut_chart[key][x].total_notices);
                              status_label.push(response.data.notice_donut_chart[key][x].status_data.status_name);
                              status_colors.push(response.data.notice_donut_chart[key][x].status_data
                                  .status_color);
                          }
                          var donutChartCanvas = 'canvas_' + key;
                          var donutData = 'donutData_' + key;
                          donutChartCanvas = $('#donutChart_' + key).get(0).getContext('2d')
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

          function generate_pdf() {
              $("#circular_holder").html('');
              $("#circular_holder").html('<img class="spinner_loader" src="{{ asset('public/images/lottery.gif') }}">');
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
                          '<a href="javascript:void(0);" onClick="generate_pdf()">{{ Lang::get('Download') }}</a>'
                          );
                  },
                  error: function(res) {
                      $("#circular_holder").html(
                          '<a href="javascript:void(0);" onClick="generate_pdf()">{{ Lang::get('Download') }}</a>'
                          );
                  }

              });
          }

          
      </script>
