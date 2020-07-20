<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Util;
use ImageStore;
use Storage;
use School;

use App\Modules\Image\Http\Requests\ImageCreateRequest;
use App\Modules\Image\Http\Requests\ImageUpdateRequest;
use App\Modules\Image\Http\Requests\ImageDestroyRequest;

/**
 * Класс контроллер для изображения.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageController extends Controller
{
    /**
     * Получение байт кода изображения.
     *
     * @param int $school Школа.
     * @param string $name Название изображения.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function read(int $school, string $name): Response
    {
        School::setById($school);

        $pathinfo = pathinfo($name);

        $id = substr($pathinfo["basename"], 0, Util::strlen($pathinfo["basename"]) - Util::strlen($pathinfo["extension"]) - 1);
        $format = strtolower($pathinfo["extension"]);

        $image = ImageStore::get($id);

        if($image['format'] == $format)
        {
            $format = null;

            if($format == "png") $format = 'image/png';
            else if($format == "jpg") $format = 'image/jpeg';
            else if($format == "gif") $format = 'image/gif';
            else if($format == "swf") $format = 'image/application/x-shockwave-flash';

            if($format)
            {
                return (new Response(ImageStore::getByte($id)))
                    ->header('Cache-Control', 'max-age=2592000')
                    ->header('Content-type', $format);
            }
        }

        return (new Response(null, 404));
    }

    /**
     * Создание изображения.
     *
     * @param int $school Школа.
     * @param \App\Modules\Image\Http\Requests\ImageCreateRequest $request Запрос.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function create(int $school, ImageCreateRequest $request): Response
    {
        School::setById($school);

        $request->file('file')->move(storage_path('app/public/images/'), $request->input('id') . '.' . $request->input('format'));
        return response()->json(['success' => true]);
    }

    /**
     * Обновление изображения.
     *
     * @param int $school Школа.
     * @param \App\Modules\Image\Http\Requests\ImageUpdateRequest $request Запрос.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function update(int $school, ImageUpdateRequest $request): Response
    {
        School::setById($school);

        $request->file('file')->move(storage_path('app/public/images/'), $request->input('id') . '.' . $request->input('format'));
        return response()->json(['success' => true]);
    }

    /**
     * Удаление изображения.
     *
     * @param int $school Школа.
     * @param \App\Modules\Image\Http\Requests\ImageDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function destroy(int $school, ImageDestroyRequest $request): Response
    {
        School::setById($school);

        Storage::disk('images')->delete($request->input('id') . '.' . $request->input('format'));
        return response()->json(['success' => true]);
    }
}
