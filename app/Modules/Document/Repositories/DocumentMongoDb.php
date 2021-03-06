<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Repositories;

use DB;
use Cache;
use App\Models\RepositoryMongoDb;

/**
 * Класс репозитария документов на основе DocumentMongoDb.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentMongoDb extends Document
{
    use RepositoryMongoDb;

    /**
     * Создание.
     *
     * @param string $path Путь к файлу.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function create(string $path)
    {
        $model = $this->newInstance();
        $model->id = round((time() * 1000) + microtime(true));
        $model->path = $path;
        $model->format = pathinfo($path)["extension"];
        $status = $model->save();

        if(!$status)
        {
            $this->setErrors($model->getErrors());
            return false;
        }

        return $model->id;
    }

    /**
     * Обновление.
     *
     * @param int $id Id записи для обновления.
     * @param string $path Путь к файлу.
     *
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, string $path)
    {
        $model = $this->newInstance()->find($id);

        if($model)
        {
            $model->path = $path;
            $model->format = pathinfo($path)["extension"];
            $model->cache = time();

            $status = $model->save();

            if($model->hasError() == true || $status == false)
            {
                $this->setErrors($model->getErrors());
                return false;
            }
            else Cache::tags(['Document', 'DocumentItem'])->forget($id);

            return $id;
        }
        else return false;
    }

    /**
     * Обновление байт кода картинки.
     *
     * @param int $id Id записи для обновления.
     * @param string $byte Байт код картинки.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function updateByte(int $id, string $byte): bool
    {
        $status = DB::connection('mongodb')
            ->collection($this->newInstance()->getTable())
            ->where('id', $id)
            ->update(['byte' => $byte]);

        Cache::tags(['Document', 'DocumentItem'])->forget($id);

        return $status;
    }

    /**
     * Получить по первичному ключу.
     *
     * @param int $id Первичный ключ.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get(int $id): ?array
    {
        $document = $this->_getById($id);

        if($document)
        {
            unset($document['byte']);
            return $document;
        }
        else
        {
            $data = Cache::tags(['Document', 'DocumentItem'])
                ->remember($id, $this->getCacheMinutes(), function() use ($id) {
                    $model = $this->getModel()->find($id);

                    if($model)
                    {
                        $data = $model->toArray();
                        $data['path'] = $model->path;
                        $data['pathCache'] = $model->pathCache;
                        $data['pathSource'] = $model->pathSource;

                        $this->_setById($id, $data);

                        unset($data['byte']);
                        return $data;
                    }

                    else return null;
                });

            if($data) return $data;
            else return null;
        }
    }

    /**
     * Получение байт кода картинки.
     *
     * @param int $id Id записи для обновления.
     *
     * @return string Вернет байт код документа.
     * @since 1.0
     * @version 1.0
     */
    public function getByte(int $id): ?string
    {
        $document = $this->_getById($id);

        if($document) return $document['byte'];
        else
        {
            $document = DB::connection('mongodb')
                ->collection($this->newInstance()->getTable())
                ->where('id', $id)
                ->first();

            if($document) return $document['byte'];
            else return null;
        }
    }

    /**
     * Получение всех записей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function all(): ?array
    {
        return $this->newInstance()->all();
    }

    /**
     * Удаление.
     *
     * @param int $id Id записи для удаления.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function destroy($id): bool
    {
        $model = $this->newInstance();

        if(is_numeric($id)) $status = $model->destroy($id);
        else $status = $model->whereIn('id', $id)->delete();

        if(!$status) $this->setErrors($model->getErrors());
        else Cache::tags(['Document', 'DocumentItem'])->forget($id);

        return $status;
    }
}
