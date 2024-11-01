<?php
/**
 * Adds WPCI_Logo_Widget widget.
 */
class WPCI_Logo_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'WPCI_Logo_Widget', // Base ID
            __( 'Logo', 'wp-company-info' ), // Name
            array( 'description' => __( 'Displays the logo uploaded through the customizer.', 'wp-company-info' ), ) // Args
        );
    }

    
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        echo $args['before_widget'];

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }

        $size       = ! empty( $instance['size'] ) ? $instance['size'] : '';

        echo do_shortcode( '[logo size="'.$size.'"]' );

        echo $args['after_widget'];

    }

    
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $size       = ! empty( $instance['size'] ) ? $instance['size'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
                <?php
                $image_sizes = get_intermediate_image_sizes();
                $image_sizes[] = 'full';

                foreach( $image_sizes as $size_name ) {
                    $selected = ( $size === $size_name ) ? ' selected="selected"' : '';
                    echo "<option value=\"$size_name\"$selected>$size_name</option>";
                }
                ?>
            </select>
        </p>
        <?php

    }


    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['size'] = ( ! empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';

        return $instance;

    }

} // class WPCI_Logo_Widget