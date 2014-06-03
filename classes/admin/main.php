<?php
class BEA_Rediderect_Admin_Main {
	
	//create new submenu in admin menu
	public function __construct() { 
		add_action( 'network_admin_menu', array( __CLASS__, 'view_redirect_settings' ) ); 
	}
	/**
	 * Get template for redirect blog plugin
	 * @author Lucie Gomes
	 */	
	public static function view_redirect_settings() {
		
		$redirect_blog = new BEA_Redirect_Menu();
		
		add_submenu_page( 'sites.php', $redirect_blog->_name, $redirect_blog->_name, 'manage_sites', $redirect_blog->_domain, array( $redirect_blog, 'admin_page' ) );

	}
}