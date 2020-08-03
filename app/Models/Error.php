<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 *
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Models;

use Util;
use Exception;

/**
 * Трейт ошибок.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Сайтография.
 * @author Инчагов Тимофей Александрович.
 */
trait Error
{
    /**
     * Массив ошибок.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private array $_errors = [];

    /**
     * Очистить ошибку.
     *
     * @return \App\Models\Error
     * @since 1.0
     * @version 1.0
     */
    public function cleanError()
    {
        $this->_errors = [];

        return $this;
    }

    /**
     * Проверка наличия ошибки.
     *
     * @return bool Вернет true если есть ошибка.
     * @since 1.0
     * @version 1.0
     */
    public function hasError(): bool
    {
        if(count($this->_errors) == 0) return false;

        return true;
    }

    /**
     * Выборс ошибки.
     *
     * @return $this|Exception Вернет true если есть ошибка.
     * @throws Exception
     * @since 1.0
     * @version 1.0
     */
    public function throwError()
    {
        if($this->hasError()) throw new Exception($this->getErrorMessage(), $this->getErrorNumber());
        else return $this;
    }

    /**
     * Добавление ошибки.
     *
     * @param mixed $type Тип ошибки, это может быть краткий ее индификатор, или название. Это так же может быть массив, состоящий из:
     * <pre>
     * array
     * (
     * "type" => "Тип ошибки",
     * "message" => "Сообщение об ошибки",
     * "tag" => "Тэг ошибки, нужен для спец описания"
     * )
     * </pre>
     * @param string $message Сообщение об ошибки.
     * @param string $tag Тэг ошибки, нужен для спец описания.
     *
     * @return \App\Models\Error
     * @since 1.0
     * @version 1.0
     */
    public function addError($type, string $message = null, string $tag = null)
    {
        if(is_array($type))
        {
            if(Util::isAssoc($type)) $this->_errors[] = $type;
            else $this->_errors = array_merge($this->_errors, $type);
        }
        else
        {
            $this->_errors[] = array(
                "type" => $type,
                "message" => $message,
                "tag" => $tag,
            );
        }

        return $this;
    }

    /**
     * Получение ошибки по номеру.
     *
     * @param int $index Номер ошибки.
     *
     * @return array|bool Массив с описанием ошибки, где:
     * <ul>
     *    <li>type - тип ошибки</li>
     *    <li>message - сообщение об ошибки</li>
     *    <li>tag - тэг ошибки, нужен для спец описания.</li>
     * </ul>
     * @since 1.0
     * @version 1.0
     */
    public function getError(int $index = 0)
    {
        if($this->hasError())
        {
            if(isset($index))
            {
                if(isset($this->_errors[$index])) return $this->_errors[$index];
                else return false;
            }
        }
        return false;
    }

    /**
     * Получение всех ошибок.
     *
     * @return array|bool Массив с описанием ошибки, где:
     * <ul>
     *    <li>type - тип ошибки</li>
     *    <li>message - сообщение об ошибки</li>
     *    <li>tag - тэг ошибки, нужен для спец описания.</li>
     * </ul>
     * @since 1.0
     * @version 1.0
     */
    public function getErrors()
    {
        if($this->hasError()) return $this->_errors;
        return false;
    }

    /**
     * Установка всех ошибок.
     *
     * @param array $errors Массив ошибок.
     *
     * @return \App\Models\Error
     * @since 1.0
     * @version 1.0
     */
    public function setErrors(array $errors)
    {
        $this->_errors = $errors;

        return $this;
    }

    /**
     * Получение полного описания ошибки.
     *
     * @param int $index Номер ошибки.
     *
     * @return string|bool Строка с описанием ошибки.
     * @since 1.0
     * @version 1.0
     */
    public function getErrorString(int $index = 0)
    {
        if($this->hasError())
        {
            $mes = $this->getErrorType($index);

            if($mes)
            {
                if($this->getErrorNumber($index)) $mes .= ", " . $this->getErrorNumber($index);
                if($this->getErrorMessage($index)) $mes .= ": " . $this->getErrorMessage($index);

                return $mes;
            }
            else return false;
        }
        else return false;
    }

    /**
     * Получение типа ошибки.
     *
     * @param int $index Номер ошибки.
     *
     * @return string|bool Тип ошибки, это может быть краткий ее индификатор.
     * @since 1.0
     * @version 1.0
     */
    public function getErrorType(int $index = 0)
    {
        if($this->hasError())
        {
            if(isset($this->_errors[$index]["type"])) return $this->_errors[$index]["type"];
            else return false;
        }
        else return false;
    }

    /**
     * Получение сообщения об ошибки.
     *
     * @param int $index Номер ошибки.
     *
     * @return string|bool Сообщение об ошибки.
     * @since 1.0
     * @version 1.0
     */
    public function getErrorMessage(int $index = 0)
    {
        if($this->hasError())
        {
            if(isset($this->_errors[$index]["message"])) return $this->_errors[$index]["message"];
            else return false;
        }
        else return false;
    }

    /**
     * Получение номера ошибки.
     *
     * @param int $index Номер ошибки.
     *
     * @return string|bool Номер ошибки.
     * @since 1.0
     * @version 1.0
     */
    public function getErrorNumber(int $index = 0)
    {
        if($this->hasError())
        {
            if(isset($this->_errors[$index]["tag"])) return $this->_errors[$index]["tag"];
            else return false;
        }
        else return false;
    }
}
