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
                        <li class="breadcrumb-item active">@lang('Asking Answer')</li>
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
                        <div class="card-body">
                            
                            @include('backend.app_management.digital_support.ans_grid')
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
<script>
     
    function load_data(type) {
        if (type == 'approved') {
            window.location.href = "{{ route('admin.app-management.digital-support-ans.approve')}}";
        } else if (type == 'rejected') {
            window.location.href = "{{ route('admin.app-management.digital-support-ans.reject')}}";
        
        } else if (type == 'pending') {
            window.location.href = "{{ route('admin.app-management.digital-support-ans.index')}}";
        
        }
    }
</script>


