<?php
/**
 * Author M. Atoar Rahman
 * Date: 01/02/2021
 * Time: 03:40 PM
 */

use App\Model\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appointments = [[
            'id' => 1,
            'date' =>'16 June, 2021',
            'time_from' => '10:00 PM',
            'time_to' => '11:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 2,
            'created_by' => 2
        ],[
            'id' => 2,
            'date' =>'16 June, 2021',
            'time_from' => '03:00 PM',
            'time_to' => '04:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 1,
            'created_by' => 3
        ],[
            'id' => 3,
            'date' =>'16 June, 2021',
            'time_from' => '03:00 PM',
            'time_to' => '04:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 2,
            'created_by' => 3
        ],[
            'id' => 4,
            'date' =>'16 June, 2021',
            'time_from' => '03:00 PM',
            'time_to' => '04:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 2,
            'created_by' => 2
        ],[
            'id' => 5,
            'date' =>'16 June, 2021',
            'time_from' => '03:00 PM',
            'time_to' => '04:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 1,
            'created_by' => 2
        ],[
            'id' => 6,
            'date' =>'16 June, 2021',
            'time_from' => '03:00 PM',
            'time_to' => '04:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 1,
            'created_by' => 2
        ],[
            'id' => 7,
            'date' =>'16 June, 2021',
            'time_from' => '03:00 PM',
            'time_to' => '04:00 PM',
            'topics' => 'অর্থহীন লেখা যার মাঝে আছে অনেক কিছু।',
            'requested_to' => 1,
            'created_by' => 2
        ]];
        foreach ($appointments as $key => $data) {
            $old = Appointment::where('id', $data['id'])->first();
            if (!$old) {
                Appointment::create($data);
            }
        }

        //DB::table('appointments')->insert($appointments);
    }
}
