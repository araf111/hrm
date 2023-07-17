@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Committee Room Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Committee Room Management')</li>
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
                            <a href="{{route('admin.master_setup.committee_room.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Add Committee Room')</a>
                             <h4 class="text-left">@lang('List of Committee Room')</h4>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-sm table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th width="5%">@lang('Serial')</th>
                                    <th>@lang('Committee Room Name')</th>
                                    {{-- <th>@lang('Committee Room Name (EN)')</th> --}}
                                    <th>@lang('Block, Floor, Room No')</th>
                                    <th>@lang('Telephone No, PABX')</th>
                                    <th width="5%" class="text-center">@lang('Status')</th>                                 
                                    <th width="10%" class="text-center">@lang('Action')</th>
                                </tr>
                                </thead>
                                <tbody>

                                    @foreach ($committeeRoom as $data)
                                        <tr>
                                            <td>{{ digitDateLang($loop->iteration) }}</td>
                                            <td>
                                              @if (session()->get('language') == 'bn')
                                                {{ $data->name_bn }}
                                              @else
                                                {{ $data->name_en }}
                                              @endif
                                            </td>
                                            {{-- <td>{{ $data->name_en}}</td> --}}
                                            <td>
                                              @lang('Block'): 
                                                @foreach ($songshodBlock as $block)
                                                    @if ($data->songshod_blocks_id == $block->id)
                                                      {{ session()->get('language') == 'bn' ? $block->name_bn : $block->name }} <br/>
                                                    @endif
                                                @endforeach
                                              
                                              @lang('Floor'): 
                                                @foreach ($songshodFloor as $floor)
                                                  @if ($data->songshod_floors_id == $floor->id)
                                                    {{ session()->get('language') == 'bn' ? $floor->name_bn : $floor->name }} <br/>
                                                  @endif
                                                @endforeach
                                              @lang('Room No.'): 
                                                @foreach ($songshodRoom as $room)
                                                  @if ($data->songshod_rooms_id == $room->id)
                                                    {{ digitDateLang($room->room) }} <br/>
                                                  @endif
                                                @endforeach
                                            </td>
                                            <td>
                                              @foreach ($phone_pabx as $phonepabx)
                                                @if( $data->songshod_rooms_id == $phonepabx->room_id )

                                                  {{ digitDateLang($phonepabx->num_of_telephone." , ".$phonepabx->num_of_pabx)}}

                                                @endif
                                              @endforeach
                                              
                                            </td>
                                            <td class="text-center"> 
                                              @if ($data->status == 1)
                                              {!! activeStatus($data->status) !!}
                                              @else
                                              {!! activeStatus($data->status) !!}
                                              @endif  
                                            </td>  
                                            <td class="text-center">                                          
                                                {{-- <a href="{{ route('admin.master_setup.committee_room.show',$data->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></i></a> --}}
                                                <a href="{{ route('admin.master_setup.committee_room.edit',$data->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Update Button"><i class="fa fa-edit"></i></a>
                                                 <a href="#" class="btn btn-sm btn-danger delete" data-route="{{route('admin.master_setup.committee_room.destroy',$data->id)}}"><i class="fa fa-trash"></i></a>   
                                       
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