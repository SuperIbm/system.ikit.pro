<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Класс миграции.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CreateTableUserReferrals extends Migration
{
    /**
     * Запуск миграции.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function up(): void
    {
        Schema::create('user_referrals', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('referral_id')->unsigned()->index('referral_id');

            $table->bigInteger('user_invited_id')->unsigned()->index('user_invited_id');
            $table->bigInteger('user_referral_id')->unsigned()->index('user_referral_id');

            $table->timestamps();
            $table->softDeletes()->index('deleted_at');
        });
    }

    /**
     * Запуск отката миграции.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function down(): void
    {
        Schema::drop('user_referrals');
    }
}
