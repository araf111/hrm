@extends('backend.layouts.app')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Profile Management') </h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        @if (session()->get('language') == 'bn')
                            {{ isset($profileData) ? $profileData->nameBng : __('User Information') }}
                        @else
                            {{ isset($profileData) ? $profileData->nameEng : __('User Information') }}
                        @endif
                        <a href="javascript:(void);" id="edit_button" class="btn btn-info float-right d-none"
                            onclick="load_data('edit')"><i class="fa fa-edit mr-2"></i>
                            @lang('Edit')
                        </a> &nbsp;
                        <a href="javascript:(void);" id="view_button" class="btn btn-info float-right d-none"
                            onclick="load_data('view')"><i class="fa fa-eye mr-2"></i>
                            @lang('View')
                        </a>
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="content" id="profile_container">

    </div>
    <script>
        $(document).ready(function() {
            load_data('view');
        });

        function load_data(type) {
            //$('#profile_container').html('');
            if (type == 'view') {
                $("#view_button").removeClass('block');
                $("#view_button").addClass('d-none');
                $("#edit_button").removeClass('d-none');
                $("#edit_button").addClass('block');

            }
            if (type == 'edit') {
                $("#view_button").removeClass('d-none');
                $("#view_button").addClass('block');
                $("#edit_button").removeClass('block');
                $("#edit_button").addClass('d-none');

            }
            $('#profile_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
            $.ajax({
                url: "{{ url('/user-management/user-info/profile_details') }}/" + type,
                type: "GET",
                data: {
                    id: "{{ $profileID }}"
                },
                success: function(response) {
                    $('#profile_container').html(response);
                    //DOM elements
                    $(".select2").select2({});
                },
                error: function(res) {
                    $('#profile_container').html('@lang("No Data Found")');
                }
            });

        }
    </script>
@endsection
