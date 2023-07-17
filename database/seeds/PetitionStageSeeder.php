<?php

use App\Model\PetitionStage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetitionStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('petition_stages')->truncate();
        $data = "

        INSERT INTO `petition_stages` (`id`, `rule_number`, `role_id`, `stage`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 102, 4, 1, 1, 1, 1, NULL, '2021-06-19 06:24:23', '2021-06-19 06:24:23'),
(2, 102, 5, 2, 1, 1, 1, NULL, '2021-06-19 06:24:23', '2021-06-19 06:24:23'),
(3, 102, 6, 3, 1, 1, 1, NULL, '2021-06-19 06:24:23', '2021-06-19 06:24:23'),
(4, 102, 7, 4, 1, 1, 1, NULL, '2021-06-19 06:24:23', '2021-06-19 06:24:23');


        ";

        DB::insert($data);
    }
}
