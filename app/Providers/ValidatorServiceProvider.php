<?php
/**
 * Основные провайдеры.
 *
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;

use App\Models\Validators\DateMongoValidator;
use App\Models\Validators\UniqueSoftValidator;
use App\Models\Validators\FloatValidator;
use App\Models\Validators\PhoneValidator;
use App\Models\Validators\FloatBetweenValidator;

/**
 * Класс сервис-провайдера для валидации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
        Validator::extend('date_mongo', DateMongoValidator::class);
        Validator::extend('unique_soft', UniqueSoftValidator::class);
        Validator::extend('float', FloatValidator::class);
        Validator::extend('phone', PhoneValidator::class);
        Validator::extend('float_between', FloatBetweenValidator::class);
    }
}