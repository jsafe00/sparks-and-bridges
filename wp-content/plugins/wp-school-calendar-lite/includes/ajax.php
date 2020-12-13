<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WP_School_Calendar_Ajax_Action {

    private static $_instance = NULL;
    
    /**
     * Initialize all variables, filters and actions
     */
    public function __construct() {
        add_action( 'wp_ajax_wpsc_get_tooltip',        array( $this, 'get_tooltip' ) );
        add_action( 'wp_ajax_nopriv_wpsc_get_tooltip', array( $this, 'get_tooltip' ) );
        add_action( 'wp_ajax_wpsc_get_content',        array( $this, 'get_content' ) );
        add_action( 'wp_ajax_nopriv_wpsc_get_content', array( $this, 'get_content' ) );
    }

    /**
     * retrieve singleton class instance
     * @return instance reference to plugin
     */
    public static function instance() {
        if ( NULL === self::$_instance ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * Get important date tooltip content via AJAX
     * 
     * @since 1.0
     */
    public function get_tooltip() {
        check_ajax_referer( 'wp_school_calendar', 'nonce' );
        
        $important_dates = explode( ',', sanitize_text_field( $_POST['important_dates'] ) );
        
        $html = '<div class="wpsc-tooltip-container">';
        
        foreach ( $important_dates as $important_date_id ) {
            $important_date = wpsc_get_important_date( $important_date_id );
            $date_string = wpsc_format_date( $important_date['start_date'], $important_date['end_date'], wpsc_settings_value( 'date_format' ), wpsc_settings_value( 'show_year' ) );

            $html .= sprintf( '<div class="wpsc-tooltip-item wpsc-important-date-category-%s">', $important_date['category_id'] );
            $html .= '<div class="wpsc-tooltip-item-inner">';
            $html .= sprintf( '<div class="wpsc-tooltip-date">%s</div>', $date_string );
            $html .= sprintf( '<div class="wpsc-tooltip-title">%s</div>', $important_date['important_date_title'] );
            
            $additional_notes = get_post_meta( $important_date_id, '_additional_notes', true );
            
            if ( '' !== $additional_notes ) {
                $html .= sprintf( '<div class="wpsc-tooltip-note">%s</div>', $additional_notes );
            }
            
            $html .= '</div>';
            $html .= '</div>';

        }
        
        $html .= '</div>';
        
        wp_send_json_success( array( 'tooltip' => $html ) );
    }
    
    /**
     * Get calendar content via AJAX
     * 
     * @since 1.0
     */
    public function get_content() {
        check_ajax_referer( 'wp_school_calendar', 'nonce' );
        
        $school_year_id = intval( $_POST['school_year_id'] );
        
        $args = array();
        
        if ( isset( $_POST['categories'] ) ) {
            $args['categories'] = sanitize_text_field( $_POST['categories'] );
        }
        
        $content = wpsc_get_calendar_content( $school_year_id, $args );
        
        wp_send_json_success( array( 'content' => $content ) );
    }
    
}

WP_School_Calendar_Ajax_Action::instance();