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
use ImageStore;

use App\Modules\User\Repositories\User;
use Illuminate\Routing\Controller;
use App\Modules\User\Http\Requests\UserImageSiteUpdateRequest;


/**
 * Класс контроллер для работы с изображениями пользователя в публичной части.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserImageSiteController extends Controller
{
    /**
     * Репозитарий для выбранных групп пользователя.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    /**
     * Обновление данных.
     *
     * @param \App\Modules\User\Http\Requests\UserImageSiteUpdateRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(UserImageSiteUpdateRequest $request)
    {
        if($request->hasFile('image') && $request->file('image')->isValid())
        {
            $id = Auth::user()->toArray()["id"];
            $data = [];
            $data['image_small_id'] = $request->file('image');
            $data['image_middle_id'] = $request->file('image');

            $status = $this->_user->update($id, $data);

            if($status)
            {
                Log::info('Success: Update the user image.', [
                    'module' => "User",
                    'login' => Auth::user()->login,
                    'type' => 'update'
                ]);

                $data = [
                    'success' => true
                ];
            }
            else
            {
                Log::warning('Fail: Update the user image.', [
                    'module' => "User",
                    'login' => Auth::user()->login,
                    'type' => 'update'
                ]);

                $data = [
                    'success' => false,
                    'message' => $this->_user->getErrorMessage()
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
     * Удаление данных.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy()
    {
        $id = Auth::user()->toArray()["id"];

        $data = $this->_user->get($id);

        if($data)
        {
            if($data['image_small_id']) ImageStore::destroy("user", $data['image_small_id']['id']);
            if($data['image_middle_id']) ImageStore::destroy("user", $data['image_middle_id']['id']);

            $status = $this->_user->update($id, [
                'image_small_id' => null,
                'image_middle_id' => null
            ]);

            if($status == true && $this->_user->hasError() == false)
            {
                Log::info('Success: Destroy the user image.', [
                    'module' => "User",
                    'login' => Auth::user()->login,
                    'type' => 'destroy'
                ]);

                $data = [
                    'success' => true
                ];
            }
            else
            {
                Log::warning('Fail: Destroy the user image.', [
                    'module' => "User",
                    'login' => Auth::user()->login,
                    'type' => 'destroy'
                ]);

                $data = [
                    'success' => false,
                    'message' => $this->_user->getErrorMessage()
                ];
            }
        }
        else
        {
            Log::warning('Fail: Destroy the user image.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => false
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
