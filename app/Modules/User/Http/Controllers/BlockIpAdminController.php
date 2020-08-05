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
use Util;

use App\Modules\User\Repositories\BlockIp;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\BlockIpAdminReadRequest;
use App\Modules\User\Http\Requests\BlockIpAdminDestroyRequest;

/**
 * Класс контроллер для работы с блокированными IP в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class BlockIpAdminController extends Controller
{
    /**
     * Репозитарий заблокированных IP.
     *
     * @var \App\Modules\User\Repositories\BlockIp
     * @version 1.0
     * @since 1.0
     */
    private BlockIp $_blockIp;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\BlockIp $blockIp Репозитарий заблокированных IP.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(BlockIp $blockIp)
    {
        $this->_blockIp = $blockIp;
    }

    /**
     * Получение блокированного IP.
     *
     * @param int $id ID инфоблока.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get($id)
    {
        $data = $this->_blockIp->get($id);

        if($data)
        {
            $data = [
                'data' => $data,
                'success' => true,
            ];
        }
        else
        {
            $data = [
                'success' => false,
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Чтение данных.
     *
     * @param \App\Modules\User\Http\Requests\BlockIpAdminReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function read(BlockIpAdminReadRequest $request)
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
                    "property" => "ip",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ]
            ];
        }
        else $filters = [];

        $data = $this->_blockIp->read($filters, null, json_decode($request->input('sort'), true), $request->input('start'), $request->input('limit'));

        if($this->_blockIp->hasError() == false)
        {
            $data = [
                'data' => $data == null ? [] : $data,
                'total' => $this->_blockIp->count($filters),
                'success' => true
            ];
        }
        else
        {
            $data = [
                'success' => false
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Добавление данных.
     *
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data["status"] = $data["status"] == "on" ? true : false;
        $status = $this->_blockIp->create($data);

        if($status)
        {
            Log::info('Success: Create a blocked IP.', [
                'module' => "BlockIp",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Create a blocked IP.', [
                'module' => "BlockIp",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_blockIp->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Обновление данных.
     *
     * @param int $id ID заблокированного IP.
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, Request $request)
    {
        $data = $request->all();
        $data["status"] = $data["status"] == "on" ? true : false;
        $status = $this->_blockIp->update($id, $data);

        if($status)
        {
            Log::info('Success: Update the blocked IP.', [
                'module' => "BlockIp",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Update the blocked IP.', [
                'module' => "BlockIp",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_blockIp->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Удаление данных.
     *
     * @param \App\Modules\User\Http\Requests\BlockIpAdminDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(BlockIpAdminDestroyRequest $request)
    {
        $ids = json_decode($request->input('ids'), true);
        $status = $this->_blockIp->destroy($ids);

        if($status == true && $this->_blockIp->hasError() == false)
        {
            Log::info('Success: Destroy the blocked IP.', [
                'module' => "BlockIp",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Destroy the blocked IP.', [
                'module' => "BlockIp",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_blockIp->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
