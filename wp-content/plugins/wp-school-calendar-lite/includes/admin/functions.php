<?php
/**
 * Add new important date category
 * 
 * @since 1.0
 * 
 * @param array $args Array of arguments
 * @return int Category ID
 */
function wpsc_add_new_category( $args ) {
    $category_id = wp_insert_post( array( 
        'post_type'   => 'important_date_cat',
        'post_title'  => $args['name'],
        'post_status' => 'publish'
    ) );
    
    update_post_meta( $category_id, '_bgcolor', $args['bgcolor'] );
    
    return $category_id;
}

/**
 * Delete important date category
 * 
 * @since 1.0
 * 
 * @global wpdb $wpdb wpdb object
 * @param int $category_id Category ID
 * @return boolean True if success
 */
function wpsc_delete_category( $category_id ) {
    global $wpdb;
    
    $default_category = wpsc_settings_value( 'default_category' );
    
    $data = array(
        'meta_value' => $default_category
    );
    
    $where = array(
        'meta_key'   => '_category_id',
        'meta_value' => $category_id
    );
    
    $wpdb->update( $wpdb->postmeta, $data, $where, array( '%d' ), array( '%s', '%d' ) );
    
    wp_delete_post( $category_id, true );
    
    return true;
}

/**
 * Save important date category
 * 
 * @since 1.0
 * 
 * @param array $args Array of arguments
 * @return boolean True if success
 */
function wpsc_save_category( $args ) {
    wp_update_post( array(
        'ID'         => $args['category_id'],
        'post_title' => $args['name'],
    ) );
    
    update_post_meta( $args['category_id'], '_bgcolor', $args['bgcolor'] );
    
    return true;
}

/**
 * Add new school year
 * 
 * @since 1.0
 * 
 * @param array $args Array of arguments
 * @return int School year ID
 */
function wpsc_add_new_school_year( $args ) {
    $year_name = '' === $args['end_year'] ? $args['start_year'] : sprintf( '%s - %s', $args['start_year'], $args['end_year'] );
    
    $school_year_id = wp_insert_post( array( 
        'post_type'   => 'school_year',
        'post_title'  => $year_name,
        'post_status' => 'publish'
    ) );
    
    update_post_meta( $school_year_id, '_start_year', $args['start_year'] );
    update_post_meta( $school_year_id, '_end_year', $args['end_year'] );
    update_post_meta( $school_year_id, '_start_date', $args['start_date'] );
    update_post_meta( $school_year_id, '_end_date', $args['end_date'] );
    update_post_meta( $school_year_id, '_enable', $args['enable'] );
    
    return $school_year_id;
}

/**
 * Delete school year
 * 
 * @since 1.0
 * 
 * @param int $school_year_id School year ID
 * @return boolean True if success
 */
function wpsc_delete_school_year( $school_year_id ) {
    wp_delete_post( $school_year_id, true );
    return true;
}

/**
 * Save school year
 * 
 * @since 1.0
 * 
 * @param array $args Array of arguments
 * @return boolean True if success
 */
function wpsc_save_school_year( $args ) {
    $year_name = '' === $args['end_year'] ? $args['start_year'] : sprintf( '%s - %s', $args['start_year'], $args['end_year'] );
    
    wp_update_post( array(
        'ID'         => $args['school_year_id'],
        'post_title' => $year_name,
    ) );
    
    update_post_meta( $args['school_year_id'], '_start_year', $args['start_year'] );
    update_post_meta( $args['school_year_id'], '_end_year', $args['end_year'] );
    update_post_meta( $args['school_year_id'], '_start_date', $args['start_date'] );
    update_post_meta( $args['school_year_id'], '_end_date', $args['end_date'] );
    update_post_meta( $args['school_year_id'], '_enable', $args['enable'] );
    
    return true;
}

function wpsc_create_initial_options() {
    $school_year_id = wp_insert_post( array( 
        'post_type'   => 'school_year',
        'post_title'  => '2020 - 2021',
        'post_status' => 'publish'
    ) );

    update_post_meta( $school_year_id, '_start_year', '2020' );
    update_post_meta( $school_year_id, '_end_year', '2021' );
    update_post_meta( $school_year_id, '_start_date', '2020-07-01' );
    update_post_meta( $school_year_id, '_end_date', '2021-06-30' );
    update_post_meta( $school_year_id, '_enable', 'Y' );
    
    $category_id = wp_insert_post( array( 
        'post_type'   => 'important_date_cat',
        'post_title'  => __( 'General Events', 'wp-school-calendar' ),
        'post_status' => 'publish'
    ) );

    update_post_meta( $category_id, '_bgcolor', '#006680' );
    
    $options = wpsc_get_default_settings();
    
    $options['default_category']    = $category_id;
    $options['default_school_year'] = $school_year_id;
    
    update_option( 'wpsc_options', $options );
    flush_rewrite_rules();
}

function wpsc_upgrade_34() {
    $calendar_page_id  = wpsc_settings_value( 'calendar_page' );
    $ori_calendar_page = get_post( $calendar_page_id );
    
    $post_content = $ori_calendar_page->post_content . '[wp_school_calendar]';
    
    wp_update_post( array(
        'ID'           => $calendar_page_id,
        'post_content' => $post_content,
    ) );
}

/**
 * Upgrade DB
 * 
 * @since 3.2
 * 
 * @global wpdb $wpdb
 */
function wpsc_upgrade_32() {
    global $wpdb;

    $sql  = "SELECT p.ID AS post_id FROM {$wpdb->posts} p ";
    $sql .= "WHERE p.post_type = 'important_date' AND p.post_status IN ('publish', 'draft') ";
    
    $results = $wpdb->get_results( $sql, ARRAY_A );
    
    // Delete old post meta
    
    $post_ids = array();
    
    foreach ( $results as $result ) {
        $post_ids[] = $result['post_id'];
    }
    
    $post_ids = implode( ',', $post_ids );
    
    $sql = "DELETE FROM {$wpdb->postmeta} WHERE meta_key = '_exclude_weekend' AND post_id IN ({$post_ids})";
    $wpdb->query( $sql );
    
    // Create post meta
    
    $data_values = array();
    $data_params = array();
    
    $sql = "INSERT INTO {$wpdb->postmeta} (post_id, meta_key, meta_value) VALUES ";
    
    foreach ( $results as $result ) {
        $data_params[] = '(%d, %s, %s)';
        
        $data_values[] = $result['post_id'];
        $data_values[] = '_exclude_weekend';
        $data_values[] = 'Y';
    }
    
    $sql .= implode( ',', $data_params );
    $wpdb->query( $wpdb->prepare( $sql, $data_values ) );
}
