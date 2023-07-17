<?php

use App\Model\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table( 'modules' )->truncate();

        $data = "
        
        INSERT INTO `modules` (`id`, `name`, `name_bn`, `status`, `sort`, `color`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
        (83, 'Appointment Management', 'সাক্ষাৎ ব্যবস্থাপনা', 1, 9, '#f7f706', NULL, NULL, NULL, NULL, '2021-06-26 19:24:17', '2021-07-13 15:48:42'),
        (1, 'Site Settings', 'সাইট সেটিংস', 1, 1, '#f1f30b', NULL, NULL, NULL, NULL, '2021-06-19 04:24:22', '2021-07-13 15:49:45'),
        (2, 'Profile & Activities', 'প্রোফাইল ও কার্যক্রম', 1, 2, '#f0f709', NULL, NULL, NULL, NULL, '2021-06-19 04:24:22', '2021-07-13 15:50:08'),
        (3, 'Notice Management', 'নোটিশ ব্যবস্থাপনা', 1, 3, '#f8fa07', NULL, NULL, NULL, NULL, '2021-06-19 04:24:22', '2021-07-13 15:50:40'),
        (5, 'Accommodation Management', 'আবাসন ব্যবস্থাপনা', 1, 5, '#f3f50a', NULL, NULL, NULL, NULL, '2021-06-19 04:24:22', '2021-07-13 05:01:57'),
        (6, 'Hostel Management', 'হোস্টেল ব্যবস্থাপনা', 1, 6, '#edf40a', NULL, NULL, NULL, NULL, '2021-06-19 04:24:22', '2021-07-13 05:02:29'),
        (7, 'Furniture/Goods Management', 'আসবাবপত্র/মালামাল ব্যবস্থাপনা', 1, 8, '#f7f905', NULL, NULL, NULL, NULL, '2021-06-19 04:24:22', '2021-07-13 15:48:15'),
        (4, 'Petition Management', 'পিটিশন ব্যবস্থাপনা', 1, 4, '#f5f709', NULL, NULL, NULL, NULL, '2021-06-24 09:36:44', '2021-07-13 15:50:59'),
        (84, 'Mobile application management', 'মোবাইল এপ্লিকেশন ব্যাবস্থাপনা', 1, 11, '#f2ef0d', NULL, NULL, NULL, NULL, '2021-06-26 20:26:27', '2021-07-13 05:05:10'),
        (85, 'Requsition management', 'অনুরোধ ব্যবস্থাপনা', 1, 7, '#ecf407', NULL, NULL, NULL, NULL, '2021-06-29 11:48:20', '2021-07-13 15:47:31'),
        (86, 'Miscellaneous Demand Management', 'বিবিধ চাহিদাপত্র ব্যবস্থাপনা', 1, 10, 'rgba(247,243,9,0.89)', NULL, NULL, NULL, NULL, '2021-06-29 11:50:08', '2021-07-13 15:49:09');

        ";

        DB::insert($data);  
    }
}
