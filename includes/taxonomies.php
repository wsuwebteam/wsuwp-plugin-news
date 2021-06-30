<?php namespace WSUWP\Plugin\News;


class Taxonomies {

	public function init() {

        add_action( 'init', __CLASS__ . '::register_taxonomies' );

	}


	public static function register_taxonomies() {

        $media_contacts = array(
            'labels' => array(
                'name' => 'Media Contacts',
                'singular_name' => 'Media Contact'
            ),
            'description' => '',
            'hierarchical' => false,
            'public' => true,
            'show_in_rest' => true
        );

        // register taxonomies
        register_taxonomy( 'media_contact', 'news_article', $media_contacts );

	}

}

(new Taxonomies)->init();
