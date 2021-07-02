<?php namespace WSUWP\Plugin\News\PostTypes;


class News_Feed {

	private static $slug = 'news_feed';

    private static $attributes = array(
        'labels' => array(
            'name' => 'News Feeds',
            'singular_name' => 'News Feed'
        ),
        'description' => '',
        'show_ui' => true,
        'show_in_menu' => 'news_templates',
		'show_in_rest' => true,
    );

    public static function register_post_type(){

        register_post_type( self::$slug, self::$attributes );

    }

	public static function set_default_content($postId, $post){

		if ($post->post_type == self::$slug){
			$args = array(
				'numberposts' => 1,
				'post_type' => self::$slug,
			);

			$latest_post = array_shift( wp_get_recent_posts( $args ) );

			$content = $latest_post['post_content'];

			return $content;
		}

	}

    public function init() {

        add_action( 'init', __CLASS__ . '::register_post_type' );
		add_filter( 'default_content', __CLASS__ . '::set_default_content', 10, 2 );

    }

}

(new News_Feed)->init();
