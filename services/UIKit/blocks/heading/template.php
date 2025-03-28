<?php
/**
 * Heading Block template.
 *
 * @package uikit-blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


$attributes         = $arguments['attributes'];
$general_attributes = $arguments['general_attributes'];

$wrapper_attributes = \Netdust\Services\UIKit\UIKitBlockUtils::attributes_merge(
	$general_attributes,
	array(
		'class' => array(
			"uk-{$attributes['style']}"              => $attributes['style'],
			"uk-heading-{$attributes['decoration']}" => $attributes['decoration'],
			"uk-text-{$attributes['color']}"         => $attributes['color'],
		),
	)
);

$tag_name = ! empty( $attributes['tag'] ) ? $attributes['tag'] : 'h1';

$prepared_wrapper_attributes = \Netdust\Services\UIKit\UIKitBlockUtils::prepare_wrapper_attributes( $wrapper_attributes );
?>
<<?php echo tag_escape( $tag_name ); ?> <?php echo wp_kses_data( get_block_wrapper_attributes( $prepared_wrapper_attributes[0] ) ); ?><?php \Netdust\Services\UIKit\UIKitBlockUtils::attributes( $prepared_wrapper_attributes[1], true ); ?>>
	<?php echo wp_kses_data( $attributes['text'] ); ?>
</<?php echo tag_escape( $tag_name ); ?>>
