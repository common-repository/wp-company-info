<?php

/**
 * Class WP_Company_Info_Branding
 */
class WP_Company_Info_Branding {

    /**
     * Holds the current instance of the class
     *
     * @access private
     * @var WP_Company_Info_Branding
     * @since 1.0.0
     */
    private static $instance = null;

    /**
     * Options page metabox id
     * @var string
     */
    static $metabox_id = 'wpci_logo_favicon_metabox';

    /**
     * Options Page title
     * @var string
     */
    protected $title = 'Branding';

    /**
     * Slug of the options page
     * @var string
     */
    protected $page_slug = 'branding';

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

        // Actions and filters
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'login_enqueue_scripts', array($this, 'customize_wp_login') );
        add_filter( 'login_headerurl', array($this, 'login_headerurl') );
        add_action( 'wp_head', array($this, 'output_favicon') );
        add_action( 'admin_head', array($this, 'output_favicon') );
        add_action( 'login_enqueue_scripts', array($this, 'output_favicon') );
        add_action( 'customize_register', array($this, 'customize_register') );

        // Shortcodes
        add_shortcode( 'logo', array($this, 'shortcode_logo') );
        add_shortcode( 'site-name', array($this, 'shortcode_site_name') );
        add_shortcode( 'site-description', array($this, 'shortcode_site_description') );

    }


    /**
     * Initializes the class
     *
     * @param none
     * @return WP_Company_Info_Branding
     *
     * @since 1.0.0
     */
    static function init() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new WP_Company_Info_Branding;
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
     * Outputs either the custom favicon or the default favicon
     *
     * @param none
     * @return none
     *
     * @since 1.0.0
     */
    function output_favicon() {

        if ( wpci_has_option( 'favicon_file' ) && is_wp_version( '4.3', '<' ) ) {
            echo '<link rel="shortcut icon" href="' . wpci_get_option( 'favicon_file' ) . '" />';
        }

    }


    /**
     * Output some CSS to style the login page to make it match more with the
     * front end theme.
     *
     * @param none
     * @return none
     *
     * @since 1.0.0
     */
    function customize_wp_login() {

        // Grab our full URL to the logo
        $logo_image = wpci_get_logo( 'medium', null, null, true );

        if ( empty($logo_image) || ! is_array($logo_image) ) {
            return;
        }

        // The width of the Wordpress login box
        $login_box_width = 320;

        // Get the dimensions of the image
        $src = $logo_image[0];
        $width = $logo_image[1];
        $height = $logo_image[2];

        // Set a negative margin if the logo is larger than the login box width
        if ( $width > $login_box_width ) {
            $margin_left = ( $width - $login_box_width ) / 2;
        }
        ?>
        <style type="text/css">
            body.login {
                background: #EFEFEF;
            }

            body.login div#login h1 a {
                background-image: url(<?php echo $src; ?>);
                background-size: <?php echo $width; ?>px <?php echo $height; ?>px;
                height: <?php echo $height; ?>px;
                padding-bottom: 0px;
                width: <?php echo $width; ?>px;
            <?php echo !empty( $margin_left ) ? 'margin-left: -' . $margin_left : ''; ?>
            }
        </style>
        <?php

    }


    /**
     * Link the logo to the website's home page instead of Wordpress.org
     *
     * @param none
     * @return mixed
     *
     * @since 1.0.0
     */
    function login_headerurl() {
        return home_url();
    }


    /**
     * Adds some additional settings and controls to the Wordpress
     * Theme Customizer for the branding fields.
     *
     * @param $wp_customize
     * @return none
     *
     * @since
     */
    function customize_register( $wp_customize ) {

        $logo_file_field_name = 'logo_file_id';
        $logo_file_id = WP_CONTACT_INFO_OPTION_KEY . "[$logo_file_field_name]";

        $wp_customize->add_setting( $logo_file_id , array(
            'capability'        => 'edit_theme_options',
            'type'              => 'option',
        ));

        $wp_customize->add_control( new WP_Customize_Media_Control($wp_customize, $logo_file_field_name, array(
            'label'    => __( 'Site Logo', 'wp-company-info' ),
            'section'  => 'title_tagline',
            'settings' => $logo_file_id,
        )));

    }


    /**
     * [logo] shortcode that outputs the logo file uploaded by the user.
     *
     * @param $atts
     * @param $content
     * @return string
     *
     * @since 1.0.0
     */
    function shortcode_logo( $atts, $content = NULL ) {

        $a = shortcode_atts( array(
            'size' => 'medium'
        ), $atts );

        return wpci_get_logo( $a['size'] );

    }


    /**
     * [site-name] shortcode that outputs the name of the website
     *
     * @param $atts
     * @param $content
     * @return string
     *
     * @since 1.6.0
     */
    function shortcode_site_name( $atts, $content = NULL ) {

        if ( wpci_use_schema_tags() ) {
            return '<span itemprop="name">' . get_bloginfo( 'name' ) . '</span>';
        }
        else {
            return get_bloginfo( 'name' );
        }

    }


    /**
     * [site-description] shortcode that outputs the description/tagline
     *
     * @param $atts
     * @param $content
     * @return string
     *
     * @since 1.6.0
     */
    function shortcode_site_description( $atts, $content = NULL ) {
        return get_bloginfo( 'description' );
    }

}