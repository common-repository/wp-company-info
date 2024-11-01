<?php
/**
 * Adds WPCI_Social_Network_Widget widget.
 */
class WPCI_Social_Network_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'WPCI_Social_Network_Widget', // Base ID
            __( 'Social Networks', 'wp-company-info' ), // Name
            array( 'description' => __( 'Social Networks', 'wp-company-info' ), ) // Args
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

        $icons      = ! empty( $instance['icons'] ) ? $instance['icons'] : '';
        $size       = ! empty( $instance['size'] ) ? $instance['size'] : '';
        $square     = ( $instance['square'] === 'on' ) ? 'true' : '';
        $styles     = ( $instance['styles'] === 'on' ) ? 'true' : '';

        echo do_shortcode( '[social-networks icons="'.$icons.'" size="'.$size.'" square="'.$square.'" styles="'.$styles.'"]' );
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

        $title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $icons      = ! empty( $instance['icons'] ) ? $instance['icons'] : '';
        $size       = ! empty( $instance['size'] ) ? $instance['size'] : '';
        $square     = ! empty( $instance['square'] ) ? $instance['square'] : '';
        $styles     = ! empty( $instance['styles'] ) ? $instance['styles'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'icons' ); ?>"><?php _e( 'Icons:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'icons' ); ?>" name="<?php echo $this->get_field_name( 'icons' ); ?>">
                <?php
                $options = array(
                    '' => 'No icons',
                    'font-awesome' => 'Font Awesome'
                );

                foreach( $options as $key => $value ) {
                    $selected = ( $icons === $key ) ? ' selected="selected"' : '';
                    echo "<option value=\"$key\"$selected>$value</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Size:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
                <?php
                $options = array(
                    '' => 'Default',
                    'lg' => 'Large',
                    '2x' => '2x',
                    '3x' => '3x',
                    '4x' => '4x',
                    '5x' => '5x'
                );

                foreach( $options as $key => $value ) {
                    $selected = ( $size === $key ) ? ' selected="selected"' : '';
                    echo "<option value=\"$key\"$selected>$value</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'square' ); ?>"><?php _e( 'Use square icons:' ); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'square' ); ?>" name="<?php echo $this->get_field_name( 'square' ); ?>" <?php echo ($square === 'on') ? ' checked="checked"' : ''; ?>>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'styles' ); ?>"><?php _e( 'Output styles:' ); ?></label>
            <input type="checkbox" id="<?php echo $this->get_field_id( 'styles' ); ?>" name="<?php echo $this->get_field_name( 'styles' ); ?>" <?php echo ($styles === 'on') ? ' checked="checked"' : ''; ?>>
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
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['icons'] = ( ! empty( $new_instance['icons'] ) ) ? strip_tags( $new_instance['icons'] ) : '';
        $instance['size'] = ( ! empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
        $instance['square'] = ( ! empty( $new_instance['square'] ) ) ? strip_tags( $new_instance['square'] ) : '';
        $instance['styles'] = ( ! empty( $new_instance['styles'] ) ) ? strip_tags( $new_instance['styles'] ) : '';

        return $instance;

    }

} // class WPCI_Social_Network_Widget