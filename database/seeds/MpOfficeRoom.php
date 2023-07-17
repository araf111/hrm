<?php

use Illuminate\Database\Seeder;

class MpOfficeRoom extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mp_office_rooms')->insert(
            [
            'mp_id' => 5,
            'room_ids' => '5,6,2,4',
            'status' => 1,
            'allocation_date' => now(),
            'disallocation_date' => now(),
            'created_by' => 3,
            'updated_by' => 3,
            'created_at' => now()
            ]
       );
    }
}
