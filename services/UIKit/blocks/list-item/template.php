<?php
/**
 * List Item Block template.
 *
 * @package uikit-blocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$attributes         = $arguments['attributes'];
$general_attributes = $arguments['general_attributes'];

$wrapper_attributes = $general_attributes;

$prepared_wrapper_attributes = \Netdust\Services\UIKit\UIKitBlockUtils::prepare_wrapper_attributes( $wrapper_attributes );

?>
<li <?php echo wp_kses_data( get_block_wrapper_attributes( $prepared_wrapper_attributes[0] ) ); ?><?php \Netdust\Services\UIKit\UIKitBlockUtils::attributes( $prepared_wrapper_attributes[1], true ); ?>>
	<?php echo $arguments['content']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</li>
