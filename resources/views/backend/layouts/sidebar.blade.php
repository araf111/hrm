@php
$user_role_array = Auth::user()->user_role;
if (count($user_role_array) == 0) {
    $user_role = [];
} else {
    foreach ($user_role_array as $rolee) {
        $user_role[] = $rolee->role_id;
    }
}
$nav_menus = [];
@endphp

@if (in_array(1, $user_role))
    @php
        $modules = App\Model\Module::where('status', 1)
            ->orderBy('sort', 'asc')
            ->get();
        foreach ($modules as $module) {
            $nav_menus[$module->id]['name'] = session()->get('language') == 'bn' ? $module->name_bn : $module->name;
            $nav_menus[$module->id]['color'] = @$module->color;
            $parents1 = App\Model\Menu::where('module_id', $module->id)
                ->where('parent', 0)
                ->where('status', 1)
                ->orderBy('sort', 'asc')
                ->get();
            foreach ($parents1 as $parent1) {
                $nav_menus[$module->id]['menus'][$parent1->id]['menu_name'] = session()->get('language') == 'bn' ? $parent1->name_bn : $parent1->name;
                $nav_menus[$module->id]['menus'][$parent1->id]['menu_route'] = $parent1->route;
                $nav_menus[$module->id]['menus'][$parent1->id]['menu_icon'] = $parent1->icon;
                $parents2 = App\Model\Menu::where('parent', $parent1->id)
                    ->where('status', 1)
                    ->orderBy('sort', 'asc')
                    ->get();
                foreach ($parents2 as $parent2) {
                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_name'] = session()->get('language') == 'bn' ? $parent2->name_bn : $parent2->name;
                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_route'] = $parent2->route;
                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_icon'] = $parent2->icon;
                    $parents3 = App\Model\Menu::where('parent', $parent2->id)
                        ->where('status', 1)
                        ->orderBy('sort', 'asc')
                        ->get();
                    foreach ($parents3 as $parent3) {
                        $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_name'] = session()->get('language') == 'bn' ? $parent3->name_bn : $parent3->name;
                        $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_route'] = $parent3->route;
                        $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_icon'] = $parent3->icon;
                        $parents4 = App\Model\Menu::where('parent', $parent3->id)
                            ->where('status', 1)
                            ->orderBy('sort', 'asc')
                            ->get();
                        foreach ($parents4 as $parent4) {
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_name'] = session()->get('language') == 'bn' ? $parent4->name_bn : $parent4->name;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_route'] = $parent4->route;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_icon'] = $parent4->icon;
                            $parents4 = App\Model\Menu::where('parent', $parent3->id)
                                ->where('status', 1)
                                ->orderBy('sort', 'asc')
                                ->get();
                        }
                    }
                }
            }
        }
    @endphp
@else
    @php
        $modules = App\Model\Module::where('status', 1)
            ->orderBy('sort', 'asc')
            ->get();
        foreach ($modules as $module) {
            $nav_menus[$module->id]['name'] = session()->get('language') == 'bn' ? $module->name_bn : $module->name;
            $nav_menus[$module->id]['color'] = @$module->color;
            $parents1 = App\Model\Menu::where('module_id', $module->id)
                ->where('parent', 0)
                ->whereNotIn('id', [1, 2])
                ->where('status', 1)
                ->orderBy('sort', 'asc')
                ->get();
            foreach ($parents1 as $parent1) {
                if (
                    App\Model\MenuPermission::where('menu_id', $parent1->id)
                        ->whereIn('role_id', @$user_role)
                        ->first()
                ) {
                    $nav_menus[$module->id]['menus'][$parent1->id]['menu_name'] = session()->get('language') == 'bn' ? $parent1->name_bn : $parent1->name;
                    $nav_menus[$module->id]['menus'][$parent1->id]['menu_route'] = $parent1->route;
                    $nav_menus[$module->id]['menus'][$parent1->id]['menu_icon'] = $parent1->icon;
                    $parents2 = App\Model\Menu::where('parent', $parent1->id)
                        ->where('status', 1)
                        ->orderBy('sort', 'asc')
                        ->get();
                    foreach ($parents2 as $parent2) {
                        if (
                            App\Model\MenuPermission::where('menu_id', $parent2->id)
                                ->whereIn('role_id', @$user_role)
                                ->first()
                        ) {
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_name'] = session()->get('language') == 'bn' ? $parent2->name_bn : $parent2->name;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_route'] = $parent2->route;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_icon'] = $parent2->icon;
                            $parents3 = App\Model\Menu::where('parent', $parent2->id)
                                ->where('status', 1)
                                ->orderBy('sort', 'asc')
                                ->get();
                            foreach ($parents3 as $parent3) {
                                if (
                                    App\Model\MenuPermission::where('menu_id', $parent3->id)
                                        ->whereIn('role_id', @$user_role)
                                        ->first()
                                ) {
                                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_name'] = session()->get('language') == 'bn' ? $parent3->name_bn : $parent3->name;
                                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_route'] = $parent3->route;
                                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_icon'] = $parent3->icon;
                                    $parents4 = App\Model\Menu::where('parent', $parent3->id)
                                        ->where('status', 1)
                                        ->orderBy('sort', 'asc')
                                        ->get();
                                    foreach ($parents4 as $parent4) {
                                        if (
                                            App\Model\MenuPermission::where('menu_id', $parent4->id)
                                                ->whereIn('role_id', @$user_role)
                                                ->first()
                                        ) {
                                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_name'] = session()->get('language') == 'bn' ? $parent4->name_bn : $parent4->name;
                                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_route'] = $parent4->route;
                                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_icon'] = $parent4->icon;
                                            $parents5 = App\Model\Menu::where('parent', $parent4->id)
                                                ->where('status', 1)
                                                ->orderBy('sort', 'asc')
                                                ->get();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    @endphp
@endif

<aside class="main-sidebar elevation-4" style="background: #248dc1;">
    <a href="{{ url('dashboard') }}" class="brand-link text-sm" style="background: #58b1fc;">
        <img src="{{ asset('public/backend/img/byte-solution.png') }}" alt="Admin Dashboard"
            class="brand-image img-circle elevation-3" style="opacity: .8; width: 30px;">
        <span class="brand-text font-weight-light" style="color: white;font-size: 18px">@lang('Byte Solution')</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2" id="swupMenu">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact pb-4" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link" style="color:#fff">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>@lang('Dashboard')</p>
                    </a>
                </li>
                @foreach ($nav_menus as $nav_menu)
                    @if (@$nav_menu['menus'])
                        @if (@$nav_menu['name'])
                            <li class="nav-header">{{ $nav_menu['name'] }}</li>
                        @endif
                        @foreach ($nav_menu['menus'] as $nav_menu1)
                            @if (@$nav_menu1['child'] != null)
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                        <i
                                            class="nav-icon far {{ $nav_menu1['menu_icon'] ? $nav_menu1['menu_icon'] : 'fa-circle' }}"></i>
                                        <p>
                                            {{ $nav_menu1['menu_name'] }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($nav_menu1['child'] as $nav_menu2)
                                            @if (@$nav_menu2['child'] != null)
                                                <li class="nav-item has-treeview">
                                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                        <i
                                                            class="nav-icon far {{ $nav_menu2['menu_icon'] ? $nav_menu2['menu_icon'] : 'fa-circle' }}"></i>
                                                        <p>
                                                            {{ $nav_menu2['menu_name'] }}
                                                            <i class="right fas fa-angle-left"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        @foreach ($nav_menu2['child'] as $nav_menu3)
                                                            @if (@$nav_menu3['child'] != null)
                                                                <li class="nav-item has-treeview">
                                                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                        <i
                                                                            class="nav-icon far {{ $nav_menu3['menu_icon'] ? $nav_menu3['menu_icon'] : 'fa-circle' }}"></i>
                                                                        <p>
                                                                            {{ $nav_menu3['menu_name'] }}
                                                                            <i class="right fas fa-angle-left"></i>
                                                                        </p>
                                                                    </a>
                                                                    <ul class="nav nav-treeview">
                                                                        @foreach ($nav_menu3['child'] as $nav_menu4)
                                                                            @if (@$nav_menu4['child'] != null)
                                                                                <li class="nav-item has-treeview">
                                                                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                                        <i
                                                                                            class="nav-icon far {{ $nav_menu4['menu_icon'] ? $nav_menu4['menu_icon'] : 'fa-circle' }}"></i>
                                                                                        <p>
                                                                                            {{ $nav_menu4['menu_name'] }}
                                                                                            <i
                                                                                                class="right fas fa-angle-left"></i>
                                                                                        </p>
                                                                                    </a>
                                                                                    <ul class="nav nav-treeview">
                                                                                        @foreach ($nav_menu4['child'] as $nav_menu5)
                                                                                            @if (@$nav_menu5['child'] != null)
                                                                                                <li
                                                                                                    class="nav-item has-treeview">
                                                                                                    <a href="#"
                                                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                                                        <i
                                                                                                            class="nav-icon far {{ $nav_menu5['menu_icon'] ? $nav_menu5['menu_icon'] : 'fa-circle' }}"></i>
                                                                                                        <p>
                                                                                                            {{ $nav_menu5['menu_name'] }}
                                                                                                            <i
                                                                                                                class="right fas fa-angle-left"></i>
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            @else
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ $nav_menu5['menu_route'] == '#' ? '#' : url($nav_menu5['menu_route']) }}"
                                                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}"
                                                                                                        data-swup>
                                                                                                        <i
                                                                                                            class="nav-icon far {{ $nav_menu5['menu_icon'] ? $nav_menu5['menu_icon'] : 'fa-circle' }}"></i>
                                                                                                        <p>
                                                                                                            {{ $nav_menu5['menu_name'] }}
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                <li class="nav-item">
                                                                                    <a href="{{ $nav_menu4['menu_route'] == '#' ? '#' : url($nav_menu4['menu_route']) }}"
                                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}" data-swup>
                                                                                        <i
                                                                                            class="nav-icon far {{ $nav_menu4['menu_icon'] ? $nav_menu4['menu_icon'] : 'fa-circle' }}"></i>
                                                                                        <p>
                                                                                            {{ $nav_menu4['menu_name'] }}
                                                                                        </p>
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @else
                                                                <li class="nav-item">
                                                                    <a href="{{ $nav_menu3['menu_route'] == '#' ? '#' : url($nav_menu3['menu_route']) }}"
                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}" data-swup>
                                                                        <i
                                                                            class="nav-icon far {{ $nav_menu3['menu_icon'] ? $nav_menu3['menu_icon'] : 'fa-circle' }}"></i>
                                                                        <p>
                                                                            {{ $nav_menu3['menu_name'] }}
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="nav-item">
                                                    <a href="{{ $nav_menu2['menu_route'] == '#' ? '#' : url($nav_menu2['menu_route']) }}"
                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}" data-swup>
                                                        <i
                                                            class="nav-icon far {{ $nav_menu2['menu_icon'] ? $nav_menu2['menu_icon'] : 'fa-circle' }}"></i>
                                                        <p>
                                                            {{ $nav_menu2['menu_name'] }}
                                                        </p>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ $nav_menu1['menu_route'] == '#' ? '#' : url($nav_menu1['menu_route']) }}"
                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}" data-swup>
                                        <i
                                            class="nav-icon far {{ $nav_menu1['menu_icon'] ? $nav_menu1['menu_icon'] : 'fa-circle' }}"></i>
                                        <p>
                                            {{ $nav_menu1['menu_name'] }}
                                        </p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

<script type="text/javascript">
    $(document).ready(function() {
        var mylist = [];
        var list_counter = 1;
        $(".nav-item a").each(function() {
            if ($(this).attr('href') != '#') {
                mylist.push({
                    id: list_counter++,
                    name: $(this).attr('href')
                });
            }
        });
        navigationMenu(mylist);

        function highlight_navigation(list_array) {
            var path = window.location.href;
            path = path.replace(/\/$/, "");
            path = decodeURIComponent(path);
            var max_value = [];
            for (var i = 0; i < list_array.length; i++) {
                var percent = similar(list_array[i].name, path);
                max_value.push({
                    'name': list_array[i].name,
                    'percent': percent
                });
            }
            var xValues = max_value.map(function(o) {
                return o.percent;
            });
            xValues = Array.from(max_value, o => o.percent);
            var xMax = Math.max.apply(null, xValues);
            xMax = Math.max(...xValues);
            var maxXObjects = max_value.filter(function(o) {
                return o.percent === xMax;
            });
            var the_arr = maxXObjects[0].name.split('/');
            return (the_arr.join('/'));
        }

        function navigationMenu(menu_array = null) {
            var url;
            var url_path = window.location.pathname;
            if (menu_array == null) {
                url = window.location.href;
            } else {
                if (menu_array.some(item => item.name === url_path)) {
                    url = window.location.href;
                } else {
                    url = highlight_navigation(menu_array);
                }
            }
            $('.nav-item a[href="' + url + '"]').addClass('active');
            $('.nav-item a[href="' + url + '"]').parents('ul').css('display', 'block');
            $('.nav-item a[href="' + url + '"]').parents('li').addClass('nav-item menu-open');
            $('.nav-item a').filter(function() {
                return this.href == url;
            }).addClass('active');
        }
    });
</script>
