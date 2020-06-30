<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 *
 * @package App\Modules\Core
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Core\Http\Controllers;

use App;
use Config;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


/**
 * Класс контроллер для ядра.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $source = App::environment('local') ? file_get_contents('http://localhost:8000/__laravel_nuxt__') : file_get_contents(Config::get('nuxt.page'));
        return $source;
    }
}
