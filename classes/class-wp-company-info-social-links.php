<?php

/**
 * Class WP_Company_Info_Social_Links
 */
class WP_Company_Info_Social_Links {

    /**
     * Holds the current instance of the class
     *
     * @access private
     * @var WP_Company_Info_Social_Links
     * @since 1.0.0
     */
    private static $instance = null;

    /**
     * Options page metabox id
     * @var string
     */
    static $metabox_id = 'wpci_social_links_metabox';

    /**
     * Options Page title
     * @var string
     */
    protected $title = 'Social Network Links';

    /**
     * Slug of the options page
     * @var string
     */
    protected $page_slug = 'social-links';

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
        add_action( 'wp_footer', array($this, 'enqueue_fontawesome_scripts') );

        $this->create_shortcodes();

    }


    /**
     * Initializes the class
     *
     * @param none
     * @return WP_Company_Info_Social_Links
     *
     * @since 1.0.0
     */
    static function init() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new WP_Company_Info_Social_Links;
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

        $group_field_id = $cmb->add_field( array(
            'id'          => 'social_networks',
            'type'        => 'group',
            'description' => __( 'Links to your various social network pages.', 'cmb' ),
            'options'     => array(
                'group_title'   => __( 'Entry {#}', 'cmb' ),
                'add_button'    => __( 'Add Social Link', 'cmb' ),
                'remove_button' => __( 'Remove Social Link', 'cmb' ),
                'sortable'      => true, // beta
            ),
        ) );


        $cmb->add_group_field( $group_field_id, array(
            'name' => 'Icon',
            'id'   => 'name',
            'type' => 'select',
            'options' => array(
                'facebook' => 'Facebook',
                'twitter' => 'Twitter',
                'instagram' => 'Instagram',
                'linkedin' => 'LinkedIn',
                'google-plus' => 'Google+',
                'youtube' => 'YouTube',
                'pinterest' => 'Pinterest',
                'tumblr' => 'Tumblr',
                'yelp' => 'Yelp',
                'flickr' => 'Flickr',
                'bitbucket' => 'Bitbucket',
                'github' => 'Github',
                'foursquare' => 'Foursquare',
                'houzz' => 'Houzz',
                'slack' => 'Slack',
                'vine' => 'Vine',
                'vimeo' => 'Vimeo',
                'envelope' => 'Email',
                'pencil' => 'Pencil Icon'
            )
        ) );

        $cmb->add_group_field( $group_field_id, array(
            'name' => 'URL',
            'id'   => 'url',
            'type' => 'text',
        ) );

    }


    /**
     * Creates shortcodes for each one of our fields
     *
     * @param none
     * @return none
     *
     * @since 1.0.0
     */
    function create_shortcodes() {

        add_shortcode( 'social-networks', array($this, 'shortcode_social_networks' ) );

    }


    /**
     * Outputs the content for the [social-networks] shortcode
     *
     * @param $atts
     * @param $content
     * @return string
     *
     * @since 1.0.0
     */
    function shortcode_social_networks( $atts, $content = NULL ) {

        global $wpci_output_social_icons_font;
        global $wpci_output_social_icons_style;

        // Store our shortcode attributes
        $a = shortcode_atts( array(
            'class' => 'social-networks',
            'icons' => '',
            'size' => '',
            'square' => '',
            'styles' => '',
        ), $atts );

        // Grab our social network values
        $social_networks = wpci_get_option( 'social_networks' );

        // Get out now if there are no social network links added
        if ( empty( $social_networks ) ) {
            return 'There are no social network links added.  Please go to Settings > Contact Information and add a few links.';
        }

        // Make sure we output the necessary scripts/styles in the footer
        if ( $a['icons'] === 'font-awesome' ) {
            $wpci_output_social_icons_font = true;
        }

        if ( $a['styles'] === 'true' ) {
            $wpci_output_social_icons_style = true;
        }

        if ( $a['square'] === 'true' ) {
            $a['class'] .= ' square-icons';
        }

        // Start the wrapper around the social network links
        $output = '<div class="'. $a['class'] .'">';

        // Loop through each of the social networks to output them
        foreach( $social_networks as $social_network ) {
            $url = $social_network['url'];

            if ( empty($url) ) {
                continue;
            }

            if ( stristr( '@', $url ) ) {
                $url = "mailto:{$url}";
            }

            $output .= '<a class="' . $social_network['name'] . '" rel="nofollow" href="'. $url .'" target="_blank">';

            if ( $a['icons'] === 'font-awesome' ) {
                $size = ! empty( $a['size'] ) ? 'fa-' . $a['size'] : '';
                $name = 'fa-'.$social_network['name'];

                $output .= "<i class=\"fa $name $size\"></i>";
            }
            else {
                $output .= $social_network['name'];
            }

            $output .= '</a>';
        }

        $output .= '</div>';

        return $output;

    }


    /**
     * Enqueues any Font Awesome scripts/styles
     *
     * @param none
     * @return none
     *
     * @since 0.0.7
     */
    function enqueue_fontawesome_scripts() {

        global $wpci_output_social_icons_font;
        global $wpci_output_social_icons_style;

        if ( $wpci_output_social_icons_font === true ) {
            wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
        }

        if ( $wpci_output_social_icons_style === true ) {
            wp_enqueue_style( 'wpci-styles', plugins_url( 'assets/css/style.css', WP_CONTACT_INFO_PLUGIN_FILE ) );
        }

    }
}