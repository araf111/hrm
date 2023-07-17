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
                        <li class="breadcrumb-item active">@lang('Pole')</li>
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
                            <a href="{{route('admin.app-management.pull-list.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Add New Pole')</a>
                        </div>
                        <div class="card-body">
                            
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
                                  <button type="button" class="btn btn-info" onClick="getReport()">@lang('Show Report')</button>
                              </div>
                          
                      </div>
                        <div id="report_loader" class="d-none">
                            <center><img src="{{asset("public/images/lottery.gif")}}"></center>
                        </div>
                      <div class="row" id="report_content">

                      </div>
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
        function getReport() {
            $("#report_loader").removeClass('d-none');
            $("#report_loader").addClass('show');
            $("#report_content").removeClass('show');
            $("#report_content").addClass('d-none');
              var id = $("#pole_id").val();
              var url = "{{ url('/app-management/pole-summary') }}/" + id;
              $.ajax({
                  url: url,
                  type: "GET",
                  success: function(response) {
                        $("#report_content").html(response);
                        $("#report_loader").removeClass('show');
                        $("#report_loader").addClass('d-none');
                        $("#report_content").removeClass('d-none');
                        $("#report_content").addClass('show');
                  },
                  error:function(err){
                        $("#report_loader").removeClass('show');
                        $("#report_loader").addClass('d-none');
                        $("#report_content").removeClass('d-none');
                        $("#report_content").addClass('show');
                  }
              });
          }
    </script>

@endsection


