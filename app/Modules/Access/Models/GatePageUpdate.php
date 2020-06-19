<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Models;

use App\Modules\Page\Repositories\Page;
use App\Modules\Page\Models\Page as PageModel;
use App\Modules\Access\Actions\AccessGateAction;

/**
 * Класс для определения доступа к страницам для их правки в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GatePageUpdate
{
    /**
     * Репозитарий для работы со страницами.
     *
     * @var \App\Modules\Page\Repositories\Page
     * @version 1.0
     * @since 1.0
     */
    protected $_page;

    /**
     * Конструктор.
     *
     * @param \App\Modules\Page\Repositories\Page $page Репозитарий для работы со страницами.
     *
     * @version 1.0
     * @since 1.0
     */
    public function __construct(Page $page)
    {
        $this->_page = $page;
    }

    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     * @param int|array $page Id или массив данных страницы.
     *
     * @return bool Вернет true, если есть доступ.
     * @version 1.0
     * @since 1.0
     */
    public function check($user, $page)
    {
        $accessGateAction = app(AccessGateAction::class);
        $gates = $accessGateAction->addParameter("id", $user["id"])->run();

        if(is_array($page)) $page = $this->_page->get($page["id"], true);
        else if($page instanceof PageModel) $page = $this->_page->get($page->id_page, true);
        else if(is_string($page)) $page = $this->_page->getByDirname($page, null, true);
        else if(is_numeric($page)) $page = $this->_page->get($page, true);

        if(isset($page) && count($gates["pagesUpdate"]))
        {
            for($i = 0; $i < count($gates["pagesUpdate"]); $i++)
            {
                if($gates["pagesUpdate"][$i]["id_page"] == $page["id_page"]) return true;
            }

            return false;
        }

        return true;
    }
}