<?php
/**
 *
 * @link              https://netdust.be
 * @since             1.0.0-dev
 * @package           Netdust\Vad
 * @author            Stefan Vandermeulen
 *
 * @wordpress-plugin
 * Plugin Name:       VAD Shared Services plugin
 * Plugin URI:        https://netdust.be
 * Description:       A Plugin with services VAD uses across online apps.
 * Version:           1.0.0
 * Author:            Stefan Vandermeulen
 * Author URI:        https://netdust.be
 * Text Domain:       vad_sharedservice
 */

use Netdust\ApplicationProvider;
use Netdust\Logger\LoggerInterface;

interface ntdstServicesPlugin {
}

defined( 'ABSPATH' ) || exit;

define( 'NTDSTSERVICES_PLUGIN_FILE', __FILE__ );

$_service_container = new \lucatume\DI52\Container();

if ( class_exists(\Netdust\ApplicationProvider::class)  ) {

    _load_sharedservice();

} else {

    add_action( 'netdust_platform_loaded', '_load_sharedservice', 99 );
}

function _load_sharedservice() {
    global $_service_container;
    $_service_container->singleton( ntdstServicesPlugin::class, new ApplicationProvider(
        $_service_container,
        [
            'file'                => NTDSTSERVICES_PLUGIN_FILE,
            'name'                => 'ntdstServicesPlugin',
            'text_domain'         => 'shared',
            'version'             => '1.0.0',
            'minimum_wp_version'  => '6.5',
            'minimum_php_version' => '8.0',
            'config_path'         => '/config',
            'build_path'          => ''
        ]
    ) );
    $_service_container->register( ntdstServicesPlugin::class );
}

function ntdst_services():ApplicationProvider {
    global $_service_container;
    return $_service_container->get( ntdstServicesPlugin::class );
}