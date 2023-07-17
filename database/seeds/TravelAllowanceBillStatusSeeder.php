<?php

use App\Model\TravelAllowanceBillStatus;
use Illuminate\Database\Seeder;

class TravelAllowanceBillStatusSeeder extends Seeder
{
    private $billStatuses = [
        'waiting For Sending' => 'প্রেরণের জন্য অপেক্ষ্যমান',
        'waiting for to send accounts section' => 'হিসাব শাখায় প্রেরণের জন্য অপেক্ষ্যমান',
        'waiting for audit' => 'নিরীক্ষার জন্য অপেক্ষ্যমান',
        'waiting for pay cheque' => 'চেক প্রদানের জন্য অপেক্ষ্যমান',
        'issue complete' => 'ইস্যু সম্পূর্ণ'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        foreach ($this->billStatuses as $statusEn => $statusBn) {
            TravelAllowanceBillStatus::create([
                'name'      => $statusEn,
                'name_bn'   => $statusBn
            ]);
        }
    }
}
