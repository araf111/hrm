<?php

use App\Model\PetitionCommittee;
use Illuminate\Database\Seeder;

class PetitionCommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'id' => 1,
                'parliament_id' => '1',
                'date_from' => '2021-01-02',
                'date_to' => '2025-01-02',
                'user_id' => '2,3,4,5',
                'designation_id' => '1,2,3,3',
                'member_status' => '1,1,1,1',
                'quorum' => '3',
                'created_by' => '1',
            ]
        ];

        foreach ($datas as $key => $data) {
            $old = PetitionCommittee::where('id', $data['id'])->first();
            if (!$old) {
                PetitionCommittee::create($data);
            }
        }
    }
}
