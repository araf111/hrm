<?php

namespace App\Http\Controllers\Backend\ProfileActivities;

use App\Traits\FileCategoryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Model\Profile;
use App\Model\FileInfo;
use App\Model\FileCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;

class FileCategoryController extends Controller
{
    use FileCategoryTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(authInfo()->usertype=='mp' || authInfo()->usertype=='ps' || authInfo()->usertype=='speaker')
        {
            $data['allData'] = $this->all();
            return view('backend.profileActivities.file-category.index', $data);
        }else{
            return redirect()->route('dashboard')->with('error', Lang::get('You are not allowed on this menu!'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.profileActivities.file-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileCategory = $this->creationCategory($request);
        if ($fileCategory['status'] == true) {
            return redirect()->route('admin.profile-activities.file-category.index')->with('success', 'Successfully created');
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = $this->getCategory($id);
        return view('backend.profileActivities.file-category.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fileCategory = $this->creationCategory($request, $id);

        if ($fileCategory['status'] == true) {
            return redirect()->route('admin.profile-activities.file-category.index')->with('success', 'Successfully updated');
        } else {
            // dd($fileCategory['message']);
            return redirect()->back()->with('error', $fileCategory['message']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Cat = FileInfo::where('file_category_id',$id)->get();
            $countCat = count($Cat);
            if($countCat>0){
                return response()->json(["status"=>"cat exit in file"]);
            }else{
                $fileCat = FileCategory::find($id);
                $status = $fileCat->delete();
                if($status){
                $arr = array(
                    'status'=> 0,
                    'deleted_by'=>authInfo()->id
                );
                $update = $fileCat->update($arr);
            }
                return response()->json(["status"=>"success"]);
            }

        } catch (\Exception $e) {

            $errorMessage=$e->getMessage();
            $customMessage="Exception! Something went wrong please try again!";

            \Session::flash('error', $customMessage, true);
            return response()->json(['status'=>'error']);
        }
    }
}
