<?php

use App\Model\TravelAllowanceBillType;
use Illuminate\Database\Seeder;

class TravelAllowanceBillTypeSeeder extends Seeder
{
    protected $billTypes = [
        'Travel allowance'  => 'ভ্রমন ভাতা',
        'Travel expenses'   => 'ভ্রমন ব্যয়',
        'Daily allowance'   => 'দৈনিক ভাতা',
        'Transport allowance'  => 'যাতায়ত ভাতা'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() :void
    {
        foreach ($this->billTypes as $typeEn => $typeBn) {
            TravelAllowanceBillType::create([
                'name'      => $typeEn,
                'name_bn'   => $typeBn
            ]);
        }
    }
}
