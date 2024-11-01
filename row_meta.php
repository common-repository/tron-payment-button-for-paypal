<?php 
/*
 # Written 2023
 #   by Jeffrey Quade 
**/
?>
<?php
if (!function_exists('tron_wpp_paypal_button_lite_plugin_row_meta')) { 
function tron_wpp_paypal_button_lite_plugin_row_meta($links_array, $plugin_file_name, $plugin_data, $status) { 

	// Auto detect plugin folder for this file. 
	$this_file = dirname(__FILE__);
	$this_file = str_replace('\\', '/', $this_file); // For Windows Servers
	$dir_r = array(); 
	$dir_r = explode("/", $this_file);
	$this_path = end($dir_r); 

	// Get the directory name of the argument. 
	$plugin_dir_name = str_replace('\\', '/', $plugin_file_name); 
	$dir_r = array(); 
	$dir_r = explode("/", $plugin_file_name);
	$plugin_file_path = $dir_r[0]; 
	
	if ($plugin_file_path == $this_path) {
		return array_merge( 
			$links_array, 
			array(
				'<a href="https://www.paypal.com/cgi-bin/webscr?' . 
					'cmd=_s-xclick&hosted_button_id=AEX4MXWZPR6K2" target="_blank">Donate</a>' 
			)
		);
	}
	return $links_array;
}
add_filter('plugin_row_meta', 'tron_wpp_paypal_button_lite_plugin_row_meta', 10, 4); 
}
