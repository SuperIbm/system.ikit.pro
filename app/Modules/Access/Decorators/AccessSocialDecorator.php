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
 * Класс декоратор для авторизации через социальные сети.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSocialDecorator extends Decorator
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
        $content = app(Pipeline::class)
            ->send($this->getParameters())
            ->through($this->getActions())
            ->then(function($content) {
                $this->setContent($content);
            });

        if($content) $this->setContent($content);

        if(!$this->hasError()) return $this->getContent();
        else return false;
    }
}
