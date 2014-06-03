<?php
/*
  Plugin Name: BEA Redirect Blog
  Plugin URI: http://www.beapi.fr
  Description: redirect selected blogs to another one
  Author: BeAPI
  Author URI: http://www.beapi.fr
  Version: 0.2

 */
 
// don't load directly
if ( !defined('ABSPATH') ) {
	die('-1');
}

// Plugin constants
define('BEA_REDIRECT_VERSION', '0.2');

// Plugin URL and PATH
define('BEA_REDIRECT_URL', plugin_dir_url ( __FILE__ ) );
define('BEA_REDIRECT_DIR', plugin_dir_path( __FILE__ ) );

// Function for easy load files
function _bea_redirect_load_files($dir, $files, $prefix = '') {
	foreach ($files as $file) {
		if ( is_file($dir . $prefix . $file . ".php") ) {
			require_once($dir . $prefix . $file . ".php");
		}
	}	
}

// Plugin client classes
_bea_redirect_load_files(BEA_REDIRECT_DIR . 'classes/', array( 'main', 'plugin' ) );

// Admin
if ( is_admin() ) {
	_bea_redirect_load_files( BEA_REDIRECT_DIR . 'classes/admin/', array( 'main', 'menu-redirect' ) );	
}

add_action('plugins_loaded', 'init_bea_redirect_plugin');

function init_bea_redirect_plugin() {
	
	// Client
	new bea_redirect_to_fr_plug();

	// Admin
	if ( is_admin() ) {
		
		// Load translations
		load_plugin_textdomain( 'blog-redirect', false, basename( BEA_REDIRECT_DIR ) . '/lang' );		
		
		new BEA_Rediderect_Admin_Main();
		new BEA_Redirect_Plugin();
	}
	
}
