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
 * Класс наполнения начальными данными: установка кошелька пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserWalletTableSeeder extends Seeder
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
        \DB::table('user_wallets')->delete();

        \DB::table('user_wallets')->insert(array(
            0 => array(
                'id' => 1,
                'user_id' => 1,
                'amount' => 0,
                'currency' => "RUB"
            ),
        ));
    }
}
