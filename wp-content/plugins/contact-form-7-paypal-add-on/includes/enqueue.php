<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



// admin enqueue
function cf7pp_admin_enqueue() {

	// admin css
	wp_register_style('cf7pp-admin-css',plugins_url('../assets/css/admin.css',__FILE__),false,false);
	wp_enqueue_style('cf7pp-admin-css');

	// admin js
	wp_enqueue_script('cf7pp-admin',plugins_url('../assets/js/admin.js',__FILE__),array('jquery'),false);

}
add_action('admin_enqueue_scripts','cf7pp_admin_enqueue');





// public enqueue
function cf7pp_public_enqueue() {

	// path
	$site_url = get_home_url();
	$path_paypal = $site_url.'/?cf7pp_paypal_redirect=';
	$path_stripe = $site_url.'/?cf7pp_stripe_redirect=';

	// stripe public key
	$options = get_option('cf7pp_options');
	
	
	// set defaults in case uplugin has been updated without savings the settings page
	if (!isset($options['failed'])) {
		$options['failed'] = 		'Payment Failed';
		$options['pay'] = 			'Pay';
		$options['processing'] = 	'Processing Payment';
	}

	// redirect method js
	wp_enqueue_script('cf7pp-redirect_method',plugins_url('../assets/js/redirect_method.js',__FILE__),array('jquery'),null);
	wp_localize_script('cf7pp-redirect_method', 'ajax_object_cf7pp',
		array (
			'ajax_url' 			=> admin_url('admin-ajax.php'),
			'forms' 			=> cf7pp_forms_enabled(),
			'path_paypal'		=> $path_paypal,
			'path_stripe'		=> $path_stripe,
			'method'			=> $options['redirect'],
		)
	);


}
add_action('wp_enqueue_scripts','cf7pp_public_enqueue',10);
