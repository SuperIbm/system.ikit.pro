<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Contracts;


/**
 * Абстрактный класс позволяющий проектировать собственные классы для хранения документов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class DocumentDriver
{
    /**
     * Абстрактный метод получения пути к документу.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет путь к документу.
     * @since 1.0
     * @version 1.0
     */
    abstract public function path($id, $format);

    /**
     * Абстрактный метод получения физического пути к документу.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет физический путь к документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function pathSource($id, $format);

    /**
     * Абстрактный метод чтения документа.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет байт код документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read($id, $format);

    /**
     * Абстрактный метод создания документа.
     *
     * @param int $id Индификатор документа.
     * @param string $path Путь к документу.
     *
     * @return bool Вернет статус успешности создания документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create($id, $format, $path);

    /**
     * Абстрактный метод обновления документа.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     * @param string $path Путь к документу.
     *
     * @return bool Вернет статус успешности обновления документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function update($id, $format, $path);

    /**
     * Абстрактный метод удаления документа.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return bool Вернет статус успешности удаления документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy($id, $format);
}
