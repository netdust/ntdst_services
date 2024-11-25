<?php

namespace Netdust\Services\Yootheme;


use Netdust\Core\ServiceProvider;


use Netdust\Service\Pages\VirtualPage;



class YooThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_action('after_setup_theme', function() {
            $app = \YOOtheme\Application::getInstance();
            $app->load(\YOOtheme\Path::get('./bootstrap.php'));
        });


    }

    public function make( string $uri, string $title, string $template = null ):VirtualPage {
        return new Yootheme_VirtualPage( $uri, $title, $template );
    }





}