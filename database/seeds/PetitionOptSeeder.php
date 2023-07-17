<?php

use App\Model\PetitionOtp;
use Illuminate\Database\Seeder;

class PetitionOptSeeder extends Seeder
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
                'mobile' => '01711223344',
                'otp_number' => '1234',
                'start_time' => date('Y-m-d H:i:s'),
                'end_time' => date('Y-m-d H:i:s', strtotime('+2 minutes')),
            ],[
                'id' => 2,
                'mobile' => '01722334455',
                'otp_number' => '2345',
                'start_time' => date('Y-m-d H:i:s'),
                'end_time' => date('Y-m-d H:i:s', strtotime('+2 minutes')),
            ],
        ];

        foreach ($datas as $key => $data) {
            $old = PetitionOtp::where('id', $data['id'])->first();
            if (!$old) {
                PetitionOtp::create($data);
            }
        }
    }
}
