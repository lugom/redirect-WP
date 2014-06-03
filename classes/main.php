<?php

class bea_redirect_to_fr_plug {
	
	public function __construct(){
		add_action( 'init', array( __CLASS__, 'redirect' ) );
	}
	
	public static function redirect(){
		if( is_user_logged_in() ){
			return false;
		}
		
		$blogid = get_current_blog_id();
		
		switch_to_blog( 1 );
		
		$redirected_blog = get_option( 'redirected_blog' );
		$redirected_blog_to = get_option( 'redirected_blog_to' );
		
		if( !isset( $redirected_blog ) && !is_array( $redirected_blog ) ){
			restore_current_blog();
			return false;
		}
		
		if( !isset( $redirected_blog_to ) && !is_array( $redirected_blog_to ) ){
			restore_current_blog();
			return false;
		}
		//test if is frensh blog
		if( in_array( $blogid, $redirected_blog ) ){
			//redirect blog to overone
			switch_to_blog( $redirected_blog_to );
			wp_redirect( home_url() );
			exit;
		}
		
		restore_current_blog();
		return false;
		
	}
}