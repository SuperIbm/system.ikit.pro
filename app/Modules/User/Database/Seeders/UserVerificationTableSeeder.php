<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Crypt;
use Carbon\Carbon;

/**
 * Класс наполнения начальными данными: верификация пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserVerificationTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('user_verifications')->delete();

        \DB::table('user_verifications')->insert(array(
            0 => array(
                'id' => 1,
                'user_id' => 1,
                'code' => Crypt::encrypt(intval(Carbon::now()->format("U")) + rand(1000000, 100000000)),
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
        ));
    }
}
