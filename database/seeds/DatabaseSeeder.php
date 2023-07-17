<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call( [
            SiteSettingSeeder::class,
            DepartmentSeeder::class,
            RolesSeeder::class,
            UserRolesSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
            MenuPermissionsSeeder::class,
            IconsSeeder::class,
            FloorTableSeeder::class,
            AreaSeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
            MinistriesSeeder::class,
            DesignationSeeder::class,
            ConstituenciesSeeder::class,
            ParliamentRuleSeeder::class,
            ParliamentSeeder::class,
            ParliamentSessionSeeder::class,
            PoliticalPartySeeder::class,
            ProfileSeeder::class,
            AppointmentSeeder::class,
            AttendanceSeeder::class,
            MpPsSeeder::class,

            AccommodationTypeSeeder::class,
            AccommodationBuildingSeeder::class,
            HouseBuildingSeeder::class,
            AccommodationApplicationTypeSeeder::class,
            AccommodationAssetTypeSeeder::class,
            AccommodationAssetSeeder::class,
            GlobalStatusSeeder::class,
            NoticeSeeder::class,
            HostelApplicationTypeSeeder::class,

            FlatTypeSeeder::class,
            FlatSeeder::class,
            HostelBuildingSeeder::class,
            HostelFloorSeeder::class,
            OfficeRoomTypeSeeder::class,
            OfficeRoomSeeder::class,
            ModuleSeeder::class,
            UserTypeSeeder::class,
            FurnitureElectronicGoodsSeeder::class,
            PetitionTypeSeeder::class,
            PetitionComitteeDesignationSeeder::class,
            MinistryWingSeeder::class,
            CircularSeeder::class,
            NoticeStageSeeder::class,
            PetitionOptSeeder::class,
            PetitionSeeder::class,
            PetitionStageSeeder::class,
            PetitionCommitteeSeeder::class,
            HolidayReasonSeeder::class,

            TravelAllowanceBillTypeSeeder::class,
            TravelAllowanceBillStatusSeeder::class,
        ] );
    }
}
