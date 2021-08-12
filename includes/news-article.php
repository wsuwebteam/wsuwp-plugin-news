<?php namespace WSUWP\Plugin\News\PostTypes;

class News_Article {

	private static $slug = 'news_article';

	private static $attributes = array(
		'labels'        => array(
			'name'          => 'News Articles',
			'singular_name' => 'News Article',
		),
		'description'   => '',
		'public'        => true,
		'has_archive'   => true,
		'show_in_rest'  => true,
		'menu_position' => 4,
		'menu_icon'     => 'dashicons-media-document',
		'supports'      => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
		),
		'rewrite'       => array(
			'slug'       => 'news/%year%/%monthnum%/%day%',
			'with_front' => false,
		),
		'taxonomies'    => array(
			'post_tag',
			'category',
			'author',
		),
	);

	public static function post_type_link( $url, $post ) {

		if ( self::$slug == get_post_type( $post ) ) {
			$url = str_replace( '%year%', get_the_date( 'Y', $post->ID ), $url );
			$url = str_replace( '%monthnum%', get_the_date( 'm', $post->ID ), $url );
			$url = str_replace( '%day%', get_the_date( 'd', $post->ID ), $url );
		}

		return $url;

	}

	public static function register_post_type() {

		register_post_type( self::$slug, self::$attributes );

	}

	public static function add_post_type_to_archive( $query ) {

		if ( $query->is_main_query() && ! is_admin() && ( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) ) {

			$query_post_types = $query->get( 'post_type' );

			if ( ! is_array( $query_post_types ) ) {

				$query_post_types = array( $query_post_types );

			}

			$query_post_types[] = self::$slug;

			$query->set( 'post_type', $query_post_types );

		}
	}

	public static function init() {

		add_action( 'init', __CLASS__ . '::register_post_type' );

		// Converts the Structure Tags in our permalink.
		add_filter( 'post_type_link', __CLASS__ . '::post_type_link', 10, 2 );

		add_action( 'pre_get_posts', array( __CLASS__, 'add_post_type_to_archive' ) );

	}

}

News_Article::init();
