<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\UserFieldsComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('shared._card', 'card');

        Blade::directive('render', function ($expression) {
            $parts = explode(',', $expression, 2);

            $component = $parts[0];
            $args = trim($parts[1] ?? '[]');

            return "<?php echo app('App\Http\ViewComponents\\\\'.{$component}, {$args})->toHtml() ?>";
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
