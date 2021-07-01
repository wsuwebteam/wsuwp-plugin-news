<?php namespace WSUWP\Plugin\News;


class Taxonomies {

	public static function register_taxonomies() {

        $authors = array(
            'labels' => array(
                'name' => 'Authors',
                'singular_name' => 'Author'
            ),
            'description' => '',
            'hierarchical' => false,
            'public' => true,
            'show_in_rest' => true
        );

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
        register_taxonomy( 'author', 'news_article', $authors );
        register_taxonomy( 'media_contact', 'press_release', $media_contacts );

	}

    public function init() {

        add_action( 'init', __CLASS__ . '::register_taxonomies' );

	}

}

(new Taxonomies)->init();
