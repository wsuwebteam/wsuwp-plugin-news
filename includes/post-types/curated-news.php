<?php namespace WSUWP\Plugin\News\PostTypes;

class Curated_News {

	private static $slug = 'curated_news';

	private static $attributes = array(
		'labels'       => array(
			'name'          => 'Curated News',
			'singular_name' => 'Curated News',
		),
		'description'  => '',
		'show_ui'      => true,
		'show_in_menu' => 'news_templates',
		'show_in_rest' => true,
		'supports'     => array(
			'title',
			'editor',
		),
	);

	public static function register_post_type() {

		register_post_type( self::$slug, self::$attributes );

	}

	// public static function on_insert_post($postId, $post){
	// if ($post->post_type == self::$slug && $post->post_status == "auto-draft") {
	// $args = array(
	// 'numberposts' => 1,
	// 'post_type' => self::$slug,
	// );

	// $latest_post = array_shift(wp_get_recent_posts( $args ));

	// $post->post_status = 'future';
	// $post->post_name = $latest_post['post_title'];
	// $post->post_title = $latest_post['post_title'];
	// $post->post_content = $latest_post['post_content'];

	// var_dump($latest_post);

	// wp_update_post($post);

	// need to rewrite url to newly created post
	// }
	// }

	public static function init() {

		add_action( 'init', __CLASS__ . '::register_post_type' );
		// add_action('wp_insert_post', __CLASS__ . '::on_insert_post', 10, 2);
	}

}

Curated_News::init();
