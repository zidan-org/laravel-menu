<?php

namespace NguyenHuy\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use NguyenHuy\Menu\WMenu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require  __DIR__ . '/../../routes/web.php';
        }

        $this->loadViewsFrom(__DIR__ . '/../../../', 'nguyendachuy-menu');

        $this->publishes([
            __DIR__ . '/../../config/menu.php'  => config_path('menu.php'),
        ], 'laravel-menu-config');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/nguyendachuy-menu'),
        ], 'laravel-menu-view');

        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/nguyendachuy-menu'),
        ], 'laravel-menu-public');

        $this->publishes([
            __DIR__ . '/../../database/migrations/2017_08_11_073824_create_menus_wp_table.php'
            => database_path('migrations/2017_08_11_073824_create_menus_wp_table.php'),
            __DIR__ . '/../../database/migrations/2017_08_11_074006_create_menu_items_wp_table.php'
            => database_path('migrations/2017_08_11_074006_create_menu_items_wp_table.php'),
            __DIR__ . '/../../database/migrations/2019_01_05_293551_add-role-id-to-menu-items-table.php'
            => database_path('2019_01_05_293551_add-role-id-to-menu-items-table.php'),
            __DIR__ . '/../../database/migrations/2022_07_06_000123_add_class_to_menu_table.php'
            => database_path('migrations/2022_07_15_000123_add_class_to_menu_table.php'),
        ], 'laravel-menu-migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nguyendachuy-menu', function () {
            return new WMenu();
        });

        $this->app->make('NguyenHuy\Menu\Http\Controllers\MenuController');
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/menu.php',
            'menu'
        );
    }
    protected function migrationExists($mgr)
    {
        $path = database_path('migrations/');
        $files = scandir($path);
        $pos = false;
        foreach ($files as &$value) {
            $pos = strpos($value, $mgr);
            if ($pos !== false) return true;
        }
        return false;
    }
}
