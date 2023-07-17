<?php

namespace App\Http\Controllers\Backend\MenuManagement;

use App\Http\Controllers\Controller;
use App\Model\Module;
use App\Model\Menu;
use App\Model\MenuRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class MenuController extends Controller
{
	public function list()
	{
		// dd('hii');
		return view('backend.menu-management.menu-info.list');
	}

	public function sorting(Request $request)
	{

		$data = json_decode(urldecode($request->nestableoutput));
		if (count($data)) {
			foreach ($data as $key1 => $datum) {
				$store1 = Menu::where('id', $datum->id)->first();
				$store1->sort = $key1 + 1;
				$store1->parent = 0;
				$store1->save();
				if (@$datum->children) {
					$data = $datum->children;
					foreach ($data as $key2 => $datum) {
						$store2 = Menu::where('id', $datum->id)->first();
						$store2->sort = $key2 + 1;
						$store2->parent = $store1->id;
						$store2->save();
						if (@$datum->children) {
							$data = $datum->children;
							foreach ($data as $key3 => $datum) {
								$store3 = Menu::where('id', $datum->id)->first();
								$store3->sort = $key3 + 1;
								$store3->parent = $store2->id;
								$store3->save();
								if (@$datum->children) {
									$data = $datum->children;
									foreach ($data as $key4 => $datum) {
										$store4 = Menu::where('id', $datum->id)->first();
										$store4->sort = $key4 + 1;
										$store4->parent = $store3->id;
										$store4->save();
										if (@$datum->children) {
											$data = $datum->children;
											foreach ($data as $key5 => $datum) {
												$store5 = Menu::where('id', $datum->id)->first();
												$store5->sort = $key5 + 1;
												$store5->parent = $store4->id;
												$store5->save();
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return redirect()->route('admin.menu-management.menu-info.list')->with('success', 'Well done! successfully Sorting');
	}

	public function add()
	{
		$data['menus'] = Menu::orderBy('sort', 'asc')->get();
		$data['modules'] = Module::orderBy('sort', 'asc')->get();
		return view('backend.menu-management.menu-info.add', $data);
	}


	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'name_bn' => 'required',
			'module_id' => 'required',
			'url' => 'required',
			'status' => 'required',
			'sort' => 'required'
		]);

		DB::beginTransaction();
		try {
			$menuData = new Menu;
			$menuData->name   = $request->name;
			$menuData->name_bn   = $request->name_bn;
			$menuData->module_id   = $request->module_id;

			if ($request->sub_menu_4 != '') {
				$parent = $request->sub_menu_4;
			} else if ($request->sub_menu_3 != '') {
				$parent = $request->sub_menu_3;
			} else if ($request->sub_menu_2 != '') {
				$parent = $request->sub_menu_2;
			} else if ($request->sub_menu_1 != '') {
				$parent = $request->sub_menu_1;
			} else if ($request->main_menu != '') {
				$parent = $request->main_menu;
			} else {
				$parent = 0;
			}

			$menuData->parent = $parent;
			$menuData->route  = $request->url;
			$menuData->sort   = $request->sort;
			$menuData->status = $request->status;
			$menuData->icon   = $request->icon;

			if ($menuData->save()) {
				if ($request->newname != null) {
					foreach ($request->newname as $key => $value) {
						$section_or_route_exist = MenuRoute::where('route', @$request->newurl[$key])->first();
						if ($section_or_route_exist) {
							return response()->json(['status' => 'error', 'message' => '" ' . @$request->newurl[$key] . ' " Already Exist']);
						}
						$exist = MenuRoute::find($key);
						if ($exist != null) {
							$menuroute = $exist;
						} else {
							$menuroute = new MenuRoute;
						}

						$menuroute->menu_id = $menuData->id;
						$menuroute->section_or_route = $request->newsection_or_route[$key];
						$menuroute->name = $request->newname[$key];
						$menuroute->name_bn = $request->newname_bn[$key];
						$menuroute->sort = $request->newsort[$key];
						$menuroute->route = $request->newurl[$key];
						$menuroute->status = '1';
						$menuroute->save();
					}
				}
			}
			DB::commit();
			return response()->json(['status' => 'success', 'message' => Lang::get('Data Successfully Insert')]);
		} catch (\Exception $e) {
			DB::rollback();
			dd($e);
		}
	}

	public function edit(Request $request, $id)
	{
		$data['editData'] = Menu::find($id);

		$menu_parent = [];
		$x = $data['editData']['parent'];
		while ($x > 0) {
			$menu_parent[] = $x;
			$menu = Menu::find($x);
			$x = $menu['parent'];
		}
		$data['modules'] = Module::orderBy('sort', 'asc')->get();
		$data['menu_parent'] = array_reverse($menu_parent);
		$data['menuRoutes'] = MenuRoute::where('menu_id', $id)->orderBy('sort', 'asc')->get();
		// dd($data, $x);
		return view('backend.menu-management.menu-info.add', $data);
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required',
			'name_bn' => 'required',
			'module_id' => 'required',
			'url' => 'required',
			'status' => 'required',
			'sort' => 'required'
		]);

		DB::beginTransaction();
		// try {
		$menuData = Menu::find($id);
		$menuData->name   = $request->name;
		$menuData->name_bn   = $request->name_bn;
		$menuData->module_id   = $request->module_id;

		if ($request->sub_menu_4 != '') {
			$parent = $request->sub_menu_4;
		} else if ($request->sub_menu_3 != '') {
			$parent = $request->sub_menu_3;
		} else if ($request->sub_menu_2 != '') {
			$parent = $request->sub_menu_2;
		} else if ($request->sub_menu_1 != '') {
			$parent = $request->sub_menu_1;
		} else if ($request->main_menu != '') {
			$parent = $request->main_menu;
		} else {
			$parent = 0;
		}

		$menuData->parent = $parent;
		$menuData->route    = $request->url;
		$menuData->sort   = $request->sort;
		$menuData->status = $request->status;
		$menuData->icon   = $request->icon;

		if ($menuData->save()) {
			if ($request->newname) {
				MenuRoute::where('menu_id', $menuData->id)->whereNotIn('id', array_keys($request->newname))->delete();
			} else {
				MenuRoute::where('menu_id', $menuData->id)->delete();
			}
			if ($request->newname != null) {
				foreach ($request->newname as $key => $value) {
					$section_or_route_exist = MenuRoute::where('route', @$request->newurl[$key])->where('id', '!=', $key)->first();
					if ($section_or_route_exist) {
						return response()->json(['status' => 'error', 'message' => '" ' . @$request->newurl[$key] . ' " Already Exist']);
					}
					$exist = MenuRoute::find($key);
					if ($exist != null) {
						$menuroute = $exist;
					} else {
						$menuroute = new MenuRoute;
					}

					$menuroute->menu_id = $menuData->id;
					$menuroute->section_or_route = $request->newsection_or_route[$key];
					$menuroute->name = $request->newname[$key];
					$menuroute->name_bn = $request->newname_bn[$key];
					$menuroute->sort = $request->newsort[$key];
					$menuroute->route = $request->newurl[$key];
					$menuroute->status = '1';
					$menuroute->save();
				}
			}
		}
		DB::commit();
		return response()->json(['status' => 'success', 'message' => Lang::get('Data Successfully Updated')]);
		// } catch (\Exception $e) {
		// 	DB::rollback();
		// 	dd($e);
		// }
	}

	public function getSubMenu(Request $request)
	{
		$parent = $request->parent;
		return getSubMenu($wheredata = ['parent' => $parent], $selected_sub_menu_id = null);
	}
}
