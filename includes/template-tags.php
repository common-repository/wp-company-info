<?php

if ( ! function_exists( 'wpci_get_option' ) ) :

    /**
     * Wrapper function around cmb2_get_option
     *
     * @param $key string
     * @return mixed
     *
     * @since 1.0.0
     */
    function wpci_get_option( $key = '' ) {
        return cmb2_get_option( WP_CONTACT_INFO_OPTION_KEY, $key );
    }

endif;

if ( ! function_exists( 'wpci_has_option' ) ) :

    /**
     * Wrapper function around cmb2_get_option
     *
     * @param $key string
     * @return mixed
     *
     * @since 1.0.0
     */
    function wpci_has_option( $key = '' ) {
        $value = wpci_get_option($key);
        return !empty( $value ) ? true : false;
    }

endif;


if ( ! function_exists( 'wpci_the_option' ) ) :

    /**
     * Wrapper function around cmb2_get_option
     *
     * @param $key string
     * @return mixed
     *
     * @since 1.0.0
     */
    function wpci_the_option( $key = '' ) {
        echo wpci_get_option($key);
    }

endif;

// -----------------------------------------------------


/**
 * Functions specific to each of our options,
 * meant for easier use within other plugins and themes.
 */


if ( ! function_exists( 'wpci_get_logo' ) ) :

    /**
     * Wrapper function around cmb2_get_option to return the
     * either the <img> tag or the URL to the logo file.  Set
     * the $url parameter to true to return the source.
     *
     * @param $key string
     * @return mixed
     *
     * @since 1.0.0
     */
    function wpci_get_logo( $size = 'full', $icon = NULL, $atts = NULL, $src = false ) {

        // Set the alt attribute to the site name if there is no alt specified
        if ( empty($atts['alt']) ) {
            $atts['alt'] = get_bloginfo( 'name' );
        }

        if ( $src === true ) {
            $image_array = wp_get_attachment_image_src( wpci_get_option( 'logo_file_id' ), $size, $icon );
            return $image_array;
        }
        else {
            return wp_get_attachment_image( wpci_get_option( 'logo_file_id' ), $size, $icon, $atts );
        }

    }

endif;


if ( ! function_exists( 'wpci_the_logo' ) ) :

    /**
     * Wrapper function around cmb2_get_option to output the
     * uploaded logo file.
     *
     * @param $key string
     * @return mixed
     *
     * @since 1.0.0
     */
    function wpci_the_logo( $size = NULL, $atts = NULL ) {
        echo wpci_get_logo( $size, $atts );
    }

endif;


if ( ! function_exists( 'wpci_use_schema_tags' ) ) :

    /**
     * Checks whether the schema_tags option is checked.
     *
     * @param $key string
     * @return bool
     *
     * @since 1.0.0
     */
    function wpci_use_schema_tags() {

        $field_value = wpci_get_option( 'schema_tags' );
        return ( $field_value === 'on' ) ? true : false;

    }

endif;