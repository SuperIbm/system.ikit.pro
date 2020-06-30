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

use Illuminate\Foundation\Http\FormRequest as FormRequestNative;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Класс формы проверки запроса.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FormRequest extends FormRequestNative
{
    /**
     * Формирования ответа.
     * Формируем собственный формат JSON для ответа, чтобы была возможность его прочесть.
     *
     * @param array $errors Массив ошибок.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @version 1.0
     * @since 1.0
     */
    public function response(array $errors): Response
    {
        if($errors && $this->expectsJson())
        {
            $message = null;

            foreach($errors as $key => $value)
            {
                for($i = 0; $i < count($value); $i++)
                {
                    $message = $value[$i];
                    break;
                }
            }

            return new JsonResponse
            ([
                'success' => false,
                'message' => $message
            ], 400);
        }
        else return parent::response($errors);
    }
}
