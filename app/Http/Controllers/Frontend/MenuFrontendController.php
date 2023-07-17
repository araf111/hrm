<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Model\Frontend\MenuFrontend;

class MenuFrontendController extends Controller
{
    public function list()
	{
		return view('frontend.admin.menu-management.menu-info.list');
	}

	public function sorting(Request $request){

		$data = json_decode(urldecode($request->nestableoutput));
		if(count($data)){
			foreach ($data as $key1 => $datum){
				$store1 = MenuFrontend::where('id',$datum->id)->first();
				$store1->sort = $key1+1;
				$store1->parent = 0;
				$store1->save();
				if(@$datum->children){
					$data = $datum->children;
					foreach ($data as $key2 => $datum){
						$store2 = MenuFrontend::where('id',$datum->id)->first();
						$store2->sort = $key2+1;
						$store2->parent = $store1->id;
						$store2->save();
						if(@$datum->children){
							$data = $datum->children;
							foreach ($data as $key3 => $datum){
								$store3 = MenuFrontend::where('id',$datum->id)->first();
								$store3->sort = $key3+1;
								$store3->parent = $store2->id;
								$store3->save();
								if(@$datum->children){
									$data = $datum->children;
									foreach ($data as $key4 => $datum){
										$store4 = MenuFrontend::where('id',$datum->id)->first();
										$store4->sort = $key4+1;
										$store4->parent = $store3->id;
										$store4->save();
										if(@$datum->children){
											$data = $datum->children;
											foreach ($data as $key5 => $datum){
												$store5 = MenuFrontend::where('id',$datum->id)->first();
												$store5->sort = $key5+1;
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

		return redirect()->route('admin.landing_page.menu-info.list')->with('success','Well done! successfully Sorting');
	}

	public function add()
	{
		$data['menus'] = MenuFrontend::orderBy('sort','asc')->get();
		return view('frontend.admin.menu-management.menu-info.add',$data);
	}


	public function store(Request $request)
	{
		// dd($request->all());
		$this->validate($request, [
			'name' => 'required',
			'name_bn' => 'required',
			'url' => 'required',
			'status' => 'required',
			'sort' =>'required'
		]);  

		DB::beginTransaction();
		try {
			$menuData = new MenuFrontend;
			$menuData->name   = $request->name;
			$menuData->name_bn   = $request->name_bn;

			if($request->sub_menu_4 != ''){
				$parent = $request->sub_menu_4;
			}else if($request->sub_menu_3 != ''){
				$parent = $request->sub_menu_3;
			}else if($request->sub_menu_2 != ''){
				$parent = $request->sub_menu_2;
			}else if($request->sub_menu_1 != ''){
				$parent = $request->sub_menu_1;
			}else if($request->main_menu != ''){
				$parent = $request->main_menu;
			}else{
				$parent = 0;
			}

			$menuData->parent = $parent;
			$menuData->route  = $request->url;
			$menuData->sort   = $request->sort;
			$menuData->status = $request->status;
			$menuData->icon   = $request->icon;
            $menuData->save();

			DB::commit();
			return response()->json(['status'=>'success','message'=>Lang::get('Data Successfully Insert')]);
		} catch (\Exception $e) {
			DB::rollback();
			dd($e);
		}
	}

	public function edit(Request $request,$id)
	{
		$data['editData'] = MenuFrontend::find($id);

		$menu_parent = [];
		$x = $data['editData']['parent'];
		while($x > 0) {
			$menu_parent[] = $x;
			$menu = MenuFrontend::find($x);
			$x = $menu['parent'];
		} 
		$data['menu_parent']=array_reverse($menu_parent);
		return view('frontend.admin.menu-management.menu-info.add',$data);
	}

	public function update(Request $request,$id)
	{
		$this->validate($request, [
			'name' => 'required',
			'name_bn' => 'required',
			'url' => 'required',
			'status' => 'required',
			'sort' =>'required'
		]);    

		DB::beginTransaction();
		// try {
			$menuData = MenuFrontend::find($id);
			$menuData->name   = $request->name;
			$menuData->name_bn   = $request->name_bn;

			if($request->sub_menu_4 != ''){
				$parent = $request->sub_menu_4;
			}else if($request->sub_menu_3 != ''){
				$parent = $request->sub_menu_3;
			}else if($request->sub_menu_2 != ''){
				$parent = $request->sub_menu_2;
			}else if($request->sub_menu_1 != ''){
				$parent = $request->sub_menu_1;
			}else if($request->main_menu != ''){
				$parent = $request->main_menu;
			}else{
				$parent = 0;
			}

			$menuData->parent = $parent;
			$menuData->route    = $request->url;
			$menuData->sort   = $request->sort;
			$menuData->status = $request->status;
			$menuData->icon   = $request->icon;
            $menuData->save();
			
			DB::commit();
			return response()->json(['status'=>'success','message'=>Lang::get('Data Successfully Updated')]);
		// } catch (\Exception $e) {
		// 	DB::rollback();
		// 	dd($e);
		// }
	}

	public function getSubMenuFrontend(Request $request){
		$parent = $request->parent;
		return getSubMenuFrontend($wheredata=['parent'=>$parent],$selected_sub_menu_id = null);
	}
	
}
