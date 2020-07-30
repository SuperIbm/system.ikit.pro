<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Decorators;

use App\Models\Decorator;
use Illuminate\Pipeline\Pipeline;

/**
 * Класс декоратор для регистрации нового пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSignUpDecorator extends Decorator
{
    /**
     * Метод обработчик собития после выполнения всех действий декоратора.
     *
     * @return array|boolean Верент массив данных при выполнении действия.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        $parameters = $this->getParameters();

        app(Pipeline::class)->send($parameters)->through($this->getActions())->then(function($content)
        {
            $this->setContent($content);
        });

        if(!$this->hasError()) return $this->getContent();
        else return false;
    }
}
