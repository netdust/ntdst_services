<?php

namespace Netdust\Services\UIKit;

use Netdust\Core\File;
use Netdust\Core\ServiceProvider;
use Netdust\Logger\Logger;
use Netdust\Service\Assets\AssetManager;



class UIKitServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->enqueue_block_editor_assets();
       // add_action( 'enqueue_block_editor_assets', function( ){ $this->enqueue_block_editor_assets(); }, 99 );
        //add_action( 'enqueue_block_assets', function( ){ $this->enqueue_block_editor_assets(); }, 99 );

        // Register block category.
        add_filter( 'block_categories_all', function( $cat ){
            return $this->block_categories_all( $cat );
        }, 10, 2
        );

        $this->register_block_types();

    }

    private function enqueue_block_editor_assets() {

        //if ( is_admin() ) {

            // React-jsx-runtime polyfill.
            //if ( ! wp_script_is( 'react-jsx-runtime', 'registered' ) ) {
                $asset = plugin_dir_url( __FILE__ ).  'assets/admin/js/react-jsx-runtime.js';
                $this->container->get( AssetManager::class )->script(
                    'react-jsx-runtime', $asset,  ['deps'=> ['react'], 'ver'=>'0.1'], true
                );
            //}

            // Editor css.
            $asset =  plugin_dir_url( __FILE__ ) .  'assets/admin/js/editor.js';
            $this->container->get( AssetManager::class )->script(
                'uikit-blocks-editor-js', $asset,  ['deps'=> ['react-jsx-runtime', 'wp-block-editor', 'wp-blocks', 'wp-components', 'wp-core-data', 'wp-data', 'wp-date', 'wp-element', 'wp-i18n', 'wp-notices', 'wp-primitives'], 'ver'=>'0.1'], true
            );

            $asset =   plugin_dir_url( __FILE__ ).  'assets/admin/css/editor.css';
            $this->container->get( AssetManager::class )->style(
                'uikit-blocks-editor-css', $asset,  ['ver'=>'0.1'], true
            );

        //}
    }

    private function block_categories_all( $block_categories ): array {

        array_push(
            $block_categories,
            array(
                'slug'  => 'uikit-blocks',
                'title' => __( 'Uikit Blocks', 'uikit-blocks' ),
            )
        );

        return $block_categories;

    }

    private function register_block_types() {

        $blocks = array(
            'button',
            'heading',
            'grid',
            'grid-cell',
            'countdown',
            'section',
            'container',
            'accordion',
            'accordion-item',
            'divider',
            'icon',
            'card',
            'image',
            'overlay',
            'list',
            'list-item',
        );

        foreach ( $blocks as $block_dir ) {
            new UIKitBlock( $block_dir );
        }
    }



}