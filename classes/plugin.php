<?php

class BEA_Redirect_Plugin {

	public function __construct() {
	}
	
	/**
	 * Get template file depending on theme
	 * @author Lucie Gomes
	 */
	public static function get_template( $tpl = '' ) {
		if ( empty( $tpl ) ) {
			return false;
		}

		if ( is_file( STYLESHEETPATH . '/views/' . $tpl . '.tpl.php' ) ) {// Use custom template from child theme
			return ( STYLESHEETPATH . '/views/' . $tpl . '.tpl.php' );
		} elseif ( is_file( TEMPLATEPATH . '/views/' . $tpl . '.tpl.php' ) ) {// Use custom template from parent theme
			return (TEMPLATEPATH . '/views/' . $tpl . '.tpl.php' );
		} elseif ( is_file( BEA_REDIRECT_DIR . '/views/admin/' . $tpl . '.tpl.php' ) ) {// Use builtin template
			return ( BEA_REDIRECT_DIR . '/views/admin/' . $tpl . '.tpl.php' );
		}
		
		return false;
	}
}