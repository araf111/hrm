@include('report.pdf.header')
@if(isset($profile_list))
<section class="report_profile">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">@lang('Profile Info')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                {!! $profile_list !!}
            </div>
        </div>
    </div>
</section>
@else 
<section class="report_profile">
    <div class="profile_headar">
        <div class="row">
            <div class="col-8 left">
                @if(session()->get('language') =='bn')
                    <h3 style="margin-bottom: 0">{{ $profileDetails->nameBng }}</h3>
                @else
                    <h3 style="margin-bottom: 0">{{ $profileDetails->nameEng }}</h3>
                @endif

                <p>
                    @lang('Mobile No.'): {{ digitDateLang($profileDetails->personalMobile) }}<br/>
                    @lang('Office Phone No.'): {{ digitDateLang($profileDetails->officePhoneNumber) }}<br/>
                    @lang('Email'): {{ $profileDetails->email }}
                </p>
            </div>
            <div class="col-4 right">
                <img style="height: 100px; border: 1px solid #444;" src="{{asset('/public/backend/profile/')}}/{{$profileDetails->photo}}" alt="">
            </div>
        </div>
    </div>
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">@lang('Personal Info')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="39%">@lang('1'). @lang('Name (Bangla)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->nameBng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('2'). @lang('Name (English)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->nameEng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('3'). @lang('Email')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->email }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('4'). @lang('Personal Mobile')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->personalMobile) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('5'). @lang('Alternative Mobile')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->alternativeMobile) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('6'). @lang('Office Phone Number')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->officePhoneNumber) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('7'). @lang('Office Phone Extension')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->officePhoneExtension) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('8'). @lang('Fax Number')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->faxNumber) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('9'). @lang('Gender')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    @if ($profileDetails->gender == 1)
                                        @lang('Male')
                                    @elseif ($profileDetails->gender==2)
                                        @lang('Female')
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('10'). @lang('Is He/She MP?')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    @if ($profileDetails->isMP == 1)
                                        @lang('Yes')
                                    @elseif ($profileDetails->isMP==0)
                                        @lang('No')
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('11'). @lang('Religion')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->religion_text }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('12'). @lang('Marital Status')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {!! maritalStatusView($profileDetails->merital_status ?? '') !!}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('13'). @lang('Parliament')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->parliamentNumber) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('14'). @lang('Political Party')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    @if(session()->get('language')=='bn')
                                    {{ $profileDetails->partyInfo->name_bn }}
                                    @else   
                                    {{ $profileDetails->partyInfo->name}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('15'). @lang('Constituency')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->voter_area }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('16'). @lang('Freedom Fighter Info')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    @if ($profileDetails->freedomFighterInfo == 1)
                                        @lang('Yes')
                                    @elseif ($profileDetails->freedomFighterInfo==0)
                                        @lang('No')
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('17'). @lang('Blood Group')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->bloodGroup_text }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('18'). @lang('Date of Birth')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang(nanoDateFormat($profileDetails->dateOfBirth)) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('19'). @lang('NID Number')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->nidNumber) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('20'). @lang('Birth Certificate Number')
                                </th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->birthCertificateNumber }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('21'). @lang('Passport Number')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang($profileDetails->passportNumber) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('22'). @lang('Passport Issue Date')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang(nanoDateFormat($profileDetails->passportIssueDate)) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('23'). @lang('Passport Expiry Date')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ digitDateLang(nanoDateFormat($profileDetails->passportExpireDate)) }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('24'). @lang('Identification Mark')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->identificationMark }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('25'). @lang('Present Address (Bangla)')
                                </th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->presentAddressBng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('26'). @lang('Present Address (English)')
                                </th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->presentAddressEng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('27'). @lang('Permanent Address (Bangla)')
                                </th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->permanentAddressBng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('28'). @lang('Permanent Address (English)')
                                </th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->permanentAddressEng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('29'). @lang('Office Address')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->addressOfMP }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('30'). @lang('Profession of MP')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->professionOfMP }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('31'). @lang('Height')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->height }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>


    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">@lang('Family Info')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="39%">@lang('1'). @lang('Father Name (Bangla)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->fatherNameBng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('2'). @lang('Father Name (English)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->fatherNameEng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('3'). @lang('Mother Name (Bangla)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->motherNameBng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('4'). @lang('Mother Name (English)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->motherNameEng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('5'). @lang('Spouse Name (Bangla)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->spouseNameBng }}
                                </td>
                            </tr>
                            <tr>
                                <th width="39%">@lang('6'). @lang('Spouse Name (English)')</th>
                                <td width="1%"><strong>:</strong></td>
                                <td width="60%">
                                    {{ $profileDetails->spouseNameEng }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">@lang('Educational Info')</h3>
        </div>
        <div class="card-body">
            <div class="row">

            </div>
        </div>
    </div>

    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">@lang('Training Info')</h3>
        </div>
        <div class="card-body">
            <div class="row">

            </div>
        </div>
    </div>
</section>
@endif
@include('report.pdf.footer')