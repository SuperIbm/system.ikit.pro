<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс для генерации API клиента.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessApiClientRequest extends FormRequest
{
    /**
     * Возвращает правила проверки.
     *
     * @return array Массив правил проверки.
     * @since 1.0
     * @version 1.0
     */
    public function rules(): array
    {
        return [
            'login' => 'required|between:1,199',
            'password' => 'required|between:4,25'
        ];
    }

    /**
     * Возвращает атрибуты.
     *
     * @return array Массив атрибутов.
     * @version 1.0
     * @since 1.0
     */
    public function attributes(): array
    {
        return [
            'login' => trans('access::http.requests.accessApiClientRequest.login'),
            'password' => trans('access::http.requests.accessApiClientRequest.password'),
        ];
    }
}
