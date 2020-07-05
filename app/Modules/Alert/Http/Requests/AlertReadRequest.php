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
 * Класс запрос для чтения предупреждений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AlertReadRequest extends FormRequest
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
            'start' => 'nullable|integer|digits_between:0,20',
            'limit' => 'nullable|integer|digits_between:0,20',
            'unread' => 'nullable|bool',
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
            'start' => trans('alert::http.requests.alertRead.start'),
            'limit' => trans('alert::http.requests.alertRead.limit'),
            'unread' => trans('alert::http.requests.alertRead.unread')
        ];
    }
}
