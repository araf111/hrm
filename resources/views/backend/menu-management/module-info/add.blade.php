@extends('backend.layouts.app')
@section('content')
<style>
.custom-size .colorpicker-saturation {
	width: 250px;
	height: 250px;
}

.custom-size .colorpicker-hue,
.custom-size .colorpicker-alpha {
	width: 40px;
	height: 250px;
}

.custom-size .colorpicker-color,
.custom-size .colorpicker-color div {
	height: 40px;
}
</style>
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h4 class="card-title">@lang('User Module Management')</h4>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
					<li class="breadcrumb-item active">@lang('User Module Management')</li>
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
						@if(@$editData)
							<h4 class="card-title">@lang('Update User Module')</h4>
						@else
							<h4 class="card-title">@lang('Add User Module')</h4>
						@endif
						<a href="{{route('admin.menu-management.module-info.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list"></i> @lang('User Module List')</a>
					</div>
					<div class="card-body">
						<form id="submitForm">
							@csrf
							<div class="form-row">
								<div class="form-group col-sm-3">
									<label class="control-label">@lang('Name (English)')</label>
									<input type="text" name="name" id="name" value="{{ $editData->name ?? old('name') }}" class="form-control form-control-sm name" placeholder="@lang('Name (English)')">
								</div>
								<div class="form-group col-sm-3">
									<label class="control-label">@lang('Name (Bangla)')</label>
									<input type="text" name="name_bn" id="name_bn" value="{{ $editData->name_bn ?? old('name_bn') }}" class="form-control form-control-sm name_bn" placeholder="@lang('Name (Bangla)')">
								</div>
								<div class="form-group col-sm-3">
									<label class="control-label">@lang('Status')</label>
									<select name="status" id="status" class="form-control form-control-sm status select2">
										<option value="1" {{(@$editData->status == '1')?('selected'):''}}>@lang('Active')</option>
										<option value="0" {{(@$editData->status == '0')?('selected'):''}}>@lang('Inactive')</option>
									</select>
								</div>

								<div class="form-group col-md-3">
									<label class="control-label">@lang('Color')</label>
									<div class="input-group input-group-sm colorpicker-component">
										<input type="text" name="color" id="color" class="form-control form-control-sm color" value="{{!empty(@$editData->color) ? (@$editData->color) : ''}}" placeholder="@lang('Enter Color Code')" readonly>
										<div class="input-group-append">
											<span class="input-group-text" style="padding-bottom: 0px">
												<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
											</span>
										</div>
									</div>
								</div>
							</div>							
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group text-right">
										@if(@$editData->id)
										<button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
										@else
										<button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
										<button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
										@endif
										<button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
											<a href="{{route('admin.menu-management.module-info.list') }}">@lang('Back')</a>
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

<script>
	$(function () {
		$('.colorpicker-component').colorpicker({
              customClass: 'custom-size',
              sliders: {
                  saturation: {
                      maxLeft: 250,
                      maxTop: 250
                  },
                  hue: {
                      maxTop: 250
                  },
                  alpha: {
                      maxTop: 250
                  }
              }
          });
	});
</script>
<script>
	$(document).ready(function(){
		$('#submitForm').validate({
			ignore:[],
			errorPlacement: function(error, element){
				error.insertAfter(element);
			},
			errorClass:'text-danger',
			validClass:'text-success',

			submitHandler: function (form) {
				event.preventDefault();
				$('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
				var formInfo = new FormData($("#submitForm")[0]);
				$.ajax({
					url : "{{ isset($editData) ? route('admin.menu-management.module-info.update',$editData->id) : route('admin.menu-management.module-info.store') }}",
					data : formInfo,
					type : "POST",
					processData: false,
					contentType: false,
					beforeSend : function(){
						$('.preload').show();
					},
					success:function(data){
						if(data.status == 'success'){
							toastr.success("",data.message);
							$('.preload').hide();
							setTimeout(function(){
								location.replace("{{route('admin.menu-management.module-info.list')}}");
							}, 2000);
						}else{
							toastr.error("",data.message);
							$('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
							$('.preload').hide();
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
						$('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
						$('.preload').hide();
					}
				});
			}
		});

		jQuery.validator.addClassRules({
			'name' : {
				required : true,
				remote: {
					url: "{{route('admin.menu-management.module-info.duplicate-name-check')}}",
					type: "GET",
					data: {
						name: function(){return $("#name").val();},
						edit_data: function(){return "{{@$editData->id}}"}
					},
				},
			},
			'name_bn' : {
				required : true,
				regex_bn:true,
				remote: {
					url: "{{route('admin.menu-management.module-info.duplicate-name_bn-check')}}",
					type: "GET",
					data: {
						name: function(){return $("#name_bn").val();},
						edit_data: function(){return "{{@$editData->id}}"}
					},
				},
			}
		});
	});
</script>



@endsection