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

use \Illuminate\Database\Eloquent\Builder;

/**
 * Трейт для модели которая поддерживает систему статусов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Status
{
    /**
     * Проверка статуса.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Запрос.
     * @param bool $status Статус активности.
     *
     * @return \Illuminate\Database\Eloquent\Builder Построитель запросов.
     * @since 1.0
     * @version 1.0
     */
    private function statusIs(Builder $query, bool $status = true): Builder
    {
        $query->where($this->getTable().".status", $status);

        return $query;
    }

    /**
     * Заготовка запроса активных записей.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Запрос.
     *
     * @return \Illuminate\Database\Eloquent\Builder Построитель запросов.
     * @since 1.0
     * @version 1.0
     */
    public function scopeActive(Builder $query): Builder
    {
        return $this->statusIs($query, true);
    }

    /**
     * Заготовка запроса не активных записей.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Запрос.
     *
     * @return \Illuminate\Database\Eloquent\Builder Построитель запросов.
     * @since 1.0
     * @version 1.0
     */
    public function scopeNotActive(Builder $query): Builder
    {
        return $this->statusIs($query, false);
    }

    /**
     * Проверить статус
     *
     * @return bool Вернет статус.
     * @since 1.0
     * @version 1.0
     */
    public function statusCheck(): bool
    {
        return (bool)$this->status;
    }
}
