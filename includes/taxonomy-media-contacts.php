<?php namespace WSUWP\Plugin\News;

class Taxonomy_Media_Contacts {

	public static function init() {

		add_filter( 'the_content', array( __CLASS__, 'append_media_contacts' ), 999 );

		add_action( 'set_object_terms', array( __CLASS__, 'order_media_contacts'), 10, 6 );

	}


	public static function order_media_contacts( $object_id, $terms, $tt_ids, $taxonomy, $append, $old_tt_ids ) {

		if ( 'media_contact' !== $taxonomy ) {
			return;
		}

		$media_contacts = implode( ',', $tt_ids );

		delete_post_meta( $object_id, '_media_contact_order' );

		// Save in comma-separated string format - may be useful for MySQL sorting via FIND_IN_SET().
		update_post_meta( $object_id, '_media_contact_order', $media_contacts );

	}


	public static function append_media_contacts( $content ) {

		if ( is_singular() ) {

			$post_id = get_the_ID();

			$terms = get_the_terms( $post_id, 'media_contact' );

			if ( ! is_array( $terms ) || empty( $terms ) ) {

				return $content;
			}

			$media_contact_ids = explode( ',', get_post_meta( $post_id, '_media_contact_order', true  ) );

			if ( empty( $media_contacts ) ) {

				$media_contacts = $terms;

			} else {

				$media_contacts = array();

				foreach ( $media_contact_ids as $media_contact_id ) {

					foreach ( $terms as $term ) {

						if ( (int) $media_contact_id === $term->term_id ) {

							$media_contacts[] = $term;

						}
					}
				}
			}

			if ( is_array( $media_contacts ) && ! empty( $media_contacts ) ) {

				$content .= '<h2 class="wsu-media-contact__heading">Media Contacts</h2>';

				$content .= '<ul class="wsu-media-contact__wrapper">';

				foreach ( $media_contacts as $term ) {

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

						$contact[] = '<a href="tel:+' . esc_attr( $phone ) . '">' . wp_kses_post( $phone ) . '</a>';

					}

					if ( ! empty( $email ) ) {

						$contact[] = '<a href="mailto:' . sanitize_email( $email ) . '">' . sanitize_email( $email ) . '</a>';

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