@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('MP Office Room Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('MP Office Room Management')</li>
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
                            <a href="{{route('admin.master_setup.mp_office_room.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Office Room Allotation')</a>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">@lang('Constituency Area No')</th>
                                    <th>@lang('MP Name')</th>
                                    <th width="25%">@lang('Constituency Area Name')</th>
                                    <th>@lang('Block, Level & Room No')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th width="15%" class="text-center">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mpOfficeRooms as $data)
                                         <tr>
                                            <td>{{ $data->constituencies_id }}</td>
                                            <td>
                                              {{session()->get('language') == 'bn' ? $data->mp_name_bn : $data->mp_name_en }}
                                            </td>
                                            
                                            <td>
                                              {{ session()->get('language') == 'bn' ? $data->consticuency_name_bn : $data->consticuency_name_en}}
                                            </td>                                              
                                            
                                            <td>
                                              @lang('Block'): {{digitDateLang($data->songshod_blocks_id)}}<br/> 
                                              @lang('Floor'): {{ digitDateLang($data->songshod_floors_id) }}<br/> 
                                              @lang('Room'): {{digitDateLang($data->room_ids)  }}</td> 
                                            <td class="text-center">{!! activeStatus($data->status) !!}</td>
                                            <td class="text-center">                                          
                                                <a href="{{ route('admin.master_setup.mp_office_room.show',$data->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></i></a>
                                                <a href="{{ route('admin.master_setup.mp_office_room.edit',$data->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Update Button"><i class="fa fa-edit"></i></a>
                                                 <a href="#" class="btn btn-sm btn-danger delete" data-route="{{route('admin.master_setup.mp_office_room.destroy',$data->id)}}"><i class="fa fa-trash"></i></a>   
                                      
                                             </td> 
                                        </tr>
                                        @endforeach
                                    </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
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
                  text: "Data has been used !",
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