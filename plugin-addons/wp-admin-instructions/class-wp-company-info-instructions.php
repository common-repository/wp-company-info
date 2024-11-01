<?php

class WP_Company_Info_Instructions {

	/**
	 * Holds the current instance of the class
	 *
	 * @access private
	 * @var WP_Company_Info_Contact_Info
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Constructor
	 *
	 * Call all of our actions and filters
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		add_filter( 'wp_admin_instructions_tabs', array($this, 'add_tabs') , 10 );

	}

	/**
	 * Initializes the class
	 *
	 * @param none
	 * @return WP_Company_Info_Contact_Info
	 *
	 * @since 1.0.0
	 */
	static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new WP_Company_Info_Instructions;
		}
		return self::$instance;
	}


	/**
	 * Adds tabs to the WP Admin Instructions page of instructions.
	 *
	 * @param $tabs
	 * @return array
	 *
	 * @since 1.0.0
	 */
	function add_tabs($tabs) {

		$tabs[] = array(
			'title' => 'Company Info',
			'slug' => 'company-info',
			'template' => plugin_dir_path( __FILE__ ) . 'view/tab-company-info.php'
		);

		return $tabs;

	}

}