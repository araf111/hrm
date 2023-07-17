<?php

namespace App\Model\SSO;

use Exception;
use Firebase\JWT\JWT;

class AppLoginResponse
{
    private $ssoValues;

    function __construct()
    {
        $this->ssoValues = new SSOValues();
    }

    public function parseResponse($response, $sessionNonce)
    {

        if (empty($this->ssoValues->getSharedSecret())) {
            throw new Exception("Shared secret not found");
        }

        $decoded =  JWT::decode($response, $this->ssoValues->getSharedSecret(), array('HS256'));

        $utc = round(microtime(true) * 1000);

        $nonce = $decoded->nonce;

        if ($nonce !== $sessionNonce) {
            throw new Exception("Nonce not found");
        }

        $appLoginResponseDTO = new AppLoginResponseDTO();

        $appLoginResponseDTO->setUserName($decoded->username);
        $appLoginResponseDTO->setEmployeeRecordId($decoded->employee_record_id);
        $appLoginResponseDTO->setOfficeId($decoded->office_id);
        //$appLoginResponseDTO->setDesignation($decoded->designation);
        $appLoginResponseDTO->setOfficeUnitId($decoded->office_unit_id);
        $appLoginResponseDTO->setInchargeLabel($decoded->incharge_label);
        $appLoginResponseDTO->setOfficeUnitOrganogramId($decoded->office_unit_organogram_id);
        //$appLoginResponseDTO->setOfficeNameEng($decoded->office_name_eng);
        //$appLoginResponseDTO->setOfficeNameBng($decoded->office_name_bng);
        $appLoginResponseDTO->setOfficeMinistryId($decoded->office_ministry_id);
        //$appLoginResponseDTO->setOfficeMinistryNameEng($decoded->office_ministry_name_eng);
        //$appLoginResponseDTO->setOfficeMinistryNameBng($decoded->office_ministry_name_bng);
        //$appLoginResponseDTO->setUnitNameEng($decoded->unit_name_eng);
        //$appLoginResponseDTO->setUnitNameBng($decoded->unit_name_bng);
        $appLoginResponseDTO->setLandingPageUrl($decoded->landingpageurl);

        return $appLoginResponseDTO;
    }
}