<?php namespace WSUWP\Plugin\News\PostTypes;


class Curated_News {

	private static $slug = 'curated_news';

    private static $attributes = array(
        'labels' => array(
            'name' => 'Curated News',
            'singular_name' => 'Curated News'
        ),
        'description' => '',
        'show_ui' => true,
        'show_in_menu' => 'news_templates',
    );

    public static function register_post_type(){

        register_post_type( self::$slug, self::$attributes );

    }

    public function init() {

        add_action( 'init', __CLASS__ . '::register_post_type' );

    }

}

(new Curated_News)->init();
