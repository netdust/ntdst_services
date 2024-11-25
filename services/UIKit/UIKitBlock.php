<?php

namespace Netdust\Services\UIKit;

use Netdust\Services\UIKit\UIKitBlockUtils;

class UIKitBlock extends \Netdust\Service\Blocks\Block {

    protected string $json;

    protected function getBlockPath(): string
    {
        return dirname( __FILE__ ) . '/blocks/' . $this->blockName;
    }

    protected function getBlockType(): string
    {
        return $this->getBlockPath() .'/block.json';
    }

    protected function getBlockAttributes(): array
    {
        return (array) $this->json['attributes'];
    }

    protected function initialize(): void
    {
        $this->json = wp_json_file_decode( $this->getBlockType(), array( 'associative' => true ) );

        if ( ! $this->json ) {
            return;
        }

        parent::initialize();

    }

    protected function renderBlock(array $attributes = [], ?string $content = null): ?string
    {
        // Block attributes.
        $attributes = $this->prepare_attributes_for_render( $attributes );

        // General attributes.
        $general_attributes = $this->get_general_attributes( $attributes );

        $slug = $this->getBlockPath() . '/template';

        $arguments = array(
            'attributes'         => $attributes,
            'general_attributes' => $general_attributes,
            'content'            => $content,
        );

        return UIKitBlockUIKitBlockUtils::view( $slug, null, $arguments, true );
    }

    /**
     * Add value for attributes with no default value.
     *
     * WP_Block_Type::prepare_attributes_for_render does not set attributes with no default value.
     *
     * @param array $attributes Original block attributes.
     * @return array Prepared block attributes.
     */
    protected function prepare_attributes_for_render( $attributes ) {

        if ( empty( $this->getBlockAttributes() ) ) {
            return $attributes;
        }

        // Add missing values as empty string boolean etc.
        $missing_schema_attributes = array_diff_key( $this->getBlockAttributes(), $attributes );

        foreach ( $missing_schema_attributes as $attribute_name => $schema ) {

            switch ( $schema['type'] ) {
                case 'boolean':
                    $attributes[ $attribute_name ] = false;
                    break;
                case 'object':
                case 'array':
                    $attributes[ $attribute_name ] = array();
                    break;
                case 'string':
                    $attributes[ $attribute_name ] = '';
                    break;
                case 'integer':
                case 'number':
                    $attributes[ $attribute_name ] = 0;
                    break;
                case 'null':
                default:
                    $attributes[ $attribute_name ] = null;
                    break;
            }
        }

        return $attributes;
    }

    /**
     * Generate general attributes.
     *
     * @param array $attributes Block attributes.
     * @return array Generated general attributes array.
     */
    protected function get_general_attributes( $attributes ) {

        $general_attributes = array();

        // Margin.
        if ( array_key_exists( 'generalMargin', $this->getBlockAttributes() ) && array_key_exists( 'generalMargin', $attributes ) && $attributes['generalMargin'] ) {
            $general_attributes = UIKitBlockUtils::attributes_merge(
                $general_attributes,
                array(
                    'class' => array(
                        'uk-margin'               => $attributes['generalMargin'] && 'default' === $attributes['generalMargin'],
                        "uk-margin-{$attributes['generalMargin']}" => $attributes['generalMargin'] && 'default' !== $attributes['generalMargin'],
                        'uk-margin-remove-top'    => $attributes['generalMarginRemoveTop'],
                        'uk-margin-remove-bottom' => $attributes['generalMarginRemoveBottom'],
                    ),
                )
            );
        }

        // Text alignment.
        if ( array_key_exists( 'generalTextAlign', $this->getBlockAttributes() ) && array_key_exists( 'generalTextAlign', $attributes ) && $attributes['generalTextAlign'] ) {
            $general_attributes = UIKitBlockUtils::attributes_merge(
                $general_attributes,
                array(
                    'class' => array(
                        "uk-text-{$attributes['generalTextAlign']}" => ! $attributes['generalTextAlignBreakpoint'],
                        "uk-text-{$attributes['generalTextAlign']}@{$attributes['generalTextAlignBreakpoint']}" => $attributes['generalTextAlignBreakpoint'],
                        "uk-text-{$attributes['generalTextAlignFallback']}" => $attributes['generalTextAlignBreakpoint'] && $attributes['generalTextAlignFallback'],
                    ),
                )
            );
        }

        // Visiblity.
        if ( array_key_exists( 'generalVisiblity', $this->getBlockAttributes() ) && array_key_exists( 'generalVisiblity', $attributes ) && $attributes['generalVisiblity'] ) {
            $general_attributes = UIKitBlockUtils::attributes_merge(
                $general_attributes,
                array(
                    'class' => array(
                        "uk-{$attributes['generalVisiblity']}",
                    ),
                )
            );
        }

        // Position.
        if ( array_key_exists( 'generalPosition', $this->getBlockAttributes() ) && array_key_exists( 'generalPosition', $attributes ) && $attributes['generalPosition'] ) {
            $general_attributes = UIKitBlockUtils::attributes_merge(
                $general_attributes,
                array(
                    'class' => array(
                        "uk-position-{$attributes['generalPosition']}",
                    ),
                    'style' => array(
                        "left: {$attributes['generalPositionLeft']};" => $attributes['generalPositionLeft'],
                        "right: {$attributes['generalPositionRight']};" => $attributes['generalPositionRight'],
                        "top: {$attributes['generalPositionTop']};" => $attributes['generalPositionTop'],
                        "bottom: {$attributes['generalPositionBottom']};" => $attributes['generalPositionBottom'],
                        "z-index: {$attributes['generalPositionZIndex']};" => $attributes['generalPositionZIndex'],
                    ),
                )
            );
        }

        // Scrollspy parent.
        if ( array_key_exists( 'generalScrollspy', $this->getBlockAttributes() ) && array_key_exists( 'generalScrollspy', $attributes ) && $attributes['generalScrollspy'] ) {
            $general_attributes = UIKitBlockUtils::attributes_merge(
                $general_attributes,
                array(
                    'data-uk-scrollspy' => array(
                        'target: [data-uk-scrollspy-class];',
                        "cls: uk-animation-{$attributes['generalScrollspy']};" => $attributes['generalScrollspy'],
                        "delay: {$attributes['generalScrollspyDelay']};" => $attributes['generalScrollspyDelay'],
                    ),
                )
            );
        }

        // Transition toggle parent.
        if ( array_key_exists( 'generalTransitionHover', $this->getBlockAttributes() ) && array_key_exists( 'generalTransitionHover', $attributes ) && $attributes['generalTransitionHover'] ) {
            $general_attributes = UIKitBlockUtils::attributes_merge(
                $general_attributes,
                array(
                    'class' => array(
                        'uk-transition-toggle' => $attributes['generalTransitionHover'],
                    ),
                )
            );
        }

        // Effect.
        if ( array_key_exists( 'generalEffect', $this->getBlockAttributes() ) && array_key_exists( 'generalEffect', $attributes ) && $attributes['generalEffect'] ) {

            // Animation child.
            if ( 'animation' === $attributes['generalEffect'] && $attributes['generalAnimation'] ) {
                $general_attributes = UIKitBlockUtils::attributes_merge(
                    $general_attributes,
                    array(
                        'data-uk-scrollspy-class' => UIKitBlockUtils::attribute_value(
                            array(
                                "uk-animation-{$attributes['generalAnimation']}" => 'inherit' !== $attributes['generalAnimation'],
                            ),
                            true
                        ),
                    )
                );
            }

            // Transition child.
            if ( 'transition' === $attributes['generalEffect'] ) {
                $general_attributes = UIKitBlockUtils::attributes_merge(
                    $general_attributes,
                    array(
                        'class' => array(
                            "uk-transition-{$attributes['generalTransition']}" => $attributes['generalTransition'],
                        ),
                    )
                );
            }

            // Parallax.
            if ( 'parallax' === $attributes['generalEffect'] ) {
                $general_attributes = UIKitBlockUtils::attributes_merge(
                    $general_attributes,
                    array(
                        'class'            => array(
                            "uk-transform-origin-{$attributes['generalParallaxOrigin']}" => $attributes['generalParallaxOrigin'],
                        ),
                        'data-uk-parallax' => array(
                            "x: {$attributes['generalParallaxX']};" => $attributes['generalParallaxX'],
                            "y: {$attributes['generalParallaxY']};" => $attributes['generalParallaxY'],
                            "scale: {$attributes['generalParallaxScale']};" => $attributes['generalParallaxScale'],
                            "rotate: {$attributes['generalParallaxRotate']};" => $attributes['generalParallaxRotate'],
                            "opacity: {$attributes['generalParallaxOpacity']};" => $attributes['generalParallaxOpacity'],
                            "blur: {$attributes['generalParallaxBlur']};" => $attributes['generalParallaxBlur'],
                            "easing: {$attributes['generalParallaxEasing']};" => $attributes['generalParallaxEasing'],
                            "media: {$attributes['generalParallaxBreakpoint']};" => $attributes['generalParallaxBreakpoint'],
                            $attributes['generalParallaxCustom'] => $attributes['generalParallaxCustom'],
                        ),
                    )
                );
            }
        }

        return $general_attributes;
    }
}