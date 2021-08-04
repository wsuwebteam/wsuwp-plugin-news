<?php namespace WSUWP\Plugin\News;

class Remove_Post_Type {

	public function remove_draft_widget() {
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	}

	public function remove_default_post_type_menu_bar( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'new-post' );
	}

	public function remove_default_post_type() {
		remove_menu_page( 'edit.php' );
	}

	public static function init() {
		/*** Remove Default Post Type */

		// Remove from Quick Draft
		add_action( 'wp_dashboard_setup', array( $this, 'remove_draft_widget' ), 999 );

		// Remove from +New Post in Admin Bar
		add_action( 'admin_bar_menu', array( $this, 'remove_default_post_type_menu_bar' ), 999 );

		// Remove from the Side Menu
		add_action( 'admin_menu', array( $this, 'remove_default_post_type' ) );

	}

}

Remove_Post_Type::init();
