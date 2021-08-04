<?php namespace WSUWP\Plugin\News;

class Content_Defaults {

	public static function get_content_from_latest_post( $slug ) {

		$args = array(
			'numberposts' => 1,
			'post_type'   => $slug,
		);

		$latest_post = array_shift( wp_get_recent_posts( $args ) );

		$content = $latest_post['post_content'];

		return $content;

	}

	public static function set_default_content( $content, $post ) {

		switch ( $post->post_type ) {
			case 'news_feed':
				$content = self::get_content_from_latest_post( 'news_feed' );
				break;
			case 'curated_news':
				$content = self::get_content_from_latest_post( 'curated_news' );
				break;
		}

		return $content;

	}

	public static function init() {

		add_filter( 'default_content', __CLASS__ . '::set_default_content', 10, 2 );

	}

}

Content_Defaults::init();
