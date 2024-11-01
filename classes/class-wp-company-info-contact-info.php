<?php

/**
 * Class WP_Company_Info_Contact_Info
 */
class WP_Company_Info_Contact_Info {

	/**
	 * Holds the current instance of the class
	 *
	 * @access private
	 * @var WP_Company_Info_Contact_Info
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Options page metabox id
	 * @var string
	 */
	static $metabox_id = 'wpci_contact_info_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = 'Contact Information';

	/**
	 * Slug of the options page
	 * @var string
	 */
	protected $page_slug = 'contact-information';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';


	/**
	 * Constructor
	 *
	 * Call all of our actions and filters
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
		add_action( 'load-'.$this->options_page, array($this, 'add_help_tab'), 50);
		add_action( 'load-post.php', array($this, 'add_help_tab') , 50 );
		add_action( 'load-edit.php', array($this, 'add_help_tab') , 50 );

		add_action( 'wp_loaded', array($this, 'create_shortcodes') );

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
			self::$instance = new WP_Company_Info_Contact_Info;
		}
		return self::$instance;
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function register_settings() {
		register_setting( WP_CONTACT_INFO_OPTION_KEY, WP_CONTACT_INFO_OPTION_KEY );
	}


	/**
	 * Add menu options page
	 *
	 * @since 1.0.0
	 */
	public function add_options_page() {

		$this->options_page = add_options_page( $this->title, $this->title, 'manage_options', $this->page_slug, array( $this, 'admin_page_display' ) );

	}


	/**
	 * Admin page markup. Mostly handled by CMB2
	 *
	 * @since 1.0.0
	 */
	public function admin_page_display() {

		if ( !empty($_POST) ) {
			echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>';
		}
		?>
		<div class="wrap cmb2-options-page <?php echo WP_CONTACT_INFO_OPTION_KEY; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( self::$metabox_id, WP_CONTACT_INFO_OPTION_KEY ); ?>
		</div>
		<?php
	}


	/**
	 * Add the options metabox to the array of metaboxes
	 *
	 * @since 1.0.0
	 */
	function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'         => self::$metabox_id,
			'hookup'     => false,
			'cmb_styles' => true,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( WP_CONTACT_INFO_OPTION_KEY, )
			),
		) );

		$cmb->add_field( array(
			'name' => 'Basic Information',
			'type' => 'title',
			'id'   => 'basic_information'
		) );

		$cmb->add_field( array(
			'name'    => 'Use Schema Tags',
			'desc'    => 'If checked, all of the contact information will be outputted using Schema.org markup.',
			'id'      => 'schema_tags',
			'type'    => 'checkbox',
		) );

		$cmb->add_field( array(
			'name'    => 'Address',
			'id'      => 'address',
			'type'    => 'address',
            'do_country' => true,
		) );

		$cmb->add_field( array(
			'name'    => 'Phone Number',
			'id'      => 'phone_number',
			'type'    => 'text_medium',
		) );

		$cmb->add_field( array(
			'name'    => 'Fax Number',
			'id'      => 'fax_number',
			'type'    => 'text_medium',
		) );

		$cmb->add_field( array(
			'name'    => 'Email Address',
			'id'      => 'email',
			'type'    => 'text_email',
			'desc'    => 'Leave blank to use the <a href="'.site_url().'/wp-admin/options-general.php">default admin email address</a>.'
		) );

		$cmb->add_field( array(
			'name'    => 'Additional Contact Information',
			'desc'    => 'Any additional contact information fields that aren\'t available above.',
			'id'      => 'additional_company_info',
			'type'    => 'title',
		) );

		$group_field_id = $cmb->add_field( array(
			'id'          => 'additional_info',
			'type'        => 'group',
			'options'     => array(
				'group_title'   => __( 'Field {#}', 'cmb' ),
				'add_button'    => __( 'Add Field', 'cmb' ),
				'remove_button' => __( 'Remove Field', 'cmb' ),
				'sortable'      => true, // beta
			),
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Name/Label',
			'desc' => 'The human readable name of the field (`First Name`, `Last Name`, `Phone Number`, etc)',
			'id'   => 'name',
			'type' => 'text',
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'ID',
			'desc' => 'The ID to use for the field as well as the shortcode.  Should not include any spaces or punctiation (ex: `first-name`, `last-name`, `phone-number`, etc)',
			'id'   => 'id',
			'type' => 'text',
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Value',
			'desc' => 'The actual value for this field (ex: Jane, Smith, 000-000-0000, etc)',
			'id'   => 'value',
			'type' => 'text',
		) );

	}


	/**
	 * Creates shortcodes for each one of our default fields as
	 * well as any additional fields specified by the user
	 *
	 * @param none
	 * @return none
	 *
	 * @since 1.0.0
	 */
	function create_shortcodes() {

		// Create the basic shortcodes offered by default
		add_shortcode( 'address', array($this, 'shortcode_address' ) );
		add_shortcode( 'phone', array($this, 'shortcode_phone' ) );
		add_shortcode( 'fax', array($this, 'shortcode_fax' ) );
		add_shortcode( 'email', array($this, 'shortcode_email' ) );

		// Create shortcodes for any fields specified by the user
		$all_additional_contact_info = wpci_get_option( 'additional_info' );

		if ( !empty( $all_additional_contact_info ) ) {
			foreach( $all_additional_contact_info as $field ) {
				$id = !empty( $field['id'] ) ? $field['id'] : '';
				$value = !empty( $field['value'] ) ?  $field['value'] : '';

				if ( !empty($id) && !empty($value) ) {
					add_shortcode( $id, function($atts, $content = null) use ($value) {

						$a = shortcode_atts( array(
							'link' => '',
						), $atts );

						$output = '';

						if ( empty( $value ) ) {
							$output = 'No value was set.';
						}

						// Unless turned off, wrap the phone number in a hyperlink
						if ( $a['link'] === 'true' ) {
							$output .= "<a href=\"tel:$value\">";
						}

						$output .= $value;

						// If we are wrapping the phone number in a hyperlink, close the hyperlink
						if ( $a['link'] === 'true' ) {
							$output .= "</a>";
						}

						return $output;
					} );
				}
			}
		}

	}

	/**
	 * Outputs the content for the [address] shortcode
	 *
	 * Available shortcode parameters:
	 *
	 *      'field' - Output only this specific field of the address (ex State) instead of
	 *                outputting the whole address
	 *
	 * @param $atts
	 * @param $content
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function shortcode_address( $atts, $content = NULL ) {

		$a = shortcode_atts( array(
			'field' => '',
			'formatted' => 'true'
		), $atts );

		$address = wpci_get_option( 'address' );
		$output = '';

		// Set default values for each address key
		$address = wp_parse_args( $address, array(
			'address-1' => '',
			'address-2' => '',
			'city'      => '',
			'state'     => '',
			'zip'       => '',
            'country'   => '',
		) );


		if ( wpci_use_schema_tags() ) {
			$output .= '<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';

			// Format the address lines 1 and 2
			$address['address-1'] = '<span itemprop="streetAddress">' . $address['address-1'];
			if ( empty($address['address-2']) ) {
				$address['address-1'] .= '</span>';
			}
			if ( !empty($address['address-2']) ) {
				$address['address-2'] = $address['address-2'] . '</span>';
			}

			// Format the city
			if ( ! empty($address['city']) ) {
				$address['city'] = '<span itemprop="addressLocality">' . $address['city'] . '</span>';
			}

			// Format the state
			if ( ! empty($address['state']) ) {
				$address['state'] = '<span itemprop="addressRegion">' . $address['state'] . '</span>';
			}

			// Format the zipcode
			if ( ! empty($address['zip']) ) {
				$address['zip'] = '<span itemprop="postalCode">' . $address['zip'] . '</span>';
			}

			// Format the country
            if ( ! empty($address['country']) ) {
	            $address['country'] = '<span itemprop="addressCountry">' . $address['country'] . '</span>';
            }
		}


		if ( !empty( $a['field'] ) ) {
			$output .= $address[ $a['field'] ];
		}
		else {
			if ( $a['formatted'] === 'false' ) {
				$output .= $address['address-1'];
				$output .= !empty($address['address-2']) ? ', ' . $address['address-2'] . ', ' : ', ';
				$output .= $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
				$output .= !empty($address['country']) ? ' ' . $address['country'] : '';
			}
			else {
				$output .= $address['address-1'] . '<br>';
				$output .= !empty($address['address-2']) ? $address['address-2'] . '<br>' : '';
				$output .= $address['city'] . ', ' . $address['state'] . ' ' . $address['zip'];
				$output .= !empty($address['country']) ? '<br>' . $address['country'] : '';
			}
		}


		if ( wpci_use_schema_tags() ) {
			$output .= '</span>';
		}

		return $output;

	}

	/**
	 * Outputs the content for the [phone] shortcode
	 *
	 * @param $atts
	 * @param $content
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function shortcode_phone( $atts, $content = NULL ) {

		$output = '';

		$a = shortcode_atts( array(
			'link' => '',
			'class' => '',
			'use_schema_tags' => ''
		), $atts );

		$phone_number = wpci_get_option( 'phone_number' );
		$use_schema_tags = ( $a['use_schema_tags'] === 'false' ) ? true : false;

		if ( empty( $phone_number ) ) {
			return 'No phone number set.';
		}

		// Unless turned off, wrap the phone number in a hyperlink
		if ( $a['link'] === 'true' ) {
			$output .= "<a";
		}

		// Unless turned off, wrap the phone number in a hyperlink
		if ( $a['link'] === 'true' ) {
			$output .= " href=\"tel:$phone_number\"";
		}

		// Unless turned off, wrap the phone number in a hyperlink
		if ( ! empty($a['class']) ) {
			$output .= " class=\"{$a['class']}\"";
		}

		// Unless turned off, wrap the phone number in a hyperlink
		if ( $a['link'] === 'true' ) {
			$output .= ">";
		}

		// If we're using schema tags, wrap the phone number in the tag
		if ( wpci_use_schema_tags() && $use_schema_tags ) {
			$output .= '<span itemprop="telephone">'.$phone_number.'</span>';
		}
		else {
			$output .= $phone_number;
		}

		// If we are wrapping the phone number in a hyperlink, close the hyperlink
		if ( $a['link'] === 'true' ) {
			$output .= "</a>";
		}

		return $output;

	}

	/**
	 * Outputs the content for the [phone] shortcode
	 *
	 * @param $atts
	 * @param $content
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function shortcode_fax( $atts, $content = NULL ) {

		$fax_number = wpci_get_option( 'fax_number' );

		if ( empty( $fax_number ) ) {
			return 'No fax number set.';
		}

		if ( wpci_use_schema_tags() ) {
			$output = '<span itemprop="faxNumber">'.$fax_number.'</span>';
		}
		else {
			$output = $fax_number;
		}

		return $output;

	}

	/**
	 * Outputs the content for the [email] shortcode
	 *
	 * @param $atts
	 * @param $content
	 * @return string
	 *
	 * @since 1.0.0
	 */
	function shortcode_email( $atts, $content = NULL ) {

		$a = shortcode_atts( array(
			'link' => '',
		), $atts );

		$output = '';
		$email = wpci_get_option( 'email' );

		if ( empty( $email ) ) {
			$email = get_bloginfo( 'admin_email' );
		}

		if ( $a['link'] === 'true' ) {
			$output .= "<a href=\"mailto:$email\">";
		}

		if ( wpci_use_schema_tags() ) {
			$output .= '<span itemprop="email">' . $email . '</span>';
		}
		else {
			$output .= $email;
		}

		if ( $a['link'] === 'true' ) {
			$output .= "</a>";
		}

		return $output;

	}


	/**
	 * Adds a help tab listing all of the shortcodes available
	 * to output the contact information.
	 *
	 * @param none
	 * @return none
	 *
	 * @since 1.0.0
	 */
	function add_help_tab() {

		$screen = get_current_screen();

		$content  = '<p>The WP Company Info plugin provides various shortcodes for outputting the contact information.  Those shortcodes are as follows:</p>';
		$content .= '<ul>';
		$content .= '<li>[address] OR [address field="address-1|address-2|city|state|zip"]</li>';
		$content .= '<li>[phone]</li>';
		$content .= '<li>[fax]</li>';
		$content .= '<li>[email]</li>';
		$content .= '<li>[social-networks]</li>';
		$content .= '</ul>';

		// Add my_help_tab if current screen is My Admin Page
		$screen->add_help_tab( array(
			'id'	=> 'wp_company_info',
			'title'	=> __('Company Info'),
			'content'	=> $content
		) );

	}
}