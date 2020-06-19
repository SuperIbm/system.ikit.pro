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
 * Работа с метаданными.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Meta
{
    /**
     * Заголовок страницы.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_title;

    /**
     * Описание страницы.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_description;

    /**
     * Ключевые слова страницы.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_keywords;

    /**
     * Изображение страницы.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_image;

    /**
     * Ширина изображения страницы.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_imageWidth;

    /**
     * Высота изображения страницы.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_imageHeight;

    /**
     * Установка заголовка страницы.
     *
     * @param string $title Заголовок страницы.
     *
     * @return \App\Models\Meta Возвращает объект методанных.
     * @since 1.0
     * @version 1.0
     */
    public function setTitle(string $title): Meta
    {
        $this->_title = $title;

        return $this;
    }

    /**
     * Получение заголовка страницы.
     *
     * @param string $default Заголовок страницы по умолчанию.
     *
     * @return string Возвращает заголовок страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getTitle(string $default = ""): string
    {
        if($this->_title) return $this->_title;
        else return $default;
    }

    /**
     * Установка описания страницы.
     *
     * @param string $description Описание страницы.
     *
     * @return \App\Models\Meta Возвращает объект методанных.
     * @since 1.0
     * @version 1.0
     */
    public function setDescription(string $description): Meta
    {
        $this->_description = $description;

        return $this;
    }

    /**
     * Получение описания страницы.
     *
     * @param string $default Описание страницы по умолчанию.
     *
     * @return string Возвращает описание страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getDescription(string $default = ""): string
    {
        if($this->_description) return $this->_description;
        else return $default;
    }

    /**
     * Установка ключевых слов страницы.
     *
     * @param string $keywords Ключевые слова страницы.
     *
     * @return \App\Models\Meta Возвращает объект методанных.
     * @since 1.0
     * @version 1.0
     */
    public function setKeywords(string $keywords): Meta
    {
        $this->_keywords = $keywords;

        return $this;
    }

    /**
     * Получение ключевых слов страницы.
     *
     * @param string $default Ключевые слова страницы по умолчанию.
     *
     * @return string Возвращает ключевые слова страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getKeywords(string $default = ""): string
    {
        if($this->_keywords) return $this->_keywords;
        else return $default;
    }

    /**
     * Установка изображения страницы.
     *
     * @param string $image Изображения страницы.
     *
     * @return \App\Models\Meta Возвращает объект методанных.
     * @since 1.0
     * @version 1.0
     */
    public function setImage(string $image): Meta
    {
        $this->_image = $image;

        return $this;
    }

    /**
     * Получение изображения страницы.
     *
     * @param string $default Изображения страницы по умолчанию.
     *
     * @return string Возвращает изображения страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getImage(string $default = null): string
    {
        if($this->_image) return $this->_image;
        else return $default;
    }

    /**
     * Установка ширины изображения страницы.
     *
     * @param int $imageWidth Ширина изображения страницы.
     *
     * @return \App\Models\Meta Возвращает объект методанных.
     * @since 1.0
     * @version 1.0
     */
    public function setImageWidth(int $imageWidth): Meta
    {
        $this->_imageWidth = $imageWidth;

        return $this;
    }

    /**
     * Получение ширины изображения страницы.
     *
     * @param int $default Ширина изображения страницы по умолчанию.
     *
     * @return int Возвращает ширину изображения страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getImageWidth(int $default = null): int
    {
        if($this->_imageWidth) return $this->_imageWidth;
        else return $default;
    }

    /**
     * Установка высоты изображения страницы.
     *
     * @param int $imageHeight Высота изображения страницы.
     *
     * @return \App\Models\Meta Возвращает объект методанных.
     * @since 1.0
     * @version 1.0
     */
    public function setImageHeight(int $imageHeight): Meta
    {
        $this->_imageHeight = $imageHeight;

        return $this;
    }

    /**
     * Получение высоты изображения страницы.
     *
     * @param int $default Высота изображения страницы по умолчанию.
     *
     * @return int Возвращает высоту изображения страницы.
     * @since 1.0
     * @version 1.0
     */
    public function getImageHeight(int $default = null): int
    {
        if($this->_imageHeight) return $this->_imageHeight;
        else return $default;
    }
}