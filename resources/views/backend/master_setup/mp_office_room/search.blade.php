@extends('backend.layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('MP Office Room Management')</h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('MP Office Room Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        {{-- <div class="card-header text-right">
                            <a href="{{route('admin.master_setup.mp_office_room.create') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> @lang('Office Room Allotation')</a>
                        </div> --}}
                        <div class="card-body">
                            <div class="row">
                              <h5>@lang('Search by Block, Level or MP Name')</h5>                                
                            </div>
                            <div class="form-group row">
                              <div class="col-6">
                                  <div class="custom-control custom-switch pl-0">
                                    <div class="form-check d-inline-block">
                                        <input type="radio" class="form-check-input"
                                            id="radioSearchItem" onclick="searchBySongshodNoParty()" name="radioSearchItem" checked>
                                        <label class="form-check-label"
                                            for="radioSearchItem">@lang('Parliament No.')</label>
                                    </div>
                                      <!-- Group of material radios - option 1 -->
                                      <div class="form-check d-inline-block">
                                          <input type="radio" class="form-check-input"
                                              id="radioSearchItem" onclick="searchByBlockLevel()" name="radioSearchItem">
                                          <label class="form-check-label"
                                              for="radioSearchItem">@lang('Block & Level')</label>
                                      </div>

                                      <!-- Group of material radios - option 2 -->
                                      <div class="form-check d-inline-block">
                                          <input type="radio" class="form-check-input"
                                              id="radioSearchItem" onclick="searchByMp()" name="radioSearchItem">
                                              <input type="hidden" name="searchType" id="searchType" value="1">
                                          <label class="form-check-label"
                                              for="radioSearchItem">@lang('MP Name')</label>
                                      </div>

                                  </div>
                              </div>
                            </div>
                            <div class="row" id="parliamentParty">
                                <div class="col-3">
                                    <label class="control-label" for="date_to">@lang('1'). @lang('Parliament Session')<span class="text-danger"> *</span></label>
                                    <select name="parliament_session_id" id="parliament_session_id" readonly class="form-control select2" style="width:100%">
                                        <option value="">@lang('Parliament Session')</option>
                                        @foreach($parliamentSession as $s)
                                        <option value="{{$s->id}}">{{Lang::get($s->session_no)}}</option>
                                        @endforeach
                                    </select>                                
                                </div>
                                <div class="col-3">
                                    <label class="control-label" for="political_parties_id ">@lang('2').@lang('Political Party')</label><br>
                                    <select class="form-control" name="political_parties_id " id="political_parties_id">
                                        <option value="">@lang('Political Party')</option>
                                        @foreach ($politicalParties as $politicalParty)
                                            <option value="{{ $politicalParty->id }}">{{ Lang::get($politicalParty->name_bn) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <label for=""></label>
                                    <div class="form-group">
                                      <button type="button" class="btn btn-info" onClick="load_data()">@lang('Search')</button>
                                        <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="blockFloor" style="display: none">
                              <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                  <label class="control-label" for="ministry_id">@lang('1'). @lang('Select Block') <span class="text-danger"> *</span></label> <br>
                                  <select id="songshod_blocks_id" name="songshod_blocks_id" class="songshod_blocks_id form-control @error('songshod_blocks_id') is-invalid @enderror select2">
                                      <option value="">@lang('Select Block Number')</option>
                                      @foreach ($songshodBlock as $list)
                                      <option value="{{$list->id}}">{{(session()->get('language') =='bn')?$list->name_bn:$list->name}}</option>
                                      @endforeach
                                  </select>
                                  @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror       
                              </div>
                              <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                  <label class="control-label" for="ministry_id">@lang('2'). @lang('Select Floor') <span class="text-danger"> *</span></label> <br>
                                  <select id="songshod_floors_id" name="songshod_floors_id" class="songshod_floors_id form-control @error('songshod_floors_id') is-invalid @enderror select2">
                                      
                                  </select>
      
                                  @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror       
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6">
                                  <label for=""></label>
                                <div class="form-group">
                                  <button type="button" class="btn btn-info" onClick="load_data()">@lang('Search')</button>
                                    <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                </div>
                            </div>
                            </div>
                            <div class="row" id="MpName" style="display: none">
                                <div class="col-sm-3 form-group">
                                  <label class="control-label" for="ministry_id">@lang('1'). @lang('Select MP') <span class="text-danger"> *</span></label> <br>
                                    <select name="user_id" id="user_id" class="user_id @error('user_id') is-invalid @enderror form-control form-control-sm select2">
                                        <option value="">@lang('Select the Name')</option>
                                        @if (isset($profiles) && count($profiles) > 0)
                                        @foreach ($profiles as $data)
                                        @if($data->user_id == old('user_id'))
                                        <option selected value="{{ $data->user_id }}">
                                            @if(session()->get('language') =='bn')
                                            {{ $data->name_bn }}
                                            @else
                                            {{ $data->name_eng }}
                                            @endif
                                        </option>
                                        @else
                                        <option value="{{ $data->user_id }}">
                                            @if(session()->get('language') =='bn')
                                            {{ $data->name_bn }}
                                            @else
                                            {{ $data->name_eng }}
                                            @endif
                                        </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('user_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <label for=""></label>
                                    <div class="form-group">
                                      <button type="button" class="btn btn-info" onClick="load_data()">@lang('Search')</button>
                                        <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                    </div>
                                </div>        
                            </div>
                            <div class="row">
                                <div class="col-3" style="display: none">
                                    <select name="report_type" id="report_type" readonly class="form-control select2" style="width:100%">
                                        {{-- <option value="">@lang('Select Report Type')</option>
                                        @foreach($report_types as $r)
                                        <option value="{{$r['type']}}">{{$r['name']}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                              {{-- <div class="col-sm-12 col-md-12 col-lg-12">
                                  <div class="form-group text-right">
                                    <button type="button" class="btn btn-info" onClick="load_data()">@lang('Search')</button>
                                      <button type="reset" class="btn btn-danger btn-sm">@lang('Clear')</button>
                                  </div>
                              </div> --}}
                            </div>
                            {{-- <div class="row ">
                                <select class="form-control btn btn-primary" style="width: 15%" name="" id="">
                                    <option onClick="exportDoc()" value="">Doc Report</option>
                                    <option onClick="load_report(\'pdf\')" value="">PDF Report</option>
                                    <option onClick="exportExcel()" value="">Excel Report</option>
                                </select>
                            </div> --}}
                            <div id="list_container">
                              <table id="list_orders_table" class="table table-sm table-bordered table-striped">
                                  <thead>
                                      <tr>
                                        <th>@lang('Constituency Area No')</th>
                                        <th>@lang('Photo')</th>
                                        <th>@lang('MP Name')</th>
                                        <th>@lang('Constituency Area Name')</th>
                                        <th>@lang('Block, Level & Room No')</th>
                                        <th width="5%">@lang('Status')</th>  
                                      </tr>
                                  </thead>

                              </table>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#reportTypeSelcetion").on('change',function(){
                var reportType =  $(this).val();
                console.log("working");
                console.log(reportType);
            });
        })
    </script>
@endsection
@section('script')
   {{-- report pdf and doc  --}}
   <script>

    function load_report(type) {
            // console.log("pdf");

        if (type == 'pdf') {
            my_loader('start');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: "POST",
                crossDomain: true,
                data: JSON.stringify({
                    date: $('#reportrange').text().trim(),
                    doc_type: type,
                    rule_number: $("#rule_number").val(),
                    report_type: $("#report_type").val(),
                    //report_title: $("#report_type").text(),
                    parliament_session_id: $("#parliament_session_id").val()
                }),
                url: "{{url('/admin/master-setup/mp_office_room_report')}}",
                contentType: "application/json",
                success: function(data) {
                    const linkSource = data;
                    const downloadLink = document.createElement("a");
                    const fileName = $("#report_type").val() + "_" + Date() + ".pdf";
                    downloadLink.href = linkSource;
                    downloadLink.download = fileName;
                    downloadLink.click();
                    my_loader('stop');
                },
                error:function(res){
                    my_loader('stop');
                }

            });
        } else if (type == 'xlsx') {
            // console.log('xlsx');
            my_loader('start');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: "POST",
                crossDomain: true,
                data: JSON.stringify({
                    date: $('#reportrange').text().trim(),
                    doc_type: type,
                    rule_number: $("#rule_number").val(),
                    report_type: $("#report_type").val(),
                    //report_title: $("#report_type").text(),
                    parliament_session_id: $("#parliament_session_id").val()
                }),
                url: "{{url('/admin/master-setup/mp_office_room_report')}}",
                contentType: "application/json",
                success: function(data) {
                    const linkSource = data;
                    const downloadLink = document.createElement("a");
                    const fileName = $("#report_type").val() + "_" + Date() + ".pdf";
                    downloadLink.href = linkSource;
                    downloadLink.download = fileName;
                    downloadLink.click();
                    my_loader('stop');
                },
                error:function(res){
                    my_loader('stop');
                }

            });
        }else{
            my_loader('start');
            $.ajax({
                url: "{{url('/admin/notice-management/mp_office_room_report')}}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                    date: $('#reportrange').text().trim(),
                    doc_type: type,
                    // rule_number: $("#rule_number").val(),
                    report_type: $("#report_type").val(),
                    parliament_session_id: $("#parliament_session_id").val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == true) {
                        $('#list_container').html(response.data);
                        $("#list_table").DataTable({
                            destroy: true
                        });
                        my_loader('stop');
                    } else {
                        Swal.fire('@lang("No Data Found")', '', 'error');
                        $('#list_container').html('');
                        my_loader('stop');
                    }
                },
                error:function(res){
                    my_loader('stop');
                }
            });
        }

    }
</script>

<script>
    function exportDoc() {
        my_loader('start');
        $("#list_table_length").hide();
        $("#dataTables_filter").hide();
        $("#list_table_info").hide();
        $("#list_table_paginate").hide();
        var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' " +
            "xmlns:w='urn:schemas-microsoft-com:office:word' " +
            "xmlns='http://www.w3.org/TR/REC-html40'>" +
            "<head><meta charset='utf-8'><title>" + $("#report_type").val() + "</title></head><body>";
        var footer = "</body></html>";
        var sourceHTML = header + document.getElementById("list_container").innerHTML + footer;
        var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
        var fileDownload = document.createElement("a");
        document.body.appendChild(fileDownload);
        fileDownload.href = source;
        fileDownload.download = $("#report_type").val() + "_" + Date() + ".doc";
        fileDownload.click();
        document.body.removeChild(fileDownload);
        setTimeout(function() {
            $("#list_table_length").show();
            $("#dataTables_filter").show();
            $("#list_table_info").show();
            $("#list_table_paginate").show();
            my_loader('stop');
        }, 2000);
    }

    function tableToExcel() {
        // console.log("tableToExcel method is working");
        let table = "#list_orders_table";
        let name = "report.office_room_list";
        filename = "mp_office room";
        // console.log(table,name,filename);
        let uri = 'data:application/vnd.ms-excel;base64,';
        console.log(uri);
        var table2excel = new Table2Excel();
        table2excel.export(document.querySelectorAll("#list_orders_table"));
    }

</script>
   {{-- report pdf and doc  --}}

<script>
  function load_data() {
    var search_type = $("#searchType").val();
   var block_id = $('#songshod_blocks_id').val();
    var floor_id = $('#songshod_floors_id').val();
    console.log(block_id,floor_id);
    var mp_id = $('#user_id').val();
    var parliament_session_id = $('#parliament_session_id').val();
    var political_parties_id = $('#political_parties_id').val();
    let url;
    var url_data = {}

    if (search_type==2 && block_id>0) {
        url = "{{ url('/admin/master-setup/mp_office_room_search')}}";
        url_data = {
            type:'room',
            _token: "{{ csrf_token() }}",
            block_id: block_id,
            floor_id: floor_id
        };
    } else if(search_type==3) {
        url = "{{ url('/admin/master-setup/mp_office_room_search')}}";
        url_data = {
            type:'mp',
            _token: "{{ csrf_token() }}",
            mp_id: $('#user_id').val()
        };
        
    }else if(search_type==1){
        if(parliament_session_id > 0 && political_parties_id > 0){
            url = "{{ url('/admin/master-setup/mp_office_room_search')}}";
            url_data = {
                _token: "{{ csrf_token() }}",
                type:'session',
                parliament_session_id: parliament_session_id,
                political_parties_id: political_parties_id
            };

        }else if(parliament_session_id > 0 && political_parties_id==''){
            url = "{{ url('/admin/master-setup/mp_office_room_search')}}";
            url_data = {
                type:'session',
                _token: "{{ csrf_token() }}",
                parliament_session_id: parliament_session_id
            };
        }
    }else{
      // console.log(url);
    }
   if(url!=undefined){
        $('#list_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
        $.ajax({
        url: url,
        type: "POST",
        data: url_data,
        success: function(response) {
            response = JSON.parse(response);
            if (response.status == true) {
                $('#list_container').html(response.data);
                $("#list_orders_table").DataTable({

                });
            } else {
                //Swal.fire('@lang("No Data Found")', '', 'error');
                $('#list_container').html('');
            }
        }
    });
   }
   

}
</script>
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
    })
</script>
<script>
    function searchBySongshodNoParty() {
        $('#parliamentParty').show();
        $('#blockFloor').hide();
        $('#MpName').hide();
        console.log('searchBySongshodNoParty');
        $("#searchType").val(1);
    }
    function searchByBlockLevel(){
        $('#blockFloor').show();
        $('#parliamentParty').hide();
        $('#MpName').hide();
        //$("#songshod_blocks_id").val("");
        console.log("searchByBlockLevel");
        $("#searchType").val(2);
    };
    function searchByMp() {
        $('#MpName').show();
        $('#parliamentParty').hide();
        $('#blockFloor').hide();
        console.log("searchByMp");
        $("#searchType").val(3);
    }
</script>

@endsection