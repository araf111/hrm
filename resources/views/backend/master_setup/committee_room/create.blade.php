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
<div class="container-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title w-100">
                    <a href="{{ route('admin.master_setup.committee_room.index') }}" class="btn btn-info float-right"><i class="fa fa-list mr-2"></i> @lang('Committee Room List')</a>
                </h4>
                <h5>@lang('Add Committee Room')</h5>
            </div>
            <div class="card-body">
                <form id="standingCommitteeForm" class="form-horizontal" action="{{route('admin.master_setup.committee_room.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="" class="control-label">@lang('1'). @lang('Enter Committee Room Name (BN)')<span class="text-danger"> *</span></label>
                            <input id="name_bn" type="text" name="name_bn" placeholder="@lang('Enter Committee Room Name (BN)')" class="form-control name_bn form-control-sm @error('name_bn') is-invalid @enderror" value="{{old('name_bn')}}" >  

                            @error('name_bn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror    
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="" class="control-label">@lang('2'). @lang('Enter Committee Room Name (EN)')<span class="text-danger"> *</span></label>
                            <input id="name_en" type="text" name="name_en" placeholder="@lang('Enter Committee Room Name (EN)')" class="form-control name_en form-control-sm @error('name_en') is-invalid @enderror" value="{{old('name_bn')}}">  
                            @error('name_en')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror       
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="house_buildings_id">@lang('3'). @lang('Bulding Name') <span class="text-danger"> *</span></label>
                           <input id="house_buildings_id" name="house_buildings_id" class="form-control form-control-sm @error('house_buildings_id') is-invalid @enderror" type="text" value="@lang('Parliament Building')" readonly> 
                           @error('house_buildings_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror  

                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="songshod_blocks_id">@lang('4'). @lang('Select Block') <span class="text-danger"> *</span></label>
                            <select id="songshod_blocks_id" name="songshod_blocks_id" class="songshod_blocks_id form-control @error('songshod_blocks_id') is-invalid @enderror select2">
                                <option value="">@lang('Select Block Number')</option>
                                @foreach ($songshodBlock as $list)
                                    @if($list->id == old('songshod_blocks_id'))
                                        <option selected value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                    @else
                                        <option value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                    @endif
                                @endforeach
                            </select>

                            @error('songshod_blocks_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="songshod_floors_id">@lang('5'). @lang('Select Floor') <span class="text-danger"> *</span></label>
                            <select id="songshod_floors_id" name="songshod_floors_id" class="songshod_floors_id form-control @error('songshod_floors_id') is-invalid @enderror select2">
                                
                            </select>

                            @error('songshod_floors_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="songshod_rooms_id">@lang('6'). @lang('Select Room Number') <span class="text-danger"> *</span></label>
                            <select id="songshod_rooms_id" name="songshod_rooms_id" class="songshod_rooms_id form-control @error('songshod_rooms_id') is-invalid @enderror select2">
                                
                            </select>

                            @error('songshod_rooms_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror       
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="form-group col-sm-3">
                            <label class="control-label" for="telephone">@lang('3'). @lang('Telephone No') <span class="text-danger"> *</span></label>
                            <input type="text" name="telephone" id="telephone" class="telephone form-control @error('telephone') is-invalid @enderror" value="{{old('telephone')}}" readonly>
                            @error('telephone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror        
                        </div>
                        <div class="form-group col-sm-3">
                            <label class="control-label" for="pabx">@lang('3'). @lang('PABX No') <span class="text-danger"> *</span></label>
                            <input type="text" name="pabx" id="pabx" class="pabx form-control @error('pabx') is-invalid @enderror" value="{{old('pabx')}}" readonly>
                            @error('pabx')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror 
                        </div> --}}
                        {{-- <div class="form-group col-sm-2">
                            <label class="control-label" for="date_to">@lang('6'). @lang('Committee Status')</label>
                            <select name="status" id="status" class="form-control form-control-sm">                          
                                <option value="1">@lang('Active')</option>
                                <option value="0">@lang('Inactive')</option>                                      
                            </select>                             
                        </div> --}}
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success btn-sm">@lang('Submit')</button>
                                <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                    <a href="{{ route('admin.master_setup.committee_room.index') }}">@lang('Back')</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $("#songshod_blocks_id").on('change', function() {
            if ($(this).val() == '') {
                $('#songshod_floors_id').html('');
            } else {
                var url = "{{url('/admin/master-setup/committee_room/floor')}}"+'/'+$(this).val();
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {
                        $('#songshod_floors_id').html('');
                        if (response !== '') {
                            $('#songshod_floors_id').append(response);
                        }
                    }
                });
            }

        });
        $("#songshod_floors_id").on('change', function() {
            if ($(this).val() == '') {
                $('#songshod_rooms_id').html('');
            } else {
                var url = "{{url('/admin/master-setup/committee_room/room')}}/"+$('#songshod_blocks_id').val()+"/"+$(this).val() ;
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {
                        $('#songshod_rooms_id').html('');
                        if (response !== '') {
                            $('#songshod_rooms_id').append(response);
                        }
                    }
                });
            }

        });
        $("#songshod_rooms_id").on('change', function() {
            if ($(this).val() == '') {
            } else {
                var url = "{{url('/admin/master-setup/committee_room/phonepabx')}}/"+$('#songshod_blocks_id').val()+"/"+ $('#songshod_floors_id').val()+"/"+$(this).val() ;
                $.ajax({
                    url: url,
                    type: "GET",
                    // data: request_data,
                    success: function(response) {             
                    //    console.log(response);
                        response = JSON.parse(response);
                        if (response !== '') {
                            $('#telephone').val(response.phone);
                            $('#pabx').val(response.pabx);
                        }
                    }
                });
            }

        });

        $('#standingCommitteeForm').validate({
            ignore:[],
            errorPlacement: function(error, element){
                error.insertAfter(element);
            },
            errorClass:'text-danger',
            validClass:'text-success',

        });

        jQuery.validator.addClassRules({
            'name_bn' : {
                required : true,
                regex_bn:true,
            },
            'name_en' : {
                required : true,
                regex_en:true,
            },
            
        });

    })
</script>

@endsection
