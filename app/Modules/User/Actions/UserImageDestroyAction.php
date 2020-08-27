<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Actions;

use App\Models\Action;
use App\Modules\User\Repositories\User;
use ImageStore;

/**
 * Удаление изображения пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserImageDestroyAction extends Action
{
    /**
     * Репозитарий для выбранных групп пользователя.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private User $_user;

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
     * Метод запуска логики.
     *
     * @return mixed Вернет результаты исполнения.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        if($this->getParameter("id") && $this->getParameter("school"))
        {
            $filters = [
                [
                    "table" => "users",
                    "property" => "id",
                    "operator" => "=",
                    "value" => $this->getParameter("id")
                ],
                [
                    "table" => "user_schools",
                    "property" => "school_id",
                    "operator" => "=",
                    "value" => $this->getParameter("school")
                ]
            ];

            $user = $this->_user->get(null, null, $filters, [
                "schools"
            ]);

            if(!$this->_user->hasError())
            {
                if($user)
                {
                    if($user['image_small_id']) ImageStore::destroy("user", $user['image_small_id']['id']);
                    if($user['image_middle_id']) ImageStore::destroy("user", $user['image_middle_id']['id']);

                    $this->_user->update($this->getParameter("id"), [
                        'image_small_id' => null,
                        'image_middle_id' => null
                    ]);

                    if(!$this->_user->hasError()) return true;
                    else
                    {
                        $this->setErrors($this->_user->getErrors());

                        return false;
                    }
                }
                else
                {
                    $this->addError("user", trans('access::http.actions.userConfigUpdateAction.not_exist_user'));

                    return false;
                }
            }
            else
            {
                $this->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else return null;
    }
}
