<?php
/**
 * Тестирование ядра базовых классов.
 * Этот пакет содержит набор тестов для ядра баззовых классов.
 *
 * @package App.Test.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Test\Models;

use Tests\TestCase;
use Util;

/**
 * Тестирование: Класс работы с утилитами.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UtilTest extends TestCase
{
    /**
     * Конвертирование из одной кодировки в другую.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testIconv(): void
    {
        $result = Util::iconv('test');
        $this->assertEquals('test', $result);
    }

    /**
     * Очистка строки от всех HTML тэгов.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetText(): void
    {
        $result = Util::getText('<b>test<br />here</b>');
        $this->assertEquals('testhere', $result);
    }

    /**
     * Очистка строки с переводом тэга &lt;br /&gt; к \\r\\n и удаление HTML разметки.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetTextN(): void
    {
        $result = Util::getTextN('<b>test<br />here</b>');
        $this->assertEquals("test\r\nhere", $result);
    }

    /**
     * Очистка строки с переводом каретки к тэгу &lt;br /&gt; и удаление HTML разметки.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetTextBr(): void
    {
        $result = Util::getTextBr("<b>test\r\nhere</b>");
        $this->assertEquals("test<br />here", $result);
    }

    /**
     * Очистка строки с переводом каретки к тэгу &lt;br /&gt; с сохранением HTML разметки.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetHtmlBr(): void
    {
        $result = Util::getHtmlBr("<b>test\r\nhere</b>");
        $this->assertEquals("<b>test<br />here</b>", $result);
    }

    /**
     * Очистка строки с сохранением HTML разметки.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetHtmlN(): void
    {
        $result = Util::getHtmlN("<b>test<br >here</b>");
        $this->assertEquals("<b>test<br >here</b>", $result);
    }

    /**
     * Обработка строки с переводом тэга &lt;br /&gt; к \\r\\n.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testParserBrToRn(): void
    {
        $result = Util::parserBrToRn("test<br />here");
        $this->assertEquals("test\r\nhere", $result);
    }

    /**
     * Обработка строки с переводом корретки к тэгу &lt;br /&gt;.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testParserRnToBr(): void
    {
        $result = Util::parserRnToBr("test\r\nhere");
        $this->assertEquals("test<br />here", $result);
    }

    /**
     * Удаление всех лишних пробелов в строке.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testDeleteWhitespace(): void
    {
        $result = Util::deleteWhitespace(" test  here ");
        $this->assertEquals("test here", $result);
    }

    /**
     * Транслирует текст.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testLatin(): void
    {
        $result = Util::latin("Тестирую");
        $this->assertEquals("Testiruu", $result);
    }

    /**
     * Метод проверит является ли массив ассоциативным.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testIsAssoc(): void
    {
        $result = Util::isAssoc([
            "test" => 1
        ]);

        $this->assertTrue($result);
    }

    /**
     * Получение отформатированного числа.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetNumber(): void
    {
        $result = Util::getNumber(123.12, 2);
        $this->assertEquals(123.12, $result);
    }

    /**
     * Получение отформатированного числа в виде цены.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGetMoney(): void
    {
        $result = Util::getMoney(123.12);
        $this->assertEquals("$123.12", $result);
    }
}
