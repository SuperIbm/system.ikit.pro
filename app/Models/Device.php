<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 *
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Models;

/**
 * Определение устройства пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Сайтография.
 * @author Инчагов Тимофей Александрович.
 */
class Device
{
    /**
     * Данные пользовательского агента.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private string $_agent = '';

    /**
     * Конструктор.
     *
     * @version 1.0
     * @since 1.0
     */
    public function __construct()
    {
        if(isset($_SERVER['HTTP_USER_AGENT'])) $this->setAgent($_SERVER['HTTP_USER_AGENT']);
    }

    /**
     * Установка агента.
     *
     * @param string $agent Данные пользовательского агента.
     *
     * @return \App\Models\Device Возвращает теущий объект.
     * @version 1.0
     * @since 1.0
     */
    public function setAgent(string $agent): Device
    {
        $this->_agent = $agent;

        return $this;
    }

    /**
     * Получение агента.
     *
     * @return string Данные пользовательского агента..
     * @version 1.0
     * @since 1.0
     */
    public function getAgent(): string
    {
        return $this->_agent;
    }

    /**
     * Получение системы и устройства.
     *
     * @return array Вернет массив с названием операционной системы и устройством.
     * @version 1.0
     * @since 1.0
     */
    public function system(): array
    {
        $osPlatform = "Unknown OS Platform";

        $os_array = array
        (
            '/windows phone 10/i' => 'Windows Phone 8',
            '/windows phone 8/i' => 'Windows Phone 8',
            '/windows phone os 7/i' => 'Windows Phone 7',
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        $device = '';

        foreach($os_array as $regex => $value)
        {
            if(preg_match($regex, $this->getAgent()))
            {
                $osPlatform = $value;
                $device = !preg_match('/(windows|mac|linux|ubuntu)/i', $osPlatform) ? 'MOBILE' : (preg_match('/phone/i', $osPlatform) ? 'MOBILE' : 'SYSTEM');
                break;
            }
        }

        $device = !$device ? 'SYSTEM' : $device;

        return array('os' => $osPlatform, 'device' => $device);
    }

    /**
     * Получение браузера.
     *
     * @return string Вернет название браузера.
     * @version 1.0
     * @since 1.0
     */
    public function browser(): string
    {
        $browser = "Unknown Browser";

        $browser_array = array(
            '/edg/i' => 'Microsoft Edge',
            '/msie/i' => 'Internet Explorer',
            '/YaBrowser/i' => 'Yandex browser',
            '/Yptp/i' => 'Yandex browser',
            '/firefox/i' => 'Firefox',
            '/opera/i' => 'Opera',
            '/OPR/i' => 'Opera',
            '/chrome/i' => 'Chrome',
            '/safari/i' => 'Safari',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser',
            '/Trident/i' => 'Internet Explorer',
        );

        foreach($browser_array as $regex => $value)
        {
            if(preg_match($regex, $this->getAgent(), $result))
            {
                $browser = $value;
                break;
            }
        }

        return $browser;
    }
}
