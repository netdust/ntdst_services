<?php

namespace Netdust\Services\PostFilter;

use Netdust\Core\File;
use Netdust\Core\ServiceProvider;
use Netdust\Logger\Logger;
use Netdust\Service\Assets\AssetManager;
use Netdust\Traits\Mixins;
use Netdust\View\TemplateServiceProvider;


class PostFilterServiceProvider extends ServiceProvider
{
    use Mixins;

    public function register() {
        // make template methods easly avialable
        $this->container->get( TemplateServiceProvider::class )->template_mixin(
            $this,
            $this->container->get( TemplateServiceProvider::class )->make(
                dirname(__FILE__ ) . '/templates/'
            )
        );
    }

    public function boot() {


        add_shortcode( 'post_filter', function( array $atts, string $content = ""  )  {

            if( !empty( $atts['name'] ) ) {
                ob_start();

                $filter = $this->container->get( $atts['name'] );
                $filter->query_args = $atts;

                $filter->echo_template();

                $html = ob_get_contents();
                ob_end_clean();
                return $html;
            }

            return '';

        });

    }

    public function make( string $name, array $param ): PostFilter {

        $factory = $param['class'] ?? PostFilter::class;
        $provider = $param['provider'] ?? $this;

        $this->container->singleton(
            $name, new $factory( $provider, $param )
        );
        $this->container->get( $name )->register();
        return $this->container->get( $name );
    }


}