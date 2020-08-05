<?php
/**
 * Модуль Заказов.
 * Этот модуль содержит все классы для работы с заказами.
 *
 * @package App\Modules\Order
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Order\Providers;

use App;

use App\Modules\Order\Models\Order as OrderModel;
use App\Modules\Order\Repositories\Order as OrderRepository;
use App\Modules\Order\Events\Listeners\OrderListener;

use App\Modules\Order\Models\OrderCharge as OrderChargeModel;
use App\Modules\Order\Repositories\OrderCharge as OrderChargeRepository;
use App\Modules\Order\Events\Listeners\OrderChargeListener;

use App\Modules\Order\Models\OrderInvoice as OrderInvoiceModel;
use App\Modules\Order\Repositories\OrderInvoice as OrderInvoiceRepository;
use App\Modules\Order\Events\Listeners\OrderInvoiceListener;

use App\Modules\Order\Models\OrderPayment as OrderPaymentModel;
use App\Modules\Order\Repositories\OrderPayment as OrderPaymentRepository;
use App\Modules\Order\Events\Listeners\OrderPaymentListener;

use App\Modules\Order\Models\OrderRefund as OrderRefundModel;
use App\Modules\Order\Repositories\OrderRefund as OrderRefundRepository;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected $moduleName = 'Order';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'order';

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Регистрация сервис провайдеров.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        App::singleton(OrderRepository::class, function()
        {
            return new OrderRepository(new OrderModel());
        });

        OrderModel::observe(OrderListener::class);

        //

        App::singleton(OrderChargeRepository::class, function()
        {
            return new OrderChargeRepository(new OrderChargeModel());
        });

        OrderChargeModel::observe(OrderChargeListener::class);

        //

        App::singleton(OrderInvoiceRepository::class, function()
        {
            return new OrderInvoiceRepository(new OrderInvoiceModel());
        });

        OrderInvoiceModel::observe(OrderInvoiceListener::class);

        //

        App::singleton(OrderPaymentRepository::class, function()
        {
            return new OrderPaymentRepository(new OrderPaymentModel());
        });

        OrderPaymentModel::observe(OrderPaymentListener::class);

        //

        App::singleton(OrderRefundRepository::class, function()
        {
            return new OrderRefundRepository(new OrderRefundModel());
        });
    }

    /**
     * Регистрация настроек.
     *
     * @return void
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower);
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if(is_dir($langPath))
        {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        }
        else
        {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Регистрация дополнительной директории для фабрик.
     *
     * @return void
     */
    public function registerFactories(): void
    {
        if(!app()->environment('production') && $this->app->runningInConsole())
        {
            app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
        }
    }

    /**
     * Получение сервисов через сервис-провайдер.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Получить пути к опубликованным шаблонам.
     *
     * @return array
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach(\Config::get('view.paths') as $path)
        {
            if(is_dir($path . '/modules/' . $this->moduleNameLower))
            {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
