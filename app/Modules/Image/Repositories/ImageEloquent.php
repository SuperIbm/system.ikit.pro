<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Repositories;

use DB;
use Cache;
use App\Models\RepositoryEloquent;

/**
 * Класс репозитария изображений на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageEloquent extends Image
{
    use RepositoryEloquent;

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
        $pro = getImageSize($path);

        $model->path = $path;
        $model->cache = time();
        $model->folder = $this->getFolder();

        if($pro)
        {
            $model->width = $pro[0];
            $model->height = $pro[1];
            $model->format = $this->getFormatText($pro[2]);
        }
        else
        {
            $pathinfo = pathinfo($path);
            $model->format = $pathinfo['extension'];
        }

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

        $model->path = $path;
        $model->cache = time();
        $model->folder = $this->getFolder();

        if($model)
        {
            $pro = @getImageSize($path);

            if($pro)
            {
                $model->width = $pro[0];
                $model->height = $pro[1];
                $model->format = $this->getFormatText($pro[2]);
            }
            else
            {
                $pathinfo = pathinfo($path);
                $model->format = $pathinfo['extension'];
            }

            $status = $model->save();

            if($model->hasError() == true || $status == false)
            {
                $this->setErrors($model->getErrors());
                return false;
            }
            else Cache::tags(['Image', 'ImageItem'])->forget($id);

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
        $status = DB::table($this->newInstance()->getTable())
            ->where('id', $id)
            ->update(['byte' => $byte]);

        Cache::tags(['Image', 'ImageItem'])->forget($id);

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
        $image = $this->_getById($id);

        if($image)
        {
            unset($image['byte']);
            return $image;
        }
        else
        {
            $data = Cache::tags(['Image', 'ImageItem'])->remember($id, $this->getCacheMinutes(),
                function() use ($id)
                {
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
                }
            );

            if($data) return $data;
            else return null;
        }
    }

    /**
     * Получение байт кода картинки.
     *
     * @param int $id Id записи для обновления.
     *
     * @return string Вернет байт код изображения.
     * @since 1.0
     * @version 1.0
     */
    public function getByte(int $id): ?string
    {
        $image = $this->_getById($id);

        if($image) return $image['byte'];
        else
        {
            $image = DB::table($this->newInstance()->getTable())
                ->where('id', $id)
                ->first();

            if($image) return $image['byte'];
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
     * @param int|array $id Id записи для удаления.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(int $id): bool
    {
        $model = $this->newInstance();
        $status = $model->destroy($id);

        if(!$status && $this->hasError()) $this->setErrors($model->getErrors());
        else Cache::tags(['Image', 'ImageItem'])->forget($id);

        return $status;
    }
}
