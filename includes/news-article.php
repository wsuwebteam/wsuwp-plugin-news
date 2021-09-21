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
			'slug'       => 'news',
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

			$url_array = explode( '/news/', $url );

			$url = $url_array[0] . '/news/';

			$url .= get_the_date( 'Y', $post->ID ) . '/';
			$url .= get_the_date( 'm', $post->ID ) . '/';
			$url .= get_the_date( 'd', $post->ID ) . '/';
			$url .= $url_array[1];

		}

		return $url;

	}

	public static function register_post_type() {

		add_rewrite_rule(
			'^news/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/([^/]+)',
			'index.php?news_article=$matches[4]',
			'top'
		);
		add_rewrite_rule(
			'^news/([0-9]{4})/([0-9]{1,2})/?$',
			'index.php?post_type=news_article&year=$matches[1]&monthnum=$matches[2]',
			'top'
		);
		add_rewrite_rule(
			'^news/([0-9]{4})/?$',
			'index.php?post_type=news_article&year=$matches[1]',
			'top'
		);

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

		add_filter( 'wsu_wds_component_post_byline', array( __CLASS__, 'set_author' ) );

		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 12 );

	}

	public static function register_taxonomies() {

		register_taxonomy_for_object_type( 'wsuwp_university_location', self::$slug );

		register_taxonomy_for_object_type( 'wsuwp_university_org', self::$slug );
		
	}


	public static function set_author( $attrs ) {

		if ( 'news_article' === get_post_type() && taxonomy_exists( 'author' ) ) {

			$attrs['authors'] = array();

			$post_id = get_the_ID();

			$terms = get_the_terms( $post_id, 'author' );

			if ( is_array( $terms ) ) {

				foreach ( $terms as $term ) {

					$author = array(
						'name' => $term->name,
						'title' => get_term_meta( $term->term_id, 'organization', true ),
					);

					$attrs['authors'][] = $author;
				}
			}
		}

		return $attrs;
	}

}

News_Article::init();
