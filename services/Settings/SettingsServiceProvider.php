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