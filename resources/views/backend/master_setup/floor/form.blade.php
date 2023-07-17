@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('SongShod Bhaban Floor')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('SongShod Bhaban Floor')</li>
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
                        <h4 class="card-title">@lang('Update SongShod Bhaban Floor')</h4>
                    @else
                        <h4 class="card-title">@lang('Create SongShod Bhaban Floor')</h4>
                    @endif
                </div>
                <!-- Form Start-->
                <form id="formSubmit" name="formSubmit" method="POST"
                      @if($data->id)
                      action="{{ route('admin.master_setup.songshodFloor.update', $data->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    @else
                        action="{{ route('admin.master_setup.songshodFloor.store') }}">
                    @endif
                    @csrf

                    <input type="hidden" id="id" name="id" value="{{$data->id}}">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="block_id">@lang('Block No')<span style="color: red;"> *</span></label>
                                    <select id="block_id" name="block_id" class="form-control @error('block_id') is-invalid @enderror select2">
                                        <option value="">@lang('Select Block Number')</option>
                                        @foreach ($block as $list)
                                        @if($list->id==$data->block_id)
                                        <option selected value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                        @else
                                        <option value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
    
                                    @error('block_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Name (English)')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="name" name="name" value="{{old('name', $data->name)}}"
                                           class="form-control name @error('name') is-invalid @enderror"
                                           placeholder="@lang('Enter Name in English')" autocomplete="off" maxlength="30">

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="control-label" for="name_bn">@lang('Name (Bangla)')<span
                                            style="color: red;"> *</span></label>
                                    <input type="text" id="name_bn" onkeydown="removeSpecials(event)" name="name_bn" value="{{old('name_bn', $data->name_bn)}}"
                                           class="form-control name_bn @error('name_bn') is-invalid @enderror"
                                           placeholder="@lang('Enter Name in Bangla')" autocomplete="off" maxlength="30">

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
                                    <input type="checkbox" name="status" {{ $data->status == 1 ? 'checked' : '' }} value="1" class="custom-control-input" id="active-status">
                                    <label class="custom-control-label" for="active-status">@lang('Make it active ?')</label>
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
                                        <a href="{{route('admin.master_setup.songshodFloor.index') }}">@lang('Back')</a>
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
{{-- <script>
    function removeSpecials(evt) {
        var input = document.getElementById("name_bn");
        var patt = /[^\u0000-\u007F ]+/;
        setTimeout(function() {
            var value = input.value;
            if (patt.test(value) == false) {
                input.value = "";
            }
        }, 100);
    }
</script> --}}
<script>
    $(document).ready(function(){
		$('#formSubmit').validate({
			ignore:[],
			errorPlacement: function (error, element) {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element);
				}
			},
			errorClass:'text-danger',
			validClass:'text-success',

		});

		jQuery.validator.addClassRules({
			'name_bn' : {
				required : true,
				regex_bn:true,
			},
			'name' : {
				required : true,
				regex_en:true,
			},
			
		});
    })
</script>

@endsection
