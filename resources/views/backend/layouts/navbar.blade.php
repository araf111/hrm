<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" style="color: white;"><i class="fas fa-bars"></i></a>
    </li>
</ul>

<ul class="navbar-nav ml-auto d-inline-flex">
    <li class="nav-item" style="padding-right: 15px;">
        <a target="_blank" style="color: #fff; font-size: 20px;" title="Website View" href="{{ url('/') }}"><i class="fas fa-globe"></i></a>
    </li>
    {{-- <li class="nav-item" style="padding-right: 15px;">
        <a href="{{ asset('public/MpPortalApp.apk') }}"><img height="30px"
                src="{{ asset('public/playstore_icon.png') }}"></a>
    </li>
    <li class="nav-item" style="padding-right: 15px;">
        <a href="#" target="_blank"><img height="30px" src="{{ asset('public/app_store_icon.png') }}"></a>
    </li> --}}
    <li class="nav-item">
        <style type="text/css">
            .bootstrap-switch-label{
                background: white;
            }
        </style>
        <a href="{{ route('language', ((session()->get('language') == 'bn')?('en'):'bn')) }}">
            @if(session()->get('language') == 'bn')
            <div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 76px;"><div class="bootstrap-switch-container" style="width: 111px; margin-left: 0px;"><span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 37px;">EN</span><span class="bootstrap-switch-label" style="width: 37px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-info" style="width: 37px;">বাং</span><input class="d-none" type="checkbox" name="my-checkbox" checked="" data-bootstrap-switch="" data-off-text="বাং" data-on-text="EN" data-off-color="info" data-on-color="success"></div></div>
            @else
            <div class="bootstrap-switch-null bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch-undefined bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-animate" style="width: 76px;"><div class="bootstrap-switch-container" style="width: 111px; margin-left: -37px;"><span class="bootstrap-switch-handle-on bootstrap-switch-success" style="width: 37px;">EN</span><span class="bootstrap-switch-label" style="width: 37px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-info" style="width: 37px;">বাং</span><input class="d-none" type="checkbox" name="my-checkbox" data-bootstrap-switch="" data-off-text="বাং" data-on-text="EN" data-off-color="info" data-on-color="success"></div></div> 
            @endif
        </a>
    </li>
{{--     <li class="nav-item">
        @if (session()->get('language') == 'bn')
            <a class="nav-link btn btn-sm" href="{{ route('language', 'en') }}"
                style="background: white;color: #17a2b8;border: 2px solid #17a2b8; line-height: 14px;">English</a>
        @else
            <a class="nav-link btn btn-sm" href="{{ route('language', 'bn') }}"
                style="background: white;color: #17a2b8;border: 2px solid #17a2b8; line-height: 14px;">বাংলা</a>
        @endif
    </li> --}}
    <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true" style="color:white;">
            @if(isset(authInfo()->profileData) && isset(authInfo()->profileData['nameBng']))
            @if (session()->get('language') == 'bn')
            {{ digitDateLang(@authInfo()->profileData['constituencyNumber']).', '.@authInfo()->profileData['constituency']->bn_name.', '.@authInfo()->profileData['nameBng']  }}
            @else
                {{ @authInfo()->profileData['constituencyNumber'].', '.ucwords(strtolower(@authInfo()->profileData['constituency']->name)).', '.ucwords(strtolower(@authInfo()->profileData['nameEng'])) }}
            @endif
            @if(isset(authInfo()->profileData['photo']) && authInfo()->profileData['photo']!= '')
                <img src="{{ asset('public/backend/profile')}}/{{@authInfo()->profileData['photo']}}" class="ml-2 img-circle elevation-2" alt="" style="width: 24px;">
            @endif
           @else
            @if (session()->get('language') == 'bn')
                {{ auth()->user()->name_bn }}
            @else
                {{ auth()->user()->name }}
            @endif
            <img src="{{ asset('public/backend/user/profile.jpg') }}" class="ml-2 img-circle elevation-2" alt="User Image" style="width: 24px;">
            {{-- <img src="{{ authInfo()->image }}" class="ml-2 img-circle elevation-2" alt="User Image" style="width: 24px;"> --}}
            @endif
                
        </a>
        <div class="dropdown-menu dropdown-menu-right">
           
            <a href="@if(authInfo()->usertype=='mp'){{ url('/profile-activities/myprofile') }} @else {{ url('/profile-activities/myprofile') }} @endif" class="dropdown-item">
                <i class="fas fa-user"></i> @lang("My Profile")
            </a>
          
            <a href="{{ route('profile-management.change.password') }}" class="dropdown-item">

                <i class="fas fa-lock"></i> @lang("Change Password")
            </a>
            <a href="#" class="dropdown-item"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> @lang("Logout")
            </a>
            <form style="display: none;" method="post" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </li>
</ul>
