<?php

/**
 * Plugin Name: WP School Calendar
 * Plugin URI: https://wpschoolcalendar.com
 * Description: Helps you build amazing school calendar for your WordPress site.
 * Author: WP School Calendar
 * Author URI: https://wpschoolcalendar.com
 * Version: 3.4.2
 * Text Domain: wp-school-calendar
 * Domain Path: languages
 * 
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'wpsc_fs' ) ) {
    wpsc_fs()->set_basename( false, __FILE__ );
} else {
    
    if ( !function_exists( 'wpsc_fs' ) ) {
        function wpsc_fs()
        {
            global  $wpsc_fs ;
            
            if ( !isset( $wpsc_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/includes/freemius/start.php';
                $wpsc_fs = fs_dynamic_init( array(
                    'id'             => '5764',
                    'slug'           => 'wp-school-calendar-lite',
                    'premium_slug'   => 'wp-school-calendar-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_62a91c6b07d4c7e1d3f9a83d9f23b',
                    'is_premium'     => false,
                    'premium_suffix' => 'Pro',
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'trial'          => array(
                    'days'               => 7,
                    'is_require_payment' => false,
                ),
                    'menu'           => array(
                    'slug'       => 'edit.php?post_type=important_date',
                    'first-path' => 'edit.php?post_type=important_date&page=wpsc-getting-started',
                    'contact'    => false,
                    'support'    => false,
                ),
                    'is_live'        => true,
                ) );
            }
            
            return $wpsc_fs;
        }
        
        // Init Freemius.
        wpsc_fs();
        // Signal that SDK was initiated.
        do_action( 'wpsc_fs_loaded' );
    }
    
    class WP_School_Calendar
    {
        private static  $_instance = NULL ;
        /**
         * Initialize all variables, filters and actions
         */
        public function __construct()
        {
            // Define plugin file path
            if ( !defined( 'WPSC_PLUGIN_FILE' ) ) {
                define( 'WPSC_PLUGIN_FILE', __FILE__ );
            }
            // Plugin version
            if ( !defined( 'WPSC_PLUGIN_VERSION' ) ) {
                define( 'WPSC_PLUGIN_VERSION', '3.4.2' );
            }
            // File base name.
            if ( !defined( 'WPSC_PLUGIN_BASENAME' ) ) {
                define( 'WPSC_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
            }
            // Plugin Folder Path.
            if ( !defined( 'WPSC_PLUGIN_DIR' ) ) {
                define( 'WPSC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            }
            // Plugin Folder URL.
            if ( !defined( 'WPSC_PLUGIN_URL' ) ) {
                define( 'WPSC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            }
            require_once WPSC_PLUGIN_DIR . 'includes/functions.php';
            require_once WPSC_PLUGIN_DIR . 'includes/post-type.php';
            require_once WPSC_PLUGIN_DIR . 'includes/widget.php';
            require_once WPSC_PLUGIN_DIR . 'includes/ajax.php';
            
            if ( is_admin() ) {
                require_once WPSC_PLUGIN_DIR . 'includes/admin/functions.php';
                require_once WPSC_PLUGIN_DIR . 'includes/admin/meta-boxes.php';
                require_once WPSC_PLUGIN_DIR . 'includes/admin/categories.php';
                require_once WPSC_PLUGIN_DIR . 'includes/admin/school-year.php';
                require_once WPSC_PLUGIN_DIR . 'includes/admin/settings.php';
                require_once WPSC_PLUGIN_DIR . 'includes/admin/getting-started.php';
            }
            
            add_action( 'init', array( $this, 'load_plugin_textdomain' ), 0 );
            add_action( 'init', array( $this, 'init' ), 1 );
            add_action( 'template_redirect', array( $this, 'render_custom_style' ), 0 );
            add_action( 'wp_loaded', array( $this, 'register_scripts' ) );
            add_action( 'admin_init', array( $this, 'silent_upgrade_db' ), 20 );
            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
            add_action( 'wp_head', array( $this, 'load_internal_color_style' ) );
            add_filter( 'query_vars', array( $this, 'custom_style_vars' ) );
            // Shortcode
            add_shortcode( 'wp_school_calendar', array( $this, 'add_shortcode' ) );
            // Gutenberg Block
            add_action( 'init', array( $this, 'register_gutenberg_block' ) );
            add_action( 'enqueue_block_editor_assets', array( $this, 'editor_assets' ) );
        }
        
        /**
         * retrieve singleton class instance
         * @return instance reference to plugin
         */
        public static function instance()
        {
            if ( NULL === self::$_instance ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        /**
         * Initialize custom stylesheet
         * 
         * @since 1.0
         * 
         * @global object $wp
         */
        public function init()
        {
            global  $wp ;
            
            if ( 'Y' === wpsc_settings_value( 'external_color_style' ) ) {
                $wp->add_query_var( 'wpsc-custom-style' );
                add_rewrite_rule( 'wpsc-custom-style\\.css$', 'index.php?wpsc-custom-style=1', 'top' );
            }
        
        }
        
        /**
         * Add 'wpsc-custom-style' to query vars
         * 
         * @since 1.0
         * 
         * @param array $vars Original query vars
         * @return array Modified query vars
         */
        public function custom_style_vars( $vars )
        {
            if ( 'Y' === wpsc_settings_value( 'external_color_style' ) ) {
                $vars[] = 'wpsc-custom-style';
            }
            return $vars;
        }
        
        /**
         * Render custom stylesheet
         * 
         * @since 1.0
         */
        public function render_custom_style()
        {
            if ( 'N' === wpsc_settings_value( 'external_color_style' ) ) {
                return;
            }
            
            if ( get_query_var( 'wpsc-custom-style' ) === '1' ) {
                header( 'Content-Type: text/css; charset: UTF-8' );
                echo  wpsc_get_important_date_single_color() ;
                exit;
            }
        
        }
        
        /**
         * Load Localisation files.
         * 
         * @since 3.0
         * 
         * Locales found in:
         *  - WP_LANG_DIR/wp-school-calendar/wp-school-calendar-LOCALE.mo
         *  - WP_LANG_DIR/plugins/wp-school-calendar-LOCALE.mo
         */
        public function load_plugin_textdomain()
        {
            $locale = ( is_admin() && function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale() );
            $locale = apply_filters( 'plugin_locale', $locale, 'wp-school-calendar' );
            unload_textdomain( 'wp-school-calendar' );
            load_textdomain( 'wp-school-calendar', WP_LANG_DIR . '/wp-school-calendar/wp-school-calendar-' . $locale . '.mo' );
            load_plugin_textdomain( 'wp-school-calendar', false, plugin_basename( dirname( WPSC_PLUGIN_FILE ) ) . '/languages' );
        }
        
        /**
         * Process upgrade database
         * 
         * @since 1.0
         */
        public function silent_upgrade_db()
        {
            if ( wp_doing_ajax() ) {
                return;
            }
            if ( get_option( 'wpsc_options', array() ) === array() ) {
                wpsc_create_initial_options();
            }
            $wpsc_version = get_option( 'wpsc_version', '' );
            
            if ( version_compare( $wpsc_version, WPSC_PLUGIN_VERSION, '<' ) || '' === $wpsc_version ) {
                if ( version_compare( $wpsc_version, '3.0', '>' ) && version_compare( $wpsc_version, '3.2', '<' ) ) {
                    wpsc_upgrade_32();
                }
                if ( version_compare( $wpsc_version, '3.4', '<' ) ) {
                    wpsc_upgrade_34();
                }
                update_option( 'wpsc_version', WPSC_PLUGIN_VERSION );
            }
        
        }
        
        /**
         * Get admin script arguments
         * 
         * @since 1.0
         * 
         * @return array Admin script arguments
         */
        public static function admin_script_args()
        {
            return array(
                'ajaxurl'          => admin_url( 'admin-ajax.php' ),
                'nonce'            => wp_create_nonce( 'wpsc_admin' ),
                'loading'          => __( 'Loading...', 'wp-school-calendar' ),
                'datepickerButton' => __( 'Choose', 'wp-school-calendar' ),
                'warnDelete'       => __( 'Are you sure want to delete this item?', 'wp-school-calendar' ),
            );
        }
        
        /**
         * Get frontend script arguments
         * 
         * @since 1.0
         * 
         * @return array Frontend script arguments
         */
        public static function frontend_script_args()
        {
            return array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'wp_school_calendar' ),
                'loading' => __( 'Loading...', 'wp-school-calendar' ),
            );
        }
        
        /**
         * Load admin stylesheet and script
         * 
         * @since 1.0
         */
        public function admin_enqueue_scripts()
        {
            $screen = get_current_screen();
            if ( isset( $screen->post_type ) && 'important_date' === $screen->post_type && isset( $screen->base ) ) {
                
                if ( 'important_date_page_wpsc-settings' === $screen->base ) {
                    wp_enqueue_media();
                    wp_enqueue_script( 'magnific-popup' );
                    wp_enqueue_script( 'jquery-select2' );
                    wp_enqueue_script( 'wpsc-admin-settings' );
                    wp_enqueue_style( 'magnific-popup' );
                    wp_enqueue_style( 'jquery-select2' );
                    wp_enqueue_style( 'wpsc-admin-settings' );
                } elseif ( 'important_date_page_wpsc-category' === $screen->base ) {
                    wp_enqueue_script( 'wp-color-picker' );
                    wp_enqueue_script( 'wpsc-admin-category' );
                    wp_enqueue_style( 'wpsc-admin-category' );
                    wp_localize_script( 'wpsc-admin-category', 'WPSC_Admin', self::admin_script_args() );
                } elseif ( 'edit' === $screen->base ) {
                    wp_enqueue_style( 'wpsc-admin-important-date' );
                } elseif ( 'post' === $screen->base ) {
                    wp_enqueue_script( 'wp-color-picker' );
                    wp_enqueue_script( 'jquery-ui-datepicker' );
                    wp_enqueue_script( 'wpsc-admin-important-date' );
                    wp_enqueue_style( 'jquery-ui' );
                    wp_enqueue_style( 'datepicker' );
                    wp_enqueue_style( 'wpsc-admin-important-date' );
                    wp_localize_script( 'wpsc-admin-important-date', 'WPSC_Admin', self::admin_script_args() );
                } elseif ( 'important_date_page_wpsc-school-year' === $screen->base ) {
                    wp_enqueue_script( 'jquery-ui-datepicker' );
                    wp_enqueue_script( 'wpsc-admin-school-year' );
                    wp_enqueue_style( 'jquery-ui' );
                    wp_enqueue_style( 'datepicker' );
                    wp_enqueue_style( 'wpsc-admin-school-year' );
                    wp_localize_script( 'wpsc-admin-school-year', 'WPSC_Admin', self::admin_script_args() );
                } elseif ( 'important_date_page_wpsc-getting-started' === $screen->base ) {
                    wp_enqueue_style( 'wpsc-admin-getting-started' );
                }
            
            }
        }
        
        public function register_scripts()
        {
            wp_register_script(
                'magnific-popup',
                WPSC_PLUGIN_URL . 'assets/js/jquery.magnific-popup.min.js',
                array( 'jquery' ),
                false,
                true
            );
            wp_register_script(
                'jquery-select2',
                WPSC_PLUGIN_URL . 'assets/js/select2.min.js',
                array( 'jquery' ),
                false,
                true
            );
            wp_register_script(
                'wpsc-admin-important-date',
                WPSC_PLUGIN_URL . 'assets/js/admin-important-date.js',
                array( 'jquery', 'wp-color-picker', 'jquery-ui-datepicker' ),
                false,
                true
            );
            wp_register_script(
                'wpsc-admin-settings',
                WPSC_PLUGIN_URL . 'assets/js/admin-settings.js',
                array( 'jquery', 'jquery-select2' ),
                false,
                true
            );
            wp_register_script(
                'wpsc-admin-category',
                WPSC_PLUGIN_URL . 'assets/js/admin-category.js',
                array( 'jquery', 'wp-color-picker' ),
                false,
                true
            );
            wp_register_script(
                'wpsc-admin-school-year',
                WPSC_PLUGIN_URL . 'assets/js/admin-school-year.js',
                array( 'jquery', 'jquery-ui-datepicker' ),
                false,
                true
            );
            wp_register_script(
                'wpsc-gutenberg-block',
                WPSC_PLUGIN_URL . 'assets/js/block.js',
                array(
                'wp-blocks',
                'wp-i18n',
                'wp-element',
                'wp-editor',
                'wp-components'
            ),
                false,
                true
            );
            wp_register_style( 'magnific-popup', WPSC_PLUGIN_URL . 'assets/css/magnific-popup.css' );
            wp_register_style( 'jquery-ui', WPSC_PLUGIN_URL . 'assets/css/jquery-ui.css' );
            wp_register_style( 'datepicker', WPSC_PLUGIN_URL . 'assets/css/datepicker.css' );
            wp_register_style( 'jquery-select2', WPSC_PLUGIN_URL . 'assets/css/select2.css' );
            wp_register_style( 'wpsc-admin-important-date', WPSC_PLUGIN_URL . 'assets/css/admin-important-date.css', array( 'jquery-ui', 'datepicker' ) );
            wp_register_style( 'wpsc-admin-getting-started', WPSC_PLUGIN_URL . 'assets/css/admin-getting-started.css', array() );
            wp_register_style( 'wpsc-admin-settings', WPSC_PLUGIN_URL . 'assets/css/admin-settings.css', array( 'jquery-select2' ) );
            wp_register_style( 'wpsc-admin-category', WPSC_PLUGIN_URL . 'assets/css/admin-category.css', array() );
            wp_register_style( 'wpsc-admin-school-year', WPSC_PLUGIN_URL . 'assets/css/admin-school-year.css', array( 'jquery-ui', 'datepicker' ) );
            $frontend_style_deps = array();
            wp_register_style( 'wpsc-frontend', WPSC_PLUGIN_URL . 'assets/css/frontend.css', $frontend_style_deps );
            wp_register_style( 'wpsc-widget', WPSC_PLUGIN_URL . 'assets/css/widget.css' );
            if ( 'Y' === wpsc_settings_value( 'external_color_style' ) ) {
                wp_register_style( 'wpsc-custom-style', home_url( '/wpsc-custom-style.css' ), array() );
            }
        }
        
        /**
         * Load frontend stylesheet dan scripts
         * 
         * @since 1.0
         * 
         * @global array $post object
         */
        public function enqueue_scripts()
        {
            wp_enqueue_style( 'wpsc-frontend' );
            wp_enqueue_style( 'wpsc-widget' );
            if ( 'Y' === wpsc_settings_value( 'external_color_style' ) ) {
                wp_enqueue_style( 'wpsc-custom-style' );
            }
        }
        
        public function add_shortcode()
        {
            $output = sprintf( '<div id="wpsc-block-calendar">%s</div>', wpsc_get_calendar_content() );
            return $output;
        }
        
        public function register_gutenberg_block()
        {
            if ( !function_exists( 'register_block_type' ) ) {
                // Gutenberg is not active
                return;
            }
            register_block_type( 'wp-school-calendar/wp-school-calendar', array(
                'render_callback' => array( $this, 'render_gutenberg_block' ),
            ) );
        }
        
        public function render_gutenberg_block( $attributes )
        {
            $output = sprintf( '<div id="wpsc-block-calendar">%s</div>', wpsc_get_calendar_content() );
            return $output;
        }
        
        public function editor_assets()
        {
            wp_enqueue_script( 'wpsc-gutenberg-block' );
            wp_enqueue_style( 'wpsc-frontend' );
            
            if ( 'Y' === wpsc_settings_value( 'external_color_style' ) ) {
                wp_enqueue_style( 'wpsc-custom-style' );
            } else {
                wp_add_inline_style( 'wpsc-frontend', wpsc_get_important_date_single_color() );
            }
        
        }
        
        public function load_internal_color_style()
        {
            
            if ( 'N' === wpsc_settings_value( 'external_color_style' ) ) {
                echo  '<style>' . "\n" ;
                echo  wpsc_get_important_date_single_color() ;
                echo  '</style>' . "\n" ;
            }
        
        }
    
    }
    WP_School_Calendar::instance();
}
