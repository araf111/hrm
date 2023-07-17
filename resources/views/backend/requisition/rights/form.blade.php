@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark">@lang('Telephone/PABX Rights')</h4>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Telephone/PABX Rights')</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if ($data->id)
                <h4 class="card-title">@lang('Update Telephone/PABX Rights')</h4>
                @else
                <h4 class="card-title">@lang('Create Telephone/PABX Rights')</h4>
                @endif
            </div>
            <!-- Form Start-->
            <form id="formSubmit" name="formSubmit" method="POST" @if($data->id)
                action="{{ route('admin.requisition.telephone_pabx_rights.update', $data->id) }}">
                <input name="_method" type="hidden" value="PUT">
                @else
                action="{{ route('admin.requisition.telephone_pabx_rights.store') }}">
                @endif
                @csrf

                <input type="hidden" id="id" name="id" value="{{$data->id}}">
                <div class="card-body">
                    <div class="row">
                        {{-- <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="place_type">@lang('Place of Telephone/PABX Rights')<span style="color: red;"> *</span></label>
                                <select id="place_type" required name="place_type" class="form-control place_type @error('place_type') is-invalid @enderror select2">
                                    @php
                                    $place_type = $data->place_type;
                                    @endphp
                                    @if($place_type==0)
                                    <option selected value="0">@lang('Official')</option>
                                    @else
                                    <option value="0">@lang('Official')</option>
                                    @endif
                                    @if($place_type==1)
                                    <option selected value="1">@lang('Residential')</option>
                                    @else
                                    <option value="1">@lang('Residential')</option>
                                    @endif
                                </select>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="usertype">@lang('Designation')<span style="color: red;"> *</span></label>
                                <select id="usertype"  name="usertype" class="form-control usertype @error('usertype') is-invalid @enderror select2">
                                    {{-- <option value="">@lang('Select Designation')</option> --}}
                                    @foreach ($userTypes as $list)
                                    @if($list->usertype==$data->usertype)
                                    <option selected value="{{$list->usertype}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                    @else
                                    <option value="{{$list->usertype}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                    @endif
                                    @endforeach
                                </select>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="num_of_telephone">@lang('Quantity of Telephone')<span style="color: red;"> *</span></label>
                                <input type="number"  id="num_of_telephone" name="num_of_telephone" value="{{old('room', $data->num_of_telephone)}}" class="form-control num_of_telephone @error('num_of_telephone') is-invalid @enderror" placeholder="@lang('Enter Quantity of Telephone')" autocomplete="off" maxlength="30">

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="num_of_pabx">@lang('Quantity of PABX')<span style="color: red;"> *</span></label>
                                <input type="number"  id="num_of_pabx" name="num_of_pabx" onkeydown="removeSpecials(event)" value="{{old('num_of_pabx', $data->num_of_pabx)}}" class="form-control num_of_pabx @error('num_of_pabx') is-invalid @enderror" placeholder="@lang('Enter Quantity of PABX')" autocomplete="off" maxlength="30">

                                @error('name_bn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="num_of_mobile">@lang('Quantity of Mobile')<span style="color: red;"> *</span></label>
                                <input type="number"  id="num_of_mobile" name="num_of_mobile" onkeydown="removeSpecials(event)" value="{{old('num_of_mobile', $data->num_of_mobile)}}" class="form-control num_of_mobile @error('num_of_mobile') is-invalid @enderror" placeholder="@lang('Enter Quantity of Mobile')" autocomplete="off" maxlength="30">

                                @error('name_bn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>


                        @if($data->id)
                        <div class="form-group col-sm-4 mt-auto">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"  name="status" {{ $data->status == 1 ? 'checked' : '' }} value="1" class="custom-control-input" id="active-status">
                                <label class="custom-control-label" for="active-status">
                                    @if($data->status == 0)
                                    @lang('Make it active ?')
                                    @else
                                    @lang('Make it inactive ?')
                                    @endif
                                </label>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-right">
                                @if($data->id)
                                <button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
                                @else
                                <button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                @endif
                                <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                    <a href="{{route('admin.requisition.telephone_pabx_rights.index') }}">@lang('Back')</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--Form End-->
        </div>
    </div>
</div>
<script>
    function removeSpecials(evt) {
        var input = document.getElementById("room_bn");
        var patt = /[^\u0000-\u007F ]+/;
        setTimeout(function() {
            var value = input.value;
            if (patt.test(value) == false) {
                input.value = "";
            }
        }, 100);
    }
</script>



<script>
    $(document).ready(function(){
        $('#formSubmit').validate({
            ignore:[],
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            errorClass:'text-danger',
            validClass:'text-success',

        });

        jQuery.validator.addClassRules({
            'usertype' : {
                required : true,
            },
            'num_of_telephone' : {
                required : true,
            },
            'num_of_pabx' : {
                required : true,
            },
            'num_of_mobile' : {
                required : true,
            },
            
        });
    })
</script>
@endsection
