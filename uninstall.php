<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
		delete_option( 'rwp_howdy_text' );
		delete_option( 'rwp_eliminate_logo' );
		delete_option( 'rwp_eliminate_new_menu' );
		delete_option( 'rwp_eliminate_help' );
		delete_option( 'rwp_lower_left_text' );
		delete_option( 'rwp_login_logo' );
		delete_option( 'rwp_login_logo_height' );
		delete_option( 'rwp_remove_comp_dashboards' );
		delete_option( 'rwp_left_widget_title' );
		delete_option( 'rwp_left_widget_content' );
		delete_option( 'rwp_right_widget_title' );
		delete_option( 'rwp_right_widget_content' );
		delete_option( 'rwp_remove_from_admin_menu' );