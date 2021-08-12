<?php namespace WSUWP\Plugin\News;

class Plugin {

	protected static $version = '0.0.4';

	public static function get( $property ) {
		switch ( $property ) {
			case 'version':
				return self::$version;

			case 'plugin_dir':
				return plugin_dir_path( dirname( __FILE__ ) );

			case 'plugin_url':
				return plugin_dir_url( dirname( __FILE__ ) );

			case 'template_dir':
				return plugin_dir_path( dirname( __FILE__ ) ) . '/templates';

			case 'class_dir':
				return plugin_dir_path( dirname( __FILE__ ) ) . '/classes';

			default:
				return '';
		}
	}

	public static function init() {
		require_once __DIR__ . '/scripts.php';
		//require_once __DIR__ . '/remove-post-type.php';
		//require_once __DIR__ . '/news-templates-page.php';
		require_once __DIR__ . '/news-article.php';
		//require_once __DIR__ . '/post-types/press-release.php';
		//require_once __DIR__ . '/post-types/announcement.php';
		//require_once __DIR__ . '/post-types/curated-news.php';
		//require_once __DIR__ . '/post-types//news-feed.php';
		require_once __DIR__ . '/taxonomies.php';
		//require_once __DIR__ . '/content-defaults.php';
	}
}

Plugin::init();
