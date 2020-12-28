<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function cf7pp_stripe_redirect($post_id,$fid,$return_url) {
	
	$options = get_option('cf7pp_options');
	
	
	// get variables

	$name = 	sanitize_text_field(get_post_meta($post_id, "_cf7pp_name", true));
	$price = 	sanitize_text_field(get_post_meta($post_id, "_cf7pp_price", true));
	$id = 		sanitize_text_field(get_post_meta($post_id, "_cf7pp_id", true));
	
	if ($options['mode_stripe'] == "1") {
		$stripe_key = sanitize_text_field($options['pub_key_test']);
		$stripe_sec = sanitize_text_field($options['sec_key_test']);
	} else {
		$stripe_key = sanitize_text_field($options['pub_key_live']);
		$stripe_sec = sanitize_text_field($options['sec_key_live']);
	}
	
	
	
	
	if (empty($options['session'])) {
		$session = '1';
	} else {
		$session = sanitize_text_field($options['session']);
	}

	if ($session == '1') {
		
		if(isset($_COOKIE['cf7pp_stripe_return'])) {
			$stripe_return 	= sanitize_text_field($_COOKIE['cf7pp_stripe_return']);
			$stripe_email 	= sanitize_text_field($_COOKIE['cf7pp_stripe_email']);
		}
		
	} else {
		
		if(isset($_SESSION['cf7pp_stripe_return'])) {
			$stripe_return 	= sanitize_text_field($_SESSION['cf7pp_stripe_return']);
			$stripe_email 	= sanitize_text_field($_SESSION['cf7pp_stripe_email']);
		}
		
	}
	
	
	// email
	
	if (empty($stripe_email)) {
		$email = null;
	} else {
		$email = $stripe_email;
	}
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$email = null;
	}
	
	
	// currency
	if ($options['currency'] == "1") { $currency = "AUD"; }
	if ($options['currency'] == "2") { $currency = "BRL"; }
	if ($options['currency'] == "3") { $currency = "CAD"; }
	if ($options['currency'] == "4") { $currency = "CZK"; }
	if ($options['currency'] == "5") { $currency = "DKK"; }
	if ($options['currency'] == "6") { $currency = "EUR"; }
	if ($options['currency'] == "7") { $currency = "HKD"; }
	if ($options['currency'] == "8") { $currency = "HUF"; }
	if ($options['currency'] == "9") { $currency = "ILS"; }
	if ($options['currency'] == "10") { $currency = "JPY"; }
	if ($options['currency'] == "11") { $currency = "MYR"; }
	if ($options['currency'] == "12") { $currency = "MXN"; }
	if ($options['currency'] == "13") { $currency = "NOK"; }
	if ($options['currency'] == "14") { $currency = "NZD"; }
	if ($options['currency'] == "15") { $currency = "PHP"; }
	if ($options['currency'] == "16") { $currency = "PLN"; }
	if ($options['currency'] == "17") { $currency = "GBP"; }
	if ($options['currency'] == "18") { $currency = "RUB"; }
	if ($options['currency'] == "19") { $currency = "SGD"; }
	if ($options['currency'] == "20") { $currency = "SEK"; }
	if ($options['currency'] == "21") { $currency = "CHF"; }
	if ($options['currency'] == "22") { $currency = "TWD"; }
	if ($options['currency'] == "23") { $currency = "THB"; }
	if ($options['currency'] == "24") { $currency = "TRY"; }
	if ($options['currency'] == "25") { $currency = "USD"; }
	
	
	$cancel_url = $return_url;
	
	// return url
	if (!empty($stripe_return)) {
		$success_url = $stripe_return;
	} else {
		$success_url = $return_url;
	}
	
	if (filter_var($success_url, FILTER_VALIDATE_URL) === FALSE) {
		echo "Website admin: Success or Return URL is not valid.";
		exit;
	}
	
	if (filter_var($cancel_url, FILTER_VALIDATE_URL) === FALSE) {
		echo "Website admin: Success or Return URL is not valid.";
		exit;
	}
	
	if (empty($name)) 		{ $name =  "(No item name)"; }
	
	
	if (empty($stripe_key)) {
		echo "Website Admin: Please enter your Stripe API keys on the settings page (Contact -> PayPal & Stripe Settings -> Stripe)";
		exit;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// add secret key
	\Stripe\Stripe::setApiKey($stripe_sec);



	if (!empty($price)) {
		
		if ($currency != 'JPY') {
			// convert amount to cents
			$amount = $price * 100;
		} else {
			$amount = $price;
			$amount = (int)$amount;
		}
		
		
		if (!empty($id)) {
			$description = $id;
		} else {
			$description = ' ';
		}
		
		$line_items[] = [
			'price_data' => [
				'currency' 		=> $currency,
				'unit_amount' 	=> $amount,
				'product_data' 	=> [
					'name' 			=> $name,
					'description' 	=> $description,
				],
			],
			'quantity' => 1,
		];
		
	}
	
	
	
	
	
	// Stripe does not allow totals of 0.00, so show error if this happens
	if ($amount == 0) {
		echo 'Website Admin: Price cannot be set to 0.00.';
		exit;
	}
	
	
	

	
	
	$checkout_session = \Stripe\Checkout\Session::create([
	  'submit_type' 				=> 'pay',
	  'payment_method_types' 		=> ['card'],
	  'customer_email' 				=> $email,
	  'line_items' 					=> $line_items,
	  'mode' 						=> 'payment',
	  'success_url' 				=> $success_url.'?cf7pp_stripe_success=true&fid='.$fid.'&id={CHECKOUT_SESSION_ID}',
	  'cancel_url' 					=> $cancel_url,
	]);
	
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<script src="https://js.stripe.com/v3/"></script>
		</head>
		<body>
		</body>
			
			<script type="text/javascript">
			// publishable API key
			var stripe = Stripe('<?php echo $stripe_key; ?>');
			
			var session_id = '<?php echo $checkout_session->id ?>';
			
			window.onload = function() {
				var result = stripe.redirectToCheckout({ sessionId: session_id });
			};
			
			</script>
	</html>
	<?php
}
	
?>