<?php
/**
 * Модуль предупреждений.
 * Этот модуль содержит все классы для работы с предупреждениями.
 *
 * @package App\Modules\Alert
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Alert\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс запрос для удаления предупреждений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AlertDestroyRequest extends FormRequest
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
            'ids' => 'required|json'
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
            'ids' => trans('act::http.request.ids')
        ];
    }
}
