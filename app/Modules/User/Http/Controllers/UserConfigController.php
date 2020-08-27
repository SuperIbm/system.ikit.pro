<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Http\Controllers;

use Log;
use Auth;
use School;
use App\Modules\User\Actions\UserConfigGetAction;
use App\Modules\User\Actions\UserConfigUpdateAction;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Класс контроллер для работы с конфигурациями пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserConfigController extends Controller
{
    /**
     * Получение конфигурации.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get()
    {
        $action = app(UserConfigGetAction::class);

        $data = $action->setParameters([
            "id" => Auth::getUser()->id
        ])->run();

        if(!$action->hasError())
        {
            if($data)
            {
                $data = [
                    'success' => true,
                    'data' => $data
                ];
            }
            else
            {
                $data = [
                    'success' => false
                ];
            }
        }
        else
        {
            Log::warning(trans('access::http.controllers.userConfigController.get.log'), [
                'module' => "User",
                'type' => 'get',
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Обновление данных.
     *
     * @param int $id ID пользователя.
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(Request $request)
    {
        $action = app(UserConfigUpdateAction::class);
        $data = $request->all();

        $action->setParameters([
            "id" => Auth::getUser()->id,
            "data" => $data
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userConfigController.update.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userConfigController.update.log'), [
                'module' => "User",
                'type' => 'update',
                'request' => $request->all(),
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
