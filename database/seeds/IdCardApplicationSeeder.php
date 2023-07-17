<?php

use Illuminate\Database\Seeder;

class IdCardApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('id_card_applications')->insert([
            ['application_for'=>1,
            'mp_name'=>"মোঃ মজহারুল হক",
            'constituency_name'=>"১, পঞ্চগড়-১",
            'identification_mark'=>"kIshor",
            'blood_group'=>'A',
            'nid'=>215432215424,
            'date_of_birth'=>'25-02-1955',
            'telephone'=>'01707568468',
            'mobile'=>'01967607350',
            'email'=>'nasir93cse@gmail.com',
            'photo'=>'',
            'signature'=>'',
            'serial_no'=>'',
            'approved_date'=>null,
            'issue_date'=>null,
            'approved_by'=>'',
            'issued_by'=>'',
            'status'=>0],
            ['application_for'=>2,
            'mp_name'=>"মোঃ মজহারুল হক",
            'constituency_name'=>"পঞ্চগড়-২",
            'identification_mark'=>"kIshor",
            'blood_group'=>'A',
            'nid'=>215432215424,
            'date_of_birth'=>'25-02-1955',
            'telephone'=>'01707568468',
            'mobile'=>'01967607350',
            'email'=>'nasir93cse@gmail.com',
            'photo'=>'',
            'signature'=>'',
            'serial_no'=>'',
            'approved_date'=>null,
            'issue_date'=>null,
            'approved_by'=>'',
            'issued_by'=>'',
            'status'=>0],
            ['application_for'=>3,
            'mp_name'=>"মোঃ মজহারুল হক",
            'constituency_name'=>"ঠাকুরগাও-১",
            'identification_mark'=>"kIshor",
            'blood_group'=>'A',
            'nid'=>215432215424,
            'date_of_birth'=>'25-02-1955',
            'telephone'=>'01707568468',
            'mobile'=>'01967607350',
            'email'=>'nasir93cse@gmail.com',
            'photo'=>'',
            'signature'=>'',
            'serial_no'=>'',
            'approved_date'=>null,
            'issue_date'=>null,
            'approved_by'=>'',
            'issued_by'=>'',
            'status'=>0],
                      
            
    ]);
    }
}
