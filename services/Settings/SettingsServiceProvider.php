<?php

namespace Netdust\Services\Settings;

use Netdust\Core\File;
use Netdust\Core\ServiceProvider;
use Netdust\Logger\Logger;
use Netdust\Service\Assets\AssetManager;
use Netdust\Traits\Mixins;
use Netdust\View\TemplateServiceProvider;


class SettingsServiceProvider extends ServiceProvider
{
    public function register() {
    }

    public function boot() {

        $asset = plugin_dir_url( __FILE__ ) . 'assets/settings.js';
        $this->container->get( AssetManager::class )->script(
            'settings-js', $asset,  ['ver'=>'0.1','to'=>['admin']]
        );

        $asset = plugin_dir_url( __FILE__ ) . 'assets/settings.css';
        $this->container->get( AssetManager::class )->style(
            'settings-css', $asset,  ['ver'=>'0.1','to'=>['admin']]
        );
    }

    public function make( string $name, array $param ): Settings {
        $factory = $param['class'] ?? Settings::class;
        $this->container->singleton(
            $name,
            new $factory( $name, $param ), ['register']
        );
        return $this->container->get( $name );
    }


}