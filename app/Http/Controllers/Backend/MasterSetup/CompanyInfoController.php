<?php

namespace App\Http\Controllers\Backend\MasterSetup;

use App\Traits\CrudTrait;
use App\Traits\FileTrait;
use App\Model\CompanyInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CompanyInfoService;
use App\Http\Requests\CompanyInfoRequest;
use App\Repositories\CompanyInfoRepository;

class CompanyInfoController extends Controller
{
    use FileTrait;

    private $companyInfoService;
    private $CompanyInfoRepository;

    /**
     * ConpanyInfoController constructor.
     * @param CompanyInfoService $companyInfoService
     */
    public function __construct(
        CompanyInfoService $companyInfoService,
        CompanyInfoRepository $CompanyInfoRepository
    ) {
        $this->companyInfoService = $companyInfoService;
        $this->CompanyInfoRepository = $CompanyInfoRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('hii');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.master_setup.company_info.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyInfoRequest $request)
    {
        $this->companyInfoService->store($request, $request->all());
        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyInfo $companyInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompanyInfo  $companyInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyInfo $companyInfo)
    {
        //
    }
}
