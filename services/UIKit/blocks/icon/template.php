<?php
/**
 * Icon Block template.
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
		'data-uk-lightbox' => 'lightbox' === $attributes['target'],
	)
);

$icon_attributes = array(
	'class'        => array(
		'uk-icon',
		"uk-text-{$attributes['color']}" => $attributes['color'],
		"uk-{$attributes['linkStyle']}"  => $attributes['linkStyle'] && (bool) $attributes['url'],
	),
	'href'         => $attributes['url'],
	'target'       => array(
		'_blank' => '_blank' === $attributes['target'],
	),
	'rel'          => $attributes['rel'],
	'data-type'    => array(
		$attributes['lightboxType'] => ( 'lightbox' === $attributes['target'] ) && $attributes['lightboxType'],
	),
	'data-uk-icon' => \Netdust\Services\UIKit\UIKitBlockUtils::attribute_value(
		array(
			"icon: {$attributes['icon']};"   => $attributes['icon'],
			'icon: star;'                    => ! $attributes['icon'],
			"width: {$attributes['size']};"  => $attributes['size'] && 'icon-button' !== $attributes['linkStyle'],
			"height: {$attributes['size']};" => $attributes['size'] && 'icon-button' !== $attributes['linkStyle'],
		),
		true
	),
);

$tag_name = $attributes['url'] ? 'a' : 'span';

$prepared_wrapper_attributes = \Netdust\Services\UIKit\UIKitBlockUtils::prepare_wrapper_attributes( $wrapper_attributes );

?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes( $prepared_wrapper_attributes[0] ) ); ?><?php \Netdust\Services\UIKit\UIKitBlockUtils::attributes( $prepared_wrapper_attributes[1], true ); ?>>
	<<?php echo tag_escape( $tag_name ); ?> <?php \Netdust\Services\UIKit\UIKitBlockUtils::attributes( $icon_attributes ); ?>></<?php echo tag_escape( $tag_name ); ?>>
</div>
