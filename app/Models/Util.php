<?php

namespace App\Models;


/**
 * Класс работы с утилитами.
 * Этот класс содержит небольшие методы, которые часто требуются для выполнения тривиальных задач.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Util
{
    /**
     * Конвертирование из одной кодировки в другую.
     *
     * @param mixed $arString Переменная со строками.
     * @param string $from Из кодировки.
     * @param string $to В кодировку.
     *
     * @return mixed Переменная с переконвертированными строками.
     * @since 1.0
     * @version 1.0
     */
    public function iconv($arString, string $from = 'utf-8', string $to = 'windows-1251')
    {
        if(is_array($arString))
        {
            foreach($arString AS $k => $v)
            {
                if(is_array($v) == true) $arString[$k] = $this->iconv($v, $from, $to);
                else
                {
                    $v = @iconv($from, $to, $arString[$k]);

                    if($v != false) $arString[$k] = $v;
                }
            }
        }
        else $arString = @iconv($from, $to, $arString);

        return $arString;
    }

    /**
     * Очистка строки от всех HTML тэгов.
     *
     * @param string $string Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function getText(string $string): string
    {
        $string = trim($string);
        $string = strip_tags($string);

        return $string;
    }


    /**
     * Очистка строки с переводом тэга &lt;br /&gt; к \\r\\n и удаление HTML разметки.
     *
     * @param string $string Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function getTextN(string $string): string
    {
        $string = trim($string);
        $string = $this->parserBrToRn($string);
        $string = strip_tags($string);

        return $string;
    }


    /**
     * Очистка строки с переводом каретки к тэгу &lt;br /&gt; и удаление HTML разметки.
     *
     * @param string $string Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function getTextBr(string $string): string
    {
        $string = trim($string);
        $string = strip_tags($string, "<br>,<br/>,<br />");
        $string = $this->parserRnToBr($string);

        return $string;
    }


    /**
     * Очистка строки с переводом каретки к тэгу &lt;br /&gt; с сохранением HTML разметки.
     *
     * @param string $string Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function getHtmlBr(string $string): string
    {
        $string = trim($string);
        $string = $this->parserRnToBr($string);
        return $string;
    }


    /**
     * Очистка строки с сохранением HTML разметки.
     *
     * @param string $string Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function getHtmlN(string $string): string
    {
        $string = trim($string);
        return $string;
    }


    /**
     * Обработка строки с переводом тэга &lt;br /&gt; к \\r\\n.
     *
     * @param string $str Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function parserBrToRn(string $str): string
    {
        $str = str_replace("<br />", "\r\n", $str);
        $str = str_replace("<br>", "\r\n", $str);
        return $str;
    }


    /**
     * Обработка строки с переводом корретки к тэгу &lt;br /&gt;.
     *
     * @param string $str Строка.
     *
     * @return string Очищенная строка.
     * @since 1.0
     * @version 1.0
     */
    public function parserRnToBr(string $str): string
    {
        $str = str_replace("\r\n", "<br />", $str);
        $str = str_replace("\n", "<br />", $str);
        $str = str_replace("\r", "<br />", $str);
        return $str;
    }

    /**
     * Удаление всех лишних пробелов в строке.
     *
     * @param string $string Строка для очистки лишних пробелов.
     *
     * @return string Строка без лишних пробелов.
     * @since 1.0
     * @version 1.0
     */
    public function deleteWhitespace(string $string): string
    {
        $string = preg_replace('/ {2,}/', ' ', $string);
        $string = trim($string);
        return $string;
    }


    /**
     * Транслирует текст.
     * Переводит текст с русского языка.
     *
     * @param string $string Строка для перевода.
     * @param string $separator Сепаратор, который используется в качестве пробела.
     * @param bool $symbols Если указать true, то допустит только буквы и и цифры, остальные символы будут удалены.
     *
     * @return string Транслируемая строка.
     * @since 1.0
     * @version 1.0
     */
    public function latin(string $string, $separator = "-", $symbols = true): string
    {
        $order = array(
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "e",
            "ж" => "zh",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "c",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sh",
            "ъ" => "",
            "ы" => "i",
            "ь" => "",
            "э" => "e",
            "ю" => "u",
            "я" => "ya",

            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ё" => "E",
            "Ж" => "ZH",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "C",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SH",
            "Ъ" => "",
            "Ы" => "I",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "U",
            "Я" => "Ya",

            "a" => "a",
            "b" => "b",
            "c" => "c",
            "d" => "d",
            "e" => "e",
            "f" => "f",
            "g" => "g",
            "h" => "h",
            "i" => "i",
            "j" => "j",
            "k" => "k",
            "l" => "l",
            "m" => "m",
            "n" => "n",
            "o" => "o",
            "p" => "p",
            "q" => "q",
            "r" => "r",
            "s" => "s",
            "t" => "t",
            "u" => "u",
            "v" => "v",
            "w" => "w",
            "x" => "x",
            "y" => "y",
            "z" => "z",

            "A" => "A",
            "B" => "B",
            "C" => "C",
            "D" => "D",
            "E" => "E",
            "F" => "F",
            "G" => "G",
            "H" => "H",
            "I" => "I",
            "J" => "J",
            "K" => "K",
            "L" => "L",
            "M" => "M",
            "N" => "N",
            "O" => "O",
            "P" => "P",
            "Q" => "Q",
            "R" => "R",
            "S" => "S",
            "T" => "T",
            "U" => "U",
            "V" => "V",
            "W" => "W",
            "X" => "X",
            "Y" => "Y",
            "Z" => "Z",

            "0" => "0",
            "1" => "1",
            "2" => "2",
            "3" => "3",
            "4" => "4",
            "5" => "5",
            "6" => "6",
            "7" => "7",
            "8" => "8",
            "9" => "9",

            " " => $separator,
            $separator => $separator
        );

        $length = strlen($string);
        $latin = "";

        for($i = 0; $i < $length; $i++)
        {
            $letter = mb_substr($string, $i, 1, "utf-8");

            if(isset($order[$letter])) $latin .= $order[$letter];
            else if($symbols == false) $latin .= $letter;
        }

        return $latin;
    }


    /**
     * Метод проверит является ли массив ассоциативным.
     *
     * @param array $arr Ассоциативный массив для проверки.
     *
     * @return string Возвращает true, если массив ассоциативный.
     * @since 1.0
     * @version 1.0
     */
    public function isAssoc($arr)
    {
        if(array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Получение уникального ключа.
     *
     * @param array $params Параметры.
     *
     * @return string Вернет уникальный ключ.
     * @since 1.0
     * @version 1.0
     */
    public function getKey(...$params): string
    {
        return serialize($params);
    }

    /**
     * Проверка соотвествия версий.
     *
     * @param string $versionFirst Первая версия.
     * @param string $versionSecond Вторая версия.
     *
     * @return bool Вернет true, если версии соотвествуют.
     * @since 1.0
     * @version 1.0
     */
    function isCorrectVersion($versionFirst, $versionSecond)
    {
        $versionCurrent = explode(".", $versionFirst);
        $versionModule = explode(".", $versionSecond);

        return $versionCurrent[0] == $versionModule[0];
    }

    /**
     * Получение отформатированного числа.
     *
     * @param float $number Число для форматирования.
     * @param int $digits Количество чисел после дробной точки.
     * @param string $separate Точка для дробного числа.
     * @param string $separateDigits Разделитель для числа.
     *
     * @return string Вернет отформатированное число.
     * @since 1.0
     * @version 1.0
     */
    private function _number(float $number, int $digits = 0, string $separate = ",", string $separateDigits = '.'): string
    {
        $numberArr = [];
        $number = round($number, $digits);

        if($number < 0) $minus = true;
        else $minus = false;

        if($minus) $number = str_replace("-", "", $number) * 1;

        $celAndOst = explode(".", $number);
        $numberArr[0] = $celAndOst[0];

        if(isset($celAndOst[1])) $numberArr[1] = $celAndOst[1];

        $lenPrice = strlen(trim($numberArr[0])) - 1;

        if($lenPrice >= 3)
        {
            $numberForm = "";

            for($i = $lenPrice, $z = -1; $i >= 0; $i--)
            {
                if($z == 2)
                {
                    $numberForm = $separate . $numberForm;
                    $z = -1;
                }

                $numberForm = @$numberArr[0][$i] . $numberForm;
                $z++;
            }

            $numberArr[0] = $numberForm;
        }

        $numberNew = $numberArr[0];

        if($numberArr[0] != "" && isset($numberArr[1]) && $numberArr[1] != "" && $digits)
        {
            $numberNew = $numberArr[0] . $separateDigits . $numberArr[1];
        }

        if($minus) return "-" . $numberNew;
        else return $numberNew;
    }

    /**
     * Получение отформатированного числа.
     *
     * @param float $number Число для форматирования.
     * @param int $digits Количество чисел после дробной точки.
     *
     * @return string Вернет отформатированное число.
     * @since 1.0
     * @version 1.0
     */
    public function getNumber($number, $digits = 0): string
    {
        return $this->_number($number, $digits);
    }

    /**
     * Получение отформатированного числа в виде цены.
     *
     * @param float $number Число для форматирования.
     * @param bool $digits Отображать дробные числа.
     * @param string $label Знак валюты.
     *
     * @return string Вернет отформатированное число.
     * @since 1.0
     * @version 1.0
     */
    public function getMoney($number, $digits = true, $label = '$'): string
    {
        $digits = $digits == false ? 0 : 2;
        $money = $this->_number($number, $digits);

        if($label) $money = $label . $money;

        return $money;
    }

    /**
     * Проверка содержит ли строка корректный JSON.
     *
     * @param string $string Строка проверки.
     *
     * @return bool Вернет результат проверки.
     * @since 1.0
     * @version 1.0
     */
    public function isJson($string): bool
    {
        if(is_string($string) && !is_numeric($string))
        {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }

        return false;
    }
}