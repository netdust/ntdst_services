<?php

/**
 * Button field class
 *
 * @package notification
 */


namespace Netdust\Services\Settings\CoreFields;

/**
 * Button class
 */
class Button
{
	/**
	 * Button field
	 *
	 * @param \BracketSpace\Notification\Utils\Settings\Field $field Field instance.
	 * @return void
	 */
	public function input($field)
	{
		echo sprintf(
			'<a href="%s" class="button">%s</a>',
			esc_url_raw($field->addon('url')),
			esc_html($field->addon('label'))
		);
	}

	/**
	 * Sanitize button URL
	 *
	 * @param string $value URL.
	 * @return string       Sanitized URL
	 */
	public function sanitize($value)
	{
		return esc_url_raw($value);
	}
}
