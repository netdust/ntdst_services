<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! isset( $template ) ) {
    return;
}

$taxonomies = $template->get_param('taxonomies',[] );
$count = count ( $taxonomies );

?>

<nav class="uk-navbar-container">
    <div class="uk-tile uk-tile-default uk-padding-remove-top uk-padding-remove-bottom">
        <div uk-navbar>
            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <?php
                    foreach ( $taxonomies as $slug => $taxonomy ):
                        ?>
                        <li id="tax-<?= $slug; ?>">
                            <a href ><?= $taxonomy['label']; ?></a>
                            <div class="uk-dropbar uk-dropbar-top" uk-drop="mode: hover;boundary: !.uk-navbar; flip: false">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <?php
                                    foreach ( $taxonomy['terms'] as $term => $label ): ?>
                                        <li>
                                            <a href="javascript:;" class="filter-item" data-term="<?= $term; ?>" data-cat="<?= $slug; ?>" data-label="<?= $label; ?>" >
                                                <?= $label; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="uk-navbar-right">
                <ul class="uk-navbar-nav filter-active">

                </ul>
            </div>
        </div>
    </div>
</nav>