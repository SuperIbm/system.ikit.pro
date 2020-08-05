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
class CreateTableUserWalletInputs extends Migration
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
        Schema::create('user_wallet_inputs', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('user_wallet_id')->unsigned()->index('user_wallet_id');

            $table->float('amount', 10, 2)->unsigned()->index('amount');

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
        Schema::drop('user_wallet_inputs');
    }
}
