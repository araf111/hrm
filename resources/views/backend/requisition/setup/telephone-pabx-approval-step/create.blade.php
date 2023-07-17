@extends('backend.layouts.app')
@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				@if(count(@$editData))
				<h4 class="card-title">@lang('Update Telephone/PABX Approval Stage')</h4>
				@else
				<h4 class="card-title">@lang('Add Telephone/PABX Approval Stage')</h4>
				@endif
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
					<li class="breadcrumb-item active">@lang('Telephone/PABX Approval Stage')</li>
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
						<a href="{{route('admin.requisition.telephone_pabx_approval_steps.index') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Stage List')</a>
					</div>
					<div class="card-body">
						<form id="submitForm">
							@csrf
							<div id="add_extra_div">
								@if(!count(@$editData))
								<div class="remove_extra_div">
									<div class="row">
										<div class="form-group col-sm-3">
											<label class="control-label">@lang('User Role')</label>
											<select name="role_id[1]" class="form-control form-control-sm role_id select2">
												<option value="">@lang('Select Role')</option>	
												@foreach($roles as $list)
												<option value="{{$list->id}}">{{(session()->get('language')=='bn')?($list->name_bn):$list->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-sm-3">
											<label class="control-label">@lang('Status')</label>
											<select name="status[1]" class="form-control form-control-sm status select2">
												<option value="1">@lang('Active')</option>
												<option value="0">@lang('Inactive')</option>
											</select>
										</div>
										<div class="form-group col-md-2" style="padding-top: 30px;">  
											<i class="btn btn-info fa fa-plus-circle add_extra"></i>
										</div>
									</div>							
								</div>
								@else
								@foreach($editData as $key => $data)
								<div class="remove_extra_div">  
									<div class="row">
										<div class="form-group col-sm-3">
											<select name="role_id[{{$key}}]" class="form-control form-control-sm role_id select2">
												<option value="">@lang('Select Role')</option>	
												@foreach($roles as $list)
												<option value="{{$list->id}}" {{($data->role_id == $list->id)?('selected'):''}}>{{(session()->get('language')=='bn')?($list->name_bn):$list->name}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-sm-3">
											<select name="status[{{$key}}]" class="form-control form-control-sm status select2">
												<option value="1" {{($data->role_id == 1)?('selected'):''}}>@lang('Active')</option>
												<option value="0" {{($data->role_id == 0)?('selected'):''}}>@lang('Inactive')</option>
											</select>
										</div>
										<div class="form-group col-md-2">  
											<i class="btn btn-info fa fa-plus-circle add_extra"></i>  
											@if($key != 0)
											<i class="btn btn-danger fa fa-minus-circle remove_extra"> </i>  
											@endif
										</div>  
									</div>							   
								</div> 
								@endforeach
								@endif
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group text-right">
										@if(count(@$editData))
										<button type="submit" class="btn btn-success btn-sm">@lang('Update')</button>
										@else
										<button type="submit" class="btn btn-success btn-sm">@lang('Save')</button>
										<button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
										@endif
										<button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
											<a href="{{route('admin.requisition.telephone_pabx_approval_steps.index') }}">@lang('Back')</a>
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


<script id="extra_templete" type="text/x-handlebars-template">  
	<div class="remove_extra_div">  
		<div class="row">
			<div class="form-group col-sm-3">
				<select name="role_id[@{{counter}}]" class="form-control form-control-sm role_id select2">
					<option value="">@lang('Select Role')</option>	
					@foreach($roles as $list)
					<option value="{{$list->id}}">{{(session()->get('language')=='bn')?($list->name_bn):$list->name}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group col-sm-3">
				<select name="status[@{{counter}}]" class="form-control form-control-sm status select2">
					<option value="1">@lang('Active')</option>
					<option value="0">@lang('Inactive')</option>
				</select>
			</div>
			<div class="form-group col-md-2">  
				<i class="btn btn-info fa fa-plus-circle add_extra"></i>  
				<i class="btn btn-danger fa fa-minus-circle remove_extra"> </i>  
			</div>  
		</div>							   
	</div>  
</script> 

<script type="text/javascript">  
	$(document).ready(function(){  
		var counter = '10000';  
		$(document).on("click",".add_extra",function(){  
			var source = $("#extra_templete").html();  
			var template = Handlebars.compile(source);   
			var data= {counter:counter};   
			var html = template(data);   
			counter ++;  
			$("#add_extra_div").append(html);  
			$('.select2').select2(); 
		});   

		$(document).on("click", ".remove_extra", function (event) {  
			$(this).closest(".remove_extra_div").remove();         
		});   
	});   
</script> 

<script>
	$(document).ready(function(){
		$('#submitForm').validate({
			ignore:[],
			errorPlacement: function(error, element){
				if(element.hasClass("role_id")){error.insertAfter(element.next()); }
				else if(element.hasClass("status")){error.insertAfter(element.next()); }
				else{error.insertAfter(element);}
			},
			errorClass:'text-danger',
			validClass:'text-success',

			submitHandler: function (form) {
				event.preventDefault();
				$('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
				var formInfo = new FormData($("#submitForm")[0]);
				$.ajax({
					url : "{{route('admin.requisition.telephone_pabx_approval_steps.store')}}",
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
								location.replace(data.reload_url);
							}, 2000);
						}else if(data.status == 'error'){
							toastr.error("",data.message);
							$('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
							$('.preload').hide();
						}else{
							toastr.error('দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান ', {globalPosition: 'top right',className: 'error',autoHideDelay:10000});
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
			'role_id' : {
				required : true
			},
			'status' : {
				required : true
			}
		});
	});
</script>



@endsection