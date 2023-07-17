<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidayReasonSeeder extends Seeder
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
                'name_bn' =>'চিকিৎসার জন্য বর্হি বাংলাদেশ ছুটি',
                'name' =>'Outer Bangladesh Leave for Treatment',
            ]
        ];

        foreach ($datas as $key => $data) {
            $old = DB::table('holiday_reasons')->where('id', $data['id'])->first();
            if (!$old) {
                DB::table('holiday_reasons')->insert($data);
            }
        }
    }
}
