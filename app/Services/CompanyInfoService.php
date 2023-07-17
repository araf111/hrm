<?php

/**
 * Created by VS Code.
 * User: Araf
 * Date: 28/01/2023
 * Time: 12:48 PM
 */

namespace App\Services;


use Carbon\Carbon;
use App\Traits\CrudTrait;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\CompanyInfoRepository;


class CompanyInfoService
{
    use CrudTrait, FileTrait;

    private $repository;

    /**
     * CompanyInfoService constructor.
     * @param CompanyInfoRepository $repository
     */
    public function __construct(
        CompanyInfoRepository $repository

    ) {
        $this->repository = $repository;
        $this->setActionRepository($repository);
    }

    public function store($request, array $data)
    {
        if (array_key_exists('company_logo', $data)) {
            $file = $data['company_logo'];
            $path = $this->upload($file, 'company-logo');
            $data['company_logo'] = $path;
        }
        if (array_key_exists('company_signature', $data)) {
            $file = $data['company_signature'];
            $path = $this->upload($file, 'company-logo');
            $data['company_signature'] = $path;
        }

        $this->save($data);

        $response = [
            'status' => 200,
            'message' => Lang::get('Data Saved successfully'),
            'type' => 'success'
        ];
        return response($response);

        // if ($status) {
        //     return response()->json(['status' => true, 'message' => Lang::get('Data Saved successfully')], 400);
        // } else {
        //     return response()->json(['status' => false, 'message' => Lang::get('Data Not Saved')], 400);
        // }
        // if ($status) {
        //     $data = array(
        //         'status' => 1,
        //         'message' => Lang::get('Data Saved successfully'),
        //         'type' => 'success'
        //     );
        // } else {
        //     $data = array(
        //         'status' => 0,
        //         'message' => Lang::get('Data Not Saved'),
        //         'type' => 'warning'
        //     );
        // }
        // echo json_encode($data);
    }

    public function updateRequest()
    {
        //
    }
}
