<?php

/**
 * @file functions.php
 */

if ( ! function_exists( 'is_wp_version' ) ) :

    /**
     * Checks what the current version of Wordpress
     * @param string $version
     * @param string $compare  The operator to use to compare versions
     * @return bool
     */
    function is_wp_version( $version = '3.0', $compare = '>=' ) {

        global $wp_version;

        if ( version_compare( $wp_version, $version, $compare ) ) {
            return true;
        }
        else {
            return false;
        }

    }

endif;