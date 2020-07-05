<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс проверки запроса для удаления документа.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentDestroyRequest extends FormRequest
{
    /**
     * Получить правила валидации для запроса.
     *
     * @return array Правила валидирования.
     * @version 1.0
     * @since 1.0
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|digits_between:1,20',
            'format' => 'required|in:jpg,png,gif,jpeg,swf,flw'
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
            'id' => trans('document::http.requests.documentDestroy.file'),
            'format' => trans('document::http.requests.documentDestroy.format')
        ];
    }
}
