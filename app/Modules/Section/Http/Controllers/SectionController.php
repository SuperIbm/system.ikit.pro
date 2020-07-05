<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

use Log;
use Auth;
use Config;
use Util;

use App\Modules\Section\Actions\SectionMenuAction;

/**
 * Класс контроллер для разделов системы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SectionController extends Controller
{
    /**
     * Чтение данных.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function sections(): JsonResponse
    {
        $action = app(SectionMenuAction::class);
        $data = $action->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'data' => $data
            ];
        }
        else
        {
            Log::warning('Чтение разделов.', [
                'module' => "Section",
                'login' => Auth::user()->login,
                'type' => 'read',
                'error' => $action->hasError()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
