<?php


namespace App\Model\SSO\Lib;


class UserInformationDTO
{
    private $upazilaBbsCode;
    private $office_origin_id;
    private $ref_origin_unit_org_id;
    private $is_admin;
    private $office_id;
    private $divisionBbsCode;
    private $uid;
    private $office_name_eng;
    private $upazila_name_eng;
    private $upazila_name_bng;
    private $layer_level;
    private $is_default_role;
    private $office_name_bng;
    private $office_ministry_id;
    private $office_origin_unit_id;
    private $office_head;
    private $designation_bng;
    private $districtBbsCode;
    private $layer_sequence;
    private $employee_record_id;
    private $name_bng;
    private $division_name_bng;
    private $geo_district_id;
    private $office_unit_id;
    private $officeUnitOrganogramId;
    private $unit_name_bng;
    private $geo_upazila_id;
    private $district_name_bng;
    private $geo_division_id;
    private $designation_level;
    private $district_name_eng;
    private $personal_email;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getUpazilaBbsCode()
    {
        return $this->upazilaBbsCode;
    }

    /**
     * @param mixed $upazilaBbsCode
     */
    public function setUpazilaBbsCode($upazilaBbsCode): void
    {
        $this->upazilaBbsCode = $upazilaBbsCode;
    }

    /**
     * @return mixed
     */
    public function getOfficeOriginId()
    {
        return $this->office_origin_id;
    }

    /**
     * @param mixed $office_origin_id
     */
    public function setOfficeOriginId($office_origin_id): void
    {
        $this->office_origin_id = $office_origin_id;
    }

    /**
     * @return mixed
     */
    public function getRefOriginUnitOrgId()
    {
        return $this->ref_origin_unit_org_id;
    }

    /**
     * @param mixed $ref_origin_unit_org_id
     */
    public function setRefOriginUnitOrgId($ref_origin_unit_org_id): void
    {
        $this->ref_origin_unit_org_id = $ref_origin_unit_org_id;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @param mixed $is_admin
     */
    public function setIsAdmin($is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    /**
     * @return mixed
     */
    public function getOfficeId()
    {
        return $this->office_id;
    }

    /**
     * @param mixed $office_id
     */
    public function setOfficeId($office_id): void
    {
        $this->office_id = $office_id;
    }

    /**
     * @return mixed
     */
    public function getDivisionBbsCode()
    {
        return $this->divisionBbsCode;
    }

    /**
     * @param mixed $divisionBbsCode
     */
    public function setDivisionBbsCode($divisionBbsCode): void
    {
        $this->divisionBbsCode = $divisionBbsCode;
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getOfficeNameEng()
    {
        return $this->office_name_eng;
    }

    /**
     * @param mixed $office_name_eng
     */
    public function setOfficeNameEng($office_name_eng): void
    {
        $this->office_name_eng = $office_name_eng;
    }

    /**
     * @return mixed
     */
    public function getUpazilaNameEng()
    {
        return $this->upazila_name_eng;
    }

    /**
     * @param mixed $upazila_name_eng
     */
    public function setUpazilaNameEng($upazila_name_eng): void
    {
        $this->upazila_name_eng = $upazila_name_eng;
    }

    /**
     * @return mixed
     */
    public function getUpazilaNameBng()
    {
        return $this->upazila_name_bng;
    }

    /**
     * @param mixed $upazila_name_bng
     */
    public function setUpazilaNameBng($upazila_name_bng): void
    {
        $this->upazila_name_bng = $upazila_name_bng;
    }

    /**
     * @return mixed
     */
    public function getLayerLevel()
    {
        return $this->layer_level;
    }

    /**
     * @param mixed $layer_level
     */
    public function setLayerLevel($layer_level): void
    {
        $this->layer_level = $layer_level;
    }

    /**
     * @return mixed
     */
    public function getIsDefaultRole()
    {
        return $this->is_default_role;
    }

    /**
     * @param mixed $is_default_role
     */
    public function setIsDefaultRole($is_default_role): void
    {
        $this->is_default_role = $is_default_role;
    }

    /**
     * @return mixed
     */
    public function getOfficeNameBng()
    {
        return $this->office_name_bng;
    }

    /**
     * @param mixed $office_name_bng
     */
    public function setOfficeNameBng($office_name_bng): void
    {
        $this->office_name_bng = $office_name_bng;
    }

    /**
     * @return mixed
     */
    public function getOfficeMinistryId()
    {
        return $this->office_ministry_id;
    }

    /**
     * @param mixed $office_ministry_id
     */
    public function setOfficeMinistryId($office_ministry_id): void
    {
        $this->office_ministry_id = $office_ministry_id;
    }

    /**
     * @return mixed
     */
    public function getOfficeOriginUnitId()
    {
        return $this->office_origin_unit_id;
    }

    /**
     * @param mixed $office_origin_unit_id
     */
    public function setOfficeOriginUnitId($office_origin_unit_id): void
    {
        $this->office_origin_unit_id = $office_origin_unit_id;
    }

    /**
     * @return mixed
     */
    public function getOfficeHead()
    {
        return $this->office_head;
    }

    /**
     * @param mixed $office_head
     */
    public function setOfficeHead($office_head): void
    {
        $this->office_head = $office_head;
    }

    /**
     * @return mixed
     */
    public function getDesignationBng()
    {
        return $this->designation_bng;
    }

    /**
     * @param mixed $designation_bng
     */
    public function setDesignationBng($designation_bng): void
    {
        $this->designation_bng = $designation_bng;
    }

    /**
     * @return mixed
     */
    public function getDistrictBbsCode()
    {
        return $this->districtBbsCode;
    }

    /**
     * @param mixed $districtBbsCode
     */
    public function setDistrictBbsCode($districtBbsCode): void
    {
        $this->districtBbsCode = $districtBbsCode;
    }

    /**
     * @return mixed
     */
    public function getLayerSequence()
    {
        return $this->layer_sequence;
    }

    /**
     * @param mixed $layer_sequence
     */
    public function setLayerSequence($layer_sequence): void
    {
        $this->layer_sequence = $layer_sequence;
    }

    /**
     * @return mixed
     */
    public function getEmployeeRecordId()
    {
        return $this->employee_record_id;
    }

    /**
     * @param mixed $employee_record_id
     */
    public function setEmployeeRecordId($employee_record_id): void
    {
        $this->employee_record_id = $employee_record_id;
    }

    /**
     * @return mixed
     */
    public function getNameBng()
    {
        return $this->name_bng;
    }

    /**
     * @param mixed $name_bng
     */
    public function setNameBng($name_bng): void
    {
        $this->name_bng = $name_bng;
    }

    /**
     * @return mixed
     */
    public function getDivisionNameBng()
    {
        return $this->division_name_bng;
    }

    /**
     * @param mixed $division_name_bng
     */
    public function setDivisionNameBng($division_name_bng): void
    {
        $this->division_name_bng = $division_name_bng;
    }

    /**
     * @return mixed
     */
    public function getGeoDistrictId()
    {
        return $this->geo_district_id;
    }

    /**
     * @param mixed $geo_district_id
     */
    public function setGeoDistrictId($geo_district_id): void
    {
        $this->geo_district_id = $geo_district_id;
    }

    /**
     * @return mixed
     */
    public function getOfficeUnitId()
    {
        return $this->office_unit_id;
    }

    /**
     * @param mixed $office_unit_id
     */
    public function setOfficeUnitId($office_unit_id): void
    {
        $this->office_unit_id = $office_unit_id;
    }

    /**
     * @return mixed
     */
    public function getOfficeUnitOrganogramId()
    {
        return $this->officeUnitOrganogramId;
    }

    /**
     * @param mixed $officeUnitOrganogramId
     */
    public function setOfficeUnitOrganogramId($officeUnitOrganogramId): void
    {
        $this->officeUnitOrganogramId = $officeUnitOrganogramId;
    }

    /**
     * @return mixed
     */
    public function getUnitNameBng()
    {
        return $this->unit_name_bng;
    }

    /**
     * @param mixed $unit_name_bng
     */
    public function setUnitNameBng($unit_name_bng): void
    {
        $this->unit_name_bng = $unit_name_bng;
    }

    /**
     * @return mixed
     */
    public function getGeoUpazilaId()
    {
        return $this->geo_upazila_id;
    }

    /**
     * @param mixed $geo_upazila_id
     */
    public function setGeoUpazilaId($geo_upazila_id): void
    {
        $this->geo_upazila_id = $geo_upazila_id;
    }

    /**
     * @return mixed
     */
    public function getDistrictNameBng()
    {
        return $this->district_name_bng;
    }

    /**
     * @param mixed $district_name_bng
     */
    public function setDistrictNameBng($district_name_bng): void
    {
        $this->district_name_bng = $district_name_bng;
    }

    /**
     * @return mixed
     */
    public function getGeoDivisionId()
    {
        return $this->geo_division_id;
    }

    /**
     * @param mixed $geo_division_id
     */
    public function setGeoDivisionId($geo_division_id): void
    {
        $this->geo_division_id = $geo_division_id;
    }

    /**
     * @return mixed
     */
    public function getDesignationLevel()
    {
        return $this->designation_level;
    }

    /**
     * @param mixed $designation_level
     */
    public function setDesignationLevel($designation_level): void
    {
        $this->designation_level = $designation_level;
    }

    /**
     * @return mixed
     */
    public function getDistrictNameEng()
    {
        return $this->district_name_eng;
    }

    /**
     * @param mixed $district_name_eng
     */
    public function setDistrictNameEng($district_name_eng): void
    {
        $this->district_name_eng = $district_name_eng;
    }

    /**
     * @return mixed
     */
    public function getPersonalEmail()
    {
        return $this->personal_email;
    }

    /**
     * @param mixed $personal_email
     */
    public function setPersonalEmail($personal_email): void
    {
        $this->personal_email = $personal_email;
    }

    public static function parseJSON($jsonData)
    {
        $userInformationDTO = new UserInformationDTO();
        $userInformationDTO->setNameBng($jsonData[0]['name_bng']);
        return $userInformationDTO;
    }

}