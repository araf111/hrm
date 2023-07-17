<?php

/**
 * Author M. Atoar Rahman
 * Date: 24/01/2021
 * Time: 11:40 AM
 */

use App\Model\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->truncate();

        $data = "

        INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(34, 38, 22, '2021-07-04 22:15:32', '2021-07-04 22:15:32'),
(3, 21, 4, '2021-06-30 08:50:13', '2021-06-30 08:50:13'),
(4, 3, 9, '2021-06-30 09:24:49', '2021-06-30 09:24:49'),
(5, 25, 11, '2021-06-30 09:30:01', '2021-06-30 09:30:01'),
(6, 26, 12, '2021-06-30 09:30:18', '2021-06-30 09:30:18'),
(7, 27, 13, '2021-06-30 09:30:35', '2021-06-30 09:30:35'),
(8, 28, 14, '2021-06-30 09:30:49', '2021-06-30 09:30:49'),
(33, 37, 2, NULL, NULL),
(10, 5, 9, '2021-06-30 13:49:14', '2021-06-30 13:49:14'),
(11, 6, 9, '2021-06-30 13:49:45', '2021-06-30 13:49:45'),
(12, 7, 9, '2021-06-30 13:49:54', '2021-06-30 13:49:54'),
(13, 8, 9, '2021-06-30 13:50:03', '2021-06-30 13:50:03'),
(14, 9, 9, '2021-06-30 13:50:11', '2021-06-30 13:50:11'),
(15, 10, 9, '2021-06-30 13:50:22', '2021-06-30 13:50:22'),
(16, 11, 9, '2021-06-30 13:50:30', '2021-06-30 13:50:30'),
(17, 29, 15, '2021-06-30 18:28:50', '2021-06-30 18:28:50'),
(18, 4, 9, '2021-07-01 08:03:32', '2021-07-01 08:03:32'),
(19, 31, 17, '2021-07-01 08:17:16', '2021-07-01 08:17:16'),
(20, 30, 16, '2021-07-01 08:17:30', '2021-07-01 08:17:30'),
(21, 32, 18, '2021-07-01 08:17:46', '2021-07-01 08:17:46'),
(22, 22, 19, '2021-07-01 13:06:01', '2021-07-01 13:06:01'),
(23, 23, 20, '2021-07-01 13:06:18', '2021-07-01 13:06:18'),
(24, 24, 21, '2021-07-01 13:06:34', '2021-07-01 13:06:34'),
(25, 12, 10, '2021-07-02 09:23:09', '2021-07-02 09:23:09'),
(26, 13, 10, '2021-07-02 09:23:21', '2021-07-02 09:23:21'),
(47, 20, 9, '2021-07-15 21:43:53', '2021-07-15 21:43:53'),
(31, 2, 9, '2021-07-02 11:23:17', '2021-07-02 11:23:17'),
(35, 39, 23, '2021-07-04 22:15:58', '2021-07-04 22:15:58'),
(36, 40, 23, '2021-07-04 22:48:35', '2021-07-04 22:48:35'),
(37, 41, 24, '2021-07-08 17:57:23', '2021-07-08 17:57:23'),
(38, 42, 25, '2021-07-11 16:30:30', '2021-07-11 16:30:30'),
(39, 43, 26, '2021-07-11 16:31:12', '2021-07-11 16:31:12'),
(40, 44, 27, '2021-07-11 16:31:58', '2021-07-11 16:31:58'),
(41, 45, 28, '2021-07-11 16:32:35', '2021-07-11 16:32:35'),
(42, 17, 29, '2021-07-11 19:50:30', '2021-07-11 19:50:30'),
(46, 20, 8, '2021-07-15 21:43:53', '2021-07-15 21:43:53'),
(54, 46, 30, '2021-08-03 09:49:27', '2021-08-03 09:49:27'),
(53, 47, 31, '2021-08-03 09:48:12', '2021-08-03 09:48:12'),
(55, 48, 32, '2021-08-03 20:13:39', '2021-08-03 20:13:39'),
(56, 49, 10, '2021-08-03 20:47:47', '2021-08-03 20:47:47');


        ";

        DB::insert($data);
    }
}
