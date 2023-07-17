<!-- 
 * Author M. Atoar Rahman
 * Date: 10/08/2021
 * Time: 11:40 AM
-->
<!-- START HEADER -->
<header class="header_wrap">
    <div class="top-header bg_purple">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <a href="#">@lang('MP Portal, Notice and Petition Management System')</a>
                </div> 
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="float_right py-0"> 
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item bg-transparent text-white border-0" style="padding:0rem 1rem 0rem 0rem; line-height: 28px;">
                            <i class="fas fa-calendar-alt"></i>
                            {{ digitDateLang(date('d M Y')) }}
                        </li>
                        <li class="list-group-item bg-transparent text-white border-0 p-0">
                            @if (session()->get('language') == 'bn')
                            <a class="nav-link btn btn-sm" href="{{ route('language', 'en') }}"
                                style="background: white;color: #17a2b8;border: 2px solid #610d5e; line-height: 8px;">English</a>
                            @else
                                <a class="nav-link btn btn-sm" href="{{ route('language', 'bn') }}"
                                    style="background: white;color: #17a2b8;border: 2px solid #610d5e; line-height: 8px;">বাংলা</a>
                            @endif
                        </li>
                    </ul>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="menu_bar">
       
        <nav id="navbar_top" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{url('/')}}">
                    <img class="img-responsive img-fluid" src="{{asset('public/frontend/images/logo.png')}}" alt="logo"/>@lang('MP Portal')
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="main_nav">
                    <ul class="navbar-nav ms-auto">
                        @php
                            $nav_menus = [];    
                            $parents1 = App\Model\Frontend\MenuFrontend::where('parent', 0)
                                ->where('status', 1)
                                ->orderBy('sort', 'asc')
                                ->get();

                            foreach ($parents1 as $parent1) {
                                $nav_menus['menus'][$parent1->id]['menu_name'] = session()->get('language') == 'bn' ? $parent1->name_bn : $parent1->name;
                                $nav_menus['menus'][$parent1->id]['menu_route'] = $parent1->route;
                                $nav_menus['menus'][$parent1->id]['menu_icon'] = $parent1->icon;
                                $parents2 = App\Model\Frontend\MenuFrontend::where('parent', $parent1->id)
                                    ->where('status', 1)
                                    ->orderBy('sort', 'asc')
                                    ->get();
                                foreach ($parents2 as $parent2) {
                                    $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['menu_name'] = session()->get('language') == 'bn' ? $parent2->name_bn : $parent2->name;
                                    $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['menu_route'] = $parent2->route;
                                    $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['menu_icon'] = $parent2->icon;
                                    $parents3 = App\Model\Frontend\MenuFrontend::where('parent', $parent2->id)
                                        ->where('status', 1)
                                        ->orderBy('sort', 'asc')
                                        ->get();
                                    foreach ($parents3 as $parent3) {
                                        $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_name'] = session()->get('language') == 'bn' ? $parent3->name_bn : $parent3->name;
                                        $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_route'] = $parent3->route;
                                        $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_icon'] = $parent3->icon;
                                        $parents4 = App\Model\Frontend\MenuFrontend::where('parent', $parent3->id)
                                            ->where('status', 1)
                                            ->orderBy('sort', 'asc')
                                            ->get();
                                        foreach ($parents4 as $parent4) {
                                            $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_name'] = session()->get('language') == 'bn' ? $parent4->name_bn : $parent4->name;
                                            $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_route'] = $parent4->route;
                                            $nav_menus['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_icon'] = $parent4->icon;
                                            $parents4 = App\Model\Frontend\MenuFrontend::where('parent', $parent3->id)
                                                ->where('status', 1)
                                                ->orderBy('sort', 'asc')
                                                ->get();
                                        }
                                    }
                                }
                            }
                        @endphp

                        @foreach ($nav_menus as $nav_menu)
                            @foreach ($nav_menu as $nav_menu1)
                                @if (@$nav_menu1['child'] != null)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#">
                                            <i class="nav-icon far {{ $nav_menu1['menu_icon'] ? $nav_menu1['menu_icon'] : '' }}"></i>
                                            {{ $nav_menu1['menu_name'] }} 
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end fade-down">
                                            @foreach ($nav_menu1['child'] as $nav_menu2)
                                                @if (@$nav_menu2['child'] != null)
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="nav-icon far {{ $nav_menu2['menu_icon'] ? $nav_menu2['menu_icon'] : '' }}"></i>
                                                            {{ $nav_menu2['menu_name'] }} 
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end fade-down">
                                                            @foreach ($nav_menu2['child'] as $nav_menu3)
                                                                @if (@$nav_menu3['child'] != null) 
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <i class="nav-icon far {{ $nav_menu3['menu_icon'] ? $nav_menu3['menu_icon'] : '' }}"></i>
                                                                            {{ $nav_menu3['menu_name'] }} 
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end fade-down">
                                                                            @foreach ($nav_menu3['child'] as $nav_menu4)
                                                                                @if (@$nav_menu4['child'] != null)
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="#">
                                                                                            <i class="nav-icon far {{ $nav_menu4['menu_icon'] ? $nav_menu4['menu_icon'] : '' }}"></i>
                                                                                            {{ $nav_menu4['menu_name'] }} 
                                                                                        </a>
                                                                                        <ul class="dropdown-menu dropdown-menu-end fade-down">
                                                                                            @foreach ($nav_menu4['child'] as $nav_menu5)
                                                                                                @if (@$nav_menu5['child'] != null)
                                                                                                    <li>
                                                                                                        <a class="dropdown-item" href="#">
                                                                                                            <i class="nav-icon far {{ $nav_menu5['menu_icon'] ? $nav_menu5['menu_icon'] : '' }}"></i>
                                                                                                            {{ $nav_menu5['menu_name'] }} 
                                                                                                        </a>
                                                                                                    </li>
                                                                                                @else
                                                                                                    <li>
                                                                                                        <a class="dropdown-item" href="{{ $nav_menu5['menu_route'] == '#' ? '#' : url($nav_menu5['menu_route']) }}">
                                                                                                            <i class="nav-icon far {{ $nav_menu5['menu_icon'] ? $nav_menu5['menu_icon'] : '' }}"></i>
                                                                                                            {{ $nav_menu5['menu_name'] }} 
                                                                                                        </a>
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="{{ $nav_menu4['menu_route'] == '#' ? '#' : url($nav_menu4['menu_route']) }}">
                                                                                            <i class="nav-icon far {{ $nav_menu4['menu_icon'] ? $nav_menu4['menu_icon'] : '' }}"></i>
                                                                                            {{ $nav_menu4['menu_name'] }} 
                                                                                        </a>
                                                                                    </li>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ $nav_menu3['menu_route'] == '#' ? '#' : url($nav_menu3['menu_route']) }}">
                                                                            <i class="nav-icon far {{ $nav_menu3['menu_icon'] ? $nav_menu3['menu_icon'] : '' }}"></i>
                                                                            {{ $nav_menu3['menu_name'] }} 
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li>
                                                        <a class="dropdown-item" href="{{ $nav_menu2['menu_route'] == '#' ? '#' : url($nav_menu2['menu_route']) }}">
                                                            <i class="nav-icon far {{ $nav_menu2['menu_icon'] ? $nav_menu2['menu_icon'] : '' }}"></i>
                                                            {{ $nav_menu2['menu_name'] }} 
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ $nav_menu1['menu_route'] == '#' ? '#' : url($nav_menu1['menu_route']) }}">
                                            <i class="nav-icon far {{ $nav_menu1['menu_icon'] ? $nav_menu1['menu_icon'] : '' }}"></i>
                                            {{ $nav_menu1['menu_name'] }} 
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endforeach
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/login')}}"> 
                                <button class="btn btn-login">
                                <i class="fas fa-user"></i> @lang('Login')
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>


<!-- SCRIPT --> 

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
            document.getElementById('navbar_top').classList.add('fixed-top');
            // add padding top to show content behind navbar
            navbar_height = document.querySelector('.navbar').offsetHeight;
            document.body.style.paddingTop = navbar_height + 'px';
            } else {
            document.getElementById('navbar_top').classList.remove('fixed-top');
            // remove padding top from body
            document.body.style.paddingTop = '0';
            } 
        });
    }); 

</script>

