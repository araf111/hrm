

    <style>
        .navbar-nav {
            display: inherit !important;
        }
        .header__btn {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            padding: 10px 20px;
            display: inline-block;
            margin-right: 10px;
            background-color: #fff;
            border: 1px solid #2c2c2c;
            border-radius: 3px;
            cursor: pointer;
            outline: none;
        }

        .header__btn:last-child {
            margin-right: 0;
        }

        .header__btn:hover,
        .header__btn.js-active {
            color: #fff;
            background-color: #2c2c2c;
        }

        .header {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }

        .header__title {
            margin-bottom: 30px;
            font-size: 2.1rem;
        }

        .content__title {
            margin-bottom: 40px;
            font-size: 20px;
            text-align: center;
        }

        .content__title--m-sm {
            margin-bottom: 10px;
        }

        .multisteps-form__progress {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
        }

        .multisteps-form__progress-btn {
            transition-property: all;
            transition-duration: 0.15s;
            transition-timing-function: linear;
            transition-delay: 0s;
            position: relative;
            padding-top: 20px;
            color: rgba(108, 117, 125, 0.7);
            text-indent: -9999px;
            border: none;
            background-color: transparent;
            outline: none !important;
            cursor: pointer;
        }

        @media (min-width:500px) {
            .multisteps-form__progress-btn {
                text-indent: 0;
            }
        }

        .multisteps-form__progress-btn:before {
            position: absolute;
            top: 0;
            left: 50%;
            display: block;
            width: 13px;
            height: 13px;
            content: '';
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            transition: all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            border: 2px solid currentColor;
            border-radius: 50%;
            background-color: #fff;
            box-sizing: border-box;
            z-index: 3;
        }

        .multisteps-form__progress-btn:after {
            position: absolute;
            top: 5px;
            left: calc(-50% - 13px / 2);
            transition-property: all;
            transition-duration: 0.15s;
            transition-timing-function: linear;
            transition-delay: 0s;
            display: block;
            width: 100%;
            height: 2px;
            content: '';
            background-color: currentColor;
            z-index: 1;
        }

        .multisteps-form__progress-btn:first-child:after {
            display: none;
        }

        .multisteps-form__progress-btn.js-active {
            color: #28a745;
            ;
        }

        .multisteps-form__progress-btn.js-active:before {
            -webkit-transform: translateX(-50%) scale(1.2);
            transform: translateX(-50%) scale(1.2);
            background-color: currentColor;
        }

        .multisteps-form__form {
            position: relative;
        }

        .multisteps-form__panel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            opacity: 0;
            visibility: hidden;
        }

        .multisteps-form__panel.js-active {
            height: auto;
            opacity: 1;
            visibility: visible;
        }

        .multisteps-form__panel[data-animation="scaleOut"] {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .multisteps-form__panel[data-animation="scaleOut"].js-active {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .multisteps-form__panel[data-animation="slideHorz"] {
            left: 50px;
        }

        .multisteps-form__panel[data-animation="slideHorz"].js-active {
            transition-property: all;
            transition-duration: 0.25s;
            transition-timing-function: cubic-bezier(0.2, 1.13, 0.38, 1.43);
            transition-delay: 0s;
            left: 0;
        }

        .multisteps-form__panel[data-animation="slideVert"] {
            top: 30px;
        }

        .multisteps-form__panel[data-animation="slideVert"].js-active {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            top: 0;
        }

        .multisteps-form__panel[data-animation="fadeIn"].js-active {
            transition-property: all;
            transition-duration: 0.3s;
            transition-timing-function: linear;
            transition-delay: 0s;
        }

        .multisteps-form__panel[data-animation="scaleIn"] {
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        .multisteps-form__panel[data-animation="scaleIn"].js-active {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        h5.multisteps-form__title {
            font-size: 16px;
        }

        .select2-container {
            padding-right: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            right: 6px;
        }

        .select2-container--default .select2-selection--single {
            border-color: #ddd;
        }
        .load-data .nav-pills .nav-link{
            background: #ddd;
            margin:0px 1px 0px 1px;
            border-radius: 0;
            font-family: 'nikosh', Poppins, sans-serif;
            transition: 0.5s;
        }
        .load-data .nav-pills .nav-link.active, .nav-pills .show>.nav-link{
            background: #33a264;
        }
        .load-data .nav-pills .nav-link:not(.active):hover{
            background: #33a264;
            color: #fff;
        }
        .select2-container {
            padding-right: 0 !important;
        }
        .select2.select2-container.select2-container--default{
            width: 100% !important;
        }

    </style>
<!-- <script src='js/jquery_ui.js' type='text/javascript'></script> -->

    @if (session()->get('language') == 'bn')
        <style>
            .custom-file-input:lang(en)~.custom-file-label::after {
                content: "ব্রাউজ";
            }

        </style>
    @else
        <style>
            .custom-file-input:lang(en)~.custom-file-label::after {
                content: "Browse";
            }

        </style>
    @endif

        <div class="col-md-12">
            <div class="myloader d-none"></div>
            <div class="card">
                <div class="card-header d-none">

                    <h4 class="card-title w-100">
                        @if (session()->get('language') == 'bn')
                            {{ isset($editData) ? $editData->nameBng : __('Parliament Member Information') }}
                        @else
                            {{ isset($editData) ? $editData->nameEng : __('Parliament Member Information') }}
                        @endif
                        <a href="{{ route('admin.profile-activities.v2profiles.index') }}"
                            class="btn btn-info float-right"><i class="fa fa-list mr-2"></i>
                            @lang('Parliament Member List')
                        </a>
                    </h4>
                </div>
                <div class="card-body overflow-hidden">

                    <div class="row ">
                        <div class="col-12 text-center">
                            <center>
                                @if (isset($editData->photo) && $editData->photo != '')
                                    {!! arrayToimage($editData->photo) !!}
                                @endif
                            </center>
                        </div>
                    </div>
                    <div class="clearfix">
                        &nbsp;
                    </div>


                    <div class="multisteps-form">
                        <!--progress bar-->
                        <div class="row">
                            <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
                                <div class="multisteps-form__progress">
                                    <button class="multisteps-form__progress-btn js-active" type="button"
                                        title="Personal Info">@lang('Personal Info')</button>
                                    <button class="multisteps-form__progress-btn" type="button"
                                        title="Family Info">@lang('Family Info')</button>
                                    <button class="multisteps-form__progress-btn" type="button"
                                        title="Educational Info">@lang('Educational Info')</button>
                                    <button class="multisteps-form__progress-btn" type="button"
                                        title="Training Info">@lang('Training Info')</button>
                                    <button class="multisteps-form__progress-btn" type="button"
                                        title="Login Info">@lang('Login Info')</button>
                                </div>
                            </div>
                        </div>
                        <!--form panels-->
                        <div class="row">
                            <div class="col-12 m-auto">
                                <form method="POST" enctype="multipart/form-data" id="profile_form"
                                    action="javascript:void(0)" class="multisteps-form__form">
                                    <!--Basic Info Panel-->
                                    <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active"
                                        data-animation="scaleIn">
                                        <div class="bg-success p-2">
                                            <h5 class="multisteps-form__title m-0">@lang('Personal Info')</h5>
                                        </div>
                                        <div class="multisteps-form__content">
                                            <div class="form-row mt-3">
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="nameBng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="nameBng"
                                                        value="{{ isset($editData) ? $editData->nameBng : '' }}"
                                                        placeholder="@lang('Enter Name in Bangla')" />
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="nameEng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="nameEng"
                                                        value="{{ isset($editData) ? $editData->nameEng : '' }}"
                                                        placeholder="@lang('Enter Name in English')" />
                                                </div>


                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="email"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="email"
                                                        value="{{ isset($editData) ? $editData->email : '' }}"
                                                        placeholder="@lang('Enter Email Address')" />
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <div class="input-group" data-target-input="nearest">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" style="padding: 4px;">
                                                                <span style="border-bottom-right-radius: 0; border-top-right-radius: 0;">+88</span>
                                                            </div>
                                                        </div>
                                                        <input type="number" min="0" inputmode="numeric" pattern="[0-9]*" 
                                                        id="personalMobile"
                                                        class="multisteps-form__input form-control form-control-sm formOnInput"
                                                        name="personalMobile"
                                                        value="{{ isset($editData) ? $editData->personalMobile : '' }}"
                                                        placeholder="@lang('Enter Personal Mobile Number')" >
                                                    </div>
                    
                                                    <span id="mobileMsg" class="text-danger"></span>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <div class="input-group" data-target-input="nearest">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" style="padding: 4px;">
                                                                <span style="border-bottom-right-radius: 0; border-top-right-radius: 0;">+88</span>
                                                            </div>
                                                        </div>
                                                        <input type="number" min="0" inputmode="numeric" pattern="[0-9]*" id="alternativeMobile"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        name="alternativeMobile"
                                                        value="{{ isset($editData) ? $editData->alternativeMobile : '' }}"
                                                        placeholder="@lang('Enter Alternative Mobile Number')" />
                                                    </div>
                    
                                                    <span id="alternativeMobileMsg" class="text-danger"></span>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="officePhoneNumber"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="officePhoneNumber"
                                                        value="{{ isset($editData) ? $editData->officePhoneNumber : '' }}"
                                                        placeholder="@lang('Enter Office Phone Number')" />
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="officePhoneExtension"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="officePhoneExtension"
                                                        value="{{ isset($editData) ? $editData->officePhoneExtension : '' }}"
                                                        placeholder="@lang('Enter Office Phone Extension')" />
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="faxNumber"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="faxNumber"
                                                        value="{{ isset($editData) ? $editData->faxNumber : '' }}"
                                                        placeholder="@lang('Enter Fax Number')" />
                                                </div>


                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="gender" id="gender"
                                                        class="form-control select2 @error('gender') is-invalid @enderror">
                                                        <option value="">@lang('Select Gender')</option>
                                                        <option
                                                            {{ isset($editData) && $editData->gender == 1 ? 'selected' : '' }}
                                                            value="1">@lang('Male')</option>
                                                        <option
                                                            {{ isset($editData) && $editData->gender == 2 ? 'selected' : '' }}
                                                            value="2">@lang('Female')</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="isMP" id="isMP"
                                                        class="form-control select2 @error('isMP') is-invalid @enderror">
                                                        <option value="">@lang('Is He/She MP?')</option>
                                                        <option
                                                            {{ isset($editData) && $editData->isMP == 1 ? 'selected' : '' }}
                                                            value="1">@lang('Yes')</option>
                                                        <option
                                                            {{ isset($editData) && $editData->isMP == 0 ? 'selected' : '' }}
                                                            value="0">@lang('No')</option>
                                                    </select>
                                                </div>
                                                {{-- <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <select name="designation_id" id="designation_id"
                                                    class="form-control form-control-sm select2 @error('designation_id') is-invalid @enderror">
                                                    {!! designationDropdown($editData->designation_id ?? '') !!}
                                                </select>
                                            </div> --}}
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="religion" id="religion"
                                                        class="form-control form-control-md select2">
                                                        {!! religionDropdown($editData->religion ?? '') !!}
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="merital_status" id=""
                                                        class="form-control form-control-sm select2">
                                                        {!! maritalStatusDropdown($editData->merital_status ?? '') !!}
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="parliamentNumber" id="parliamentNumber"
                                                        class="form-control form-control-sm select2 @error('parliamentNumber') is-invalid @enderror">
                                                        <option value="0">@lang("Select Parliament")</option>
                                                        @foreach($parliament_list as $p) 
                                                        <option value="{{$p->parliament_number}}" @if((isset($editData->parliamentNumber) && $editData->parliamentNumber==$p->parliament_number)) {{'selected="selected"'}} @endif>
                                                            {{ digitDateLang($p->parliament_number) }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @error('parliamentNumber')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="political_parties_id" id="political_parties_id"
                                                        class="form-control form-control-sm select2 @error('political_parties_id') is-invalid @enderror">
                                                        {!! politicalPartiesDropdown($editData->political_parties_id ?? '') !!}
                                                    </select>
                                                    @error('political_parties_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="constituency_id" id="constituency_id"
                                                        class="form-control form-control-sm select2 @error('constituency_id') is-invalid @enderror">
                                                        <option value="">@lang('Select Constituency')</option>
                                                    </select>
                                                    @error('constituency_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="freedomFighterInfo" id="freedomFighterInfo"
                                                        class="form-control form-control-sm select2 @error('freedomFighterInfo') is-invalid @enderror">
                                                        <option value="">@lang('Select Freedom Fighter Info')</option>
                                                        <option
                                                            {{ isset($editData) && $editData->freedomFighterInfo == 1 ? 'selected' : '' }}
                                                            value="1">@lang('Yes')</option>
                                                        <option
                                                            {{ isset($editData) && $editData->freedomFighterInfo == 0 ? 'selected' : '' }}
                                                            value="0">@lang('No')</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <select name="bloodGroup" id="bloodGroup"
                                                        class="form-control form-control-sm select2 @error('bloodGroup') is-invalid @enderror">
                                                        <option value="0">@lang('Select Blood Group')</option>
                                                        @foreach($bloodgroup_list as $blood)
                                                        <option  value="{{$blood['id']}}" @if(isset($editData) && $editData->bloodGroup == $blood['id']) {{ 'selected' }} @endif>@if(session()->get('language')=='bn'){{ $blood['name_bng'] }} @else{{ $blood['name_eng']}} @endif</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    {{-- <input id="dateOfBirth"
                                                        class="multisteps-form__input form-control form-control-sm datepicker_box readonly_date"
                                                        type="text" name="dateOfBirth"
                                                        value="{{ 
                                                        ($profileData->dateOfBirth!='' && $profileData->dateOfBirth!='0000-00-00')?digitDateLang(nanoDateFormat($profileData->dateOfBirth)):'' }}"
                                                        placeholder="@lang('Enter Date of Birth')" autocomplete="off" /> --}}
                                                        <input type="text" id="dateOfBirth" class="readonly_date nano_custom_date" name="dateOfBirth">
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="nidNumber" type="number" min="0" inputmode="numeric" pattern="[0-9]*" 
                                                        class="multisteps-form__input form-control form-control-sm"
                                                         name="nidNumber"
                                                        value="{{ isset($editData) ? $editData->nidNumber : '' }}"
                                                        placeholder="@lang('Enter NID Number')" />
                                                        <span id="nidMsg" class="text-danger"></span>
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="birthCertificateNumber"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="birthCertificateNumber"
                                                        value="{{ isset($editData) ? $editData->birthCertificateNumber : '' }}"
                                                        placeholder="@lang('Enter Birth Certificate Number')" />
                                                </div>


                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="passportNumber"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="passportNumber"
                                                        value="{{ isset($editData) ? $editData->passportNumber : '' }}"
                                                        placeholder="@lang('Enter Passport Number')" />
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    {{-- <input id="passportIssueDate"
                                                        class="multisteps-form__input form-control form-control-sm datepicker_box readonly_date"
                                                        type="text" name="passportIssueDate"
                                                        value="{{ (isset($editData) && $editData->passportIssueDate!='0000-00-00' ) ? $editData->passportIssueDate : '' }}"
                                                        placeholder="@lang('Enter Passport Issue Date')" /> --}}
                                                        <input type="text" id="passportIssueDate" class="readonly_date nano_custom_date" name="passportIssueDate" placeholder="@lang('Enter Passport Issue Date')">
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                   {{--  <input id="passportExpireDate"
                                                        class="multisteps-form__input form-control form-control-sm datepicker_box readonly_date"
                                                        type="text" name="passportExpireDate"
                                                        value="{{ (isset($editData) && $editData->passportExpireDate!='0000-00-00') ? $editData->passportExpireDate : '' }}"
                                                        placeholder="@lang('Enter Passport Expire Date')" /> --}}
                                                        <input type="text" id="passportExpireDate" class="readonly_date nano_custom_date" name="passportExpireDate" placeholder="@lang('Enter Passport Expire Date')">
                                                </div>

                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="identificationMark"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="identificationMark"
                                                        value="{{ isset($editData) ? $editData->identificationMark : '' }}"
                                                        placeholder="@lang('Enter Identification Mark')" />
                                                </div>

                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <textarea name="presentAddressBng"
                                                        class="multisteps-form__input form-control" id="presentAddressBng"
                                                        rows="3" placeholder="@lang('Enter Present Address in Bangla')">
                                                        {{ isset($editData) ? $editData->presentAddressBng : '' }}
                                                    </textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <textarea name="presentAddressEng"
                                                        class="multisteps-form__input form-control" id="presentAddressEng"
                                                        rows="3" placeholder="@lang('Enter Present Address in English')">
                                                        {{ isset($editData) ? $editData->presentAddressEng : '' }}
                                                    </textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <textarea name="permanentAddressBng"
                                                        class="multisteps-form__input form-control" id="permanentAddressBng"
                                                        rows="3" placeholder="@lang('Enter Permanent Address in Bangla')">
                                                        {{ isset($editData) ? $editData->permanentAddressBng : '' }}
                                                    </textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <textarea name="permanentAddressEng"
                                                        class="multisteps-form__input form-control" id="permanentAddressEng"
                                                        rows="3" placeholder="@lang('Enter Permanent Address in English')">
                                                        {{ isset($editData) ? $editData->permanentAddressEng : '' }}
                                                    </textarea>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                                    <textarea name="addressOfMP" class="multisteps-form__input form-control"
                                                        id="addressOfMP" rows="2"
                                                        placeholder="@lang('Enter Office Address')">
                                                        {{ isset($editData) ? $editData->addressOfMP : '' }}
                                                    </textarea>
                                                </div>


                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="professionOfMP" class="multisteps-form__input form-control"
                                                        type="text" name="professionOfMP"
                                                        value="{{ isset($editData) ? $editData->professionOfMP : '' }}"
                                                        placeholder="@lang('Enter Profession')" />
                                                </div>
                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <input id="height" class="multisteps-form__input form-control"
                                                        type="text" name="height"
                                                        value="{{ isset($editData) ? $editData->height : '' }}"
                                                        placeholder="@lang('Enter Height')" />
                                                </div>

                                                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" name="photo" class="custom-file-input"
                                                            id="customFile">
                                                        <label class="custom-file-label" for="customFile">@lang('Choose
                                                            Photo')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="button-row d-flex mt-4">
                                                <button class="btn btn-info ml-auto js-btn-next" type="button" id="first_step_button"
                                                    title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Family Info Panel-->
                                    <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                        data-animation="scaleIn">
                                        <div class="bg-success p-2">
                                            <h5 class="multisteps-form__title m-0">@lang('Family Info')</h5>
                                        </div>
                                        <div class="multisteps-form__content">
                                            <div class="form-row mt-3">
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <input id="fatherNameBng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="fatherNameBng"
                                                        value="{{ isset($editData) ? $editData->fatherNameBng : '' }}"
                                                        placeholder="@lang('Enter Father Name in Bangla')" />
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <input id="fatherNameEng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="fatherNameEng"
                                                        value="{{ isset($editData) ? $editData->fatherNameEng : '' }}"
                                                        placeholder="@lang('Enter Father Name in English')" />
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <input id="motherNameBng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="motherNameBng"
                                                        value="{{ isset($editData) ? $editData->motherNameBng : '' }}"
                                                        placeholder="@lang('Enter Mother Name in Bangla')" />
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <input id="motherNameEng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="motherNameEng"
                                                        value="{{ isset($editData) ? $editData->motherNameEng : '' }}"
                                                        placeholder="@lang('Enter Mother Name in English')" />
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <input id="spouseNameBng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="spouseNameBng"
                                                        value="{{ isset($editData) ? $editData->spouseNameBng : '' }}"
                                                        placeholder="@lang('Enter Spouse Name in Bangla')" />
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                    <input id="spouseNameEng"
                                                        class="multisteps-form__input form-control form-control-sm"
                                                        type="text" name="spouseNameEng"
                                                        value="{{ isset($editData) ? $editData->spouseNameEng : '' }}"
                                                        placeholder="@lang('Enter Spouse Name in English')" />
                                                </div>
                                            </div>

                                            <div class="button-row d-flex mt-4">
                                                <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i
                                                        class="fa fa-angle-left"></i> @lang('Previous')</button>
                                                <button class="btn btn-info ml-auto js-btn-next" type="button"
                                                    title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Educational Info Panel-->
                                    <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                        data-animation="scaleIn">
                                        <div class="bg-success p-2">
                                            <h5 class="multisteps-form__title m-0">@lang('Educational Info')</h5>
                                        </div>
                                        <div class="multisteps-form__content">
                                            {{-- <div class="form-row mt-3">
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="ssc" class="multisteps-form__input form-control form-control-sm" type="text" name="ssc" placeholder="@lang('SSC')"/>
                                            </div>
                                        </div> --}}
                                            <div class="button-row d-flex mt-4 col-12">
                                                <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i
                                                        class="fa fa-angle-left"></i> @lang('Previous')</button>
                                                <button class="btn btn-info ml-auto js-btn-next" type="button"
                                                    title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Training Info Panel-->
                                    <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                        data-animation="scaleIn">
                                        <div class="bg-success p-2">
                                            <h5 class="multisteps-form__title m-0">@lang('Training Info')</h5>
                                        </div>
                                        <div class="multisteps-form__content">
                                            <div class="form-row mt-3">
                                                {{-- <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="Others" class="multisteps-form__input form-control form-control-sm" type="text" name="Others" placeholder="@lang('Others')"/>
                                            </div> --}}
                                            </div>
                                            <div class="button-row d-flex mt-4">
                                                <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i
                                                        class="fa fa-angle-left"></i> @lang('Previous')</< /button>
                                                    <button class="btn btn-success ml-auto" type="submit"
                                                        title="Send">@lang('Submit')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--Login Info Panel-->
                                <div class="multisteps-form__panel shadow p-4 rounded bg-white"
                                data-animation="scaleIn">
                                <div class="bg-success p-2">
                                    <h5 class="multisteps-form__title m-0">@lang('Login Info')</h5>
                                </div>
                                <div class="multisteps-form__content">
                                    <div class="form-row mt-3">
                                        <div class="form-group col-sm-6">
                                            <input type="hidden" value="{{($userInfo!='')?$userInfo->id:0}}" id="user_id" name="user_id">
                                            <label class="control-label">@lang('Password') <span
                                                    style="color: red">*</span></label>
                                            <input type="password" name="password" id="password" value=""
                                                class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                placeholder="@lang('Enter Password')" autocomplete="off">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="control-label">@lang('Confirm Password') <span
                                                    style="color: red">*</span></label>
                                            <input type="password" name="confirm_password" value=""
                                                class="form-control form-control-sm @error('confirm_password') is-invalid @enderror"
                                                placeholder="@lang('Enter Confirm Password')"
                                                autocomplete="off">
                                            @error('confirm_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-success ml-auto" type="button" title="Save Password" onclick="save_password()">@lang('Save')</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <script>
        $(function() {
            var start = moment(); //.subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                @if(session()->get('language')=='bn')
                $('#dateOfBirth span').html(nanoLangTranslate(start.format('D-MM-YYYY')));
                @else
                $('#dateOfBirth span').html(start.format('D-MM-YYYY'));
                @endif
            }

            $('#dateOfBirth').daterangepicker({
                showDropdowns: true,
                startDate: "{{ (isset($editData->dateOfBirth) && $editData->dateOfBirth!='' && $editData->dateOfBirth!='0000-00-00')?date('d-m-Y',strtotime($editData->dateOfBirth)):date('d-m-Y') }}",
                //endDate: end,
                minDate:"{{ date('d-m-Y',strtotime('1920-01-01'))}}",
                maxDate:"{{ date('d-m-Y')}}",
                singleDatePicker: true,
                locale: daterange_locale,
                //ranges: daterange_ranges
            }, cb);
            cb(start, end);

            var start_passportIssueDate = moment(); //.subtract(29, 'days');
            var end_passportIssueDate = moment();

            function cb(start, end) {
                @if(session()->get('language')=='bn')
                $('#passportIssueDate span').html(nanoLangTranslate(start.format('D-MM-YYYY')));
                @else
                $('#passportIssueDate span').html(start.format('D-MM-YYYY'));
                @endif
            }

            $('#passportIssueDate').daterangepicker({
                showDropdowns: true,
                startDate: "{{ (isset($editData->passportIssueDate) && $editData->passportIssueDate!='' && $editData->passportIssueDate!='0000-00-00')?date('d-m-Y',strtotime($editData->passportIssueDate)):date('d-m-Y') }}",
                //endDate: end,
                minDate:"{{ date('d-m-Y',strtotime('1920-01-01'))}}",
                maxDate:"{{ date('d-m-Y')}}",
                singleDatePicker: true,
                locale: daterange_locale,
                //ranges: daterange_ranges
            }, cb);
            cb(start_passportIssueDate, end_passportIssueDate);

            var start_passportExpireDate = moment(); //.subtract(29, 'days');
            var end_passportExpireDate = moment();

            function cb(start, end) {
                @if(session()->get('language')=='bn')
                $('#passportExpireDate span').html(nanoLangTranslate(start.format('D-MM-YYYY')));
                @else
                $('#passportExpireDate span').html(start.format('D-MM-YYYY'));
                @endif
            }

            $('#passportExpireDate').daterangepicker({
                showDropdowns: true,
                startDate: "{{ (isset($editData->passportExpireDate) && $editData->passportExpireDate!='' && $editData->passportExpireDate!='0000-00-00')?date('d-m-Y',strtotime($editData->passportExpireDate)):date('d-m-Y') }}",
                //endDate: end,
                //minDate:"{{ date('d-m-Y',strtotime('1920-01-01'))}}",
                //maxDate:"{{ date('d-m-Y')}}",
                singleDatePicker: true,
                locale: daterange_locale,
                //ranges: daterange_ranges
            }, cb);
            cb(start_passportExpireDate, end_passportExpireDate);


            $("#empId").select2({
                //tags: true
            });
        })

        $(function(){
            $('#personalMobile').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#mobileMsg').text('@lang("The Mobile Number Should be 11 Digit")'); 
                }
                if (val.length >= 10) {
                    $('#mobileMsg').text(''); 
                }
                if( val.length>10 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });
            
            $('#alternativeMobile').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length>0 && val.length<11) {
                    $('#alternativeMobileMsg').text('@lang("The Mobile Number Should be 11 Digit")'); 
                }
                if (val.length==0 || val.length==11) {
                    $('#alternativeMobileMsg').text(''); 
                }
                if( val.length>10 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });

            $('#nidNumber').keydown(function(e){
                var $this = $(this);
                var val = $this.val();
                if (val.length >= 0) {
                    $('#nidMsg').text('@lang("The NID Number Should be 10-17 Digit")'); 
                }
                if (val.length >= 10) {
                    $('#nidMsg').text(''); 
                }
                if( val.length>17 && e.keyCode != 8 ){        
                    e.preventDefault();
                }
            });

            $("#first_step_button").click(function(){
                var personal_mobile = $("#personalMobile").val();
                var alternative_mobile = $("#alternativeMobile").val();
                var nid_number = $("#nidNumber").val();
                if(personal_mobile.length>0 && personal_mobile.length<11){
                    $('#mobileMsg').text('@lang("The Mobile Number Should be 11 Digit")'); 
                    return false;
                }
                else if(alternative_mobile.length>0 && alternative_mobile.length<11){
                    $('#alternativeMobileMsg').text('@lang("The Mobile Number Should be 11 Digit")');
                    return false;
                }
                else if(nid_number.length>0 && nid_number.length<10){
                    $('#nidMsg').text('@lang("The NID Number Should be 10-17 Digit")');
                    return false;
                }
                console.log(personal_mobile.length+'/'+alternative_mobile.length+'/'+nid_number.length);
            });
        })
        //$(function() {
            //document.getElementById("employee_div").style.display = "none"
            //document.getElementById("parlament_div").style.display = "none"
            var division_id = $('#division_id').val();
            var district_id = "{{ $editData->district_id ?? 'null' }}";
            var constituency_id = "{{ $editData->constituency_id ?? 'null' }}";

            $(document).ready(function(){
                $(".readonly_date").keypress(function(e) {
                return false;
                });
                $(".readonly_date").keydown(function(e) {
                    return false;
                });
              
               /*  $('.datepicker_box').datepicker({
                    format: 'dd-mm-yyyy',
                    language:'bn'
                    //ignoreReadonly: true,
                    //useCurrent: false,
                }); */
            });


            if (division_id) {
                getDistrictByDivision(division_id);
            }

            $(document).on('change', '#division_id', function() {
                var division_id = $(this).val();
                getDistrictByDivision(division_id);
            });


            function getDistrictByDivision(division_id) {
                $.ajax({
                    url: "{{ route('districtListByDivisionId') }}",
                    data: {
                        division_id: division_id
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var output = '<option value="">Select District</option>';
                        $.each(response.data, function(k, val) {
                            output += '<option value="' + val.id + '">' + val.name + '</option>'
                        });
                        $('select[name="district_id"]').html(output);
                        if (district_id) {
                            $('#district_id').val(district_id).trigger('change');
                        }
                    }
                });
            }

            $(document).on('change', '#district_id', function() {
                var district_id = $(this).val();
                getConstituencyByDistrict(district_id);
            });

            function getConstituencyByDistrict(district_id) {
                $.ajax({
                    url: "{{ route('constituenciesListByDistrictId') }}",
                    data: {
                        district_id: district_id
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var output = '<option value="">Select constituency</option>';
                        $.each(response.data, function(k, val) {
                            output += '<option value="' + val.id + '">' + val.name + '</option>'
                        });
                        $('select[name="constituency_id"]').html(output);
                        if (constituency_id) {
                            $('#constituency_id').val(constituency_id).trigger('change');
                        }
                    }
                });
            }
        //});
    </script>
    <script>
       // $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $('#profile_form').submit(function(e) {
                e.preventDefault();
                my_loader('start');
                var formData = new FormData(this);
                formData.set('dateOfBirth', nanoLangTranslate(formData.get('dateOfBirth'),'en'));
                formData.set('personalMobile', nanoLangTranslate(formData.get('personalMobile'),'en'));
                //console.log(formData.get('dateOfBirth'));
                formData.append('profileID', "{{$editData->profileID}}");
                $.ajax({
                    type: 'POST',
                    url: "{{ url('profile-activities/updateprofile') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        data = JSON.parse(data);
                        if (data.status) {
                            my_loader('stop');
                            Swal.fire({
                                text: '@lang("Data Updated Successfully")',
                                type: 'success'
                            }).then((result) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('something went wrong', '', 'error');
                            my_loader('stop');
                        }
                    },
                    error: function(data) {
                        Swal.fire('something went wrong', '', 'error');
                        my_loader('stop');
                    }
                });

            });
        //});

        function save_password() {
            my_loader('start');
            $.ajax({
                url: "{{ url('/changepassword') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $('#user_id').val(),
                    password: $("#password").val()
                },
                success: function(response) {
                    my_loader('stop');
                    response = JSON.parse(response);
                    if (response.status == true) {
                        Swal.fire(response.message, '', 'success');
                    } else {
                        Swal.fire(response.message, '', 'warning');
                    }
                },
                error:function(res){
                    my_loader('stop');
                }
            });

        }
    </script>
