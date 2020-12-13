<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WP_School_Calendar_Post_Type {

    private static $_instance = NULL;
    
    /**
     * Initialize all variables, filters and actions
     */
    public function __construct() {
        add_action( 'init',                                      array( $this, 'register_post_type' ) );
        add_action( 'manage_important_date_posts_custom_column', array( $this, 'render_important_date_columns' ), 10, 2 );
        add_action( 'restrict_manage_posts',                     array( $this, 'restrict_manage_posts' ) );
        add_action( 'admin_head',                                array( $this, 'remove_date_dropdown' ) );
        add_action( 'admin_print_scripts',                       array( $this, 'disable_autosave' ) );
        
        add_filter( 'manage_important_date_posts_columns',         array( $this, 'important_date_columns' ) );
        add_filter( 'manage_edit-important_date_sortable_columns', array( $this, 'important_date_sortable_columns' ) );
        add_filter( 'bulk_actions-edit-important_date',            array( $this, 'important_date_bulk_actions' ) );
        add_filter( 'post_updated_messages',                       array( $this, 'post_updated_messages' ) );
        add_filter( 'bulk_post_updated_messages',                  array( $this, 'bulk_post_updated_messages' ), 10, 2 );
        add_filter( 'post_row_actions',                            array( $this, 'row_actions' ), 100, 2 );
        add_filter( 'enter_title_here',                            array( $this, 'enter_title_here' ), 1, 2 );
        add_filter( 'request',                                     array( $this, 'request_query' ) );
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
     * Register custom post types and taxonomy
     * 
     * @since 1.0
     */
    public function register_post_type() {
        register_post_type( 'school_year', apply_filters( 'wpsc_register_post_type_school_year', array(
            'public'              => false,
            'show_ui'             => false,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'hierarchical'        => false,
            'rewrite'             => false,
            'has_archive'         => false,
            'query_var'           => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false
        ) ) );
        
        register_post_type( 'important_date', apply_filters( 'wpsc_register_post_type_important_date', array(
            'labels' => array(
                'name'                  => __( 'Important Dates', 'wp-school-calendar' ),
                'singular_name'         => __( 'Important Date', 'wp-school-calendar' ),
                'menu_name'             => _x( 'School Calendar', 'Admin menu name', 'wp-school-calendar' ),
                'add_new'               => __( 'Add New Date', 'wp-school-calendar' ),
                'add_new_item'          => __( 'Add New Important Date', 'wp-school-calendar' ),
                'edit'                  => __( 'Edit', 'wp-school-calendar' ),
                'edit_item'             => __( 'Edit Important Date', 'wp-school-calendar' ),
                'new_item'              => __( 'New Important Date', 'wp-school-calendar' ),
                'all_items'             => __( 'Important Dates', 'wp-school-calendar' ),
                'view'                  => __( 'View Important Date', 'wp-school-calendar' ),
                'view_item'             => __( 'View Important Date', 'wp-school-calendar' ),
                'search_items'          => __( 'Search Important Date', 'wp-school-calendar' ),
                'not_found'             => __( 'No important date found', 'wp-school-calendar' ),
                'not_found_in_trash'    => __( 'No important date found in trash', 'wp-school-calendar' ),
                'parent'                => __( 'Parent Important Date', 'wp-school-calendar' ),
                'featured_image'        => __( 'Featured Image', 'wp-school-calendar' ),
                'set_featured_image'    => __( 'Set Featured Image', 'wp-school-calendar' ),
                'remove_featured_image' => __( 'Remove Image', 'wp-school-calendar' ),
                'use_featured_image'    => __( 'Use as Featured Image', 'wp-school-calendar' ),
                'insert_into_item'      => __( 'Insert into Important Date', 'wp-school-calendar' ),
                'uploaded_to_this_item' => __( 'Uploaded to this important date', 'wp-school-calendar' ),
                'filter_items_list'     => __( 'Filter important date', 'wp-school-calendar' ),
                'items_list_navigation' => __( 'Important date navigation', 'wp-school-calendar' ),
                'items_list'            => __( 'important date list', 'wp-school-calendar' ),
            ),
            'description'         => __( 'This is where you can add new important date that you can use in your WordPress site.', 'wp-school-calendar' ),
            'public'              => false,
            'show_ui'             => true,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-calendar-alt',
            'menu_position'       => 35,
            'hierarchical'        => false,
            'rewrite'             => false,
            'has_archive'         => false,
            'query_var'           => false,
            'supports'            => array( 'title' ),
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false
        ) ) );
        
        register_post_type( 'important_date_cat', apply_filters( 'wpsc_register_post_type_cat', array(
            'public'              => false,
            'show_ui'             => false,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'hierarchical'        => false,
            'rewrite'             => false,
            'has_archive'         => false,
            'query_var'           => false,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false
        ) ) );
    }
    
    /**
     * Disable inline editing
     * 
     * @since 1.0
     * 
     * @param array $actions    Original actions
     * @param WP_Post $post     WP_Post object
     * @return array Modified actions
     */
    public function row_actions( $actions, $post ) {
        if ( in_array( $post->post_type, array( 'important_date' ) ) ) {
            if ( isset( $actions['inline hide-if-no-js'] ) ) {
                unset( $actions['inline hide-if-no-js'] );
            }
        }

        return $actions;
    }
    
    /**
     * Change "enter title here" text
     * 
     * @since 1.0
     * 
     * @param string $text  Original "enter title here" text
     * @param WP_Post $post WP_Post object
     * @return string Modified "enter title here" text
     */
    public function enter_title_here( $text, $post ) {
        switch ( $post->post_type ) {
            case 'important_date' :
                $text = __( 'Enter title here', 'wp-school-calendar' );
                break;
        }

        return $text;
    }
    
    /**
     * Change important date columns
     * 
     * @since 1.0
     * 
     * @param array $existing_columns Array of existing post columns
     * @return array Array of new post columns
     */
    public function important_date_columns( $existing_columns ) {
        $columns = array();
        
        $columns['cb']         = $existing_columns['cb'];
        $columns['name']       = __( 'Name', 'wp-school-calendar' );
        $columns['start_date'] = __( 'Start Date', 'wp-school-calendar' );
        $columns['end_date']   = __( 'End Date', 'wp-school-calendar' );
        $columns['category']   = __( 'Category', 'wp-school-calendar' );

        return $columns;
    }

    /**
     * Add important date sortable columns
     * 
     * @since 1.0
     * 
     * @param array $columns Array of existing sortable columns
     * @return array Array of new sortable columns
     */
    public function important_date_sortable_columns( $columns ) {
        $custom = array(
			'name' => 'name',
		);
        
		return wp_parse_args( $custom, $columns );
    }
    
    /**
     * Display important date column content
     * 
     * @since 1.0
     * 
     * @global WP_Post $post WP_Post object
     * @param string $column Column name
     */
    public function render_important_date_columns( $column ) {
        global $post;
        
        $start_date  = get_post_meta( $post->ID, '_start_date', true );
        $end_date    = get_post_meta( $post->ID, '_end_date', true );
        $category_id = get_post_meta( $post->ID, '_category_id', true );

        switch ( $column ) {
            case 'name':
                $edit_link = get_edit_post_link( $post->ID );
                $title = _draft_or_post_title();
                echo '<strong><a class="row-title" href="' . esc_url( $edit_link ) . '">' . esc_html( $title ) . '</a>';
                _post_states( $post );
                echo '</strong>';
                break;
            case 'start_date':
                if ( '' === $start_date ) {
                    echo '<span class="na">&mdash;</span>';
                } else {
                    echo date( 'F j, Y', strtotime( $start_date ) );
                }
                break;
            case 'end_date':
                if ( $start_date === $end_date ) {
                    echo '<span class="na">&mdash;</span>';
                } else {
                    echo date( 'F j, Y', strtotime( $end_date ) );
                }
                break;
            case 'category':
                echo wpsc_get_category_name( $category_id );
                break;
        }
    }
    
    /**
     * Remove months dropdown
     * 
     * @since 1.0
     * 
     * @global string $typenow Post type
     */
    public function remove_date_dropdown() {
        global $typenow;

        if ( in_array( $typenow, array( 'important_date' ) ) ) {
            add_filter( 'months_dropdown_results', '__return_empty_array' );
        }
    }
    
    /**
     * Disable important date bulk actions
     * 
     * @since 1.0
     * 
     * @param array $actions Array of bulk actions
     * @return array Array of new bulk actions
     */
    public function important_date_bulk_actions( $actions ) {
        if ( isset( $actions['edit'] ) ) {
            unset( $actions['edit'] );
        }
        
        return $actions;
    }
    
    /**
     * Change update message for important date
     * 
     * @since 1.0
     * 
     * @global WP_Post $post WP_Post object
     * @global integer $post_ID Post ID
     * @param array $messages Array of updated messages
     * @return array Array of new updated message
     */
    public function post_updated_messages( $messages ) {
        global $post, $post_ID;

        $messages['important_date'] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => __( 'Important date updated.', 'wp-school-calendar' ),
            2 => __( 'Custom field updated.', 'wp-school-calendar' ),
            3 => __( 'Custom field deleted.', 'wp-school-calendar' ),
            4 => __( 'Important date updated.', 'wp-school-calendar' ),
            5 => isset( $_GET['revision'] ) ? sprintf( __( 'Important date restored to revision from %s', 'wp-school-calendar' ), wp_post_revision_title( ( int ) $_GET['revision'], false ) ) : false,
            6 => __( 'Important date published.', 'wp-school-calendar' ),
            7 => __( 'Important date saved.', 'wp-school-calendar' ),
            8 => __( 'Important date submitted.', 'wp-school-calendar' ),
            9 => sprintf( __( 'Important date scheduled for: <strong>%1$s</strong>.', 'wp-school-calendar' ), date_i18n( __( 'M j, Y @ G:i', 'wp-school-calendar' ), strtotime( $post->post_date ) ) ),
            10 => __( 'Important date draft updated.', 'wp-school-calendar' )
        );
        
        return $messages;
    }
    
    /**
     * Change bulk update message for important date
     * 
     * @since 1.0
     * 
     * @param array $bulk_messages Array of bulk messages
     * @param integer $bulk_counts The number of bulk counts
     * @return array Array of new bulk messages
     */
    public function bulk_post_updated_messages( $bulk_messages, $bulk_counts ) {
        $bulk_messages['important_date'] = array(
            'updated'   => _n( '%s important date updated.', '%s important date updated.', $bulk_counts['updated'], 'wp-school-calendar' ),
            'locked'    => _n( '%s important date not updated, somebody is editing it.', '%s important date not updated, somebody is editing them.', $bulk_counts['locked'], 'wp-school-calendar' ),
            'deleted'   => _n( '%s important date permanently deleted.', '%s important date permanently deleted.', $bulk_counts['deleted'], 'wp-school-calendar' ),
            'trashed'   => _n( '%s important date moved to the Trash.', '%s important date moved to the Trash.', $bulk_counts['trashed'], 'wp-school-calendar' ),
            'untrashed' => _n( '%s important date restored from the Trash.', '%s important date restored from the Trash.', $bulk_counts['untrashed'], 'wp-school-calendar' ),
        );

        return $bulk_messages;
    }    
    
    /**
     * Disable autosave on upcoming event
     * 
     * @since 1.0
     * 
     * @global WP_Post $post WP_Post object
     */
    public function disable_autosave() {
        global $post;

        if ( $post && in_array( get_post_type( $post->ID ), array( 'important_date' ) ) ) {
            wp_dequeue_script( 'autosave' );
        }
    }
    
    /**
     * Add some filter on administration page
     * 
     * @since 1.0
     * 
     * @global string $typenow Post type
     */
    public function restrict_manage_posts() {
        global $typenow;

        if ( 'important_date' == $typenow ) {
            $categories = wpsc_get_categories();
            $current_category_id = isset( $_GET['wpsc_category'] ) ? intval( $_GET['wpsc_category'] ) : false;
            ?>
            <select name="wpsc_category">
                <option value=""><?php echo __( 'All Categories', 'wp-school-calendar' ) ?></option>
                <?php foreach ( $categories as $category ): ?>
                <option <?php selected( $current_category_id, $category['category_id'] ) ?> value="<?php echo $category['category_id'] ?>"><?php echo esc_html( $category['name'] ); ?></option>
                <?php endforeach; ?>
            </select>
            <?php
        }
    }
    
    public function request_query( $vars ) {
        global $typenow, $wp_query, $wp_post_statuses;

        if ( 'important_date' === $typenow ) {
            if ( isset( $_GET['wpsc_category'] ) && '' !== $_GET['wpsc_category'] ) {
                $vars = array_merge( $vars, array(
                    'meta_query' => array(
                        'relation' => 'AND',
                        'category_clause' => array(
                            'key' => '_category_id',
                            'value' => $_GET['wpsc_category'],
                        ),
                        'start_date_clause' => array(
                            'key'  => '_start_date',
                            'type' => 'date'
                        ),
                    ),
                    'orderby' => array(
                        'start_date_clause' => 'DESC'
                    )
                ) );
            } else {
                $vars = array_merge( $vars, array(
                    'meta_query' => array(
                        'relation' => 'AND',
                        'category_clause' => array(
                            'key'  => '_category_id',
                            'type' => 'numeric'
                        ),
                        'start_date_clause' => array(
                            'key'  => '_start_date',
                            'type' => 'date'
                        ),
                    ),
                    'orderby' => array(
                        'start_date_clause' => 'DESC'
                    )
                ) );
            }
        }
        
        return $vars;
    }
}

WP_School_Calendar_Post_Type::instance();