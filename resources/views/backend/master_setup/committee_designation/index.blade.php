@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Committee Designation Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Committee Designation Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                          <a href="{{route('admin.master_setup.committee_designation.create') }}" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> @lang('Add Committee Designation')</a>
                        </div>
                        <table id="dataTable" class="table table-sm table-bordered table-striped">
                        <div class="card-body">
                          <h5 class="float-left">@lang('Committee Designation List')</h5>
                                <thead>
                                <tr>
                                    <th width="5%">@lang('Serial')</th>
                                    <th>@lang('Committee Designation Name')</th>
                                    <th>@lang('Committee Designation Name')</th>
                                    <th width="5%">@lang('Status')</th>
                                    <th width="10%" class="text-center">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($committeeDesignation as $data)
                                        <tr>
                                            <td>{{ digitDateLang($loop->iteration) }}</td>
                                            <td>
                                                {{$data->name_bn}}                                               
                                            </td>
                                            <td>
                                                {{$data->name_en}}                                               
                                            </td>                                           
                                            @if($data->status == 1)                                                
                                                    <td>{!! activeStatus($data->status) !!}</td>                                                
                                                @else
                                                   <td>{!! activeStatus($data->status) !!}</td>                               

                                            @endif                                    
                                            <td>                                          
                                           <a href="{{ route('admin.master_setup.committee_designation.edit',$data->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Update Button"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger delete" data-route="{{route('admin.master_setup.committee_designation.destroy',$data->id)}}"><i class="fa fa-trash"></i></a>                                          
                                        </td>           
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
    </section>
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
              }else if (response.status == 'data_is_used') {
                Swal.fire({
                  title: 'Not Delete',
                  text: "Data is used",
                  type: 'warning'
                }).then((result) => {
                  window.setTimeout(function() {
                    window.location.reload()
                  }, 1000);


                });
              }else {
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

