<?php
/**
 * Модуль Типографи.
 * Этот модуль содержит все классы для работы с типографом.
 *
 * @package App\Modules\Typograph
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Typograph\Http\Controllers;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use EMT\EMTypograph;
use Illuminate\Http\JsonResponse;

/**
 * Класс контроллер для работы с типографом в административной части.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class TypographAdminController extends Controller
{
    /**
     * Получение типографированного текста.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get(Request $request): JsonResponse
    {
        $text = str_replace("\t", '', $request->input('text'));
        $text = str_replace("\n\r", '', $text);
        $text = str_replace("\r\n", '', $text);
        $text = str_replace("\n", '', $text);
        $text = str_replace("\r", '', $text);

        if($text != "")
        {
            $typograph = new EMTypograph();

            $typograph->do_setup("OptAlign.all", false);
            $typograph->do_setup("Text.paragraphs", false);
            $typograph->do_setup("Text.breakline", false);

            $result = $typograph->process($text);

            if($result)
            {
                $data = [
                    'success' => true,
                    'text' => $result
                ];
            }
            else
            {
                $data = [
                    'success' => false
                ];
            }
        }
        else
        {
            $data = [
                'success' => true,
                'text' => ''
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
