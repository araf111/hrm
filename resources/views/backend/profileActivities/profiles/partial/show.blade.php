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

    </style>
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->
    <div class="col-sm-12">
        <div class="card pt-5">
            <div class="multisteps-form">
                <div class="row ">
                    <div class="col-12 text-center">
                        <center>
                            {!! $profileData->photo !!}
                        </center>

                    </div>
                </div>
                <div class="clearfix">
                    &nbsp;
                </div>
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
                        </div>
                    </div>
                </div>
                <!--form panels-->
                <div class="row">
                    <div class="col-12 m-auto">
                        <form method="POST" enctype="multipart/form-data" id="profile_form" action="javascript:void(0)"
                            class="multisteps-form__form">
                            <!--Basic Info Panel-->
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active"
                                data-animation="scaleIn">
                                <div class="bg-success p-2">
                                    <h5 class="multisteps-form__title m-0">@lang('Personal Info')</h5>
                                </div>
                                <div class="multisteps-form__content mt-3">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="39%">@lang('1'). @lang('Name (Bangla)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->nameBng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('3'). @lang('Email')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->email }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('5'). @lang('Alternative Mobile')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ digitDateLang($profileData->alternativeMobile) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('7'). @lang('Office Phone Extension')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ digitDateLang($profileData->officePhoneExtension) }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th width="39%">@lang('9'). @lang('Gender')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            @if ($profileData->gender == 1)
                                                                @lang('Male')
                                                            @elseif ($profileData->gender==2)
                                                                @lang('Female')
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('11'). @lang('Religion')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->religion_text }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('13'). @lang('Parliament')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->parliament_number }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('15'). @lang('Constituency')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->voter_area }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('17'). @lang('Blood Group')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->bloodGroup_text }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('19'). @lang('NID Number')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ digitDateLang($profileData->nidNumber) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('21'). @lang('Passport Number')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->passportNumber }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('23'). @lang('Passport Expiry Date')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ ($profileData->passportExpireDate!='' && $profileData->passportExpireDate!='0000-00-00')?digitDateLang(nanoDateFormat($profileData->passportExpireDate)):''
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">
                                                            @lang('25'). @lang('Present Address (Bangla)')
                                                        </th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->presentAddressBng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">
                                                            @lang('27'). @lang('Permanent Address (Bangla)')
                                                        </th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->permanentAddressBng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('29'). @lang('Office Address')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->addressOfMP }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('31'). @lang('Height')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->height }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>




                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="39%">@lang('2'). @lang('Name (English)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->nameEng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('4'). @lang('Personal Mobile')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ digitDateLang($profileData->personalMobile) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('6'). @lang('Office Phone Number')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ digitDateLang($profileData->officePhoneNumber) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('8'). @lang('Fax Number')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->faxNumber }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('10'). @lang('Is He/She MP?')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            @if ($profileData->isMP == 1)
                                                                @lang('Yes')
                                                            @elseif ($profileData->isMP==0)
                                                                @lang('No')
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('12'). @lang('Marital Status')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {!! maritalStatusView($profileData->merital_status ?? '') !!}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('14'). @lang('Political Party')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            @if(session()->get('language')=='bn')
                                                            {{ $profileData->party_name_bn }}
                                                            @else   
                                                            {{ $profileData->party_name_en }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('16'). @lang('Freedom Fighter Info')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            @if ($profileData->freedomFighterInfo == 1)
                                                                @lang('Yes')
                                                            @elseif ($profileData->freedomFighterInfo==0)
                                                                @lang('No')
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('18'). @lang('Date of Birth')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ ($profileData->dateOfBirth!='' && $profileData->dateOfBirth!='0000-00-00')?digitDateLang(nanoDateFormat($profileData->dateOfBirth)):'' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('20'). @lang('Birth Certificate Number')
                                                        </th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->birthCertificateNumber }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('22'). @lang('Passport Issue Date')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ ($profileData->passportIssueDate!='' && $profileData->passportIssueDate!='0000-00-00')?digitDateLang(nanoDateFormat($profileData->passportIssueDate)):''
                                                            }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('24'). @lang('Identification Mark')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->identificationMark }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('26'). @lang('Present Address (English)')
                                                        </th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->presentAddressEng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">
                                                            @lang('28'). @lang('Permanent Address(English)')
                                                        </th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->permanentAddressEng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('30'). @lang('Profession of MP')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->professionOfMP }}
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="button-row d-flex mt-4">
                                        <button class="btn btn-info ml-auto js-btn-next" type="button"
                                            title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!--Family Info Panel-->
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                                <div class="bg-success p-2">
                                    <h5 class="multisteps-form__title m-0">@lang('Family Info')</h5>
                                </div>
                                <div class="multisteps-form__content mt-3">

                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="39%">@lang('1'). @lang('Father Name (Bangla)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->fatherNameBng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('3'). @lang('Mother Name (Bangla)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->motherNameBng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('5'). @lang('Spouse Name (Bangla)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->spouseNameBng }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th width="39%">@lang('2'). @lang('Father Name (English)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->fatherNameEng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('4'). @lang('Mother Name (English)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->motherNameEng }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th width="39%">@lang('6'). @lang('Spouse Name (English)')</th>
                                                        <td width="1%"><strong>:</strong></td>
                                                        <td width="60%">
                                                            {{ $profileData->spouseNameEng }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
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
                            <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
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

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        /* //selector onchange - changing animation
            const animationSelect = document.querySelector('.pick-animation__select');

            animationSelect.addEventListener('change', () => {
                const newAnimationType = animationSelect.value;

                setAnimationType(newAnimationType);
            }); */
    </script>
