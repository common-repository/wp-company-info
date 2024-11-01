<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Address
 * Description: Makes available an 'address' CMB2 Custom Field Type. Based on https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-field-types#example-4-multiple-inputs-one-field-lets-create-an-address-field
 * Author: jtsternberg
 * Author URI: http://dsgnwrks.pro
 * Version: 0.1.0
 */

/**
 * Template tag for displaying an address from the CMB2 address field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'address' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function wpci_address_field( $metakey, $post_id = 0 ) {
	echo wpci_get_address_field( $metakey, $post_id );
}

/**
 * Template tag for returning an address from the CMB2 address field type (on the front-end)
 *
 * @since  0.1.0
 *
 * @param  string  $metakey The 'id' of the 'address' field (the metakey for get_post_meta)
 * @param  integer $post_id (optional) post ID. If using in the loop, it is not necessary
 */
function wpci_get_address_field( $metakey, $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$address = get_post_meta( $post_id, $metakey, 1 );

	// Set default values for each address key
	$address = wp_parse_args( $address, array(
		'address-1' => '',
		'address-2' => '',
		'city'      => '',
		'state'     => '',
		'zip'       => '',
		'country'   => '',
	) );

	$output = '<div class="cmb2-address">';
	$output .= '<p><strong>Address:</strong> ' . esc_html( $address['address-1'] ) . '</p>';
	if ( $address['address-2'] ) {
		$output .= '<p>' . esc_html( $address['address-2'] ) . '</p>';
	}
	$output .= '<p><strong>City:</strong> ' . esc_html( $address['city'] ) . '</p>';
	$output .= '<p><strong>State:</strong> ' . esc_html( $address['state'] ) . '</p>';
	$output .= '<p><strong>Zip:</strong> ' . esc_html( $address['zip'] ) . '</p>';
	$output .= '</div><!-- .cmb2-address -->';

	return apply_filters( 'wpci_get_address_field', $output );
}


add_action( 'cmb2_init', 'wpci_cmb2_init_address_field' );
/**
 * Initialize the CMB2 Address field.
 *
 * @since 1.9.0
 * 
 * @param null
 * @return null
 */
function wpci_cmb2_init_address_field() {
	require_once dirname( __FILE__ ) . '/class-cmb2-address-field.php';
	CMB2_Render_Address_Field::init();
}