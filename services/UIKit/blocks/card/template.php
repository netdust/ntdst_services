<?php
/**
 * Container Block template.
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
			'uk-card',
			"uk-card-{$attributes['style']}"   => $attributes['style'],
			"uk-card-{$attributes['padding']}" => $attributes['padding'],
			'uk-card-hover'                    => $attributes['hover'],
		),
	)
);

$img_attributes = array(
	'src' => $attributes['image'],
	'alt' => $attributes['imageAlt'],
);

$prepared_wrapper_attributes = \Netdust\Services\UIKit\UIKitBlockUtils::prepare_wrapper_attributes( $wrapper_attributes );

?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes( $prepared_wrapper_attributes[0] ) ); ?><?php \Netdust\Services\UIKit\UIKitBlockUtils::attributes( $prepared_wrapper_attributes[1], true ); ?>>

	<?php if ( $attributes['image'] ) : ?>
		<div class="uk-card-media-top">
			<img <?php \Netdust\Services\UIKit\UIKitBlockUtils::attributes( $img_attributes ); ?>>
		</div>
	<?php endif; ?>

	<div class="uk-card-body">
		<?php echo $arguments['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
</div>
