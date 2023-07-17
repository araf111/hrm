<!-- 
 * Author M. Atoar Rahman
 * Date: 01/09/2021
 * Time: 11:40 AM
-->
@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Menu for Frontend')</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Menu')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <a href="{{ route('admin.landing_page.menu-info.list') }}" class="btn btn-sm btn-info"><i
                                    class="fas fa-plus"></i> @lang('Menu List')</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Menu Name') <small>(@lang('English'))</small> <span style="color: red;"> *</span> </label>
                                            <input type="text" name="name" value="{{ @$editData->name }}"
                                                class="form-control form-control-sm name"
                                                placeholder="@lang('Enter Menu Name in English')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Menu Name') <small>(@lang('Bangla'))</small> <span style="color: red;"> *</span> </label>
                                            <input type="text" name="name_bn" value="{{ @$editData->name_bn }}"
                                                class="form-control form-control-sm name_bn"
                                                placeholder="@lang('Enter Menu Name in Bangla')">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group {{ $errors->has('main_menu') ? 'has-error' : '' }}">
                                            <label class="control-label">@lang('Main Menu')</label>
                                            <select name="main_menu" class="form-control form-control-sm select2 main_menu">
                                                <?php echo getSubMenuFrontend($wheredata = ['parent' => 0], $selected_sub_menu_id = @$menu_parent[0]); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group {{ $errors->has('parent') ? 'has-error' : '' }}">
                                            <label class="control-label">@lang('Sub Menu 1')</label>
                                            <select name="sub_menu_1"
                                                class="form-control form-control-sm select2 sub_menu_1">
                                                <?php echo getSubMenuFrontend($wheredata = ['parent' => @$menu_parent[0]], $selected_sub_menu_id = @$menu_parent[1]); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group {{ $errors->has('parent') ? 'has-error' : '' }}">
                                            <label class="control-label">@lang('Sub Menu 2')</label>
                                            <select name="sub_menu_2"
                                                class="form-control form-control-sm select2 sub_menu_2">
                                                <?php echo getSubMenuFrontend($wheredata = ['parent' => @$menu_parent[1]], $selected_sub_menu_id = @$menu_parent[2]); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group {{ $errors->has('parent') ? 'has-error' : '' }}">
                                            <label class="control-label">@lang('Sub Menu 3')</label>
                                            <select name="sub_menu_3"
                                                class="form-control form-control-sm select2 sub_menu_3">
                                                <?php echo getSubMenuFrontend($wheredata = ['parent' => @$menu_parent[2]], $selected_sub_menu_id = @$menu_parent[3]); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group {{ $errors->has('parent') ? 'has-error' : '' }}">
                                            <label class="control-label">@lang('Sub Menu 4')</label>
                                            <select name="sub_menu_4"
                                                class="form-control form-control-sm select2 sub_menu_4">
                                                <?php echo getSubMenuFrontend($wheredata = ['parent' => @$menu_parent[3]], $selected_sub_menu_id = @$menu_parent[4]); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('URL') <span style="color: red;"> *</span> </label>
                                            <input type="text" name="url" value="{{ @$editData->route }}"
                                                class="form-control form-control-sm url"
                                                 placeholder="@lang('Enter Route Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Status')</label>
                                            <select name="status" class="form-control form-control-sm select2 status">
                                                
                                                <option value="1" {{ @$editData->status == '1' ? 'selected' : '' }}>
                                                    @lang('Active')
                                                </option>
                                                <option value="0" {{ @$editData->status == '0' ? 'selected' : '' }}>
                                                    @lang('Inactive')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Sort Order') <span style="color: red;"> *</span> </label>
                                            <input type="number" value="{{ @$editData->sort }}" name="sort"
                                                class="form-control form-control-sm sort" 
                                                placeholder="@lang('Enter Sort Number')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Icon')</label>
                                            <input data-toggle="modal" data-target="#iconListModal" data-backdrop="static"
                                                data-keyboard="false" type="text" name="icon" id="icon"
                                                value="{{ @$editData->icon }}" class="form-control form-control-sm icon"
                                                placeholder="@lang('Enter Icon Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="control-label">@lang('If Exist Extra Route')</label>
                                            <button type="button" class="btn btn-sm btn-default btn-block addextraRoute">
                                                @lang('Add More Route')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="addextraRouteDiv">
                                    @if (@$menuRoutes != null)
                                        @foreach ($menuRoutes as $sl => $val)
                                            <div class="remove_extraRouteDiv card card-body" style="background: #e9e9e9;">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">@lang('Menu Name')
                                                                <small>(@lang('English'))</small></label>
                                                            <input type="text" id="newname[{{ $val->id }}]"
                                                                name="newname[{{ $val->id }}]"
                                                                value="{{ $val->name }}"
                                                                class="newname form-control form-control-sm"
                                                                placeholder="@lang('Enter Menu Name in English')">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">@lang('Menu Name')
                                                                <small>(@lang('Bangla'))</small></label>
                                                            <input type="text" id="newname_bn[{{ $val->id }}]"
                                                                name="newname_bn[{{ $val->id }}]"
                                                                value="{{ $val->name_bn }}"
                                                                class="newname_bn form-control form-control-sm"
                                                                placeholder="@lang('Enter Menu Name in Bangla')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group"
                                                            style="padding: 14px;margin-bottom: 0px;background: white;border-radius: 10px;">
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input newsection_or_route"
                                                                    type="radio"
                                                                    id="newsection_or_route_{{ $val->id }}_1"
                                                                    value="section"
                                                                    name="newsection_or_route[{{ $val->id }}]"
                                                                    {{ $val->section_or_route != 'route' ? 'checked' : '' }}>
                                                                <label for="newsection_or_route_{{ $val->id }}_1"
                                                                    class="custom-control-label">
                                                                    @lang('Section')
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                <input class="custom-control-input newsection_or_route"
                                                                    type="radio"
                                                                    id="newsection_or_route_{{ $val->id }}_2"
                                                                    value="route"
                                                                    name="newsection_or_route[{{ $val->id }}]"
                                                                    {{ $val->section_or_route == 'route' ? 'checked' : '' }}>
                                                                <label for="newsection_or_route_{{ $val->id }}_2"
                                                                    class="custom-control-label">
                                                                    @lang('Route')
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                @lang('Section/Route Name')
                                                            </label>
                                                            <input type="text" id="newurl[{{ $val->id }}]"
                                                                name="newurl[{{ $val->id }}]"
                                                                value="{{ $val->route }}"
                                                                class="newurl form-control form-control-sm"
                                                                placeholder="@lang('Enter Route Name')">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                @lang('Sort Order')</label>
                                                            <input type="number" id="newsort[{{ $val->id }}]"
                                                                name="newsort[{{ $val->id }}]"
                                                                value="{{ $val->sort }}"
                                                                class="newsort form-control form-control-sm"
                                                                placeholder="@lang('Enter Sort Number')">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-1" style="padding-top: 30px;">
                                                        <i class="btn btn-sm btn-info fa fa-plus-circle addextraRoute"></i>
                                                        <i
                                                            class="btn btn-sm btn-danger fa fa-minus-circle removeextraRoute">
                                                        </i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-sm btn-success">
                                                @if (@$editData)
                                                    @lang("Update")
                                                @else
                                                    @lang("Save")
                                                @endif
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('frontend.admin.menu-management.menu-info.all-icon-list')

    <script id="document-template" type="text/x-handlebars-template">
        <div class="remove_extraRouteDiv card card-body" style="background: #e9e9e9;">  
                		<div class="row">  
                			<div class="col-sm-2">  
                				<div class="form-group">  
                					<label class="control-label">@lang('Menu Name') <small>(@lang('English'))</small></label>  
                					<input type="text" id="newname[new@{{ counter }}]" name="newname[new@{{ counter }}]" value="" class="newname form-control form-control-sm" placeholder="@lang('Enter Menu Name in English')" >                 
                				</div>  
                			</div>  
                			<div class="col-sm-2">  
                				<div class="form-group">  
                					<label class="control-label">@lang('Menu Name') <small>(@lang('Bangla'))</small></label>  
                					<input type="text" id="newname_bn[new@{{ counter }}]" name="newname_bn[new@{{ counter }}]" value="" class="newname_bn form-control form-control-sm" placeholder="@lang('Enter Menu Name in Bangla')" >                 
                				</div>  
                			</div>  
                			<div class="col-md-2">
                				<div class="form-group" style="padding: 14px;margin-bottom: 0px;background: white;border-radius: 10px;">
                					<div class="custom-control custom-radio">
                						<input class="custom-control-input newsection_or_route" type="radio" id="newsection_or_route_new@{{ counter }}_1" value="section" name="newsection_or_route[new@{{ counter }}]" checked>
                						<label for="newsection_or_route_new@{{ counter }}_1" class="custom-control-label">@lang('Section')</label>
                					</div>
                					<div class="custom-control custom-radio">
                						<input class="custom-control-input newsection_or_route" type="radio" id="newsection_or_route_new@{{ counter }}_2" value="route" name="newsection_or_route[new@{{ counter }}]">
                						<label for="newsection_or_route_new@{{ counter }}_2" class="custom-control-label">@lang('Route')</label>
                					</div>
                				</div>
                			</div>
                			<div class="col-sm-3">  
                				<div class="form-group">  
                					<label class="control-label">@lang('Section/Route Name')</label>  
                					<input type="text" id="newurl[new@{{ counter }}]" name="newurl[new@{{ counter }}]" value="" class="newurl form-control form-control-sm" placeholder="@lang('Enter Route Name')">  
                				</div>  
                			</div>  
                			<div class="col-sm-2">  
                				<div class="form-group">  
                					<label class="control-label">@lang('Sort Order')</label>  
                					<input type="number" id="newsort[new@{{ counter }}]"  value="" name="newsort[new@{{ counter }}]" class="newsort form-control form-control-sm" placeholder="@lang('Enter Sort Number')">  
                				</div>  
                			</div>  
                			<div class="form-group col-md-1" style="padding-top: 30px;">  
                				<i class="btn btn-sm btn-info fa fa-plus-circle addextraRoute"></i>  
                				<i class="btn btn-sm btn-danger fa fa-minus-circle removeextraRoute"> </i>  
                			</div>  
                		</div>							   
                	</div>  
                </script>


    <script type="text/javascript">
        $(document).ready(function() {
            var counter = '10000000';
            $(document).on("click", ".addextraRoute", function() {
                var source = $("#document-template").html();
                var template = Handlebars.compile(source);
                var data = {
                    counter: counter
                };
                var html = template(data);
                counter++;
                $("#addextraRouteDiv").append(html);
            });

            $(document).on("click", ".removeextraRoute", function(event) {
                $(this).closest(".remove_extraRouteDiv").remove();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".demo-icon").click(function() {
                var icon = $(this).find('span').html();
                $('#icon').val(icon);
                $('#iconListModal').modal('toggle');
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#submitForm').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    if (element.hasClass("parentchield")) {
                        error.insertAfter(element.next());
                    } else if (element.hasClass("status")) {
                        error.insertAfter(element.next());
                    } else if (element.hasClass("newsection_or_route")) {
                        error.insertAfter(element.parents('.form-group'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                errorClass: 'text-danger',
                validClass: 'text-success',

                submitHandler: function(form) {
                    event.preventDefault();
                    $('[type="submit"]').attr('disabled', 'disabled').css('cursor', 'not-allowed');
                    var formInfo = new FormData($("#submitForm")[0]);
                    $.ajax({
                        url: "{{ @$editData ? route('admin.landing_page.menu-info.update', @$editData->id) : route('admin.landing_page.menu-info.store') }}",
                        data: formInfo,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('.preload').show();
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                toastr.success("", data.message);
                                $('.preload').hide();
                                setTimeout(function() {
                                    location.replace(
                                        "{{ route('admin.landing_page.menu-info.list') }}"
                                    );
                                }, 2000);
                            } else if (data.status == 'error') {
                                toastr.error("", data.message);
                                $('[type="submit"]').removeAttr('disabled').css('cursor',
                                    'pointer');
                                $('.preload').hide();
                            } else {
                                toastr.error(
                                    'দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {
                                        globalPosition: 'top right',
                                        className: 'error',
                                        autoHideDelay: 10000
                                    });
                                $('[type="submit"]').removeAttr('disabled').css('cursor',
                                    'pointer');
                                $('.preload').hide();
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr.error(
                                'দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {
                                    globalPosition: 'top right',
                                    className: 'error',
                                    autoHideDelay: 10000
                                });
                            $('[type="submit"]').removeAttr('disabled').css('cursor',
                                'pointer');
                            $('.preload').hide();
                        }
                    });
                }
            });

            jQuery.validator.addClassRules({
                name: {
                    required: true,
                    regex_en: true,
                },
                name_bn: {
                    required: true,
                    regex_bn: true,
                },
                url: {
                    required: true,
                },
                status: {
                    required: true,
                },
                sort: {
                    required: true,
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '.main_menu', function() {
            var exist = $('.sub_menu_1').hasClass('select2');
            if ($('.sub_menu_1').length) {
                var parent = $('.main_menu').val();
                $.ajax({
                    url: "{{ route('admin.landing_page.menu-info.getSubMenuFrontend') }}",
                    type: "GET",
                    data: {
                        parent: parent
                    },
                    success: function(data) {
                        $('.sub_menu_1').html(data);
                        if (exist == true) {
                            $('.sub_menu_1').val('').select2();
                        }
                    }
                });
            }
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '.sub_menu_1', function() {
            var exist = $('.sub_menu_2').hasClass('select2');
            if ($('.sub_menu_2').length) {
                var parent = $('.sub_menu_1').val();
                $.ajax({
                    url: "{{ route('admin.landing_page.menu-info.getSubMenuFrontend') }}",
                    type: "GET",
                    data: {
                        parent: parent
                    },
                    success: function(data) {
                        $('.sub_menu_2').html(data);
                        if (exist == true) {
                            $('.sub_menu_2').val('').select2();
                        }
                    }
                });
            }
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '.sub_menu_2', function() {
            var exist = $('.sub_menu_3').hasClass('select2');
            if ($('.sub_menu_3').length) {
                var parent = $('.sub_menu_2').val();
                $.ajax({
                    url: "{{ route('admin.landing_page.menu-info.getSubMenuFrontend') }}",
                    type: "GET",
                    data: {
                        parent: parent
                    },
                    success: function(data) {
                        $('.sub_menu_3').html(data);
                        if (exist == true) {
                            $('.sub_menu_3').val('').select2();
                        }
                    }
                });
            }
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '.sub_menu_3', function() {
            var exist = $('.sub_menu_4').hasClass('select2');
            if ($('.sub_menu_4').length) {
                var parent = $('.sub_menu_3').val();
                $.ajax({
                    url: "{{ route('admin.landing_page.menu-info.getSubMenuFrontend') }}",
                    type: "GET",
                    data: {
                        parent: parent
                    },
                    success: function(data) {
                        $('.sub_menu_4').html(data);
                        if (exist == true) {
                            $('.sub_menu_4').val('').select2();
                        }
                    }
                });
            }
        });
    </script>

@endsection
