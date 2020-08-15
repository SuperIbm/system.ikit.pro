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
 * Класс для регистрации пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSignUpRequest extends FormRequest
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
            'password' => 'required|between:6,25|confirmed',
            'first_name' => 'nullable|max:191',
            'second_name' => 'nullable|max:191',
            'company' => 'nullable|max:191',
            'telephone' => 'nullable|phone:1'
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
            'login' => trans('access::http.requests.accessSignUpRequest.login'),
            'password' => trans('access::http.requests.accessSignUpRequest.password'),
            'first_name' => trans('access::http.requests.accessSignUpRequest.first_name'),
            'second_name' => trans('access::http.requests.accessSignUpRequest.second_name'),
            'company' => trans('access::http.requests.accessSignUpRequest.company'),
            'telephone' => trans('access::http.requests.accessSignUpRequest.telephone'),
        ];
    }
}
