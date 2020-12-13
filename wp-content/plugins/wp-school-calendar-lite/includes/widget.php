<?php
class WP_School_Calendar_Widget_Important_Dates extends WP_Widget {
    
    protected $defaults;
    
    /**
     * Sets up a new Upcoming Important Date widget instance.
     * 
     * @since 1.0
     */
    function __construct() {
        $this->defaults = array(
            'title'              => __( 'Dates to Remember', 'wp-school-calendar' ),
            'num_important_date' => 5,
            'date_format'        => 'medium',
            'show_year'          => false
        );

        $widget_slug = 'widget-wpsc-upcoming-important-dates';

        $widget_ops = array(
            'classname'   => $widget_slug,
            'description' => esc_html_x( 'Display important dates.', 'Widget', 'wp-school-calendar' ),
        );

        $control_ops = array(
            'id_base' => $widget_slug,
        );

        parent::__construct( $widget_slug, esc_html_x( 'Important Dates', 'Widget', 'wp-school-calendar' ), $widget_ops, $control_ops );
    }
    
    /**
     * Outputs the content for the current Upcoming Important Date widget instance.
     * 
     * @since 1.0
     * 
     * @global WP_Locale $wp_locale WP_Locale object
     * @param array $args       Widget arguments
     * @param array $instance   Widget instance
     */
    function widget( $args, $instance ) {
        $instance = wp_parse_args( ( array ) $instance, $this->defaults );
        
        $important_date_args = array(
            'start_date'     => date( 'Y-m-d' ),
            'end_date'       => date( 'Y-m-d', strtotime( '1year' ) ),
            'posts_per_page' => $instance['num_important_date']
        );
        
        $upcoming_important_dates = wpsc_get_important_dates( $important_date_args );

        echo $args['before_widget'];

        if ( !empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        if ( empty( $upcoming_important_dates ) ) {
            echo '<p>', esc_html__( 'No Important Dates', 'wp-school-calendar' ), '</p>';
        } else {
            echo '<ul>';
            
            global $wp_locale;
            
            $show_year = $instance['show_year'] ? 'Y' : 'N';
            
            foreach ( $upcoming_important_dates as $important_date ) {
                $date_string = wpsc_format_date( $important_date['start_date'], $important_date['end_date'], $instance['date_format'], $show_year );
                
                printf( '<li class="">' );
                printf( '<div class="wpsc-upcoming-important-date-date">%s</div>', $date_string );
                printf( '<div class="wpsc-upcoming-important-date-title">%s</div>', $important_date['important_date_title'] );
                echo '</li>';
            }
            
            echo '</ul>';
            
            printf( '<div class="wpsc-upcoming-important-date-more"><a href="%s">%s</a></div>', get_permalink( wpsc_settings_value( 'calendar_page' ) ), __( 'Show Calendar', 'wp-school-calendar' ) );
        }
        
        echo $args['after_widget'];
    }
    
    /**
     * Handles updating settings for the current Upcoming Important Date widget instance.
     * 
     * @since 1.0
     * 
     * @param array $new_instance   New widget instance
     * @param array $old_instance   Old widget instance
     * @return array New widget instance
     */
    function update( $new_instance, $old_instance ) {
        $new_instance['title']              = wp_strip_all_tags( $new_instance['title'] );
        $new_instance['num_important_date'] = absint( $new_instance['num_important_date'] );
        $new_instance['date_format']        = $new_instance['date_format'];
        $new_instance['show_year']          = isset( $new_instance['show_year'] ) ? '1' : false;

        return $new_instance;
    }
    
    /**
     * Outputs the settings form for the Upcoming Important Date widget.
     * 
     * @since 1.0
     * 
     * @param array $instance Array of widget instance
     */
    function form( $instance ) {
        $instance = wp_parse_args( ( array ) $instance, $this->defaults );
        $date_format_options = wpsc_get_date_format_options();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php esc_html( _ex( 'Title:', 'Widget', 'wp-school-calendar' ) ); ?>
            </label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'num_events' ); ?>">
                <?php esc_html( _ex( 'Number of Events:', 'Widget', 'wp-school-calendar' ) ); ?>
            </label>
            <input type="number" id="<?php echo $this->get_field_id( 'num_events' ); ?>" name="<?php echo $this->get_field_name( 'num_important_date' ); ?>" value="<?php echo esc_attr( $instance['num_important_date'] ); ?>" class="widefat"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'date_format' ); ?>">
                <?php esc_html( _ex( 'Date Format:', 'Widget', 'wp-school-calendar' ) ); ?>
            </label>
            <select id="<?php echo $this->get_field_id( 'date_format' ); ?>" name="<?php echo $this->get_field_name( 'date_format' ); ?>" class="widefat">
                <?php foreach ( $date_format_options as $key => $name ): ?>
                <option value="<?php echo $key ?>"<?php selected( $key, $instance['date_format'] ) ?>><?php echo $name ?></option>
                <?php endforeach ?>
            </select>
        </p>
        <p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'show_year' ); ?>"
					name="<?php echo $this->get_field_name( 'show_year' ); ?>" <?php checked( '1', $instance['show_year'] ); ?>>
			<label for="<?php echo $this->get_field_id( 'show_year' ); ?>"><?php esc_html( _ex( 'Show Year', 'Widget', 'wp-school-calendar' ) ); ?></label>
		</p>
        <?php
    }
}

/**
 * Register widgets
 * 
 * @since 1.0
 */
function wpsc_register_widgets() {
    register_widget( 'WP_School_Calendar_Widget_Important_Dates' );
}

add_action( 'widgets_init', 'wpsc_register_widgets' );
