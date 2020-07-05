<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Http\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use Gate;
use App\Modules\Access\Actions\AccessGateAction;
use Illuminate\Http\Request;

/**
 * Класс контроллер для авторизации и аунтификации: администратора.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessAdminController extends Controller
{
    /**
     * Авторизация администратора.
     *
     * @param \Illuminate\Http\Request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function gate(Request $request)
    {
        if(Auth::check())
        {
            if($request->get("admin")) $status = Gate::allows('user');
            else $status = true;

            if($status)
            {
                $data = app(AccessGateAction::class)->setParameters([
                    "id" => auth()->id()
                ])->run();

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
                $data = [
                    'success' => false
                ];
            }
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
     * Выход авторизованного администратора.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => true]);
    }
}
