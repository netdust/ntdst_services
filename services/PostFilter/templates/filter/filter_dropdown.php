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
    <div class="uk-tile uk-tile-default uk-padding">
        <div>
            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" role="search" class="uk-form uk-search uk-search-default uk-width-1-1">
                <button uk-search-icon="" class="uk-search-icon-flip uk-icon uk-search-icon" aria-label="Submit Search"></button>
                <input type="hidden" name="filter_excl_categories" value="product_cat,product_type">
                <input value="" name="s" type="search" placeholder="Search" class="uk-search-input">
            </form>
        </div>
        <div uk-navbar>
            <ul class="uk-navbar-nav uk-width-1-1">
                <?php
                foreach ( $taxonomies as $slug => $taxonomy ):
                    ?>
                    <li class="uk-width-1-1 uk-width-1-4@m" id="tax-<?= $slug; ?>">
                        <a href ><?= $taxonomy['label']; ?> <span uk-navbar-parent-icon></a>
                        <div class="uk-dropbar uk-dropbar-top" uk-drop="mode: hover;boundary: !.uk-navbar; flip: false">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <?php
                                foreach ( $taxonomy['terms'] as $term => $label ): ?>
                                    <li>
                                        <a href="javascript:;" class="filter-item" data-term="<?= $term; ?>" data-cat="<?= $slug; ?>" data-label="<?= $label; ?>" >
                                            <span class="plus" uk-icon="icon: plus; ratio: .5"></span><span class="min" uk-icon="icon: minus; ratio: .5"></span><?= $label; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>