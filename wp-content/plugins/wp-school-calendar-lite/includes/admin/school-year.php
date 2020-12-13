<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WP_School_Calendar_Year {

    private static $_instance = NULL;
    public $action = NULL;

    /**
     * Initialize all variables, filters and actions
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'admin_init' ) );
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
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
     * Add School Years menu
     * 
     * @since 1.0
     */
    public function admin_menu() {
        add_submenu_page( 'edit.php?post_type=important_date', __( 'School Years', 'wp-school-calendar' ), __( 'School Years', 'wp-school-calendar' ), 'manage_options', 'wpsc-school-year', array( $this, 'admin_page' ) );
    }
    
    /**
     * Add School Years page
     * 
     * @since 1.0
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php echo esc_html__( 'School Years', 'wp-school-calendar' );?></h1>
            <hr class="wp-header-end">
            <?php 
            if ( ! empty( $_GET['edit'] ) ) {
                $this->edit();
            } else {
                $this->table();
            }
            ?>
        </div>
        <?php
    }
    
    /**
     * Display school year edit form
     * 
     * @since 1.0
     */
    private function edit() {
        $school_year = wpsc_get_school_year( intval( $_REQUEST['edit'] ) );
		?>
		<form method="post" action="<?php echo admin_url( 'edit.php?post_type=important_date&page=wpsc-school-year&edit=' . intval( $_REQUEST['edit'] ) ); ?>">
			<?php wp_nonce_field( 'school_year_edit-' . $school_year['school_year_id'] ); ?>
            <input name="edit_school_year[school_year_id]" type="hidden" value="<?php echo esc_attr( $school_year['school_year_id'] ); ?>" />
			<table class="form-table">
                <tr>
					<th scope="row"><label><?php echo esc_html__( 'Year Name', 'wp-school-calendar' ); ?></label></th>
					<td>
                        <input type="number" name="edit_school_year[start_year]" value="<?php echo esc_attr( $school_year['start_year'] ) ?>" class="small-text"> - 
                        <input type="number" name="edit_school_year[end_year]" value="<?php echo esc_attr( $school_year['end_year'] ) ?>" class="small-text">
                        <p class="description"><?php echo __( 'Example: 2019 / 2020', 'wp-school-calendar' ) ?></p>
					</td>
				</tr>
                <tr>
					<th scope="row"><label><?php echo esc_html__( 'Start Date', 'wp-school-calendar' ); ?></label></th>
					<td>
                        <input type="text" id="start-datepicker" value="" readonly="readonly" style="width:200px;">
                        <input name="edit_school_year[start_date]" id="start-datepicker-alt" type="hidden" value="<?php echo esc_attr( $school_year['start_date'] ) ?>" />
					</td>
				</tr>
                <tr>
					<th scope="row"><label><?php echo esc_html__( 'End Date', 'wp-school-calendar' ); ?></label></th>
					<td>
                        <input type="text" id="end-datepicker" value="" readonly="readonly" style="width:200px;">
                        <input name="edit_school_year[end_date]" id="end-datepicker-alt" type="hidden" value="<?php echo esc_attr( $school_year['end_date'] ) ?>" />
					</td>
				</tr>
                <tr>
					<th scope="row"><label><?php echo esc_html__( 'Status', 'wp-school-calendar' ); ?></label></th>
					<td>
                        <input type="hidden" name="edit_school_year[enable]" value="N">
                        <label><input name="edit_school_year[enable]" type="checkbox" value="Y" <?php checked( $school_year['enable'], 'Y' ) ?> /> 
                            <?php echo esc_html__( 'Enable School Year', 'wp-school-calendar' ); ?></label>
					</td>
				</tr>
			</table>
			<p class="submit"><input type="submit" class="button-primary" name="save_school_year" value="<?php echo esc_attr__( 'Save Changes', 'wp-school-calendar' ); ?>" /></p>
		</form>
		<?php
    }
    
    /**
     * Display table list of school years
     * 
     * @since 1.0
     */
    private function table() {
        $school_years = wpsc_get_school_years();
        $default_school_year = wpsc_settings_value( 'default_school_year' );
		?>
        <div id="col-container">
			<div id="col-right">
				<div class="col-wrap">
					<h3><?php echo esc_html__( 'Available School Years', 'wp-school-calendar' ); ?></h3>
                    <form method="get">
                        <?php wp_nonce_field( 'school_year_action' ); ?>
                        <input type="hidden" name="post_type" value="important_date">
                        <input type="hidden" name="page" value="wpsc-school-year">
                        <div class="tablenav top">
                            <div class="alignleft actions bulkactions">
                                <select name="action">
                                    <option value="-1"><?php echo esc_html__( 'Bulk Action', 'wp-school-calendar' ) ?></option>
                                    <option value="delete-selected"><?php echo esc_html__( 'Delete', 'wp-school-calendar' ) ?></option>
                                </select>
                                <input type="submit" class="button action" value="<?php echo esc_attr__( 'Apply', 'wp-school-calendar' ) ?>">
                            </div>
                        </div>
                        <table class="wp-list-table widefat plugins">
                            <thead>
                                <tr>
                                    <td class="manage-column column-cb check-column"><input id="cb-select-all" type="checkbox"></td>
                                    <th scope="col" class="manage-column column-name column-primary"><?php echo esc_html__( 'Year Name', 'wp-school-calendar' ); ?></th>
                                    <th scope="col" class="manage-column column-start-date"><?php echo esc_html__( 'Start Date', 'wp-school-calendar' ); ?></th>
                                    <th scope="col" class="manage-column column-end-date"><?php echo esc_html__( 'End Date', 'wp-school-calendar' ); ?></th>
                                    <th scope="col" class="manage-column column-status"><?php echo esc_html__( 'Status', 'wp-school-calendar' ); ?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <td class="manage-column column-cb check-column"><input id="cb-select-all" type="checkbox"></td>
                                    <th scope="col" class="manage-column column-name column-primary"><?php echo esc_html__( 'Year Name', 'wp-school-calendar' ); ?></th>
                                    <th scope="col" class="manage-column column-start-date"><?php echo esc_html__( 'Start Date', 'wp-school-calendar' ); ?></th>
                                    <th scope="col" class="manage-column column-end-date"><?php echo esc_html__( 'End Date', 'wp-school-calendar' ); ?></th>
                                    <th scope="col" class="manage-column column-status"><?php echo esc_html__( 'Status', 'wp-school-calendar' ); ?></th>
                                </tr>
                            </tfoot>
                            <tbody id="the-list" class="wpsc-list-table">	
                                <?php foreach ( $school_years as $school_year ): ?>
                                <tr class="inactive">
                                    <th scope="row" class="check-column">
                                        <?php if ( intval( $default_school_year ) !== intval( $school_year['school_year_id'] ) ): ?>
                                        <input type="checkbox" name="school_year[]" value="<?php echo intval( $school_year['school_year_id'] ) ?>">
                                        <?php endif ?>
                                    </th>
                                    <td class="plugin-title column-primary">
                                        <strong><?php echo empty( $school_year['end_year'] ) ? $school_year['start_year'] : sprintf( '%s - %s', $school_year['start_year'], $school_year['end_year'] ) ?></strong>
                                        <div class="row-actions">
                                            <span class="edit"><a href="<?php echo admin_url( 'edit.php?post_type=important_date&amp;page=wpsc-school-year&edit=' . intval( $school_year['school_year_id'] ) ); ?>"><?php _e( 'Edit', 'wp-school-calendar' ); ?></a></span>
                                            <?php if ( intval( $default_school_year ) !== intval( $school_year['school_year_id'] ) ): ?>
                                            <span class="delete"> | <a href="<?php echo wp_nonce_url( admin_url( 'edit.php?post_type=important_date&page=wpsc-school-year&delete=' . intval( $school_year['school_year_id'] ) ), 'school_year_delete-' . $school_year['school_year_id'] ); ?>"><?php _e( 'Delete', 'wp-school-calendar' ); ?></a></span> 
                                            <?php endif ?>
                                        </div>
                                    </td>
                                    <td class="column-start-date"><?php echo date( 'F j, Y', strtotime( $school_year['start_date'] ) ) ?></td>
                                    <td class="column-end-date"><?php echo empty( $school_year['end_date'] ) ? '&mdash;' : date( 'F j, Y', strtotime( $school_year['end_date'] ) ) ?></td>
                                    <td class="column-status"><?php echo 'Y' === $school_year['enable'] ? __( 'Enable', 'wp-school-calendar' ) : __( 'Disable', 'wp-school-calendar' ) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
			</div>
			<!-- /col-right -->
			<div id="col-left">
				<div class="col-wrap">
					<div class="form-wrap">
						<h3><?php echo esc_html__( 'Add School Year', 'wp-school-calendar' ); ?></h3>
						<form method="post" action="<?php echo admin_url( 'edit.php?post_type=important_date&page=wpsc-school-year' ) ?>">
                            <?php wp_nonce_field( 'school_year_create' ); ?>	
                            <div class="form-field form-required">
								<label><?php echo esc_html__( 'Year Name', 'wp-school-calendar' ); ?></label>
                                <input name="new_school_year[start_year]" type="number" value="" style="width:100px;" /> - 
                                <input name="new_school_year[end_year]" type="number" value="" style="width:100px;" />
                                <p class="description"><?php echo __( 'Example: 2019 / 2020', 'wp-school-calendar' ) ?></p>
							</div>
                            <div class="form-field form-required">
								<label><?php echo esc_html__( 'Start Date', 'wp-school-calendar' ); ?></label>
                                <input type="text" id="start-datepicker" value="" readonly="readonly" style="width:200px;">
								<input name="new_school_year[start_date]" id="start-datepicker-alt" type="hidden" value="<?php echo date( 'Y' ) ?>-07-01" />
							</div>
                            <div class="form-field form-required">
								<label><?php echo esc_html__( 'End Date', 'wp-school-calendar' ); ?></label>
                                <input type="text" id="end-datepicker" value="" readonly="readonly" style="width:200px;">
								<input name="new_school_year[end_date]" id="end-datepicker-alt" type="hidden" value="<?php echo date( 'Y' ) + 1 ?>-06-30" />
							</div>
                            <div class="form-field form-required">
								<label><input name="new_school_year[enable]" type="checkbox" value="Y" checked="checked" /> 
                                    <?php echo esc_html__( 'Enable School Year', 'wp-school-calendar' ); ?></label>
							</div>
							<p class="submit">
								<input type="submit" class="button button-primary" name="add_new_school_year" id="submit" value="<?php echo esc_attr__( 'Add School Year', 'wp-school-calendar' ); ?>" />
							</p>
						</form>
					</div>
				</div>
			</div>
			<!-- /col-left -->
        </div>
		<?php
    }
    
    /**
     * Do admin actions
     * 
     * @since 1.0
     */
    public function admin_init() {
        $sendback = remove_query_arg( array( '_wp_http_referer', '_wpnonce', 'action', 'school_year', 'add_new' ), wp_get_referer() );
        
        if ( isset( $_REQUEST['page'] ) && 'wpsc-school-year' === $_REQUEST['page'] ) {
            if ( ! empty( $_POST['add_new_school_year'] ) ) {
                $result = $this->process_add_school_year();
                
                if ( is_wp_error( $result ) ) {
                    echo '<div class="error"><p>' . wp_kses_post( $result->get_error_message() ) . '</p></div>';
                } else {
                    wp_redirect( $sendback );
                    exit;
                }
            } elseif ( ! empty( $_GET['delete'] ) ) {
                $result = $this->process_delete_school_year();
                wp_redirect( $sendback );
                exit;
            } elseif ( ! empty( $_POST['save_school_year'] ) ) {
                $result = $this->process_save_school_year();
                
                if ( is_wp_error( $result ) ) {
                    echo '<div class="error"><p>' . wp_kses_post( $result->get_error_message() ) . '</p></div>';
                } else {
                    wp_redirect( $sendback );
                    exit;
                }
            } elseif ( ! empty( $_GET['action'] ) && '-1' !== $_GET['action'] ) {
                if ( 'delete-selected' === $_GET['action'] ) {
                    $result = $this->process_bulk_delete_school_year();
                }
                wp_redirect( $sendback );
                exit;
            }
        }
    }
    
    /**
     * Process add new school year
     * 
     * @since 1.0
     */
    public function process_add_school_year() {
        $args = $_POST['new_school_year'];
        check_admin_referer( 'school_year_create' );
        
        if ( empty( $args['start_year'] ) || empty( $args['start_date'] ) || empty( $args['end_date'] ) ) {
            return new WP_Error( 'error_year', esc_html__( 'Please, provide Year Name and Start/End Date.', 'wp-school-calendar' ), array( 'status' => 400 ) );
        }
        
        if ( ! empty( $args['end_year'] ) && ( $args['end_year'] > $args['start_year'] + 1 || $args['end_year'] <= $args['start_year'] ) ) {
            return new WP_Error( 'error_year', esc_html__( 'Please, provide valid Year Name.', 'wp-school-calendar' ), array( 'status' => 400 ) );
        }
        
        $start_date = explode( '-', $args['start_date'] );
        $end_date   = explode( '-', $args['end_date'] );
        
        if ( intval( $start_date[0] ) === intval( $end_date[0] ) ) {}
        else {
            if ( intval( $end_date[0] ) === intval( $start_date[0] ) + 1 ) {
                if ( 13 - intval( $start_date[1] ) + intval( $end_date[1] ) > 15 ) {
                    return new WP_Error( 'error_year', esc_html__( 'Please, provide valid End Date, maximum of 15 months from Start Date.', 'wp-school-calendar' ), array( 'status' => 400 ) );
                }
            } else {
                return new WP_Error( 'error_year', esc_html__( 'Please, provide valid End Date, maximum of 15 months from Start Date.', 'wp-school-calendar' ), array( 'status' => 400 ) );
            }
        }
        
        $args = array(
            'start_year' => sanitize_text_field( $args['start_year'] ),
            'end_year'   => sanitize_text_field( $args['end_year'] ),
            'start_date' => sanitize_text_field( $args['start_date'] ),
            'end_date'   => sanitize_text_field( $args['end_date'] ),
            'enable'     => sanitize_text_field( $args['enable'] ),
        );
        
        wpsc_add_new_school_year( $args );
    }
    
    /**
     * Process delete school year
     * 
     * @since 1.0
     */
    public function process_delete_school_year() {
        $school_year_id = intval( $_GET['delete'] );
        check_admin_referer( 'school_year_delete-' . $school_year_id );
        
        $default_school_year = wpsc_settings_value( 'default_school_year' );
        
        if ( intval( $default_school_year ) === $school_year_id ) {
            return;
        }
        
        wpsc_delete_school_year( $school_year_id );
    }
    
    /**
     * Process save school year
     * 
     * @since 1.0
     */
    public function process_save_school_year() {
        $args = $_POST['edit_school_year'];
        check_admin_referer( 'school_year_edit-' . $args['school_year_id'] );
        
        if ( empty( $args['start_year'] ) || empty( $args['start_date'] ) || empty( $args['end_date'] ) ) {
            return new WP_Error( 'error_year', esc_html__( 'Please, provide Year Name and Start/End Date.', 'wp-school-calendar' ), array( 'status' => 400 ) );
        }
        
        if ( ! empty( $args['end_year'] ) && ( $args['end_year'] > $args['start_year'] + 1 || $args['end_year'] <= $args['start_year'] ) ) {
            return new WP_Error( 'error_year', esc_html__( 'Please, provide valid Year Name.', 'wp-school-calendar' ), array( 'status' => 400 ) );
        }
        
        $start_date = explode( '-', $args['start_date'] );
        $end_date   = explode( '-', $args['end_date'] );
        
        if ( intval( $start_date[0] ) === intval( $end_date[0] ) ) {}
        else {
            if ( intval( $end_date[0] ) === intval( $start_date[0] ) + 1 ) {
                if ( 13 - intval( $start_date[1] ) + intval( $end_date[1] ) > 15 ) {
                    return new WP_Error( 'error_year', esc_html__( 'Please, provide valid End Date, maximum of 15 months from Start Date.', 'wp-school-calendar' ), array( 'status' => 400 ) );
                }
            } else {
                return new WP_Error( 'error_year', esc_html__( 'Please, provide valid End Date, maximum of 15 months from Start Date.', 'wp-school-calendar' ), array( 'status' => 400 ) );
            }
        }
        
        $args = array(
            'school_year_id' => intval( $args['school_year_id'] ),
            'start_year'     => sanitize_text_field( $args['start_year'] ),
            'end_year'       => sanitize_text_field( $args['end_year'] ),
            'start_date'     => sanitize_text_field( $args['start_date'] ),
            'end_date'       => sanitize_text_field( $args['end_date'] ),
            'enable'         => sanitize_text_field( $args['enable'] ),
        );
        
        wpsc_save_school_year( $args );
    }
    
    /**
     * Process bulk delete school years
     * 
     * @since 1.0
     */
    public function process_bulk_delete_school_year() {
        $school_year_ids = $_GET['school_year'];
        check_admin_referer( 'school_year_action' );
        
        $default_school_year = wpsc_settings_value( 'default_school_year' );
        
        foreach ( $school_year_ids as $school_year_id ) {
            if ( intval( $default_school_year ) !== intval( $school_year_id ) ) {
                wpsc_delete_school_year( intval( $school_year_id ) );
            }
        }
    }
}

WP_School_Calendar_Year::instance();