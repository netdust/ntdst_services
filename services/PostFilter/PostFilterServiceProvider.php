<?php

namespace Netdust\Services\PostFilter;

use Netdust\Core\File;
use Netdust\Core\ServiceProvider;
use Netdust\Service\Assets\AssetManager;
use Netdust\View\TemplateServiceProvider;


class PostFilterServiceProvider extends ServiceProvider
{
    public function register() {

        $this->container->get( TemplateServiceProvider::class )->template_mixin( $this, dirname(__FILE__ ) );
        //$this->make( 'post_filter',  ['post_type'=>'post','exclude_cat'=>'category,language'] );

    }

    public function make( string $name, array $param ): PostFilter {
        $this->container->singleton(
            $name,
            new PostFilter( $this, $param ), ['register']
        );
        return $this->container->get( $name );
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

        $asset =  $this->container->get( File::class )->asset_url( 'js', 'filter.js' );
        $this->container->get( AssetManager::class )->script(
            'filter-js', $asset,  ['deps'=> ['jquery'], 'ver'=>'0.1'], false
        );

    }


}