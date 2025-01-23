<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! isset( $template ) ) {
    return;
}

$results = $template->get_param('results', null );

?>


<?php
if($results->have_posts()) {
    while($results->have_posts()) {
        $results->the_post();
        $post = get_post();

        $term_obj_list = get_the_terms( get_the_ID(), 'onderwerp' );
        $terms_string =  join(', ', wp_list_pluck($term_obj_list, 'name'));

        echo $template->render('filter_resultitem', [
            'title'=>get_the_title(),
            'content'=>get_the_content(),
            'excerpt'=>get_the_excerpt(),
            'permalink'=>get_the_permalink(),
            'image'=>get_the_post_thumbnail_url( ),
            'score'=>$post->relevance_score,
            'meta'=>$terms_string,
            'date'=>get_the_date('j M Y'),
        ]);

    }
    wp_reset_postdata();
}
?>