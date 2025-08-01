<?php
/**
 * User: Qbhy
 * Date: 2019/1/16
 * Time: 下午2:14
 */

namespace myfind\BaiduAIP;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

/**
 * Class LaravelServiceProvider
 *
 * @author  Qbhy <Qbhy@gmail.com>
 *
 * @package myfind\BaiduAIP
 */
class LaravelServiceProvider extends BaseServiceProvider
{
    public function boot()
    {

    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../config/baidu_aip.php');
        if ($this->app->runningInConsole()) {
            $this->publishes([$source => base_path('config/baidu_aip.php')], 'baidu_aip');
        }

        if ($this->app instanceof LumenApplication) {
            $this->app->configure('baidu_aip');
        }

        $this->mergeConfigFrom($source, 'baidu_aip');
    }

    public function register()
    {
        $this->setupConfig();

        $this->app->singleton(BaiduAIP::class, function ($app) {
            return new BaiduAIP(config('baidu_aip'));
        });

        $this->app->alias(BaiduAIP::class, 'baidu_aip');
    }
}