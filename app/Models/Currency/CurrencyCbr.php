<?php
/**
 * Котировки валют.
 * Пакет содержит классы для получения котировок валют.
 *
 * @package App.Models.Currency
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Currency;

use Carbon\Carbon;
use Yangqi\Htmldom\Htmldom;
use App\Models\Contracts\Currency;


/**
 * Класс драйвер для удаленного получения котировок с центрабанка России.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CurrencyCbr extends Currency
{
    /**
     * Получение валюты по коду валюты.
     *
     * @param \Carbon\Carbon $carbon Дата на которую нужно получить котировки.
     * @param string $charCode Код валюты для получения котировки.
     *
     * @return array|int|false Массив данных запрашиваемой валюты.
     * @since 1.0
     * @version 1.0
     */
    public function get(Carbon $carbon, string $charCode)
    {
        $pathToFile = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=" . $carbon->format("d.m.Y");
        $htmldom = new Htmldom($pathToFile, true, true);

        if($htmldom->Valute)
        {
            $data = Array();

            foreach($htmldom->Valute as $item)
            {
                $data[$item->CharCode->asText()] = [
                    "numCode" => $item->NumCode->asText(),
                    "nominal" => $item->Nominal->asText(),
                    "name" => $item->Name->asText(),
                    'value' => (float)str_replace(",", ".", $item->Value->asText())
                ];
            }

            if(isset($data[$charCode])) return $data[$charCode];
            else return $data;
        }

        return false;
    }
}
