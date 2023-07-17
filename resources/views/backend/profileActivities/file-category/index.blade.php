@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 text-dark">@lang('File Management')</h4>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
          <li class="breadcrumb-item active">@lang('Category Management')</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title w-100">@lang('Category List')
          <a href="{{ route('admin.profile-activities.file-category.create') }}" class="btn btn-info float-right"><i class="fa fa-plus mr-2"></i> @lang('Category Add')</a>
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="dataTable">
            <thead>
              <tr>
                <th>@lang('Serial')</th>
                <th>@lang('Category Name (Bangla)')</th>
                <th>@lang('Category Name (English)')</th>
                <th>@lang('Action')</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($allData) && count($allData) > 0)
              @foreach ($allData as $data)
              <tr>
                <td>{{ digitDateLang($loop->iteration) }}</td>

                <td>{{ $data->category_name_bn }}</td>
                <td>{{ $data->category_name_en }}</td>
                <td>
                  <a href="{{ route('admin.profile-activities.file-category.edit',$data->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                  <a class="btn btn-sm btn-danger delete" data-route="{{route('admin.profile-activities.file-category.destroy',$data->id)}}"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

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
            } else if (response.status == 'cat exit in file') {
              Swal.fire({
                title: 'File Exist in This Category',
                text: "So You can't Delete this Category!",
                type: 'warning'
              }).then((result) => {
                window.setTimeout(function() {
                  window.location.reload()
                }, 1000);


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
</script>
@endsection