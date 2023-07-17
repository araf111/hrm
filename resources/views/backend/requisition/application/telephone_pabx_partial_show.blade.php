<div class="content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-info">
                <div class="card-header">
                    @lang('Applicant Info')
                </div>
                <div class="card-body">
                    <table id="other_records" class="table table-sm table-bordered table-striped">
                        <thead class="px-3">
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody class="px-3">
                            <tr>
                                <td>@lang('Applicant')</td>
                                <td>
                                    @php
                                        foreach($profileData as $p){
                                            if($p->user_id == $viewData->applicant_id){
                                                if(session()->get('language') == 'bn'){
                                                    echo digitDateLang($p->constituencyNumber) . ', '. $p->voter_area_bng . ', ' . $p->nameBng;
                                                }else{
                                                    echo digitDateLang($p->constituencyNumber) . ', '. $p->voter_area_Eng . ', ' . $p->nameEng;
                                                }
                                            }
                                        }
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('Connection Type')</td>
                                <td>
                                    @if ($viewData->connection_type == 1)
                                        @lang('Telephone')
                                    @else
                                        @lang('Pabx')
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('Connection Place')</td>
                                <td>
                                    @if ($viewData->connection_place == 1)
                                        @lang('Official')
                                    @else
                                        @lang('Residential')
                                    @endif
                                </td>
                            </tr>
                            @if ($viewData->connection_place == 1)
                                <tr>
                                    <td>@lang('Building')</td>
                                    <td>
                                        @if ($viewData->building_type == 1)
                                            @lang('SongShod Bhaban')
                                        @else
                                            @lang('Hostel Building')
                                        @endif
                                    </td>
                                </tr>
                            @endif

                            @isset($viewData->block_id)
                                <tr>
                                    <td>@lang('Block No')</td>
                                    <td>
                                        @foreach ($songshodBlock as $list)
                                        @if ($list->id == $viewData->block_id)
                                            {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                        @endif
                                    @endforeach
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->floor_id)
                                <tr>
                                    <td>@lang('Floor')</td>
                                    <td>
                                        @foreach ($songshodFloor as $list)
                                            @if ($list->id == $viewData->floor_id)
                                                {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->room_id)
                                <tr>
                                    <td>@lang('Office Room No')</td>
                                    <td>
                                        @foreach ($songshodRoom as $list)
                                            @if ($list->id == $viewData->room_id)
                                                {{ session()->get('language') == 'bn' ? $list->room_bn : $list->room }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->hostel_building)
                                <tr>
                                    <td>@lang('Building Name')</td>
                                    <td>
                                        @foreach ($hostelBuilding as $list)
                                        @if ($list->id == $viewData->hostel_building)
                                            {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                        @endif
                                    @endforeach
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->hblock_id)
                                <tr>
                                    <td>@lang('Floor No')</td>
                                    <td>
                                        @foreach ($hostelFloor as $list)
                                        @if ($list->id == $viewData->hblock_id)
                                            {{ session()->get('language') == 'bn' ? $list->name_bn : $list->name }}
                                        @endif
                                    @endforeach
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->hroom_id)
                                <tr>
                                    <td>@lang('Room')</td>
                                    <td>
                                        @foreach ($hostelRooms as $list)
                                        @if ($list->id == $viewData->hroom_id)
                                            {{ session()->get('language') == 'bn' ? $list->number_bn : $list->number }}
                                        @endif
                                    @endforeach
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->require_connection_place)
                                <tr>
                                    <td>@lang('Place')</td>
                                    <td>
                                        @if ($viewData->require_connection_place == 1)
                                            @lang('In the allotted flat in the Parliament building')
                                        @else
                                            @lang('At residence')
                                        @endif
                                    </td>
                                </tr>
                            @endisset

                            @isset($viewData->own_address)
                                <tr>
                                    <td>@lang('Address')</td>
                                    <td>{{ $viewData->own_address }}</td>
                                </tr>
                            @endisset

                            <tr>
                                <td>@lang('Would you like to cash the telephone allowance')</td>
                                <td>
                                    @if ($viewData->want_renew == 1)
                                        @lang('Yes')
                                    @else
                                        @lang('No')
                                    @endif
                                    
                                </td>
                            </tr>

                            <tr>
                                <td>@lang('Application Date')</td>
                                <td>{{ digitDateLang(nanoDateFormat($viewData->created_at)) }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-success">
                <div class="card-header">
                    @lang('Set Telephone/PABX No.')
                </div>
                <div class="card-body">
                    <div class="col-12">
                        @if(isset($telephone_pabx_consent_data) && count($telephone_pabx_consent_data)>0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('Serial')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Designation')</th>
                                    <th>@lang('Consent')</th>
                                    <th>@lang('Comments')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($telephone_pabx_consent_data as $d)
                                <tr>
                                    <td>{{digitDateLang($loop->iteration)}}</td>
                                    <td>{{ $d->user_name }} </td>
                                    <td>{{$d->role_name}}</td>
                                    <td> @if($d->user_consent==1) {!! ' <span class="badge badge-success px-2"> <i class="fa fa-check"></i> </span>'!!} @else {!! ' <span class="badge badge-danger px-2"><i class="fa fa-times"></i> </span>' !!} @endif </td>
                                    <td>{!! $d->note !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    @php
                        if( isset($telephone_pabx_number) ){

                            if($viewData->connection_type == 1){
                                $telephoneOrPabx_no = $telephone_pabx_number->num_of_telephone;
                            }else if($viewData->connection_type == 2){
                                $telephoneOrPabx_no = $telephone_pabx_number->num_of_pabx;
                            }
                            
                        } else{
                            $telephoneOrPabx_no = __('Number not seated');
                        }
                    @endphp

                    <form>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="telephoneOrPabx_no">@lang('Telephone/PABX No.')<span style="color: red;"> *</span></label>
                                    <input type="number" id="telephoneOrPabx_no" name="telephoneOrPabx_no" 
                                        value="{{ $telephoneOrPabx_no }}"
                                        class="form-control @error('telephoneOrPabx_no') is-invalid @enderror"
                                        disabled
                                        placeholder="{{ $telephoneOrPabx_no }}"
                                        autocomplete="off" maxlength="30">
                                        <span id="telephoneOrPabx_no_msg" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="stage_note">@lang('Send to Whom?') <span style="color: red;"> *</span></label>
                                    <select class="form-control select2" id="stage_number" name="stage_number">
                                        @if(isset($role_list) && count($role_list)>0)
                                        @foreach($role_list as $list)
                                        <option value="{{$list->stage}}" @if($list->stage == $viewData->stage_number) {{'selected="selected"'}} @endif>{{$list->name_bn}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="control-label" for="stage_note">@lang('Comments')</label>
                                    <textarea id="stage_note" rows="2" name="stage_note" class="form-control textareaWithoutImgVideo">
                                    {{isset($my_consent_data->note)? $my_consent_data->note : '' }}
                                    </textarea>
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-12 pb-4">
                            @if(authInfo()->usertype=='staff' && !isset($my_consent_data->user_consent) )
                                <div class="form-group">
                                    <p style="text-align:center;">
                                        <a class="btn btn-sm {{(isset($telephone_pabx_consent_data->user_consent) && $telephone_pabx_consent_data->user_consent==1)?'btn-info':'btn-secondary'}} consent_button" data-id="1">
                                            <i class="fa fa-check"> </i> @lang('Agree')
                                        </a>
                                        &nbsp; &nbsp;
                                        <a class="btn btn-sm {{(isset($telephone_pabx_consent_data->user_consent) && $telephone_pabx_consent_data->user_consent==0)?'btn-danger':'btn-secondary'}} consent_button" data-id="0">
                                            <i class="fa fa-times"> </i> @lang('Disagree')
                                        </a>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <button id="approvalBtn" onclick="giveConsent()" type="button" class="btn btn-success btn-sm" style="margin:0 auto;">@lang('Send')</button>
                                    </div>
                                </div>
                            @endif
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    // Remove extra space inside textarea
    $('document').ready(function() {
        $('textarea').each(function() {
            $(this).val($(this).val().trim());
        });
    });

    $(document).ready(function() {
        $(".consent_button").each(function() {
            $(this).on("click", function() {
                selected_consent = $(this).data('id');
                if (selected_consent == 1) {
                    $(this).removeClass('btn-secondary');
                    $(this).addClass('btn-info');
                    $('.consent_button').not(this).removeClass('btn-danger');
                    $('.consent_button').not(this).addClass('btn-secondary');
                }
                if (selected_consent == 0) {
                    $(this).removeClass('btn-secondary');
                    $(this).addClass('btn-danger');
                    $('.consent_button').not(this).removeClass('btn-info');
                    $('.consent_button').not(this).addClass('btn-secondary');
                }
            });
        });
    });

    function giveConsent() {
        var request_data = {};
        var _token = "{{csrf_token()}}";
        request_data = {
            _token: _token,
            type: 'stage_consent',
            id: "{{$viewData->id}}",
            telephoneOrPabx_no: $('#telephoneOrPabx_no').val(),
            total_stage: "{{$total_stage}}",
            stage_number: "{{ isset($my_consent_data->stage_number)? $my_consent_data->stage_number : $viewData->stage_number}}",
            user_consent: selected_consent,
            stage_note: $("#stage_note").val()
        };

        Swal.fire({
            title: '@lang("Are You Sure?")',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '@lang("Yes")',
            cancelButtonText: '@lang("No")'
        }).then((result) => {
            if (result.value) {

                var telephoneOrPabx_no = $('#telephoneOrPabx_no').val();

                if(telephoneOrPabx_no.length==0){
                    $('#telephoneOrPabx_no').addClass('focusedInput');
                    $('#telephoneOrPabx_no_msg').text('The Telephone/PABX Field is Required!');

                }else{

                    var url = "{{url('/requisition/telephone_pabx/setdata')}}";

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: request_data,
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire({
                                    title: '@lang("Your Consent has been sent")',
                                    type: 'success'
                                }).then((result) => {
                                    go_back();
                                });
                                location.replace("{{ url('/requisition/telephone_pabx/department') }}");
                            } else if(response == 'exist'){
                                Swal.fire('@lang("Entered Telephone/PABX Number Exist!")', '', 'error');
                            } else {
                                Swal.fire('@lang("Technical Problem!")', '', 'error');
                            }
                        }
                    });
                }
            }
        })
    }

    $('#telephoneOrPabx_no').on('keyup', function () {
        var telephoneOrPabx_no = $('#telephoneOrPabx_no').val();
        if(telephoneOrPabx_no.length > 0){
            $('#telephoneOrPabx_no_msg').text('');
        }
    });

</script>