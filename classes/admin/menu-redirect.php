<?php

class BEA_Redirect_Menu {
	public $_name = 'Redirection de blog' ;
	public $_domain = 'blog-redirect' ;
	
	public function __construct() {
	}

	/**
	 * Admin page
	 */
	public function admin_page() {
		global $wpdb, $current_site;

		if( !current_user_can( 'manage_sites' ) ){
			wp_die( "Sorry, you don't have permissions to use this page." );
		}

		$from_blog = false;
		$redirect_id = 0;
		$nonce_string = sprintf( '%s-%s', $this->_domain, $redirect_id );
		if( isset($_GET['blog']) && wp_verify_nonce( $_GET['_wpnonce'], $nonce_string ) ) {
			$redirect_id = (int)$_GET['blog'];
			$from_blog = get_blog_details( $redirect_id );
			if( $from_blog->site_id != $current_site->id ) {
				$from_blog = false;
			}
		}
		$from_blog_id = ( isset( $_POST['source_blog'] ) ) ? (int) $_POST['source_blog'] : -1;

		if( isset($_POST[ 'action' ]) && $_POST[ 'action' ] == $this->_domain ) {
			check_admin_referer( $this->_domain );
			$blog = array();
			if( isset( $_POST['blog'] ) && is_array( $_POST['blog'] ) ) {
				$blog = $_POST['blog'];
			}
			if ( !isset( $from_blog_id ) ) {
				$msg =  __( 'Choisissez un blog source.' , $this->_domain );
			} elseif( isset( $_POST['save'] ) ) {
				$msg = $this->redirect_blog( $blog, $from_blog_id );
			}else {
				$msg = $this->delet_redirection();
			}
		}
		
		
		if( !$from_blog ) {
			$query = "SELECT b.blog_id, CONCAT(b.domain, b.path) as domain_path FROM {$wpdb->blogs} b " .
				"WHERE b.site_id = {$current_site->id} && b.blog_id > 1 ORDER BY domain_path ASC LIMIT 10000";

			$blogs = $wpdb->get_results( $query );
		}
		
		if( !isset($blogs) ) { 
			$tpl_error = BEA_Redirect_Plugin::get_template( 'redirect-error' );
			require( $tpl_error );
			return false;
		}
		
		$redirected_blog = array();
		$option_rb = get_option( 'redirected_blog' ); 
		if( isset( $option_rb ) && $option_rb !== FALSE ){
			$redirected_blog = $option_rb;
		}

		$redirected_blog_to = 0;
		$option_rbt = get_option( 'redirected_blog_to' ); 
		if( isset( $option_rbt ) && $option_rbt !== FALSE ){
			$redirected_blog_to = $option_rbt;
		}
		
		if( $from_blog || $blogs ) { 	
			$tpl = BEA_Redirect_Plugin::get_template( 'redirect-site' );
			require( $tpl );
		 } 
	}

	/**
	 * redirect blog
	 *
	 */
	public function redirect_blog( $blog = array(), $from_blog_id = '' ) {
		$blogs = $blog['id'];
		
		$option_redirect = array();
		
		foreach ( $blogs as $blog_id ) {
			if( $blog_id == $from_blog_id ){
				continue;
			}
			$option_redirect[] = $blog_id;
		}
		
		update_option( 'redirected_blog', $option_redirect );
		
		update_option( 'redirected_blog_to', $from_blog_id );
		
		return __( 'redirection enregistrée', $this->_domain );
	}
	
	public function delet_redirection() {
		
		delete_option('redirected_blog');
		delete_option('redirected_blog_to');
		
		return __( 'Redirection supprimée', $this->_domain );
	}
}