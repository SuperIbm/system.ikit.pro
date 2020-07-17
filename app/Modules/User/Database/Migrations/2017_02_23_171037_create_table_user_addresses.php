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
class CreateTableUserAddresses extends Migration
{
    /**
     * Запуск миграции.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function up()
    {
        Schema::create('user_addresses', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('user_id')->unsigned()->index('user_id');
            $table->string('postal_code', 191)->nullable();
            $table->string('country', 191)->nullable();
            $table->string('country_name', 191)->nullable();
            $table->string('city', 191)->nullable();
            $table->string('region', 191)->nullable();
            $table->string('region_name', 191)->nullable();
            $table->string('street_address', 191)->nullable();
            $table->float('latitude', 14, 10)->index('latitude')->nullable();
            $table->float('longitude', 14, 10)->index('longitude')->nullable();
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
    public function down()
    {
        Schema::drop('user_addresses');
    }
}
