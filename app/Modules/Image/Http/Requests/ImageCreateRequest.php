<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Http\Requests;

use App\Models\FormRequest;

/**
 * Класс проверки запроса для создания изображения.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageCreateRequest extends FormRequest
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
            'file' => 'required|image',
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
            'file' => trans('image::http.request.file'),
            'id' => trans('image::http.request.id'),
            'format' => trans('image::http.request.format')
        ];
    }
}
