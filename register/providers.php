<?php



return function ($app) {


    /**
     * register the  serviceproviders
     */
    $providers = [
        // Services
        \Netdust\Services\PostFilter\PostFilterServiceProvider::class,

    ];


    foreach($providers as $key => $value ) {
        if( is_array($value) ) // map alias too
            call_user_func_array( [$app->container(),'register'], $value );
        else {
            $app->container()->register( $value );
        }
    };

};