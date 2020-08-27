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
use ImageStore;

use Illuminate\Routing\Controller;
use App\Modules\User\Actions\UserImageUpdateAction;
use App\Modules\User\Actions\UserImageDestroyAction;

use App\Modules\User\Http\Requests\UserImageUpdateRequest;
use School;

/**
 * Класс контроллер для работы с изображениями пользователя в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserImageController extends Controller
{
    /**
     * Чтение данных.
     *
     * @param int $id ID пользователя.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get(int $id)
    {
        $data = ImageStore::get("user", $id);

        if(!ImageStore::hasError())
        {
            if($data)
            {
                $data = [
                    'data' => $data == null ? [] : [$data],
                    'success' => true
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
            Log::warning(trans('access::http.controllers.userImageController.get.log'), [
                'module' => "User",
                'type' => 'get',
                'parameters' => [
                    "id" => $id
                ],
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => ImageStore::getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => ImageStore::getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Обновление данных.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\User\Http\Requests\UserImageUpdateRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, UserImageUpdateRequest $request)
    {
        $action = app(UserImageUpdateAction::class);

        $action->setParameters([
            "id" => $id,
            "school" => School::getId(),
            "image" => $request->file('image')->path()
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userImageController.update.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userImageController.update.log'), [
                'module' => "User",
                'type' => 'update',
                'request' => $request->all(),
                'parameters' => [
                    "id" => $id
                ],
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
     * Удаление данных.
     *
     * @param int $id ID пользователя.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(int $id)
    {
        $action = app(UserImageDestroyAction::class);

        $action->setParameters([
            "id" => $id,
            "school" => School::getId()
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userImageController.destroy.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userImageController.destroy.log'), [
                'module' => "User",
                'type' => 'destroy',
                'parameters' => [
                    "id" => $id
                ],
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
