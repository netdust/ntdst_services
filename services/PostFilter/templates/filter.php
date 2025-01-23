<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! isset( $template ) ) {
    return;
}

$taxonomies = $template->get_param('taxonomies',[] );
$results = $template->get_param('results',[] );
$page = $template->get_param('page', '' );
$s = $template->get_param('s', '' );
$layout  = $template->get_param('layout', null );

?>



<?= $template->render( 'filter_dropdown', [ 'taxonomies'=>$taxonomies, 's'=>$s ] ); ?>

<div class="uk-text-meta uk-heading-line uk-text-center" style="color:#FFF;"><span>Found results: <span id="result-count"><?= $results->found_posts; ?></span></span></div>

<div class="ntdst-filter-results filter-wrapper uk-margin-large-top">

    <?= $template->render( 'filter_result', [ 'results'=>$results, 'layout'=>$layout ] ); ?>

</div>

<div class="uk-margin-large-top uk-text-center pagination">
    <?= $page ?>
</div>
