<?php

use YOOtheme\ImageProvider;
use YOOtheme\Url;
use function YOOtheme\app;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! isset( $template ) ) {
    return;
}

?>


<a href="<?= $template->get_param('permalink', '#' ); ?>" aria-label="<?= $template->get_param('title', 'no post' ); ?>" class="uk-link-text" style="text-decoration: none;">
    <div class="uk-tile-default uk-padding-remove">
        <div class="uk-grid tm-grid-expand uk-grid-collapse uk-margin" uk-grid>
            <div class="uk-grid-item-match  uk-width-1-2@s uk-width-1-5@m uk-first-column" >
                <div class="uk-tile-default uk-flex">
                    <div data-src="<?= $template->get_param('image', null ); ?>" uk-img class="uk-background-norepeat uk-background-center-center uk-tile uk-tile-small uk-width-1-1" style="background-size: 400px 300px; background-image: url(&quot;<?= $template->get_param('image', null ); ?>&quot;);">        </div>
                </div>
            </div>
            <div class="uk-grid-item-match uk-flex-middle uk-width-1-2@s uk-width-2-5@m" >
                <div class="uk-padding-small">

                    <h2 class="uk-h4" ><?= $template->get_param('title', null ); ?></h2>

                </div>
            </div>
            <div class="uk-grid-item-match uk-flex-middle uk-width-1-1@s uk-width-2-5@m" >
                <div class="uk-padding-small">

                    <div class="uk-text-small uk-margin" ><?= substr( $template->get_param('excerpt', null ), 0, 240 ); ?>...</div>
                    <div style="font-size: small;" >

                        <span class="el-item"><span class="el-content">Articles</span>, </span><span class="el-item"><span class="el-content">Policy Papers</span></span>

                    </div>

                </div>
            </div>
        </div>
    </div>
</a>
