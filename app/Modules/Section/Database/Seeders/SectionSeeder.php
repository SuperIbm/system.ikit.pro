<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Modules\Section\Models\Section;

/**
 * Класс наполнения начальными данными для установки разделов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SectionSeeder extends Seeder
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
        \DB::table('sections')->delete();

        Section::create([
            'id' => 1,
            "index" => "users",
            'label' => "Пользователи",
            'icon' => "mdi-account",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 2,
            "index" => "courses",
            'label' => "Курсы",
            'icon' => "mdi-book-open-page-variant",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 3,
            "index" => "leads",
            'label' => "Лиды",
            'icon' => "mdi-gift",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 4,
            "index" => "emails",
            'label' => "E-mail маркетинг",
            'icon' => "mdi-email",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 5,
            "index" => "automation",
            'label' => "Автоматизация",
            'icon' => "mdi-video-input-component",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 6,
            "index" => "forms",
            'label' => "Формы",
            'icon' => "mdi-form-textbox",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 7,
            "index" => "lists",
            'label' => "Списки",
            'icon' => "mdi-format-list-text",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 8,
            "index" => "processes",
            'label' => "Процессы",
            'icon' => "mdi-call-split",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 9,
            "index" => "reports",
            'label' => "Отчеты",
            'icon' => "mdi-chart-pie",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 10,
            "index" => "roles",
            'label' => "Роли",
            'icon' => "mdi-account-group",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 11,
            "index" => "site",
            'label' => "Сайт",
            'icon' => "mdi-earth",
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 12,
            "index" => "apps",
            'label' => "Приложения",
            'icon' => "mdi-power-plug",
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 13,
            "index" => "settings",
            'label' => "Настройки",
            'icon' => "mdi-cog",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);

        Section::create([
            'id' => 14,
            "index" => "logs",
            'label' => "Логи",
            'icon' => "mdi-clipboard-list",
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ]);
    }
}
