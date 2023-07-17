<?php

/**
 * Created by vs code.
 * User: araf
 * Date: 28/1/2023
 * Time: 12:48 PM
 */

namespace App\Repositories;


use App\Model\CompanyInfo;
// use App\Repositories\CompanyInfoRepository;
use App\Repositories\AbstractBaseRepository;

class CompanyInfoRepository extends AbstractBaseRepository
{
    protected $modelName = CompanyInfo::class;
}
