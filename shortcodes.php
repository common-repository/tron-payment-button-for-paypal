<?php 
/*
 # Written 2023
 #   by Jeffrey Quade 
**/
?>
<?php 
if (!function_exists('tron_paypal_button_lite')) { 
function tron_paypal_button_lite($atts, $content = null) { // [tron_paypal_button_lite email="you@example.com" /]

	$my_plugin_dir = str_replace('\\', '/', dirname(__FILE__));	// Changes \ to / for Windows Servers
	$plugin_dir_url = rtrim(plugin_dir_url(__DIR__), '/');		
	$my_plugin_url = $plugin_dir_url . '/' . end(explode('/', $my_plugin_dir));
	$button_url = $my_plugin_url . '/assets/' . "x-click-but6.gif";

	$atts = shortcode_atts(
		array( // defaults if values not passed
			'email' => NULL,
			'currency' => 'USD',
			'paymentaction' => 'sale' // sale, authorization, or order
			// 'cmd' = '_xclick' // _xclick, _donations, but not _cart 
		), $atts
	);
	$atts['email'] = sanitize_text_field($atts['email']);
	$atts['currency'] = sanitize_text_field($atts['currency']);
	$atts['paymentaction'] = sanitize_text_field($atts['paymentaction']);

	if (!filter_var($atts['email'], FILTER_VALIDATE_EMAIL))
		return "<div style='color:red;'>Please specify a valid email.</div>";

	$site_live = true;
	if ($site_live) $action = "https://www.paypal.com/cgi-bin/webscr";
	else { // For pre-releasse testing.
		$action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		if (file_exists('sandbox_credentials.php')) include('sandbox_credentials.php');
	} 
	
	// Multiple buttons same page.
	$rand_num = rand(1001, 9999); 
	
	// paypal standard cmd _xclick variables
	// Control click the button it goes to the sandbox site. 
	return $this_button = "
		<form name='form_buy_now_$rand_num' id='form_buy_now_$rand_num' action='{$action}' method='post' target='_blank'>
			<input name='business' id='business' type='hidden' value='{$atts['email']}' />
			<input name='currency_code' id='currency_code' type='hidden' value='{$atts['currency']}' />
			<input name='paymentaction' id='paymentaction' type='hidden' value='{$atts['paymentaction']}' />
	
			<input name='cmd' id='cmd' type='hidden' value='_xclick' />
			<input name='item_name' id='item_name' type='hidden' value='Prepayment' />
			<input name='quantity' id='quantity' type='hidden' value='1' />
			<input name='amount' id='amount' type='hidden' note='amount not including shipping, handling, or tax' value='' /> 
			
			<input name='shipping' id='shipping' type='hidden' value='0.00' /> 
			<input name='handling' id='handling' type='hidden' value='0.00' /> 
			<input name='tax' id='tax' type='hidden' value='0.00' /> 
		
			<input name='rm' id='rm' type='hidden' note='1=get, 2=post' value='2' />
			<input name='charset' id='charset' type='hidden' value='utf-8' />
			<input name='bn' id='bn' type='hidden' value='WebtronUSAInc_SP' />
	
			<input title='Pay with PayPal' alt='Pay with PayPal' name='submit' src='{$button_url}' type='image' onClick='if (event.ctrlKey||window.event.ctrlKey) {var frm = document.getElementById('form_buy_now_$rand_num') || null; if (frm) frm.action = 'https://www.sandbox.paypal.com/cgi-bin/webscr';}' />
		</form>
	";
}
add_shortcode('tron_paypal_button_lite', 'tron_paypal_button_lite'); 
} 
