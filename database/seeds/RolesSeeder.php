<?php

use App\Model\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
	public function run()
	{
		DB::table('roles')->truncate();

		$data = "

		INSERT INTO `roles` (`id`, `name`, `name_bn`, `description`, `status`, `mail_status`, `sort`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'Developer', 'ডেভেলপার', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:35:45'),
(2, 'Superadmin', 'সুপার এডমিন', NULL, 1, 0, 1, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(3, 'Admin', 'এডমিন', NULL, 1, 0, 2, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(4, 'Administrative Officer', 'প্রশাসনিক কর্মকর্তা', NULL, 1, 0, 6, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(5, ' Deputy Secretary', 'উপ সচিব', NULL, 1, 0, 7, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(6, 'Joint Secretary', 'যুগ্ন সচিব', NULL, 1, 0, 8, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(7, 'Senior Secretary', 'সিনিয়র সচিব', NULL, 1, 0, 9, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(8, 'Speaker', 'স্পীকার', NULL, 1, 0, 3, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(9, 'MP', 'এমপি', NULL, 1, 0, 4, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(10, 'PS', 'পিএস', NULL, 1, 0, 5, NULL, NULL, NULL, NULL, '2021-06-29 09:35:45', '2021-06-29 09:36:36'),
(11, 'Administrative Officer  DR', 'প্রশাসনিক কর্মকর্তা  মুলতবি শাখা', 'ফস ফসদফ', 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 09:26:52', '2021-06-30 09:26:52'),
(12, 'Deputy Secretary  DR', 'উপ সচিব মুলতবি', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 09:27:56', '2021-06-30 09:27:56'),
(13, 'Joint Secretary DR', 'যুগ্ন সচিব মুলতবি', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 09:28:38', '2021-06-30 09:28:38'),
(14, 'Senior Secretary DR', 'সিনিয়র সচিব মুলতবি', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 09:29:26', '2021-06-30 09:29:26'),
(15, 'Administrative Officer L1', 'প্রশাসনিক কর্মকর্তা আইন ১', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:13:27', '2021-06-30 14:15:38'),
(16, 'Deputy Secretary L1', 'উপসচিব আইন ১', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:14:05', '2021-06-30 14:14:05'),
(17, 'Joint Secretary L1', 'যুগ্ন সচিব আইন ১', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:14:43', '2021-06-30 14:14:43'),
(18, 'Senior Secretary L1', 'সিনিয়র সচিব আইন ১', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:15:21', '2021-06-30 14:15:21'),
(19, 'Deputy Secretary L2', 'উপসচিব আইন ২', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:19:38', '2021-06-30 14:19:38'),
(20, 'Joint Secretary L2', 'যুগ্ন সচিব আইন ২', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:19:58', '2021-06-30 14:19:58'),
(21, 'Senior Secretary L2', 'সিনিয়র সচিব আইন ২', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-06-30 14:21:35', '2021-06-30 14:21:35'),
(22, 'Section Officer', 'সেকশন কর্মকর্তা', 'আইডি কার্ডের অনুমোদন দেওয়া', 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-04 22:01:52', '2021-07-04 22:03:17'),
(23, 'Surgent at Arms', 'সার্জেন্ট এ্যাট আর্মস', 'আইডি কার্ড ইস্যূ করা', 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-04 22:04:10', '2021-07-04 22:04:10'),
(24, 'Administrative Officer HR', 'প্রশাসনিক কর্মকর্তা মানব সম্পদ', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-08 17:55:45', '2021-07-08 17:55:45'),
(25, 'ServiceBrance', 'সেবা শাখা', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-11 16:27:21', '2021-07-11 16:27:21'),
(26, 'Recommendation Committee', 'সুপারিশ কমিটি', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-11 16:27:53', '2021-07-11 16:27:53'),
(27, 'Approval Authority', 'অনুমোদন কর্তৃপক্ষ', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-11 16:28:24', '2021-07-11 16:28:24'),
(28, 'Signature Authority', 'স্বাক্ষর কর্তৃপক্ষ', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-11 16:28:54', '2021-07-11 16:28:54'),
(29, 'QA Branch', 'প্রশ্ন উত্তর শাখা', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, '2021-07-11 19:48:04', '2021-07-11 19:48:04');

		";

		DB::insert($data);
	}
}
