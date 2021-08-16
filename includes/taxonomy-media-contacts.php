<?php namespace WSUWP\Plugin\News;

class Taxonomy_Media_Contacts {

	public static function init() {

		add_filter( 'the_content', array( __CLASS__, 'append_media_contacts' ), 999 );

	}


	public static function append_media_contacts( $content ) {

		if ( is_singular() ) {

			$post_id = get_the_ID();

			$terms = get_the_terms( $post_id, 'media_contact' );

			if ( is_array( $terms ) & ! empty( $terms ) ) {

				$content .= '<h2 class="wsu-media-contact__heading">Media Contacts</h2>';

				$content .= '<ul class="wsu-media-contact__wrapper">';

				foreach ( $terms as $term ) {

					$content .= '<li class="wsu-media-contact">';

					$contact = array();

					$name         = $term->name;
					$title        = get_term_meta( $term->term_id, 'organization', true );
					$phone        = get_term_meta( $term->term_id, 'phone_number', true );
					$email        = get_term_meta( $term->term_id, 'email', true );

					if ( ! empty( $name ) ) {

						$contact[] = '<span class="wsu-media-contact__name">' . wp_kses_post( $name ) . '</span>';

					}

					if ( ! empty( $title ) ) {

						$contact[] = '<span class="wsu-media-contact__title">' . wp_kses_post( $title ) . '</span>';

					}

					if ( ! empty( $phone ) ) {

						$contact[] = '<a href="tel:+' . esc_attr( $phone ) . '">' . wp_kses_post( $phone ) . '</span>';

					}

					if ( ! empty( $phone ) ) {

						$contact[] = '<a href="mailto:' . esc_url( $email ) . '">' . wp_kses_post( $email ) . '</span>';

					}

					$content .= implode( ', ', $contact );

					$content .= '</li>';

				} // End foreach

				$content .= '</ul>';

			} // End if

		} // End if

		return $content;

	}

}

Taxonomy_Media_Contacts::init();