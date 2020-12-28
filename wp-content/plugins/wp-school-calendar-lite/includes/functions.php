<?php

/**
 * Get the default of plugin settings
 * 
 * @since 1.0
 * 
 * @return array Default settings
 */
function wpsc_get_default_settings()
{
    $default_settings = array();
    $settings = (require WPSC_PLUGIN_DIR . 'config/plugin-settings.php');
    foreach ( $settings as $key => $setting ) {
        $default_settings[$key] = $setting['default_value'];
    }
    return $default_settings;
}

/**
 * Get the value of plugin settings
 * 
 * @since 1.0
 * 
 * @global type $wpsc_options
 * 
 * @param string $key Settings key
 * @return string Settings value or False if the setting not found
 */
function wpsc_settings_value( $key = false )
{
    global  $wpsc_options ;
    $default_settings = wpsc_get_default_settings();
    if ( empty($wpsc_options) ) {
        $wpsc_options = get_option( 'wpsc_options', $default_settings );
    }
    
    if ( isset( $wpsc_options[$key] ) ) {
        return $wpsc_options[$key];
    } elseif ( isset( $default_settings[$key] ) ) {
        return $default_settings[$key];
    } else {
        return false;
    }

}

function wpsc_get_calendar_category_list( $args )
{
    global  $wpdb ;
    $params = array();
    $sql = "SELECT pm3.meta_value AS category_id ";
    $sql .= "FROM {$wpdb->posts} p ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm1 on p.ID = pm1.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm3 on p.ID = pm3.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm4 on p.ID = pm4.post_id ";
    $sql .= "WHERE p.post_type = 'important_date' and p.post_status = 'publish' ";
    $sql .= "AND pm1.meta_key = '_start_date' and pm2.meta_key = '_end_date'";
    $sql .= "AND pm3.meta_key = '_category_id' AND pm4.meta_key = '_exclude_weekend' ";
    
    if ( isset( $args['start_date'] ) && isset( $args['end_date'] ) ) {
        $sql .= "AND ((CAST(pm1.meta_value AS DATE) >= %s AND CAST(pm2.meta_value AS DATE) <= %s) OR ";
        $sql .= "(CAST(pm1.meta_value AS DATE) >= %s AND CAST(pm1.meta_value AS DATE) <= %s AND CAST(pm2.meta_value AS DATE) >= %s) OR ";
        $sql .= "(CAST(pm1.meta_value AS DATE) <= %s AND CAST(pm2.meta_value AS DATE) >= %s AND CAST(pm2.meta_value AS DATE) <= %s) OR ";
        $sql .= "(CAST(pm1.meta_value AS DATE) <= %s AND CAST(pm2.meta_value AS DATE) >= %s)) ";
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
        $params[] = $args['end_date'];
        $params[] = $args['start_date'];
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( $sql, $params ), ARRAY_A );
    $categories = array();
    foreach ( $results as $result ) {
        $categories[] = $result['category_id'];
    }
    return array_unique( $categories );
}

/**
 * Get important date category name
 * 
 * @since 1.0
 * 
 * @param int $category_id Important date category ID
 * @return string Important date category name
 */
function wpsc_get_category_name( $category_id )
{
    $category = wpsc_get_category( $category_id );
    return $category['name'];
}

/**
 * Get important date categories
 * 
 * @since 1.0
 * 
 * @global wpdb $wpdb wpdb object
 * @return array Array of important date categories
 */
function wpsc_get_categories()
{
    global  $wpdb, $wpsc_categories ;
    if ( is_array( $wpsc_categories ) && count( $wpsc_categories ) > 0 ) {
        return $wpsc_categories;
    }
    $args = "SELECT p.ID AS category_id, p.post_title AS name, pm.meta_value AS bgcolor ";
    $args .= "FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id ";
    $args .= "WHERE p.post_type = 'important_date_cat' AND p.post_status = 'publish' AND pm.meta_key = '_bgcolor' ";
    $args .= "ORDER BY p.post_title ASC";
    $wpsc_categories = $wpdb->get_results( $args, ARRAY_A );
    return $wpsc_categories;
}

function wpsc_get_category_options()
{
    $categories = wpsc_get_categories();
    $options = array();
    foreach ( $categories as $category ) {
        $options[$category['category_id']] = $category['name'];
    }
    return $options;
}

/**
 * Get single important date category
 * 
 * @since 1.0
 * 
 * @param int $id Important date category ID
 * @return array|false Array of important date category of False if not found
 */
function wpsc_get_category( $id )
{
    $obj = get_post( $id );
    
    if ( $obj ) {
        $category = array(
            'category_id' => $obj->ID,
            'name'        => $obj->post_title,
            'bgcolor'     => get_post_meta( $obj->ID, '_bgcolor', true ),
        );
        return $category;
    }
    
    return false;
}

/**
 * Get school year menus
 * 
 * @since 1.0
 * 
 * @global wpdb $wpdb wpdb object
 * @return array Array of school year menus
 */
function wpsc_get_school_year_menus()
{
    global  $wpdb ;
    $sql = "SELECT p.ID AS school_year_id, p.post_title as name ";
    $sql .= "FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id ";
    $sql .= "WHERE p.post_type = 'school_year' AND p.post_status = 'publish' ";
    $sql .= "AND pm1.meta_key = '_enable' ";
    $sql .= "AND pm1.meta_value = 'Y' ";
    $sql .= "ORDER BY name ASC";
    $results = $wpdb->get_results( $sql, ARRAY_A );
    return $results;
}

/**
 * Get school years
 * 
 * @since 1.0
 * 
 * @global wpdb $wpdb wpdb object
 * @return array Array of school years
 */
function wpsc_get_school_years()
{
    global  $wpdb ;
    $sql = "SELECT p.ID AS school_year_id, p.post_title as name, pm1.meta_value AS start_year, pm2.meta_value AS end_year, ";
    $sql .= "pm3.meta_value AS start_date, pm4.meta_value AS end_date, pm5.meta_value AS enable ";
    $sql .= "FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} pm1 ON p.ID = pm1.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm2 ON p.ID = pm2.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm3 ON p.ID = pm3.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm4 ON p.ID = pm4.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm5 ON p.ID = pm5.post_id ";
    $sql .= "WHERE p.post_type = 'school_year' AND p.post_status = 'publish' ";
    $sql .= "AND pm1.meta_key = '_start_year' ";
    $sql .= "AND pm2.meta_key = '_end_year' ";
    $sql .= "AND pm3.meta_key = '_start_date' ";
    $sql .= "AND pm4.meta_key = '_end_date' ";
    $sql .= "AND pm5.meta_key = '_enable' ";
    $sql .= "ORDER BY start_year ASC";
    $results = $wpdb->get_results( $sql, ARRAY_A );
    return $results;
}

/**
 * Get single school year
 * 
 * @since 1.0
 * 
 * @param int $id School year ID
 * @return array Array of school year or False if not found
 */
function wpsc_get_school_year( $id )
{
    $obj = get_post( $id );
    
    if ( $obj ) {
        $school_year = array(
            'school_year_id' => $obj->ID,
            'name'           => $obj->post_title,
            'start_year'     => get_post_meta( $obj->ID, '_start_year', true ),
            'end_year'       => get_post_meta( $obj->ID, '_end_year', true ),
            'start_date'     => get_post_meta( $obj->ID, '_start_date', true ),
            'end_date'       => get_post_meta( $obj->ID, '_end_date', true ),
            'enable'         => get_post_meta( $obj->ID, '_enable', true ),
        );
        return $school_year;
    }
    
    return false;
}

/**
 * Get important dates
 * 
 * @since 1.0
 * 
 * @global wpdb $wpdb wpdb object
 * @param array $args Array of arguments
 * @return array Array of important dates
 */
function wpsc_get_important_dates( $args )
{
    global  $wpdb ;
    $params = array();
    $sql = "SELECT p.ID AS post_id, p.post_title AS important_date_title, ";
    $sql .= "pm1.meta_value AS start_date, pm2.meta_value AS end_date, ";
    $sql .= "pm3.meta_value AS category_id, pm4.meta_value AS exclude_weekend ";
    $sql .= "FROM {$wpdb->posts} p ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm1 on p.ID = pm1.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm3 on p.ID = pm3.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm4 on p.ID = pm4.post_id ";
    $sql .= "WHERE p.post_type = 'important_date' and p.post_status = 'publish' ";
    $sql .= "AND pm1.meta_key = '_start_date' and pm2.meta_key = '_end_date'";
    $sql .= "AND pm3.meta_key = '_category_id' AND pm4.meta_key = '_exclude_weekend' ";
    
    if ( !empty($args['categories']) ) {
        $cats = explode( ',', $args['categories'] );
        $placeholders = array_fill( 0, count( $cats ), '%d' );
        $sql .= sprintf( 'AND pm3.meta_value IN (%s) ', implode( ', ', $placeholders ) );
        foreach ( $cats as $cat ) {
            $params[] = $cat;
        }
    }
    
    
    if ( isset( $args['start_date'] ) && isset( $args['end_date'] ) ) {
        $sql .= "AND ((CAST(pm1.meta_value AS DATE) >= %s AND CAST(pm2.meta_value AS DATE) <= %s) OR ";
        $sql .= "(CAST(pm1.meta_value AS DATE) >= %s AND CAST(pm1.meta_value AS DATE) <= %s AND CAST(pm2.meta_value AS DATE) >= %s) OR ";
        $sql .= "(CAST(pm1.meta_value AS DATE) <= %s AND CAST(pm2.meta_value AS DATE) >= %s AND CAST(pm2.meta_value AS DATE) <= %s) OR ";
        $sql .= "(CAST(pm1.meta_value AS DATE) <= %s AND CAST(pm2.meta_value AS DATE) >= %s)) ";
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
        $params[] = $args['end_date'];
        $params[] = $args['start_date'];
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
        $params[] = $args['start_date'];
        $params[] = $args['end_date'];
    }
    
    $sql .= "ORDER BY start_date ASC ";
    
    if ( isset( $args['posts_per_page'] ) ) {
        $sql .= "LIMIT 0, %d ";
        $params[] = $args['posts_per_page'];
    }
    
    $results = $wpdb->get_results( $wpdb->prepare( $sql, $params ), ARRAY_A );
    return $results;
}

/**
 * Get single important date
 * 
 * @since 1.0
 * 
 * @global wpdb $wpdb wpdb object
 * @param int $id Important date ID
 * @return array Array of important date
 */
function wpsc_get_important_date( $id )
{
    global  $wpdb ;
    $id = intval( $id );
    $sql = "SELECT p.ID AS post_id, p.post_title AS important_date_title, ";
    $sql .= "pm1.meta_value AS start_date, pm2.meta_value AS end_date, ";
    $sql .= "pm3.meta_value AS category_id ";
    $sql .= "FROM {$wpdb->posts} p ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm1 on p.ID = pm1.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm2 on p.ID = pm2.post_id ";
    $sql .= "LEFT JOIN {$wpdb->postmeta} pm3 on p.ID = pm3.post_id ";
    $sql .= "WHERE p.post_type = 'important_date' and p.post_status = 'publish' ";
    $sql .= "AND pm1.meta_key = '_start_date' and pm2.meta_key = '_end_date' AND pm3.meta_key = '_category_id' ";
    $sql .= "AND p.ID = %d ";
    $params = array( $id );
    $results = $wpdb->get_row( $wpdb->prepare( $sql, $params ), ARRAY_A );
    return $results;
}

/**
 * Get date format options
 * 
 * @since 1.0
 * 
 * @return array Array of date format options
 */
function wpsc_get_date_format_options()
{
    $options = array(
        'short'      => __( 'Short (Example: 11/30)', 'wp-school-calendar' ),
        'medium'     => __( 'Medium (Example: Nov 30)', 'wp-school-calendar' ),
        'long'       => __( 'Long (Example: November 30)', 'wp-school-calendar' ),
        'short-alt'  => __( 'Short Alt (Example: 30/11)', 'wp-school-calendar' ),
        'medium-alt' => __( 'Medium Alt (Example: 30 Nov)', 'wp-school-calendar' ),
        'long-alt'   => __( 'Long Alt (Example: 30 November)', 'wp-school-calendar' ),
    );
    return $options;
}

/**
 * Get weekday options
 * 
 * @since 1.0
 * 
 * @global array $wp_locale WP_Locale object
 * @return array Array of weekday options
 */
function wpsc_get_weekday_options()
{
    global  $wp_locale ;
    $weekdays = array();
    for ( $i = 0 ;  $i < 7 ;  $i = $i + 1 ) {
        $weekdays[] = $wp_locale->get_weekday( $i );
    }
    return $weekdays;
}

/**
 * Get calendar content
 * 
 * @since 1.0
 * 
 * @global array $wp_locale WP_Locale object
 * @param int $school_year_id School year ID
 * @return string Calendar content
 */
function wpsc_get_calendar_content( $school_year_id = '', $settings = array() )
{
    global  $wp_locale ;
    if ( '' === $school_year_id ) {
        $school_year_id = wpsc_settings_value( 'default_school_year' );
    }
    $school_year = wpsc_get_school_year( $school_year_id );
    $args['start_date'] = $school_year['start_date'];
    $args['end_date'] = $school_year['end_date'];
    $available_categories = wpsc_get_categories();
    $calendar_category_list = wpsc_get_calendar_category_list( $args );
    $start_date = explode( '-', $school_year['start_date'] );
    $end_date = explode( '-', $school_year['end_date'] );
    $start_month = intval( $start_date[1] );
    $start_year = intval( $start_date[0] );
    $end_month = intval( $end_date[1] );
    $end_year = intval( $end_date[0] );
    // List Month
    $list_month = array();
    
    if ( $start_year === $end_year ) {
        for ( $i = $start_month ;  $i <= $end_month ;  $i++ ) {
            $list_month[] = array(
                'year'  => $start_year,
                'month' => zeroise( $i, 2 ),
            );
        }
    } else {
        for ( $i = $start_month ;  $i <= 12 ;  $i++ ) {
            $list_month[] = array(
                'year'  => $start_year,
                'month' => zeroise( $i, 2 ),
            );
        }
        if ( $end_year - $start_year > 1 ) {
            for ( $i = $start_year + 1 ;  $i < $end_year ;  $i++ ) {
                for ( $j = 1 ;  $j <= 12 ;  $j++ ) {
                    $list_month[] = array(
                        'year'  => $i,
                        'month' => zeroise( $j, 2 ),
                    );
                }
            }
        }
        for ( $i = 1 ;  $i <= $end_month ;  $i++ ) {
            $list_month[] = array(
                'year'  => $end_year,
                'month' => zeroise( $i, 2 ),
            );
        }
    }
    
    // Important dates
    if ( isset( $settings['categories'] ) ) {
        $args['categories'] = $settings['categories'];
    }
    $important_dates = wpsc_get_important_dates( $args );
    $daily_important_dates = array();
    
    if ( $start_year === $end_year ) {
        for ( $i = $start_month ;  $i <= $end_month ;  $i++ ) {
            $days_in_month = date( 't', mktime(
                0,
                0,
                0,
                $i,
                1,
                $start_year
            ) );
            $current_month_daily_important_dates = array();
            for ( $current_date = 1 ;  $current_date <= $days_in_month ;  $current_date++ ) {
                $current_date_important_dates = array();
                foreach ( $important_dates as $important_date ) {
                    $str_date = sprintf(
                        '%s-%s-%s',
                        $start_year,
                        zeroise( $i, 2 ),
                        zeroise( $current_date, 2 )
                    );
                    if ( strtotime( $important_date['start_date'] ) <= strtotime( $str_date ) && strtotime( $important_date['end_date'] ) >= strtotime( $str_date ) ) {
                        $current_date_important_dates[] = $important_date;
                    }
                }
                $current_month_daily_important_dates[$current_date] = $current_date_important_dates;
            }
            $daily_important_dates[$start_year][$i] = $current_month_daily_important_dates;
        }
    } else {
        // Start Year
        for ( $i = $start_month ;  $i <= 12 ;  $i++ ) {
            $days_in_month = date( 't', mktime(
                0,
                0,
                0,
                $i,
                1,
                $start_year
            ) );
            $current_month_daily_important_dates = array();
            for ( $current_date = 1 ;  $current_date <= $days_in_month ;  $current_date++ ) {
                $current_date_important_dates = array();
                foreach ( $important_dates as $important_date ) {
                    $str_date = sprintf(
                        '%s-%s-%s',
                        $start_year,
                        zeroise( $i, 2 ),
                        zeroise( $current_date, 2 )
                    );
                    if ( strtotime( $important_date['start_date'] ) <= strtotime( $str_date ) && strtotime( $important_date['end_date'] ) >= strtotime( $str_date ) ) {
                        $current_date_important_dates[] = $important_date;
                    }
                }
                $current_month_daily_important_dates[$current_date] = $current_date_important_dates;
            }
            $daily_important_dates[$start_year][$i] = $current_month_daily_important_dates;
        }
        if ( $end_year - $start_year > 1 ) {
            for ( $i = $start_year + 1 ;  $i < $end_year ;  $i++ ) {
                for ( $j = 1 ;  $j <= 12 ;  $j++ ) {
                    $days_in_month = date( 't', mktime(
                        0,
                        0,
                        0,
                        $j,
                        1,
                        $i
                    ) );
                    $current_month_daily_important_dates = array();
                    for ( $current_date = 1 ;  $current_date <= $days_in_month ;  $current_date++ ) {
                        $current_date_important_dates = array();
                        foreach ( $important_dates as $important_date ) {
                            $str_date = sprintf(
                                '%s-%s-%s',
                                $i,
                                zeroise( $j, 2 ),
                                zeroise( $current_date, 2 )
                            );
                            if ( strtotime( $important_date['start_date'] ) <= strtotime( $str_date ) && strtotime( $important_date['end_date'] ) >= strtotime( $str_date ) ) {
                                $current_date_important_dates[] = $important_date;
                            }
                        }
                        $current_month_daily_important_dates[$current_date] = $current_date_important_dates;
                    }
                    $daily_important_dates[$i][$j] = $current_month_daily_important_dates;
                }
            }
        }
        // End Year
        for ( $i = 1 ;  $i <= $end_month ;  $i++ ) {
            $days_in_month = date( 't', mktime(
                0,
                0,
                0,
                $i,
                1,
                $end_year
            ) );
            $current_month_daily_important_dates = array();
            for ( $current_date = 1 ;  $current_date <= $days_in_month ;  $current_date++ ) {
                $current_date_important_dates = array();
                foreach ( $important_dates as $important_date ) {
                    $str_date = sprintf(
                        '%s-%s-%s',
                        $end_year,
                        zeroise( $i, 2 ),
                        zeroise( $current_date, 2 )
                    );
                    if ( strtotime( $important_date['start_date'] ) <= strtotime( $str_date ) && strtotime( $important_date['end_date'] ) >= strtotime( $str_date ) ) {
                        $current_date_important_dates[] = $important_date;
                    }
                }
                $current_month_daily_important_dates[$current_date] = $current_date_important_dates;
            }
            $daily_important_dates[$end_year][$i] = $current_month_daily_important_dates;
        }
    }
    
    ob_start();
    echo  '<div class="wpsc-container">' ;
    $settings_categories = ( isset( $settings['categories'] ) ? $settings['categories'] : '' );
    printf( '<input type="hidden" class="wpsc-school-year-id" value="%s">', $school_year_id );
    printf( '<input type="hidden" class="wpsc-categories" value="%s">', $settings_categories );
    printf( '<div class="wpsc-calendars wpsc-calendars-%s">', wpsc_settings_value( 'calendar_display' ) );
    foreach ( $list_month as $list ) {
        $single_month = array();
        $month_name = $wp_locale->get_month( $list['month'] );
        $single_month['year'] = $list['year'];
        $single_month['month'] = $list['month'];
        $single_month['month_name'] = $month_name;
        // Weekdays
        $weekdays = array();
        $weekday_ids = array();
        for ( $i = 0 ;  $i < 7 ;  $i++ ) {
            $weekday_ids[] = $i;
        }
        foreach ( $weekday_ids as $weekday_id ) {
            $weekday_name = $wp_locale->get_weekday( $weekday_id );
            
            if ( 'three-letter' === wpsc_settings_value( 'day_format' ) ) {
                $weekday_name = $wp_locale->get_weekday_abbrev( $weekday_name );
            } elseif ( 'one-letter' === wpsc_settings_value( 'day_format' ) ) {
                $weekday_name = $wp_locale->get_weekday_initial( $weekday_name );
            }
            
            $weekdays[] = array(
                'weekday'      => $weekday_id,
                'weekday_name' => $weekday_name,
            );
        }
        $single_month['weekdays'] = $weekdays;
        // Days in a Week
        $current_date = 1;
        $weekday_number = date( 'w', mktime(
            0,
            0,
            0,
            $list['month'],
            $current_date,
            $list['year']
        ) );
        $days_in_month = date( 't', mktime(
            0,
            0,
            0,
            $list['month'],
            1,
            $list['year']
        ) );
        
        if ( $list['month'] > 1 ) {
            $days_in_before_month = date( 't', mktime(
                0,
                0,
                0,
                $list['month'] - 1,
                1,
                $list['year']
            ) );
        } else {
            $days_in_before_month = date( 't', mktime(
                0,
                0,
                0,
                12,
                1,
                $list['year'] - 1
            ) );
        }
        
        $start = false;
        $prev_date = $days_in_before_month;
        $next_date = 1;
        foreach ( $weekday_ids as $weekday_id ) {
            if ( (int) $weekday_id === (int) $weekday_number ) {
                break;
            }
            $prev_date--;
        }
        for ( $i = 0 ;  $i < 6 ;  $i++ ) {
            $week_dates = array();
            foreach ( $weekday_ids as $weekday_id ) {
                if ( (int) $weekday_id === (int) $weekday_number ) {
                    $start = true;
                }
                
                if ( $start && $current_date <= $days_in_month ) {
                    $current_weekday_number = date( 'w', mktime(
                        0,
                        0,
                        0,
                        $list['month'],
                        $current_date,
                        $list['year']
                    ) );
                    $year = intval( $list['year'] );
                    $month = intval( $list['month'] );
                    $week_dates[] = array(
                        'content'                 => $current_date,
                        'group'                   => 'general-date',
                        'weekday_number'          => $current_weekday_number,
                        'current_important_dates' => $daily_important_dates[$year][$month][$current_date],
                    );
                    $current_date++;
                } else {
                    
                    if ( $start ) {
                        $current_prevnext_date = $next_date++;
                        
                        if ( $list['month'] > 1 ) {
                            $current_weekday_number = date( 'w', mktime(
                                0,
                                0,
                                0,
                                $list['month'] + 1,
                                $current_prevnext_date,
                                $list['year']
                            ) );
                        } else {
                            $current_weekday_number = date( 'w', mktime(
                                0,
                                0,
                                0,
                                12,
                                $current_prevnext_date,
                                $list['year'] - 1
                            ) );
                        }
                        
                        $week_dates[] = array(
                            'content'        => $current_prevnext_date,
                            'group'          => 'prevnext-date',
                            'weekday_number' => $current_weekday_number,
                        );
                    } else {
                        $current_prevnext_date = ++$prev_date;
                        
                        if ( $list['month'] > 1 ) {
                            $current_weekday_number = date( 'w', mktime(
                                0,
                                0,
                                0,
                                $list['month'] + 1,
                                $current_prevnext_date,
                                $list['year']
                            ) );
                        } else {
                            $current_weekday_number = date( 'w', mktime(
                                0,
                                0,
                                0,
                                12,
                                $current_prevnext_date,
                                $list['year'] - 1
                            ) );
                        }
                        
                        $week_dates[] = array(
                            'content'        => $current_prevnext_date,
                            'group'          => 'prevnext-date',
                            'weekday_number' => $current_weekday_number,
                        );
                    }
                
                }
            
            }
            $single_month['week_dates'][] = $week_dates;
        }
        printf( '<div class="wpsc-calendar wpsc-calendar-%s-%s">', $list['year'], $list['month'] );
        echo  '<div class="wpsc-calendar-inner">' ;
        printf( '<div class="wpsc-calendar-heading"><span class="wpsc-calendar-heading-month">%s</span> <span class="wpsc-calendar-heading-year">%s</span></div>', $single_month['month_name'], $list['year'] );
        echo  '<table>' ;
        echo  '<tbody>' ;
        echo  '<tr>' ;
        foreach ( $single_month['weekdays'] as $weekday ) {
            
            if ( !in_array( $weekday['weekday'], wpsc_settings_value( 'weekday' ) ) ) {
                $class = sprintf( 'wpsc-calendar-weekday wpsc-calendar-weekday-%s wpsc-calendar-weekend', $weekday['weekday'] );
            } else {
                $class = sprintf( 'wpsc-calendar-weekday wpsc-calendar-weekday-%s', $weekday['weekday'] );
            }
            
            printf( '<td><div class="%s">%s</div></td>', $class, $weekday['weekday_name'] );
        }
        echo  '</tr>' ;
        foreach ( $single_month['week_dates'] as $data_row ) {
            echo  '<tr>' ;
            foreach ( $data_row as $column ) {
                $date_attr = array();
                $date_class = array( sprintf( 'wpsc-calendar-%s', $column['group'] ), sprintf( 'wpsc-calendar-weekday-%s', $column['weekday_number'] ) );
                if ( !in_array( $column['weekday_number'], wpsc_settings_value( 'weekday' ) ) ) {
                    $date_class[] = 'wpsc-calendar-weekend';
                }
                
                if ( empty($column['current_important_dates']) ) {
                } else {
                    $categories = array();
                    foreach ( $column['current_important_dates'] as $important_date ) {
                        
                        if ( 'Y' === $important_date['exclude_weekend'] && !in_array( $column['weekday_number'], wpsc_settings_value( 'weekday' ) ) ) {
                        } else {
                            $date_class[] = sprintf( 'wpsc-calendar-important-date wpsc-calendar-important-date-%s', $important_date['post_id'] );
                            $categories[] = $important_date['category_id'];
                        }
                    
                    }
                    
                    if ( count( $categories ) > 0 ) {
                        $categories = array_unique( $categories );
                        sort( $categories );
                        $date_class[] = sprintf( 'wpsc-important-date-tooltip wpsc-important-date-category-%s', implode( '-', $categories ) );
                    }
                    
                    if ( count( $categories ) > 1 ) {
                        $date_attr[] = sprintf( 'style="%s"', wpsc_get_important_date_multi_colors( $categories ) );
                    }
                }
                
                $date_class = apply_filters( 'wpsc_calendar_date_class', $date_class );
                $date_attr = apply_filters( 'wpsc_calendar_date_attr', $date_attr );
                echo  '<td>' ;
                printf(
                    '<div class="%s" %s>%s</div>',
                    implode( ' ', $date_class ),
                    implode( ' ', $date_attr ),
                    $column['content']
                );
                echo  '</td>' ;
            }
            echo  '</tr>' ;
        }
        echo  '</tbody>' ;
        echo  '</table>' ;
        echo  '</div>' ;
        echo  '</div>' ;
    }
    echo  '</div>' ;
    // Powered by "WP School Calendar"
    
    // if ( 'Y' === wpsc_settings_value( 'credit' ) ) {
    //     echo  '<div class="wpsc-credit">' ;
    //     printf( __( 'Powered by <a href="%s" target="_blank">WP School Calendar</a>', 'wp-school-calendar' ), 'https://wpschoolcalendar.com' );
    //     echo  '</div>' ;
    // }
    
    // Important Date Categories
    $important_date_categories = array();
    foreach ( $important_dates as $important_date ) {
        $important_date_categories[] = $important_date['category_id'];
    }
    $important_date_categories = array_unique( $important_date_categories );
    echo  '<div class="wpsc-category-listings">' ;
    foreach ( $available_categories as $category ) {
        
        if ( in_array( $category['category_id'], $important_date_categories ) ) {
            echo  '<div class="wpsc-category-listing">' ;
            printf( '<span class="wpsc-category-listing-color" style="background:%s;"></span>', $category['bgcolor'] );
            printf( '<span class="wpsc-category-listing-name">%s</span>', $category['name'] );
            echo  '</div>' ;
        }
    
    }
    echo  '</div>' ;
    // Important Date Listings
    echo  '<div class="wpsc-important-date-listings">' ;
    printf( '<h3 class="wpsc-important-date-listings-heading">%s</h3>', wpsc_settings_value( 'important_date_heading' ) );
    
    if ( empty($important_dates) ) {
        printf( '<div class="wpsc-no-important-date">%s</div>', esc_html__( 'No Important Date', 'wp-school-calendar' ) );
    } else {
        foreach ( $important_dates as $important_date ) {
            printf( '<div class="wpsc-important-date-item wpsc-important-date-category-%s">', $important_date['category_id'] );
            echo  '<div class="wpsc-important-date-item-inner">' ;
            $date = wpsc_format_date(
                $important_date['start_date'],
                $important_date['end_date'],
                wpsc_settings_value( 'date_format' ),
                wpsc_settings_value( 'show_year' )
            );
            printf( '<div class="wpsc-important-date-date">%s</div>', $date );
            printf( '<div class="wpsc-important-date-title">%s</div>', $important_date['important_date_title'] );
            echo  '</div>' ;
            echo  '</div>' ;
        }
    }
    
    echo  '</div>' ;
    echo  '</div>' ;
    return ob_get_clean();
}

/**
 * Get important date single color
 * 
 * @since 1.0
 * 
 * @return string Important date color style
 */
function wpsc_get_important_date_single_color()
{
    $categories = wpsc_get_categories();
    $css = array();
    foreach ( $categories as $category ) {
        $css[] = sprintf(
            '#wpsc-block-calendar .wpsc-important-date-category-%s, .wpsc-important-date-category-%s {background:%s;color:#fff;}' . "\n",
            $category['category_id'],
            $category['category_id'],
            $category['bgcolor']
        );
    }
    return implode( '', $css );
}

/**
 * Get important date multi colors
 * 
 * @since 1.0
 * 
 * @param array $categories Array of important date categories
 * @return string Important date color style
 */
function wpsc_get_important_date_multi_colors( $categories = array() )
{
    if ( $categories === array() ) {
        return;
    }
    $tmp_all_categories = wpsc_get_categories();
    $all_categories = array();
    foreach ( $tmp_all_categories as $category ) {
        $id = $category['category_id'];
        $all_categories[$id] = $category;
    }
    $num_categories = count( $categories );
    $css = '';
    // Two colors
    if ( $num_categories === 2 ) {
        
        if ( $categories[0] === $categories[1] ) {
        } else {
            $background = 'data:image/svg+xml;base64,' . base64_encode( sprintf( '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" height="100" width="100"><polygon points="0,100 0,0 100,0" style="fill:%s;stroke:none;" /><polygon points="0,100 100,100 100,0" style="fill:%s;stroke:none;" /></svg>', $all_categories[$categories[0]]['bgcolor'], $all_categories[$categories[1]]['bgcolor'] ) );
            $css = sprintf(
                "background:url('%s') center no-repeat;background-size:%s;-ms-background-size:%s;-o-background-size:%s;-moz-background-size:%s;-webkit-background-size:%s;color:#fff;",
                $background,
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%'
            );
        }
    
    }
    // Three Colors
    if ( $num_categories === 3 ) {
        
        if ( $categories[0] === $categories[1] && $categories[1] === $categories[2] ) {
        } else {
            $background = 'data:image/svg+xml;base64,' . base64_encode( sprintf(
                '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" height="100" width="100"><polygon points="0,100 0,0 100,0" style="fill:%s;stroke:none;" /><polygon points="0,100 100,100 50,50" style="fill:%s;stroke:none;" /><polygon points="100,0 100,100 50,50" style="fill:%s;stroke:none;" /></svg>',
                $all_categories[$categories[0]]['bgcolor'],
                $all_categories[$categories[1]]['bgcolor'],
                $all_categories[$categories[2]]['bgcolor']
            ) );
            $css = sprintf(
                "background:url('%s') center no-repeat;background-size:%s;-ms-background-size:%s;-o-background-size:%s;-moz-background-size:%s;-webkit-background-size:%s;color:#fff;",
                $background,
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%'
            );
        }
    
    }
    // Four Colors
    if ( $num_categories === 4 ) {
        
        if ( $categories[0] === $categories[1] && $categories[1] === $categories[2] && $categories[2] === $categories[3] ) {
        } else {
            $background = 'data:image/svg+xml;base64,' . base64_encode( sprintf(
                '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" height="100" width="100"><polygon points="0,0 0,100 50,50" style="fill:%s;stroke:none;" /><polygon points="0,0 100,0 50,50" style="fill:%s;stroke:none;" /><polygon points="100,0 100,100 50,50" style="fill:%s;stroke:none;" /><polygon points="0,100 100,100 50,50" style="fill:%s;stroke:none;" /></svg>',
                $all_categories[$categories[0]]['bgcolor'],
                $all_categories[$categories[1]]['bgcolor'],
                $all_categories[$categories[2]]['bgcolor'],
                $all_categories[$categories[3]]['bgcolor']
            ) );
            $css = sprintf(
                "background:url('%s') center no-repeat;background-size:%s;-ms-background-size:%s;-o-background-size:%s;-moz-background-size:%s;-webkit-background-size:%s;color:#fff;",
                $background,
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%'
            );
        }
    
    }
    // Five Colors
    if ( $num_categories === 5 ) {
        
        if ( $categories[0] === $categories[1] && $categories[1] === $categories[2] && $categories[2] === $categories[3] && $categories[3] === $categories[4] ) {
        } else {
            $background = 'data:image/svg+xml;base64,' . base64_encode( sprintf(
                '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" height="100" width="100"><polygon points="0,0 25,25 25,75 0,100" style="fill:%s;stroke:none;" /><polygon points="0,0 25,25 75,25 100,0" style="fill:%s;stroke:none;" /><polygon points="100,0 75,25 75,75 100,100" style="fill:%s;stroke:none;" /><polygon points="0,100 25,75 75,75 100,100" style="fill:%s;stroke:none;" /><polygon points="25,25 75,25 75,75 25,75" style="fill:%s;stroke:none;" /></svg>',
                $all_categories[$categories[0]]['bgcolor'],
                $all_categories[$categories[1]]['bgcolor'],
                $all_categories[$categories[2]]['bgcolor'],
                $all_categories[$categories[3]]['bgcolor'],
                $all_categories[$categories[4]]['bgcolor']
            ) );
            $css = sprintf(
                "background:url('%s') center no-repeat;background-size:%s;-ms-background-size:%s;-o-background-size:%s;-moz-background-size:%s;-webkit-background-size:%s;color:#fff;",
                $background,
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%',
                '100% 100%'
            );
        }
    
    }
    return $css;
}

/**
 * Get formatted date
 * 
 * @since 1.0
 * 
 * @global array $wp_locale
 * @param string $start_date  Start date
 * @param string $end_date    End date
 * @param string $date_format Date format
 * @param string $show_year   Show year or not
 * @return string Formatted date
 */
function wpsc_format_date(
    $start_date,
    $end_date,
    $date_format,
    $show_year
)
{
    global  $wp_locale ;
    $formatted_date = '';
    if ( '' !== $start_date && '' !== $end_date ) {
        
        if ( $start_date === $end_date ) {
            $start_date = explode( '-', $start_date );
            
            if ( 'short' === $date_format ) {
                
                if ( 'Y' === $show_year ) {
                    $formatted_date .= sprintf(
                        '%s/%s/%s',
                        $start_date[1],
                        $start_date[2],
                        $start_date[0]
                    );
                } else {
                    $formatted_date .= sprintf( '%s/%s', $start_date[1], $start_date[2] );
                }
            
            } elseif ( 'medium' === $date_format ) {
                
                if ( 'Y' === $show_year ) {
                    $formatted_date .= sprintf(
                        '%s %s, %s',
                        $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                        (int) $start_date[2],
                        $start_date[0]
                    );
                } else {
                    $formatted_date .= sprintf( '%s %s', $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ), (int) $start_date[2] );
                }
            
            } elseif ( 'long' === $date_format ) {
                
                if ( 'Y' === $show_year ) {
                    $formatted_date .= sprintf(
                        '%s %s, %s',
                        $wp_locale->get_month( $start_date[1] ),
                        (int) $start_date[2],
                        $start_date[0]
                    );
                } else {
                    $formatted_date .= sprintf( '%s %s', $wp_locale->get_month( $start_date[1] ), (int) $start_date[2] );
                }
            
            } elseif ( 'short-alt' === $date_format ) {
                
                if ( 'Y' === $show_year ) {
                    $formatted_date .= sprintf(
                        '%s/%s/%s',
                        $start_date[2],
                        $start_date[1],
                        $start_date[0]
                    );
                } else {
                    $formatted_date .= sprintf( '%s/%s', $start_date[2], $start_date[1] );
                }
            
            } elseif ( 'medium-alt' === $date_format ) {
                
                if ( 'Y' === $show_year ) {
                    $formatted_date .= sprintf(
                        '%s %s %s',
                        (int) $start_date[2],
                        $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                        $start_date[0]
                    );
                } else {
                    $formatted_date .= sprintf( '%s %s', (int) $start_date[2], $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ) );
                }
            
            } elseif ( 'long-alt' === $date_format ) {
                
                if ( 'Y' === $show_year ) {
                    $formatted_date .= sprintf(
                        '%s %s %s',
                        (int) $start_date[2],
                        $wp_locale->get_month( $start_date[1] ),
                        $start_date[0]
                    );
                } else {
                    $formatted_date .= sprintf( '%s %s', (int) $start_date[2], $wp_locale->get_month( $start_date[1] ) );
                }
            
            }
        
        } else {
            $start_date = explode( '-', $start_date );
            $end_date = explode( '-', $end_date );
            
            if ( $start_date[0] === $end_date[0] ) {
                // Same Year
                
                if ( $start_date[1] === $end_date[1] ) {
                    // Same Month
                    
                    if ( 'short' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s/%s/%s - %s/%s/%s',
                                $start_date[1],
                                $start_date[2],
                                $start_date[0],
                                $end_date[1],
                                $end_date[2],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s/%s - %s/%s',
                                $start_date[1],
                                $start_date[2],
                                $end_date[1],
                                $end_date[2]
                            );
                        }
                    
                    } elseif ( 'medium' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s %s - %s, %s',
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                (int) $start_date[2],
                                (int) $end_date[2],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s %s - %s',
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                (int) $start_date[2],
                                (int) $end_date[2]
                            );
                        }
                    
                    } elseif ( 'long' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s %s - %s, %s',
                                $wp_locale->get_month( $start_date[1] ),
                                (int) $start_date[2],
                                (int) $end_date[2],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s %s - %s',
                                $wp_locale->get_month( $start_date[1] ),
                                (int) $start_date[2],
                                (int) $end_date[2]
                            );
                        }
                    
                    } elseif ( 'short-alt' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s/%s/%s - %s/%s/%s',
                                $start_date[2],
                                $start_date[1],
                                $start_date[0],
                                $end_date[2],
                                $start_date[1],
                                $start_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s/%s - %s/%s',
                                $start_date[2],
                                $start_date[1],
                                $end_date[2],
                                $start_date[1]
                            );
                        }
                    
                    } elseif ( 'medium-alt' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s - %s %s %s',
                                (int) $start_date[2],
                                (int) $end_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                $start_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s - %s %s',
                                (int) $start_date[2],
                                (int) $end_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) )
                            );
                        }
                    
                    } elseif ( 'long-alt' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s - %s %s %s',
                                (int) $start_date[2],
                                (int) $end_date[2],
                                $wp_locale->get_month( $start_date[1] ),
                                $start_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s - %s %s',
                                (int) $start_date[2],
                                (int) $end_date[2],
                                $wp_locale->get_month( $start_date[1] )
                            );
                        }
                    
                    }
                
                } else {
                    
                    if ( 'short' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s/%s/%s - %s/%s/%s',
                                $start_date[1],
                                $start_date[2],
                                $start_date[0],
                                $end_date[1],
                                $end_date[2],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s/%s - %s/%s',
                                $start_date[1],
                                $start_date[2],
                                $end_date[1],
                                $end_date[2]
                            );
                        }
                    
                    } elseif ( 'medium' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s, %s',
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                (int) $start_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) ),
                                (int) $end_date[2],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s',
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                (int) $start_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) ),
                                (int) $end_date[2]
                            );
                        }
                    
                    } elseif ( 'long' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s, %s',
                                $wp_locale->get_month( $start_date[1] ),
                                (int) $start_date[2],
                                $wp_locale->get_month( $end_date[1] ),
                                (int) $end_date[2],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s',
                                $wp_locale->get_month( $start_date[1] ),
                                (int) $start_date[2],
                                $wp_locale->get_month( $end_date[1] ),
                                (int) $end_date[2]
                            );
                        }
                    
                    } elseif ( 'short-alt' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s/%s/%s - %s/%s/%s',
                                $start_date[2],
                                $start_date[1],
                                $start_date[0],
                                $end_date[2],
                                $end_date[1],
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s/%s - %s/%s',
                                $start_date[2],
                                $start_date[1],
                                $end_date[2],
                                $end_date[1]
                            );
                        }
                    
                    } elseif ( 'medium-alt' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s %s',
                                (int) $start_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                (int) $end_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) ),
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s',
                                (int) $start_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                                (int) $end_date[2],
                                $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) )
                            );
                        }
                    
                    } elseif ( 'long-alt' === $date_format ) {
                        
                        if ( 'Y' === $show_year ) {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s %s',
                                (int) $start_date[2],
                                $wp_locale->get_month( $start_date[1] ),
                                (int) $end_date[2],
                                $wp_locale->get_month( $end_date[1] ),
                                $end_date[0]
                            );
                        } else {
                            $formatted_date .= sprintf(
                                '%s %s - %s %s',
                                (int) $start_date[2],
                                $wp_locale->get_month( $start_date[1] ),
                                (int) $end_date[2],
                                $wp_locale->get_month( $end_date[1] )
                            );
                        }
                    
                    }
                
                }
            
            } else {
                
                if ( 'short' === $date_format ) {
                    
                    if ( 'Y' === $show_year ) {
                        $formatted_date .= sprintf(
                            '%s/%s/%s - %s/%s/%s',
                            $start_date[1],
                            $start_date[2],
                            $start_date[0],
                            $end_date[1],
                            $end_date[2],
                            $end_date[0]
                        );
                    } else {
                        $formatted_date .= sprintf(
                            '%s/%s - %s/%s',
                            $start_date[1],
                            $start_date[2],
                            $end_date[1],
                            $end_date[2]
                        );
                    }
                
                } elseif ( 'medium' === $date_format ) {
                    
                    if ( 'Y' === $show_year ) {
                        $formatted_date .= sprintf(
                            '%s %s, %s - %s %s, %s',
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                            (int) $start_date[2],
                            $start_date[0],
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) ),
                            (int) $end_date[2],
                            $end_date[0]
                        );
                    } else {
                        $formatted_date .= sprintf(
                            '%s %s - %s %s',
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                            (int) $start_date[2],
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) ),
                            (int) $end_date[2]
                        );
                    }
                
                } elseif ( 'long' === $date_format ) {
                    
                    if ( 'Y' === $show_year ) {
                        $formatted_date .= sprintf(
                            '%s %s, %s - %s %s, %s',
                            $wp_locale->get_month( $start_date[1] ),
                            (int) $start_date[2],
                            $start_date[0],
                            $wp_locale->get_month( $end_date[1] ),
                            (int) $end_date[2],
                            $end_date[0]
                        );
                    } else {
                        $formatted_date .= sprintf(
                            '%s %s - %s %s',
                            $wp_locale->get_month( $start_date[1] ),
                            (int) $start_date[2],
                            $wp_locale->get_month( $end_date[1] ),
                            (int) $end_date[2]
                        );
                    }
                
                } elseif ( 'short-alt' === $date_format ) {
                    
                    if ( 'Y' === $show_year ) {
                        $formatted_date .= sprintf(
                            '%s/%s/%s - %s/%s/%s',
                            $start_date[2],
                            $start_date[1],
                            $start_date[0],
                            $end_date[2],
                            $end_date[1],
                            $end_date[0]
                        );
                    } else {
                        $formatted_date .= sprintf(
                            '%s/%s - %s/%s',
                            $start_date[2],
                            $start_date[1],
                            $end_date[2],
                            $end_date[1]
                        );
                    }
                
                } elseif ( 'medium-alt' === $date_format ) {
                    
                    if ( 'Y' === $show_year ) {
                        $formatted_date .= sprintf(
                            '%s %s %s - %s %s %s',
                            (int) $start_date[2],
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                            $start_date[0],
                            (int) $end_date[2],
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) ),
                            $end_date[0]
                        );
                    } else {
                        $formatted_date .= sprintf(
                            '%s %s - %s %s',
                            (int) $start_date[2],
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $start_date[1] ) ),
                            (int) $end_date[2],
                            $wp_locale->get_month_abbrev( $wp_locale->get_month( $end_date[1] ) )
                        );
                    }
                
                } elseif ( 'long-alt' === $date_format ) {
                    
                    if ( 'Y' === $show_year ) {
                        $formatted_date .= sprintf(
                            '%s %s %s - %s %s %s',
                            (int) $start_date[2],
                            $wp_locale->get_month( $start_date[1] ),
                            $start_date[0],
                            (int) $end_date[2],
                            $wp_locale->get_month( $end_date[1] ),
                            $end_date[0]
                        );
                    } else {
                        $formatted_date .= sprintf(
                            '%s %s - %s %s',
                            (int) $start_date[2],
                            $wp_locale->get_month( $start_date[1] ),
                            (int) $end_date[2],
                            $wp_locale->get_month( $end_date[1] )
                        );
                    }
                
                }
            
            }
        
        }
    
    }
    return $formatted_date;
}

/**
 * Get tooltip theme options
 * 
 * @since 1.0
 * 
 * @return array Array of tooltip theme options
 */
function wpsc_get_tooltip_theme_options()
{
    return array(
        'borderless' => __( 'Borderless', 'wp-school-calendar' ),
        'light'      => __( 'Light', 'wp-school-calendar' ),
        'noir'       => __( 'Noir', 'wp-school-calendar' ),
        'punk'       => __( 'Punk', 'wp-school-calendar' ),
        'shadow'     => __( 'Shadow', 'wp-school-calendar' ),
    );
}

function wpsc_get_tooltip_animation_options()
{
    return array(
        'fade'  => __( 'Fade', 'wp-school-calendar' ),
        'grow'  => __( 'Grow', 'wp-school-calendar' ),
        'swing' => __( 'Swing', 'wp-school-calendar' ),
        'slide' => __( 'Slide', 'wp-school-calendar' ),
        'fall'  => __( 'Fall', 'wp-school-calendar' ),
    );
}

/**
 * Get tooltip trigger options
 * 
 * @since 1.0
 * 
 * @return array Array of tooltip trigger options
 */
function wpsc_get_tooltip_trigger_options()
{
    return array(
        'hover' => __( 'Hover', 'wp-school-calendar' ),
        'click' => __( 'Click', 'wp-school-calendar' ),
    );
}

/**
 * Get calendar display options
 * 
 * @since 1.0
 * 
 * @return array Array of calendar display options
 */
function wpsc_get_calendar_display_options()
{
    return array(
        'two-columns'   => __( 'Two Columns Calendar', 'wp-school-calendar' ),
        'three-columns' => __( 'Three Columns Calendar', 'wp-school-calendar' ),
        'four-columns'  => __( 'Four Columns Calendar', 'wp-school-calendar' ),
    );
}

/**
 * Get day format options
 * 
 * @since 1.0
 * 
 * @return array Array of day format options
 */
function wpsc_get_day_format_options()
{
    return array(
        'one-letter'   => __( 'One Letter', 'wp-school-calendar' ),
        'three-letter' => __( 'Three Letter', 'wp-school-calendar' ),
        'full-name'    => __( 'Full Name', 'wp-school-calendar' ),
    );
}

/**
 * Convert HEX color to RGB
 * 
 * @since 1.0
 * 
 * @param string $color HEX color to be convert
 * @return array Converted RGB color
 */
function wpsc_hex2rgb( $color )
{
    $color = trim( $color, '#' );
    
    if ( strlen( $color ) === 3 ) {
        $r = hexdec( substr( $color, 0, 1 ) . substr( $color, 0, 1 ) );
        $g = hexdec( substr( $color, 1, 1 ) . substr( $color, 1, 1 ) );
        $b = hexdec( substr( $color, 2, 1 ) . substr( $color, 2, 1 ) );
    } else {
        
        if ( strlen( $color ) === 6 ) {
            $r = hexdec( substr( $color, 0, 2 ) );
            $g = hexdec( substr( $color, 2, 2 ) );
            $b = hexdec( substr( $color, 4, 2 ) );
        } else {
            return array();
        }
    
    }
    
    return array(
        'red'   => $r,
        'green' => $g,
        'blue'  => $b,
    );
}
