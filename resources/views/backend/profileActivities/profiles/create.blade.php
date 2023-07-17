@extends('backend.layouts.app')

@section('content')
<style>
    .header__btn{transition-property:all;transition-duration:0.2s;transition-timing-function:linear;transition-delay:0s;padding:10px 20px;display:inline-block;margin-right:10px;background-color:#fff;border:1px solid #2c2c2c;border-radius:3px;cursor:pointer;outline:none;}
    .header__btn:last-child{margin-right:0;}
    .header__btn:hover, .header__btn.js-active{color:#fff;background-color:#2c2c2c;}
    .header{max-width:600px;margin:50px auto;text-align:center;}
    .header__title{margin-bottom:30px;font-size:2.1rem;}
  
    .content__title{margin-bottom:40px;font-size:20px;text-align:center;}
    .content__title--m-sm{margin-bottom:10px;}
    .multisteps-form__progress{display:grid;grid-template-columns:repeat(auto-fit, minmax(0, 1fr));}
    .multisteps-form__progress-btn{transition-property:all;transition-duration:0.15s;transition-timing-function:linear;transition-delay:0s;position:relative;padding-top:20px;color:rgba(108, 117, 125, 0.7);text-indent:-9999px;border:none;background-color:transparent;outline:none !important;cursor:pointer;}
    @media (min-width:500px){.multisteps-form__progress-btn{text-indent:0;}
    }
    .multisteps-form__progress-btn:before{position:absolute;top:0;left:50%;display:block;width:13px;height:13px;content:'';-webkit-transform:translateX(-50%);transform:translateX(-50%);transition:all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;transition:all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;transition:all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;border:2px solid currentColor;border-radius:50%;background-color:#fff;box-sizing:border-box;z-index:3;}
    .multisteps-form__progress-btn:after{position:absolute;top:5px;left:calc(-50% - 13px / 2);transition-property:all;transition-duration:0.15s;transition-timing-function:linear;transition-delay:0s;display:block;width:100%;height:2px;content:'';background-color:currentColor;z-index:1;}
    .multisteps-form__progress-btn:first-child:after{display:none;}
    .multisteps-form__progress-btn.js-active{color:#28a745;;}
    .multisteps-form__progress-btn.js-active:before{-webkit-transform:translateX(-50%) scale(1.2);transform:translateX(-50%) scale(1.2);background-color:currentColor;}
    .multisteps-form__form{position:relative;}
    .multisteps-form__panel{position:absolute;top:0;left:0;width:100%;height:0;opacity:0;visibility:hidden;}
    .multisteps-form__panel.js-active{height:auto;opacity:1;visibility:visible;}
    .multisteps-form__panel[data-animation="scaleOut"]{-webkit-transform:scale(1.1);transform:scale(1.1);}
    .multisteps-form__panel[data-animation="scaleOut"].js-active{transition-property:all;transition-duration:0.2s;transition-timing-function:linear;transition-delay:0s;-webkit-transform:scale(1);transform:scale(1);}
    .multisteps-form__panel[data-animation="slideHorz"]{left:50px;}
    .multisteps-form__panel[data-animation="slideHorz"].js-active{transition-property:all;transition-duration:0.25s;transition-timing-function:cubic-bezier(0.2, 1.13, 0.38, 1.43);transition-delay:0s;left:0;}
    .multisteps-form__panel[data-animation="slideVert"]{top:30px;}
    .multisteps-form__panel[data-animation="slideVert"].js-active{transition-property:all;transition-duration:0.2s;transition-timing-function:linear;transition-delay:0s;top:0;}
    .multisteps-form__panel[data-animation="fadeIn"].js-active{transition-property:all;transition-duration:0.3s;transition-timing-function:linear;transition-delay:0s;}
    .multisteps-form__panel[data-animation="scaleIn"]{-webkit-transform:scale(0.9);transform:scale(0.9);}
    .multisteps-form__panel[data-animation="scaleIn"].js-active{transition-property:all;transition-duration:0.2s;transition-timing-function:linear;transition-delay:0s;-webkit-transform:scale(1);transform:scale(1);}
    h5.multisteps-form__title {font-size: 16px;}
    
    .select2-container{padding-right: 6px;}
    .select2-container--default .select2-selection--single .select2-selection__arrow{right: 6px;}
    .select2-container--default .select2-selection--single{border-color: #ddd;}
    
</style>

@if (session()->get('language') == 'bn')
    <style>.custom-file-input:lang(en)~.custom-file-label::after {content: "ব্রাউজ";}</style>
@else
    <style>.custom-file-input:lang(en)~.custom-file-label::after {content: "Browse";}</style>
@endif
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Profile Management') </h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="content">
        <div class="col-md-12">
            <div class="myloader d-none"></div>
            <div class="card">
                <div class="card-header">

                    <h4 class="card-title w-100">
                        @if (session()->get('language') == 'bn')
                            {{ isset($editData) ? $editData->name_bn : __('Parliament Member Information') }}
                        @else
                            {{ isset($editData) ? $editData->name_eng : __('Parliament Member Information') }}
                        @endif
                        <a href="{{ route('admin.profile-activities.profiles.index') }}"
                            class="btn btn-info float-right"><i class="fa fa-list mr-2"></i>
                            @lang('Parliament Member List')
                        </a>
                    </h4>
                </div>
                <div class="card-body overflow-hidden">
                    <form method="POST"
                    action="{{ isset($editData) ? route('admin.profile-activities.profiles.update', $editData->id) : route('admin.profile-activities.profiles.store') }}">
                    @csrf
                    @if (isset($editData))
                        @method('PUT')
                    @endif
                        <div class="form-row mb-5">
                            <div class="form-group col-6 m-auto">
                                <div class="card card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Information Load From PRP')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label ">@lang('ID No.')</label>
                                                <select name="empId" id="empId" class='form-control select2'>
                                                    <option value="">@lang('Select ID')</option>
                                                    @foreach($profileID_list as $list)
                                                    <option value="{{$list}}">{{digitDatelang($list)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 mt-4">
                                                <button type="button" name="load_profile"  class="btn btn-secondary btn-sm mt-1" onclick="load_data('employee_id')" > @lang('Search') </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="multisteps-form">
                        <!--progress bar-->
                        <div class="row">
                           <div class="col-12 col-lg-8 ml-auto mr-auto mb-4">
                              <div class="multisteps-form__progress">
                                 <button class="multisteps-form__progress-btn js-active" type="button" title="Personal Info">@lang('Personal Info')</button>
                                 <button class="multisteps-form__progress-btn" type="button" title="Family Info">@lang('Family Info')</button>
                                 <button class="multisteps-form__progress-btn" type="button" title="Educational Info">@lang('Educational Info')</button>
                                 <button class="multisteps-form__progress-btn" type="button" title="Training Info">@lang('Training Info')</button>
                              </div>
                           </div>
                        </div>
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 m-auto">
                              <form class="multisteps-form__form">
                                 <!--Basic Info Panel-->
                                 <div class="multisteps-form__panel shadow p-4 rounded bg-white js-active" data-animation="scaleIn">
                                    <div class="bg-success p-2">
                                        <h5 class="multisteps-form__title m-0">@lang('Personal Info')</h5>
                                    </div>
                                    <div class="multisteps-form__content">
                                        <div class="form-row mt-3">
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="nameBng" class="multisteps-form__input form-control form-control-sm" type="text" name="nameBng" placeholder="@lang('Enter Name in Bangla')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="nameEng" class="multisteps-form__input form-control form-control-sm" type="text" name="nameEng" placeholder="@lang('Enter Name in English')"/>
                                            </div>


                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="email" class="multisteps-form__input form-control form-control-sm" type="text" name="email" placeholder="@lang('Enter Email Address')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="personalMobile" class="multisteps-form__input form-control form-control-sm" type="text" name="personalMobile" placeholder="@lang('Enter Personal Mobile Number')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="alternativeMobile" class="multisteps-form__input form-control form-control-sm" type="text" name="alternativeMobile" placeholder="@lang('Enter Alternative Mobile Number')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="officePhoneNumber" class="multisteps-form__input form-control form-control-sm" type="text" name="officePhoneNumber" placeholder="@lang('Enter Office Phone Number')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="officePhoneExtension" class="multisteps-form__input form-control form-control-sm" type="text" name="officePhoneExtension" placeholder="@lang('Enter Office Phone Extension')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="faxNumber" class="multisteps-form__input form-control form-control-sm" type="text" name="faxNumber" placeholder="@lang('Enter Fax Number')"/>
                                            </div>


                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <select name="gender" id="gender"
                                                    class="form-control select2 @error('gender') is-invalid @enderror">
                                                    <option value="">@lang('Select Gender')</option>
                                                    <option value="1">@lang('Male')</option>
                                                    <option value="2">@lang('Female')</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <select name="isMP" id="isMP"
                                                    class="form-control select2 @error('isMP') is-invalid @enderror">
                                                    <option value="">@lang('Is He/She MP?')</option>
                                                    <option value="1">@lang('Yes')</option>
                                                    <option value="0">@lang('No')</option>
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
                                                <select name="parliament_id" id="parliament_id"
                                                    class="form-control form-control-sm select2 @error('parliament_id') is-invalid @enderror">
                                                    {!! parliamentDropdown($editData->parliament_id ?? '') !!}
                                                </select>
                                                @error('parliament_id')
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
                                                    <option value="1">@lang('Yes')</option>
                                                    <option value="0">@lang('No')</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <select name="bloodGroup" id="bloodGroup"
                                                    class="form-control form-control-sm select2 @error('bloodGroup') is-invalid @enderror">
                                                    <option value="">@lang('Select Blood Group')</option>
                                                    <option value="">@lang('A(+ve)')</option>
                                                    <option value="">@lang('A(-ve)')</option>
                                                    <option value="">@lang('B(+ve)')</option>
                                                    <option value="">@lang('B(-ve)')</option>
                                                    <option value="">@lang('O(+ve)')</option>
                                                    <option value="">@lang('O(-ve)')</option>
                                                    <option value="">@lang('AB(+ve)')</option>
                                                    <option value="">@lang('AB(-ve)')</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="dateOfBirth" class="multisteps-form__input form-control form-control-sm" type="text" name="dateOfBirth" placeholder="@lang('Enter Date of Birth')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="nidNumber" class="multisteps-form__input form-control form-control-sm" type="text" name="nidNumber" placeholder="@lang('Enter NID Number')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="birthCertificateNumber" class="multisteps-form__input form-control form-control-sm" type="text" name="birthCertificateNumber" placeholder="@lang('Enter Birth Certificate Number')"/>
                                            </div>


                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="passportNumber" class="multisteps-form__input form-control form-control-sm" type="text" name="passportNumber" placeholder="@lang('Enter Passport Number')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="passportIssueDate" class="multisteps-form__input form-control form-control-sm" type="text" name="passportIssueDate" placeholder="@lang('Enter Passport Issue Date')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="passportExpireDate" class="multisteps-form__input form-control form-control-sm" type="text" name="passportExpireDate" placeholder="@lang('Enter Passport Expire Date')"/>
                                            </div>

                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="identificationMark" class="multisteps-form__input form-control form-control-sm" type="text" name="identificationMark" placeholder="@lang('Enter Identification Mark')"/>
                                            </div>

                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <textarea name="presentAddressBng" class="multisteps-form__input form-control" id="presentAddressBng" rows="3"  placeholder="@lang('Enter Present Address in Bangla')"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <textarea name="presentAddressEng" class="multisteps-form__input form-control" id="presentAddressEng" rows="3"  placeholder="@lang('Enter Present Address in English')"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <textarea name="permanentAddressBng" class="multisteps-form__input form-control" id="permanentAddressBng" rows="3"  placeholder="@lang('Enter Permanent Address in Bangla')"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <textarea name="permanentAddressEng" class="multisteps-form__input form-control" id="permanentAddressEng" rows="3"  placeholder="@lang('Enter Permanent Address in English')"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                                                <textarea name="addressOfMP" class="multisteps-form__input form-control" id="addressOfMP" rows="2"  placeholder="@lang('Enter Office Address')"></textarea>
                                            </div>


                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="professionOfMP" class="multisteps-form__input form-control" type="text" name="professionOfMP" placeholder="@lang('Enter Profession')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <input id="height" class="multisteps-form__input form-control" type="text" name="height" placeholder="@lang('Enter Height')"/>
                                            </div>
                                            
                                            <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                                                <div class="custom-file">
                                                    <input type="file" name="photo[]" multiple class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">@lang('Choose Photo')</label>
                                                  </div>
                                            </div>
                                        </div>

                                        <div class="button-row d-flex mt-4">
                                            <button class="btn btn-info ml-auto js-btn-next" type="button" title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                 </div>
                                 <!--Family Info Panel-->
                                 <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                                    <div class="bg-success p-2">
                                        <h5 class="multisteps-form__title m-0">@lang('Family Info')</h5>
                                    </div>
                                    <div class="multisteps-form__content">
                                        <div class="form-row mt-3">
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="fatherNameBng" class="multisteps-form__input form-control form-control-sm" type="text" name="fatherNameBng" placeholder="@lang('Enter Father Name in Bangla')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="fatherNameEng" class="multisteps-form__input form-control form-control-sm" type="text" name="fatherNameEng" placeholder="@lang('Enter Father Name in English')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="motherNameBng" class="multisteps-form__input form-control form-control-sm" type="text" name="motherNameBng" placeholder="@lang('Enter Mother Name in Bangla')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="motherNameEng" class="multisteps-form__input form-control form-control-sm" type="text" name="motherNameEng" placeholder="@lang('Enter Mother Name in English')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="spouseNameBng" class="multisteps-form__input form-control form-control-sm" type="text" name="spouseNameBng" placeholder="@lang('Enter Spouse Name in Bangla')"/>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="spouseNameEng" class="multisteps-form__input form-control form-control-sm" type="text" name="spouseNameEng" placeholder="@lang('Enter Spouse Name in English')"/>
                                            </div>
                                        </div>
  
                                        <div class="button-row d-flex mt-4">
                                            <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i class="fa fa-angle-left"></i> @lang('Previous')</button>
                                            <button class="btn btn-info ml-auto js-btn-next" type="button" title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                 </div>
                                 <!--Educational Info Panel-->
                                 <div class="multisteps-form__panel shadow p-4 rounded bg-white" data-animation="scaleIn">
                                    <div class="bg-success p-2">
                                        <h5 class="multisteps-form__title m-0">@lang('Educational Info')</h5>
                                    </div>
                                    <div class="multisteps-form__content">
                                        <div class="form-row mt-3">
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="ssc" class="multisteps-form__input form-control form-control-sm" type="text" name="ssc" placeholder="@lang('SSC')"/>
                                            </div>
                                        </div>
                                        <div class="button-row d-flex mt-4 col-12">
                                            <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i class="fa fa-angle-left"></i> @lang('Previous')</button>
                                            <button class="btn btn-info ml-auto js-btn-next" type="button" title="Next">@lang('Next') <i class="fa fa-angle-right"></i></button>
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
                                            <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                                                <input id="Others" class="multisteps-form__input form-control form-control-sm" type="text" name="Others" placeholder="@lang('Others')"/>
                                            </div>
                                        </div>
                                        <div class="button-row d-flex mt-4">
                                            <button class="btn btn-info js-btn-prev" type="button" title="Prev"><i class="fa fa-angle-left"></i> @lang('Previous')</</button>
                                            <button class="btn btn-success ml-auto" type="button" title="Send">@lang('Submit')</button>
                                        </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
























                     <?php /* 
                    <form method="POST"
                        action="{{ isset($editData) ? route('admin.profile-activities.profiles.update', $editData->id) : route('admin.profile-activities.profiles.store') }}">
                        @csrf
                        @if (isset($editData))
                            @method('PUT')
                        @endif
                        <div class="form-row">
                            <div class="form-group col-sm-12">
                                <div class="card card-success">
                                    <div class="card-header text-center">
                                        <h3 class="card-title">@lang('User Information')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label for="" class="control-label">@lang('Email')</label>
                                                <input type="text" required name="email"
                                                    value="{{ $editData['userInfo']->email ?? old('email') }}"
                                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                                    placeholder="@lang('Enter Email')">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label for="" class="control-label">@lang('Password') <small>
                                                        {{ isset($editData) ? __('(You can ignore password)') : '' }}</small></label>
                                                <input id="password" type="password"
                                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                    name="password" {{ isset($editData) ? '' : 'required' }}
                                                    autocomplete="new-password" placeholder="@lang('Enter Password')">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="" class="control-label">@lang('Confirm Password')</label>
                                                <input id="password-confirm" type="password"
                                                    class="form-control form-control-sm" name="password_confirmation"
                                                    {{ isset($editData) ? '' : 'required' }} autocomplete="new-password"
                                                    placeholder="@lang('Enter Password Again')">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Information Load From PRP')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-4">
                                                <label for="" class="control-label ">@lang('ID No.')</label>
                                                <select name="empId" id="empId" class='form-control select2'>
                                                    <option value="">@lang('Select Your ID')</option>
                                                    <option value="3200305">3200305</option>
                                                    <option value="1234567">1234567</option>
                                                    <option value="3200300">3200300</option>
                                                    <option value="535464">1234567</option>
                                                    <option value="3200306">3200306</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4 mt-4">
                                                <button type="button" name="load_profile"  class="btn btn-secondary btn-sm mt-1" onclick="load_data('employee_id')" > @lang('Add Your Information') </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Personal Information')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Name (Bangla)')</label>
                                                <input type="text" required name="name_bn"
                                                    value="{{ $editData->name_bn ?? old('name_bn') }}"
                                                    class="form-control form-control-sm @error('name_bn') is-invalid @enderror"
                                                    placeholder="@lang('Enter Name in Bangla')">
                                                @error('name_bn')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Name (English)')</label>
                                                <input type="text" required name="name_eng"
                                                    value="{{ $editData->name_eng ?? old('name_eng') }}"
                                                    class="form-control form-control-sm @error('name_eng') is-invalid @enderror"
                                                    placeholder="@lang('Enter Name in English')">
                                                @error('name_eng')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang("Father's Name")</label>
                                                <input type="text" required name="father_name"
                                                    value="{{ $editData->father_name ?? old('father_name') }}"
                                                    class="form-control form-control-sm @error('father_name') is-invalid @enderror"
                                                    placeholder='@lang("Enter Fathers Name")'>
                                                @error('father_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang("Mother's Name")</label>
                                                <input type="text" required name="mother_name"
                                                    value="{{ $editData->mother_name ?? old('mother_name') }}"
                                                    class="form-control form-control-sm @error('mother_name') is-invalid @enderror"
                                                    placeholder='@lang("Enter Mothers Name")'>
                                                @error('mother_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Marital Status')</label>
                                                <select name="merital_status" id=""
                                                    class="form-control form-control-sm select2">
                                                    {!! maritalStatusDropdown($editData->merital_status ?? '') !!}
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Spouse Name (Bangla)')</label>
                                                <input type="text" value="{{ $editData->spouse_name_bn ?? '' }}"
                                                    name="spouse_name_bn"
                                                    class="form-control form-control-sm @error('spouse_name_bn') is-invalid @enderror"
                                                    placeholder="@lang('Enter Spouse Name in Bangla')">
                                                @error('spouse_name_bn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Spouse Name (English)')</label>
                                                <input type="text" value="{{ $editData->spouse_name_eng ?? '' }}"
                                                    name="spouse_name_eng"
                                                    class="form-control form-control-sm @error('spouse_name_eng') is-invalid @enderror"
                                                    placeholder="@lang('Enter Spouse Name in English')">
                                                @error('spouse_name_eng')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Spouse Date of Birth')</label>
                                                <div class="input-group date" id="reservationdate"
                                                    data-target-input="nearest">
                                                    <input type="text"
                                                        class="form-control form-control-sm datetimepicker-input @error('spouse_dob') is-invalid @enderror"
                                                        name="spouse_dob" id="datepicker"
                                                        value="{{ $editData->spouse_dob ?? old('spouse_dob') }}"
                                                        placeholder="@lang('Select Date')" data-target="#reservationdate" />
                                                    <div class="input-group-append" data-target="#reservationdate"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                </div>

                                                {{-- <input type="text" value="{{ $editData->spouse_dob ?? '' }}" name="spouse_dob" class="form-control form-control-sm @error('spouse_dob') is-invalid @enderror" placeholder="@lang('Enter Spouse Date of Birth') "> --}}

                                                @error('spouse_dob')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('NID')</label>
                                                <input type="text" required
                                                    value="{{ $editData->nid_no ?? old('nid_no') }}" name="nid_no"
                                                    class="form-control form-control-sm @error('nid_no') is-invalid @enderror"
                                                    placeholder="@lang('Enter NID No.') ">
                                                @error('nid_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Spouse NID')</label>
                                                <input type="text" value="{{ $editData->spouse_nid_no ?? '' }}"
                                                    name="spouse_nid_no"
                                                    class="form-control form-control-sm @error('spouse_nid_no') is-invalid @enderror"
                                                    placeholder="@lang('Enter Spouse NID No.')">
                                                @error('spouse_nid_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Religion')</label>
                                                <select name="religion" id="religion"
                                                    class="form-control form-control-sm select2">
                                                    {!! religionDropdown($editData->religion ?? '') !!}
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('PABX Number')</label>
                                                <input type="text" value="{{ $editData->pabx_no ?? '' }}" name="pabx_no"
                                                    class="form-control form-control-sm @error('pabx_no') is-invalid @enderror"
                                                    placeholder="@lang('Enter PABX Number')">
                                                @error('pabx_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Official Phone')</label>
                                                <input type="text" value="{{ $editData->official_phone ?? '' }}"
                                                    name="official_phone"
                                                    class="form-control form-control-sm @error('official_phone') is-invalid @enderror"
                                                    placeholder="@lang('Enter Official Phone No.')">
                                                @error('official_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Residential Phone')</label>
                                                <input type="text" value="{{ $editData->residential_phone ?? '' }}"
                                                    name="residential_phone"
                                                    class="form-control form-control-sm @error('residential_phone') is-invalid @enderror"
                                                    placeholder="@lang('Enter Residential Phone No.')">
                                                @error('residential_phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Office Address')</label>
                                                <textarea name="office_address"
                                                    class="form-control form-control-sm @error('office_address') is-invalid @enderror"
                                                    placeholder="@lang('Enter Office Address')">{{ $editData->office_address ?? '' }}</textarea>
                                                @error('office_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Present Address')</label>
                                                <textarea name="residential_address"
                                                    class="form-control form-control-sm @error('residential_address') is-invalid @enderror"
                                                    placeholder="@lang('Enter Present Address')">{{ $editData->residential_address ?? '' }}</textarea>
                                                @error('residential_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Permanent Address')</label>
                                                <textarea name="parmanent_address"
                                                    class="form-control form-control-sm @error('parmanent_address') is-invalid @enderror"
                                                    placeholder="@lang('Enter Permanent Address')">{{ $editData->parmanent_address ?? '' }}</textarea>
                                                @error('parmanent_address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">@lang('Others Information')</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">

                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Ministry')</label>
                                                <select name="ministry_id" id="ministry_id"
                                                    class="form-control form-control-sm select2 @error('ministry_id') is-invalid @enderror">
                                                    {!! ministryDropdown($editData->ministry_id ?? '') !!}
                                                </select>
                                                @error('ministry_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Designation')</label>
                                                <select name="designation_id" id="designation_id"
                                                    class="form-control form-control-sm select2 @error('designation_id') is-invalid @enderror">
                                                    {!! designationDropdown($editData->designation_id ?? '') !!}
                                                </select>
                                                @error('designation_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Parliament')</label>
                                                <select name="parliament_id" id="parliament_id"
                                                    class="form-control form-control-sm select2 @error('parliament_id') is-invalid @enderror">
                                                    {!! parliamentDropdown($editData->parliament_id ?? '') !!}
                                                </select>
                                                @error('parliament_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Political Party')</label>
                                                <select name="political_parties_id" id="political_parties_id"
                                                    class="form-control form-control-sm select2 @error('political_parties_id') is-invalid @enderror">
                                                    {!! politicalPartiesDropdown($editData->political_parties_id ?? '') !!}
                                                </select>
                                                @error('political_parties_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Birth District')</label>
                                                <select name="birth_district_id" id="birth_district_id"
                                                    class="form-control form-control-sm select2 @error('birth_district_id') is-invalid @enderror">
                                                    {!! districtDropdown($editData->birth_district_id ?? '') !!}
                                                </select>
                                                @error('birth_district_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Status')</label>
                                                <select name="status" id="status" class="form-control form-control-sm">
                                                    {!! statusDropdown($editData->status ?? '') !!}
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Division')</label>
                                                <select name="division_id" id="division_id"
                                                    class="form-control form-control-sm select2">
                                                    {!! divisionDropdown($editData['constituency']->division_id ?? '') !!}
                                                </select>
                                                @error('dtn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('District')</label>
                                                <select name="district_id" id="district_id"
                                                    class="form-control form-control-sm select2">
                                                    <option value="">@lang('Select District')</option>
                                                </select>
                                                @error('dtn')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="" class="control-label">@lang('Constituency')</label>
                                                <select name="constituency_id" id="constituency_id"
                                                    class="form-control form-control-sm select2 @error('constituency_id') is-invalid @enderror">
                                                    <option value="">@lang('Select Constituency')</option>
                                                </select>
                                                @error('constituency_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-sm-12 mt-3 mb-5">
                                <button class="btn btn-info"><i class="fa fa-save mr-2"></i>
                                    {{ isset($editData) ? __('Update Profile') : __('Save') }} </button>
                                <button class="btn btn-primary"><i class="fa fa-save mr-2"></i>
                                    @lang('Save & Send to PRP')
                                </button>
                            </div>

                        </div>
                    </form> */ ?>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(function() {
            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'YYYY-MM-DD',
            });
        })

        $(function() {
            //document.getElementById("employee_div").style.display = "none"
            //document.getElementById("parlament_div").style.display = "none"
            var division_id = $('#division_id').val();
            var district_id = "{{ $editData['constituency']->district_id ?? 'null' }}";
            var constituency_id = "{{ $editData->constituency_id ?? 'null' }}";

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
        });
    </script>
    <script>
        function load_data(type) {
            my_loader('start');
            if (type == 'employee_id') {
                request_data = {
                    _token: "{{ csrf_token() }}",
                    profile_by: type,
                    empId:$("#empId").val()
                };
            } else if (type == 'list') {
                request_data = {
                    _token: "{{ csrf_token() }}",
                    parliament_session_id: $("#list_parliament_session_id").val(),
                    call_type: type
                };
            }
            $.ajax({
                url: "{{ url('/profile-activities/loadprofile') }}",
                type: "POST",
                data: request_data,
                success: function(response) {
                    my_loader('stop');
                    response = JSON.parse(response);
                    if (response.responseCode == 200) {
                        if (type == 'employee_id') {
                            console.log(response);
                            var basicInfo = response.payload.employeeBasicInformationModel;
                            $("#nameBng").val(basicInfo.nameBng);
                            $("#nameEng").val(basicInfo.nameEng);
                            $("#fatherNameEng").val(basicInfo.fatherNameEng);
                            $("#fatherNameBng").val(basicInfo.fatherNameBng);
                            $("#motherNameEng").val(basicInfo.motherNameEng);
                            $("#motherNameBng").val(basicInfo.motherNameBng);
                            $("#spouseNameEng").val(basicInfo.spouseNameEng);
                            $("#spouseNameBng").val(basicInfo.spouseNameBng);
                            $("#dateOfBirth").val(basicInfo.dateOfBirth);
                            $("#presentAddressEng").val(basicInfo.presentAddressEng);
                            $("#presentAddressBng").val(basicInfo.presentAddressBng);
                            $("#permanentAddressEng").val(basicInfo.permanentAddressEng);
                            $("#permanentAddressBng").val(basicInfo.permanentAddressBng);
                            $("#nidNumber").val(basicInfo.nidNumber);
                            $("#birthCertificateNumber").val(basicInfo.birthCertificateNumber);
                            $("#passportNumber").val(basicInfo.passportNumber);
                            $("#passportIssueDate").val(basicInfo.passportIssueDate);
                            $("#passportExpireDate").val(basicInfo.passportExpireDate);
                            $("#gender").val(basicInfo.gender);
                            $("#religion").val(basicInfo.religion);
                            $("#bloodGroup").val(basicInfo.bloodGroup);
                            $("#identificationMark").val(basicInfo.identificationMark);
                            $("#height").val(basicInfo.height);
                            $("#personalMobile").val(basicInfo.personalMobile);
                            $("#alternativeMobile").val(basicInfo.alternativeMobile);
                            $("#email").val(basicInfo.email);
                            $("#freedomFighterInfo").val(basicInfo.freedomFighterInfo);
                            $("#officePhoneNumber").val(basicInfo.officePhoneNumber);
                            $("#officePhoneExtension").val(basicInfo.officePhoneExtension);
                            $("#faxNumber").val(basicInfo.faxNumber);
                            $("#photo").val(basicInfo.photo);
                            $("#isMP").val(basicInfo.isMP);
                            $("#professionOfMP").val(basicInfo.professionOfMP);
                            $("#addressOfMP").val(basicInfo.addressOfMP);

                            $('#isMP').trigger('change');
                            $('#gender').trigger('change');
                            $('#religion').trigger('change');
                            $('#bloodGroup').trigger('change');
                            $('#freedomFighterInfo').trigger('change');
                        
                            my_loader('stop');
                        }
                        if (type == 'list') {
                        }
                    } else {
                        Swal.fire('@lang('+response.responseCode+')', '', 'error');
                        my_loader('stop');
                    }
                },
                error: function(res){
                    my_loader('stop');
                }
            });

        }
    </script>
    <script>

        //DOM elements
        const DOMstrings = {
        stepsBtnClass: 'multisteps-form__progress-btn',
        stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
        stepsBar: document.querySelector('.multisteps-form__progress'),
        stepsForm: document.querySelector('.multisteps-form__form'),
        stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
        stepFormPanelClass: 'multisteps-form__panel',
        stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
        stepPrevBtnClass: 'js-btn-prev',
        stepNextBtnClass: 'js-btn-next' };


        //remove class from a set of items
        const removeClasses = (elemSet, className) => {

        elemSet.forEach(elem => {

            elem.classList.remove(className);

        });

        };

        //return exect parent node of the element
        const findParent = (elem, parentClass) => {

        let currentNode = elem;

        while (!currentNode.classList.contains(parentClass)) {
            currentNode = currentNode.parentNode;
        }

        return currentNode;

        };

        //get active button step number
        const getActiveStep = elem => {
        return Array.from(DOMstrings.stepsBtns).indexOf(elem);
        };

        //set all steps before clicked (and clicked too) to active
        const setActiveStep = activeStepNum => {

        //remove active state from all the state
        removeClasses(DOMstrings.stepsBtns, 'js-active');

        //set picked items to active
        DOMstrings.stepsBtns.forEach((elem, index) => {

            if (index <= activeStepNum) {
            elem.classList.add('js-active');
            }

        });
        };

        //get active panel
        const getActivePanel = () => {

        let activePanel;

        DOMstrings.stepFormPanels.forEach(elem => {

            if (elem.classList.contains('js-active')) {

            activePanel = elem;

            }

        });

        return activePanel;

        };

        //open active panel (and close unactive panels)
        const setActivePanel = activePanelNum => {

        //remove active class from all the panels
        removeClasses(DOMstrings.stepFormPanels, 'js-active');

        //show active panel
        DOMstrings.stepFormPanels.forEach((elem, index) => {
            if (index === activePanelNum) {

            elem.classList.add('js-active');

            setFormHeight(elem);

            }
        });

        };

        //set form height equal to current panel height
        const formHeight = activePanel => {

        const activePanelHeight = activePanel.offsetHeight;

        DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

        };

        const setFormHeight = () => {
        const activePanel = getActivePanel();

        formHeight(activePanel);
        };

        //STEPS BAR CLICK FUNCTION
        DOMstrings.stepsBar.addEventListener('click', e => {

        //check if click target is a step button
        const eventTarget = e.target;

        if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
            return;
        }

        //get active button step number
        const activeStep = getActiveStep(eventTarget);

        //set all steps before clicked (and clicked too) to active
        setActiveStep(activeStep);

        //open active panel
        setActivePanel(activeStep);
        });

        //PREV/NEXT BTNS CLICK
        DOMstrings.stepsForm.addEventListener('click', e => {

        const eventTarget = e.target;

        //check if we clicked on `PREV` or NEXT` buttons
        if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`)))
        {
            return;
        }

        //find active panel
        const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

        let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

        //set active step and active panel onclick
        if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
            activePanelNum--;

        } else {

            activePanelNum++;

        }

        setActiveStep(activePanelNum);
        setActivePanel(activePanelNum);

        });

        //SETTING PROPER FORM HEIGHT ONLOAD
        window.addEventListener('load', setFormHeight, false);

        //SETTING PROPER FORM HEIGHT ONRESIZE
        window.addEventListener('resize', setFormHeight, false);

        //changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

        const setAnimationType = newType => {
        DOMstrings.stepFormPanels.forEach(elem => {
            elem.dataset.animation = newType;
        });
        };

        //selector onchange - changing animation
        const animationSelect = document.querySelector('.pick-animation__select');

        animationSelect.addEventListener('change', () => {
        const newAnimationType = animationSelect.value;

        setAnimationType(newAnimationType);
        });
    </script>
    
@endsection
