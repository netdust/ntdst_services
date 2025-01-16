<?php

namespace Netdust\Services\Yootheme;


use YOOtheme\ImageProvider;
use YOOtheme\Url;
use function YOOtheme\app;

use Netdust\Core\ServiceProvider;
use Netdust\Service\Pages\VirtualPage;



class YooThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {

        /*
        add_action('after_setup_theme', function() {
            $app = \YOOtheme\Application::getInstance();
            $app->load(\YOOtheme\Path::get('./bootstrap.php'));
        });*/

    }

    public function make( string $uri, string $title, string $template = null ):VirtualPage {
        return new Yootheme_VirtualPage( $uri, $title, $template );
    }

    public function image( string $uri, string $title, string $template = null ):callable {
        [$config, $view] = app(\YOOtheme\Config::class, \YOOtheme\View::class);

        return function ($thumbnal_url, $attr) use ($config, $view) {

            if (!$src = $thumbnal_url ) {
                return;
            }

            $image = app(ImageProvider::class);
            $meta = get_post_meta(get_post_thumbnail_id());
            $src = Url::relative(set_url_scheme($src, 'relative'));
            $alt = $meta['_wp_attachment_image_alt'] ?? '';
            $width = 40;
            $height = 'auto';

            if ($view->isImage($src) == 'svg') {
                $thumbnail = $image->replace($view->image($src, ['width' => $width, 'height' => $height, 'loading' => 'lazy', 'alt' => $alt]));
            } else {
                $thumbnail = $image->replace($view->image([$src, 'thumbnail' => [$width, $height], 'srcset' => true], ['loading' => 'lazy', 'alt' => $alt]));
            }

            ?>

            <?php if ($thumbnail) : ?>
                <div<?= $view->attrs($attr) ?> property="image" typeof="ImageObject">
                    <meta property="url" content="<?= $thumbnal_url ?>">
                    <?= $thumbnail ?>
                    <!--<figcaption class="uk-text-meta"><?= get_the_post_thumbnail_caption(); ?></figcaption>-->
                </div>
            <?php endif ?>

            <?php
        };
    }


}