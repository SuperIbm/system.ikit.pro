<?php
/**
 * Модуль предупреждений.
 * Этот модуль содержит все классы для работы с предупреждениями.
 *
 * @package App\Modules\Alert
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Alert\Http\Controllers;

use Illuminate\Routing\Controller;

use Alert;
use Log;
use Auth;

use Illuminate\Http\JsonResponse;
use App\Modules\Alert\Http\Requests\AlertReadRequest;
use App\Modules\Alert\Http\Requests\AlertDestroyRequest;
use App\Modules\Alert\Http\Requests\AlertToReadRequest;

/**
 * Класс контроллер для работы с предупреждениями в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AlertController extends Controller
{
    /**
     * Чтение данных.
     *
     * @param \App\Modules\Alert\Http\Requests\AlertReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function read(AlertReadRequest $request): JsonResponse
    {
        $filter = $request->input('filter');

        if($filter)
        {
            $filters = [
                [
                    "property" => "id",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "property" => "title",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "property" => "description",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "property" => "url",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ]
            ];
        }
        else $filters = null;

        $data = Alert::list($request->get("start"), $request->get("limit"), $request->get("unread"), $filters, json_decode($request->input('sort'), true));

        if(!Alert::hasError())
        {
            $alerts = Alert::list(null, null, $request->get("unread"), $filters);
            $count = 0;

            if($alerts) $count = count($alerts);

            $data = [
                'success' => true,
                'data' => $data ? $data : [],
                'total' => $count
            ];
        }
        else
        {
            $data = [
                'success' => false,
                'message' => Alert::getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Установка предупреждения как прочитанное.
     *
     * @param int $id ID предупреждения.
     * @param \App\Modules\Alert\Http\Requests\AlertToReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function toRead(int $id, AlertToReadRequest $request): JsonResponse
    {
        if($request->get("status")) Alert::toUnread($id);
        else Alert::toRead($id);

        if(!Alert::hasError())
        {
            Log::info('Обновление предупреждения.', [
                'module' => "Alert",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::info('Обновление предупреждения.', [
                'module' => "Alert",
                'login' => Auth::user()->login,
                'type' => 'update',
                'request' => $request->all(),
                'error' => Alert::getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => Alert::getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Удаление данных.
     *
     * @param \App\Modules\Alert\Http\Requests\AlertDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(AlertDestroyRequest $request): JsonResponse
    {
        $ids = json_decode($request->input('ids'), true);

        $result = Alert::remove($ids);

        if($result)
        {
            Log::info('Удаление предупреждения.', [
                'module' => "Alert",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => true,
                "ids" => $ids
            ];
        }
        else
        {
            Log::warning('Удаление предупреждения.', [
                'module' => "Alert",
                'login' => Auth::user()->login,
                'type' => 'destroy',
                'request' => $request->all(),
                'error' => Alert::getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => Alert::getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
