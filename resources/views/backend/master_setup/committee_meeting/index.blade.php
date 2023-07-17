@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Committee Meeting Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Committee Meeting Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <a href="{{route('admin.master_setup.committee_meeting.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Add Committee Meeting')</a>
                            <h4 class="text-left">@lang('List of Committee Meetng')</h4>
                        </div>
                            <div class="row">
                                <div class="col-3">
                                <div id="reportrange"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-info" onClick="load_data()">@lang('Show Committees')</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="list_container">
                                <table id="list_import_table" class="table table-sm table-bordered table-striped">
                                    <thead>
                                        <tr>
                                          <th>@lang('Date')</th>
                                          <th>@lang('Committee Name')</th>
                                          <th>@lang('Starting Time')</th>
                                          <th>@lang('Ending Time')</th>
                                          <th width="5%">@lang('Status')</th>  
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                            <table id="dataTable" class="table table-sm table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th width="5%">@lang('Serial')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Committee Name')</th>
                                    <th>@lang('Room No.')</th>
                                    <th>@lang('Starting Time')</th>
                                    <th>@lang('Ending Time')</th>
                                    <th width="5%">@lang('Status')</th>                                 
                                    <th width="10%" class="text-center">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($committeeMeeting as $data)
                                        <tr>
                                            <td>{{ digitDateLang($loop->iteration) }}</td>
                                            <td>{{ digitDateLang(nanoDateFormat($data->date_meeting))}}</td>
                                            <td>{{ $data->committee_name }}</td>
                                            <td>{{ session()->get('language') == 'bn' ? $data->room_name_bn : $data->room_name_en }}</td>
                                            <td>{{ digitDateLang(date('h:i a',strtotime($data->time_starting)))}}</td>
                                            <td>{{ digitDateLang(date('h:i a',strtotime($data->time_ending)))}}</td>
                                            <td> 
                                              @if ($data->status == 1)
                                                {!! activeStatus($data->status) !!}                                                 
                                              @else
                                              <label class="bg-danger rounded">@lang('Cancel')</label>
                                                  
                                              @endif  
                                            </td>  
                                            <td class="text-center">                                          
                                                {{-- <a href="{{ route('admin.master_setup.committee_meeting.show',$data->id) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></i></a> --}}
                                                <a href="{{ route('admin.master_setup.committee_meeting.edit',$data->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Update Button"><i class="fa fa-edit"></i></a>
                                                 <a href="#" class="btn btn-sm btn-danger delete" data-route="{{route('admin.master_setup.committee_meeting.destroy',$data->id)}}"><i class="fa fa-trash"></i></a>  
                                       
                                             </td>                                         
                                            
                                        </tr>
            
                                    @endforeach
                                    </tbody>
                                </table>

                                
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>

    <script>
         function load_data() {
          $('#list_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
          $.ajax({
              url: "{{ url('/admin/master-setup/list_attendance') }}",
              type: "POST",
              data: {
                  _token: "{{ csrf_token() }}",
                  date: $('#reportrange').text().trim(),
                  mp_id: $("#list_mp_id").val(),
                  parliament_session_id: $("#parliament_session_id").val()
              },
              success: function(response) {
                  response = JSON.parse(response);
                  if (response.status == true) {
                      $('#list_container').html(response.data);
                      $("#list_orders_table").DataTable({

                      });
                  } else {
                      Swal.fire('@lang("No Data Found")', '', 'error');
                      $('#list_container').html('');
                  }
              }
          });

      }
  </script>
  <script type="text/javascript">
      $(function() {

          var start = moment().subtract(29, 'days');
          var end = moment();

          function cb(start, end) {
              $('#reportrange span').html(start.format('D-MM-YYYY') + ' ~ ' + end.format('D-MM-YYYY'));
          }

          $('#reportrange').daterangepicker({
              startDate: start,
              endDate: end,
              ranges: {
                  'Today': [moment(), moment()],
                  'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                  'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                  'This Month': [moment().startOf('month'), moment().endOf('month')],                  
                  'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                      'month').endOf('month')],
                  'This Year': [moment().startOf('year'), moment().endOf('year')]    
              }
          }, cb);

          cb(start, end);

      });
      moment.locale('bn');
      $('#reportrange').daterangepicker();
  </script>
@endsection
@section('script')
<script>
    $(document).on('click', '.delete', function() {
      var btn = this;
    //   alert('Yes');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        console.log(result);
        if (result.value) {
          var url = $(this).data('route');
          var _token = "{{csrf_token()}}";
          $.ajax({
            url: url,
            type: "delete",
            data: {
              _token: _token
            },
            success: function(response) {
              if (response.status == 'success') {
                Swal.fire({
                  title: 'Delete',
                  text: "Data has been deleted!",
                  type: 'success'
                }).then((result) => {
                  $(btn).closest('tr').fadeOut(1500);
                });
              } else if (response.status == 'allflatdelete') {
                Swal.fire({
                  title: 'Delete',
                  text: "All Flat has been deleted!",
                  type: 'warning'
                }).then((result) => {
                  window.setTimeout(function() {
                    window.location.reload()
                  }, 1000);
                });
              }else if (response.status == 'warinng') {
                Swal.fire({
                  title: 'Delete',
                  text: "ksldjfkdj",
                  type: 'warning'
                }).then((result) => {
                  window.setTimeout(function() {
                    window.location.reload()
                  }, 1000);


                });
                } else {
                Swal.fire('Data can not delete', '', 'error');
              }
            }
          });
        } else {
          Swal.fire('Your data is safe', '', 'success');
        }
      })
    });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  })

</script>
@endsection
