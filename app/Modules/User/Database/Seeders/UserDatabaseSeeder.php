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

use App\Modules\User\Models\UserVerification;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserDatabaseSeeder extends Seeder
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
        Model::unguard();

        $this->call(ModuleTableSeeder::class);
        $this->call(UserGroupUserTableSeeder::class);
        $this->call(UserGroupRoleTableSeeder::class);
        $this->call(UserGroupTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserVerificationTableSeeder::class);
    }
}
