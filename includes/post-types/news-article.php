<?php namespace WSUWP\Plugin\News\PostTypes;


class News_Article {

	private static $slug = 'news_article';

    private static $attributes = array(
        'labels' => array(
            'name' => 'News Articles',
            'singular_name' => 'News Article'
        ),
        'description' => '',
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'menu_position' => 4,
        'menu_icon' => 'dashicons-media-document',
        'supports' => array(
            'title',
             'editor',
             'thumbnail',
             'excerpt',
             'comments'
        ),
        'rewrite' => array(
            'slug' => '%year%/%monthnum%/%day%',
            'with_front' => false
        ),
        'taxonomies' => array(
            'post_tag',
            'category',
            'media_contact'
        )
    );

    public static function post_type_link($url, $post) {

		if ( self::$slug == get_post_type($post) ) {
			$url = str_replace( "%year%", get_the_date('Y'), $url );
			$url = str_replace( "%monthnum%", get_the_date('m'), $url );
			$url = str_replace( "%day%", get_the_date('d'), $url );
		}

		return $url;

	}

    public static function register_post_type(){

        register_post_type( self::$slug, self::$attributes );

    }

    public function init() {

        add_action( 'init', __CLASS__ . '::register_post_type' );

        // Converts the Structure Tags in our permalink.
        add_filter( 'post_type_link', __CLASS__ . '::post_type_link', 10, 2 );

    }

}

(new News_Article)->init();
