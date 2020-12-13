<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class WP_School_Calendar_Settings
{
    private static  $_instance = NULL ;
    public  $action = NULL ;
    /**
     * Initialize all variables, filters and actions
     */
    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'settings_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
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
     * Add Settings menu page
     * 
     * @since 1.0
     */
    public function admin_menu()
    {
        add_submenu_page(
            'edit.php?post_type=important_date',
            __( 'Calendar Settings', 'wp-school-calendar' ),
            __( 'Settings', 'wp-school-calendar' ),
            'manage_options',
            'wpsc-settings',
            array( $this, 'admin_page' )
        );
    }
    
    /**
     * Add Settings page
     * 
     * @since 1.0
     */
    public function admin_page()
    {
        $weekdays = wpsc_get_weekday_options();
        $date_format_options = wpsc_get_date_format_options();
        $tooltip_theme_options = wpsc_get_tooltip_theme_options();
        $tooltip_trigger_options = wpsc_get_tooltip_trigger_options();
        $tooltip_animation_options = wpsc_get_tooltip_animation_options();
        $categories = wpsc_get_categories();
        $school_years = wpsc_get_school_years();
        $day_format_options = wpsc_get_day_format_options();
        $calendar_display_options = wpsc_get_calendar_display_options();
        $category_options = wpsc_get_category_options();
        $tabs = array(
            'general'    => __( 'General', 'wp-school-calendar' ),
            'navigation' => __( 'Calendar Navigation', 'wp-school-calendar' ),
            'tooltip'    => __( 'Tooltip', 'wp-school-calendar' ),
            'pdf'        => __( 'PDF Settings', 'wp-school-calendar' ),
        );
        ?>
        <div class="wrap">
            <h2><?php 
        _e( 'Calendar Settings', 'wp-school-calendar' );
        ?></h2>
            
            <h2 class="nav-tab-wrapper">
                <?php 
        foreach ( $tabs as $id => $tab ) {
            ?>
                <?php 
            $nav_class = ( 'general' === $id ? 'nav-tab wpsc-settings-nav-tab' : 'nav-tab wpsc-settings-nav-tab wpsc-settings-nav-tab-upgrade-modal' );
            if ( 'general' === $id ) {
                $nav_class .= ' nav-tab-active';
            }
            ?>
                <a href="#<?php 
            echo  $id ;
            ?>" class="<?php 
            echo  $nav_class ;
            ?>"><?php 
            echo  $tab ;
            ?></a>
                <?php 
        }
        ?>
            </h2>
            
            <form method="post" action="options.php">
                <?php 
        settings_fields( 'wpsc_options' );
        ?>
                <div id="wpsc-settings-general" class="wpsc-settings-page">
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Default School Year', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <select name="wpsc_options[default_school_year]" class="wpsc-select">
                                    <?php 
        foreach ( $school_years as $school_year ) {
            ?>
                                    <option value="<?php 
            echo  esc_attr( $school_year['school_year_id'] ) ;
            ?>"<?php 
            selected( $school_year['school_year_id'], wpsc_settings_value( 'default_school_year' ) );
            ?>><?php 
            echo  esc_html( $school_year['name'] ) ;
            ?></option>
                                    <?php 
        }
        ?>
                                </select>
                                <p class="description"><?php 
        echo  __( 'This option determines default school year of your school calendar.', 'wp-school-calendar' ) ;
        ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Default Category', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <select name="wpsc_options[default_category]" class="wpsc-select">
                                    <?php 
        foreach ( $categories as $category ) {
            ?>
                                    <option value="<?php 
            echo  esc_attr( $category['category_id'] ) ;
            ?>"<?php 
            selected( $category['category_id'], wpsc_settings_value( 'default_category' ) );
            ?>><?php 
            echo  esc_html( $category['name'] ) ;
            ?></option>
                                    <?php 
        }
        ?>
                                </select>
                                <p class="description"><?php 
        echo  __( 'This option determines default category of important date.', 'wp-school-calendar' ) ;
        ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Calendar Display', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <select name="wpsc_options[calendar_display]" class="wpsc-select">
                                    <?php 
        foreach ( $calendar_display_options as $key => $value ) {
            ?>
                                    <option value="<?php 
            echo  esc_attr( $key ) ;
            ?>"<?php 
            selected( $key, wpsc_settings_value( 'calendar_display' ) );
            ?>><?php 
            echo  esc_html( $value ) ;
            ?></option>
                                    <?php 
        }
        ?>
                                </select>
                                <p class="description"><?php 
        echo  __( 'This option determines the number of columns.', 'wp-school-calendar' ) ;
        ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Weekday', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <select name="wpsc_options[weekday][]" multiple="multiple" class="wpsc-select">
                                    <?php 
        foreach ( $weekdays as $key => $weekday ) {
            ?>
                                    <option value="<?php 
            echo  esc_attr( $key ) ;
            ?>"<?php 
            selected( in_array( $key, wpsc_settings_value( 'weekday' ) ) );
            ?>><?php 
            echo  esc_html( $weekday ) ;
            ?></option>
                                    <?php 
        }
        ?>
                                </select>
                                <p class="description"><?php 
        echo  __( 'Choose the days that the students go to school.', 'wp-school-calendar' ) ;
        ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Day Format', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <select name="wpsc_options[day_format]" class="wpsc-select">
                                    <?php 
        foreach ( $day_format_options as $key => $value ) {
            ?>
                                    <option value="<?php 
            echo  esc_attr( $key ) ;
            ?>"<?php 
            selected( $key, wpsc_settings_value( 'day_format' ) );
            ?>><?php 
            echo  esc_html( $value ) ;
            ?></option>
                                    <?php 
        }
        ?>
                                </select>
                                <p class="description"><?php 
        echo  __( 'This option determines the format of day name.', 'wp-school-calendar' ) ;
        ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Date Format', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <select name="wpsc_options[date_format]" class="wpsc-select">
                                    <?php 
        foreach ( $date_format_options as $key => $value ) {
            ?>
                                    <option value="<?php 
            echo  esc_attr( $key ) ;
            ?>"<?php 
            selected( $key, wpsc_settings_value( 'date_format' ) );
            ?>><?php 
            echo  esc_html( $value ) ;
            ?></option>
                                    <?php 
        }
        ?>
                                </select>
                                <p class="description"><?php 
        echo  __( 'This option determines date format of important date.', 'wp-school-calendar' ) ;
        ?></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Include Year', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <p><label for="show-year"><input id="show-year" type="checkbox" name="wpsc_options[show_year]" value="Y" <?php 
        checked( 'Y', wpsc_settings_value( 'show_year' ) );
        ?>> 
                                    <?php 
        echo  esc_html__( 'Check this if you would like to display year in important date.', 'wp-school-calendar' ) ;
        ?></label></p>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'Important Date Heading Text', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <input type="text" name="wpsc_options[important_date_heading]" value="<?php 
        echo  esc_attr( wpsc_settings_value( 'important_date_heading' ) ) ;
        ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php 
        echo  esc_html__( 'External Color Style', 'wp-school-calendar' ) ;
        ?></th>
                            <td class="forminp">
                                <p><label for="external-color-style"><input id="external-color-style" type="checkbox" name="wpsc_options[external_color_style]" value="Y" <?php 
        checked( 'Y', wpsc_settings_value( 'external_color_style' ) );
        ?>> 
                                    <?php 
        echo  esc_html__( 'Check this if you would like to use external color style for important date.', 'wp-school-calendar' ) ;
        ?></label></p>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                
                <?php 
        ?>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php 
        echo  esc_attr__( 'Save Changes', 'wp-school-calendar' ) ;
        ?>" />
                </p>
            </form>
        </div>
        <div id="wpsc-upgrade-panel" class="wpsc-upgrade-panel mfp-hide">
            <div class="wpsc-upgrade-panel__heading"><?php 
        echo  __( 'PRO Feature', 'wp-school-calendar' ) ;
        ?></div>
            <div class="wpsc-upgrade-panel__description"><?php 
        echo  __( "We're sorry, these settings is not available on your plan. Please upgrade to the PRO plan to unlock all these awesome features.", 'wp-school-calendar' ) ;
        ?></div>
            <div class="wpsc-upgrade-panel__button"><a href="https://wpschoolcalendar.com" target="_blank"><?php 
        echo  __( 'Upgrade to Pro', 'wp-school-calendar' ) ;
        ?></a></div>
        </div>
        <?php 
    }
    
    /**
     * Register settings
     * 
     * @since 1.0
     */
    public function settings_init()
    {
        register_setting( 'wpsc_options', 'wpsc_options', array( $this, 'settings_sanitize' ) );
    }
    
    /**
     * Sanitize the setting input
     * 
     * @since 1.0
     * 
     * @param array $input Settings input
     * @return array Sanitized input
     */
    public function settings_sanitize( $input )
    {
        $options = get_option( 'wpsc_options', wpsc_get_default_settings() );
        $settings = (require WPSC_PLUGIN_DIR . 'config/plugin-settings.php');
        foreach ( $settings as $key => $setting ) {
            
            if ( 'text' === $setting['type'] ) {
                $options[$key] = esc_attr( $input[$key] );
            } elseif ( 'select' === $setting['type'] || 'radio' === $setting['type'] ) {
                
                if ( in_array( $input[$key], $setting['options'] ) ) {
                    $options[$key] = $input[$key];
                } else {
                    $options[$key] = $setting['default_value'];
                }
            
            } elseif ( 'multiple' === $setting['type'] ) {
                $valid_values = array();
                foreach ( $input[$key] as $val ) {
                    if ( in_array( $val, $setting['options'] ) ) {
                        $valid_values[] = $val;
                    }
                }
                $options[$key] = $valid_values;
            } elseif ( 'checkbox' === $setting['type'] ) {
                
                if ( isset( $input[$key] ) ) {
                    $options[$key] = 'Y';
                } else {
                    $options[$key] = 'N';
                }
            
            } else {
                $options[$key] = $input[$key];
            }
        
        }
        return $options;
    }

}
WP_School_Calendar_Settings::instance();