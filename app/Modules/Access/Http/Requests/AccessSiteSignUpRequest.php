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
 * Класс для регистрации пользователя через публичную часть сайта.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteSignUpRequest extends FormRequest
{
    /**
     * Возвращает правила проверки.
     *
     * @return array Массив правил проверки.
     * @since 1.0
     * @version 1.0
     */
    public function rules()
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
    public function attributes()
    {
        return [
            'login' => 'Login',
            'password' => 'Password',
            'first_name' => 'First name',
            'second_name' => 'Last name',
            'company' => 'Company',
            'telephone' => 'Telephone'
        ];
    }
}
