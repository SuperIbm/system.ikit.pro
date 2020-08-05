<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DocumentStore;
use Storage;
use School;

use App\Modules\Document\Http\Requests\DocumentCreateRequest;
use App\Modules\Document\Http\Requests\DocumentUpdateRequest;
use App\Modules\Document\Http\Requests\DocumentDestroyRequest;

/**
 * Класс контроллер для документа.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentController extends Controller
{
    /**
     * Получение байт кода документа.
     *
     * @param int $school Школа.
     * @param string $name Название документа.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function read(int $school, string $name): Response
    {
        School::setById($school);

        $pathinfo = pathinfo($name);

        $id = substr($pathinfo["basename"], 0, strlen($pathinfo["basename"]) - strlen($pathinfo["extension"]) - 1);
        $format = strtolower($pathinfo["extension"]);

        $document = DocumentStore::get($id);

        if($document['format'] == $format)
        {
            if($format == "png") $format = 'document/png';
            else if($format == "jpg") $format = 'document/jpeg';
            else if($format == "gif") $format = 'document/gif';
            else if($format == "swf") $format = 'document/application/x-shockwave-flash';

            return (new Response(DocumentStore::getByte($id)))
                ->header('Cache-Control', 'max-age=2592000')
                ->header('Content-type', $format);
        }
        else return (new Response(null, 404));
    }

    /**
     * Создание документа.
     *
     * @param int $school Школа.
     * @param \App\Modules\Document\Http\Requests\DocumentCreateRequest $request Запрос.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function create(int $school, DocumentCreateRequest $request): Response
    {
        School::setById($school);

        $request->file('file')->move(storage_path('app/public/documents/'), $request->input('id') . '.' . $request->input('format'));
        return response()->json(['success' => true]);
    }

    /**
     * Обновление документа.
     *
     * @param int $school Школа.
     * @param \App\Modules\Document\Http\Requests\DocumentUpdateRequest $request Запрос.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function update(int $school, DocumentUpdateRequest $request): Response
    {
        School::setById($school);

        $request->file('file')->move(storage_path('app/public/documents/'), $request->input('id') . '.' . $request->input('format'));
        return response()->json(['success' => true]);
    }

    /**
     * Удаление документа.
     *
     * @param int $school Школа.
     * @param \App\Modules\Document\Http\Requests\DocumentDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\Response Ответ.
     * @version 1.0
     * @since 1.0
     */
    public function destroy(int $school, DocumentDestroyRequest $request): Response
    {
        School::setById($school);

        Storage::disk('documents')->delete($request->input('id') . '.' . $request->input('format'));
        return response()->json(['success' => true]);
    }
}
