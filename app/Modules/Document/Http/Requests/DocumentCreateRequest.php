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
 * Класс проверки запроса для создания документа.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentCreateRequest extends FormRequest
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
            'file' => 'required|document',
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
            'file' => trans('document::http.request.file'),
            'id' => trans('document::http.request.id'),
            'format' => trans('document::http.request.format')
        ];
    }
}
