<?php

use App\Model\Petition;
use Illuminate\Database\Seeder;

class PetitionSeeder extends Seeder
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
                'applicant_name' => 'হাসানুর রহমান',
                'applicant_designation' => 'চাকুরী',
                'applicant_nid' => '123456789',
                'applicant_mobile' => '01711223344',
                'applicant_email' => 'a@gmail.com',
                'applicant_division_id' => '4',
                'applicant_district_id' => '35',
                'applicant_upazila_id' => '266',
                'applicant_union' => 'ছোনাউটা',
                'applicant_more_address' => 'XYZ',
                'description' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু। হ্যাঁ, এই লেখার মাঝেই আছে অনেক কিছু। যদি তুমি মনে করো, এটা তোমার কাজে লাগবে, তাহলে তা লাগবে কাজে। নিজের ভাষায় লেখা দেখতে অভ্যস্ত হও। মনে রাখবে লেখা অর্থহীন হয়, যখন তুমি তাকে অর্থহীন মনে করো; আর লেখা অর্থবোধকতা তৈরি করে, যখন তুমি তাতে অর্থ ঢালো। যেকোনো লেখাই তোমার কাছে অর্থবোধকতা তৈরি করতে পারে, যদি তুমি সেখানে অর্থদ্যোতনা দেখতে পাও।',
                'applicant_list' => '{"name":["\u0986\u09b6\u09bf\u0995\u09c1\u09b0 \u09b0\u09b9\u09ae\u09be\u09a8","\u09b0\u09be\u0995\u09bf\u09ac\u09c1\u09b2 \u0987\u09b8\u09b2\u09be\u09ae"],"signature":["\u0986\u09b6\u09bf\u0995\u09c1\u09b0 \u09b0\u09b9\u09ae\u09be\u09a8","\u09b0\u09be\u0995\u09bf\u09ac\u09c1\u09b2 \u0987\u09b8\u09b2\u09be\u09ae"],"division":["4","4"],"district":["35","33"],"upazila":["266","251"],"union":["\u0987\u09b8\u09b2\u09be\u09ae\u09aa\u09c1\u09b0","\u099c\u09b8\u09b0\u09be"],"more_address":["fgfgfd","sdsdsd"]}',
                'mp_name' => '4',
                'otp_id' => '1',
            ],[
                'id' => 2,
                'applicant_name' => 'সাইদুর রহমান',
                'applicant_designation' => 'ব্যাবসা',
                'applicant_nid' => '987654321',
                'applicant_mobile' => '01722334455',
                'applicant_email' => 'b@gmail.com',
                'applicant_division_id' => '4',
                'applicant_district_id' => '35',
                'applicant_upazila_id' => '266',
                'applicant_union' => 'ছোনাউটা',
                'applicant_more_address' => 'XYZ',
                'description' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু। হ্যাঁ, এই লেখার মাঝেই আছে অনেক কিছু। যদি তুমি মনে করো, এটা তোমার কাজে লাগবে, তাহলে তা লাগবে কাজে। নিজের ভাষায় লেখা দেখতে অভ্যস্ত হও। মনে রাখবে লেখা অর্থহীন হয়, যখন তুমি তাকে অর্থহীন মনে করো; আর লেখা অর্থবোধকতা তৈরি করে, যখন তুমি তাতে অর্থ ঢালো। যেকোনো লেখাই তোমার কাছে অর্থবোধকতা তৈরি করতে পারে, যদি তুমি সেখানে অর্থদ্যোতনা দেখতে পাও।',
                'applicant_list' => '{"name":["\u0986\u09b6\u09bf\u0995\u09c1\u09b0 \u09b0\u09b9\u09ae\u09be\u09a8","\u09b0\u09be\u0995\u09bf\u09ac\u09c1\u09b2 \u0987\u09b8\u09b2\u09be\u09ae"],"signature":["\u0986\u09b6\u09bf\u0995\u09c1\u09b0 \u09b0\u09b9\u09ae\u09be\u09a8","\u09b0\u09be\u0995\u09bf\u09ac\u09c1\u09b2 \u0987\u09b8\u09b2\u09be\u09ae"],"division":["4","4"],"district":["35","33"],"upazila":["266","251"],"union":["\u0987\u09b8\u09b2\u09be\u09ae\u09aa\u09c1\u09b0","\u099c\u09b8\u09b0\u09be"],"more_address":["fgfgfd","sdsdsd"]}',
                'mp_name' => '4',
                'otp_id' => '2',
            ],
        ];

        foreach ($datas as $key => $data) {
            $old = Petition::where('id', $data['id'])->first();
            if (!$old) {
                Petition::create($data);
            }
        }
    }
}
