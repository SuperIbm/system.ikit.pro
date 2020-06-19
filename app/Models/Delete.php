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

use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Трейт для модели, помошает при удалении.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Delete
{
    /**
     * Специализированный метод, который удаляет все модели в связе и при этом вызывает их события.
     *
     * @param \Illuminate\Database\Eloquent\Relations\Relation Отновшение модели.
     * @param bool $force Просим удалить записи полностью.
     *
     * @return object Вернет объект.
     * @since 1.0
     * @version 1.0
     */
    public function deleteRelation(Relation $relation, $force = false)
    {
        $models = $relation->get();

        foreach($models as $model)
        {
            if($force) $model->forceDelete();
            else $model->delete();
        }

        return $this;
    }
}