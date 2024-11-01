<?php

/**
 * Class WP_Company_Info_Generic_Shortcodes
 *
 * Creates some generic shortcodes that may be useful and helpful to users.
 */
class WP_Company_Info_Generic_Shortcodes {

	/**
	 * Holds the current instance of the class
	 *
	 * @access private
	 * @var WP_Company_Info_Generic_Shortcodes
	 * @since 1.7.0
	 */
	private static $instance = null;


	/**
	 * Constructor
	 *
	 * Call all of our actions and filters
	 *
	 * @since 1.7.0
	 */
	function __construct() {

		add_shortcode( 'date', array($this, 'shortcode_date') );

	}


	/**
	 * Initializes the class
	 *
	 * @param none
	 * @return WP_Company_Info_Generic_Shortcodes
	 *
	 * @since 1.7.0
	 */
	static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new WP_Company_Info_Generic_Shortcodes;
		}
		return self::$instance;
	}


	/**
	 * [date format="" timestamp=""] shortcode that outputs the name of the website
	 *
	 * @param $atts
	 * @param $content
	 * @return string
	 *
	 * @since 1.7.0
	 */
	function shortcode_date( $atts, $content = NULL ) {

		// Store our shortcode attributes
		$a = shortcode_atts( array(
			'format' => 'F j, Y g:iA',
			'timestamp' => null,
		), $atts );

		if ( $a['timestamp'] !== null ) {
			return date( $a['format'], $a['timestamp'] );
		}
		else {
			return date( $a['format'] );
		}

	}

}