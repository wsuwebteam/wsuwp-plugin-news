<?php namespace WSUWP\Plugin\News;

class Taxonomies {

	private static $custom_fields = array(
		'media_contact' => array(
			'organization' => array(
				'label'        => 'Organization/Affiliation',
				'description'  => '',
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => array(
					'schema' => array(
						'type' => 'string',
					),
				),
			),
			'email'        => array(
				'label'        => 'Email',
				'description'  => '',
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => array(
					'schema' => array(
						'type'   => 'string',
						'format' => 'email',
					),
				),
			),
			'phone_number' => array(
				'label'        => 'Phone Number',
				'description'  => '',
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => array(
					'schema' => array(
						'type' => 'string',
					),
				),
			),
		),
		'author'        => array(
			'organization' => array(
				'label'        => 'Organization/Affiliation',
				'description'  => '',
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => array(
					'schema' => array(
						'type' => 'string',
					),
				),
			),
			'email'        => array(
				'label'        => 'Email',
				'description'  => '',
				'type'         => 'string',
				'single'       => true,
				'show_in_rest' => array(
					'schema' => array(
						'type'   => 'string',
						'format' => 'email',
					),
				),
			),
		),
	);

	public static function register_taxonomies() {
		$authors = array(
			'labels'       => array(
				'name'          => 'Authors',
				'singular_name' => 'Author',
			),
			'description'  => '',
			'hierarchical' => false,
			'public'       => true,
			'show_in_rest' => true,
		);

		$media_contacts = array(
			'labels'       => array(
				'name'          => 'Media Contacts',
				'singular_name' => 'Media Contact',
			),
			'description'  => '',
			'hierarchical' => false,
			'public'       => true,
			'show_in_rest' => true,
		);

		// register taxonomies
		register_taxonomy( 'author', 'news_article', $authors );
		register_taxonomy( 'media_contact', 'press_release', $media_contacts );
		self::add_custom_fields_to_rest_response( self::$custom_fields );
	}

	public static function add_custom_fields_to_rest_response( $custom_fields ) {
		foreach ( $custom_fields as $taxonomy_slug => $fields ) {
			foreach ( $fields as $field_slug => $field ) {
				register_term_meta(
					$taxonomy_slug,
					$field_slug,
					array(
						'type'         => $field['type'],
						'description'  => $field['description'],
						'single'       => $field['single'],
						'show_in_rest' => $field['show_in_rest'],
					)
				);
			}
		}
	}

	public static function taxonomy_custom_edit_fields( $tag ) {
		$t_id          = $tag->term_id;
		$term_meta     = get_term_meta( $t_id );
		$custom_fields = self::$custom_fields[ $tag->taxonomy ];

		foreach ( $custom_fields as $key => $field ) {
			self::render_edit_field( $key, $field, $term_meta );
		}
	}

	public static function taxonomy_custom_add_fields( $taxonomy_slug ) {

		$custom_fields = self::$custom_fields[ $taxonomy_slug ];

		foreach ( $custom_fields as $key => $field ) {
			self::render_add_field( $key, $field );
		}

	}

	public static function render_edit_field( $key, $field, $term_meta ) {
		$value = isset( $term_meta[ $key ][0] ) ? $term_meta[ $key ][0] : '';
		?>
		<tr class="form-field">
			<th scope="row">
				<label for="<?php echo $key; ?>"><?php echo _e( $field['label'] ); ?></label>
			</th>
			<td>
				<input type="text" name="term_meta[<?php echo $key; ?>]" id="term_meta[<?php echo $key; ?>]" size="40" value="<?php echo $value; ?>">
				<p class="description"><?php echo $field['description']; ?></p>
			</td>
		</tr>
		<?php
	}

	public static function render_add_field( $key, $field ) {
		?>
		<div class="form-field">
			<label for="<?php echo $key; ?>"><?php echo _e( $field['label'] ); ?></label>
			<input name="term_meta[<?php echo $key; ?>]" id="term_meta[<?php echo $key; ?>]" type="text" value="" size="40">
			<p><?php echo $field['description']; ?></p>
		</div>
		<?php
	}

	public static function save_taxonomy_custom_fields( $term_id ) {

		if ( isset( $_POST['term_meta'] ) ) {
			$term_keys = array_keys( $_POST['term_meta'] );

			foreach ( $term_keys as $key ) {
				$value = sanitize_text_field( $_POST['term_meta'][ $key ] );

				if ( isset( $value ) ) {
					$prev = get_term_meta( $term_id, $key, true );

					if ( ! empty( $prev ) ) {
						update_term_meta( $term_id, $key, $value, $prev );
					} else {
						add_term_meta( $term_id, $key, $value, false );
					}
				}
			}
		}

	}

	public static function init() {

		add_action( 'init', __CLASS__ . '::register_taxonomies' );

		add_action( 'author_add_form_fields', __CLASS__ . '::taxonomy_custom_add_fields', 10, 2 );
		add_action( 'media_contact_add_form_fields', __CLASS__ . '::taxonomy_custom_add_fields', 10, 2 );
		add_action( 'author_edit_form_fields', __CLASS__ . '::taxonomy_custom_edit_fields', 10, 2 );
		add_action( 'media_contact_edit_form_fields', __CLASS__ . '::taxonomy_custom_edit_fields', 10, 2 );

		add_action( 'edited_author', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2 );
		add_action( 'edited_media_contact', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2 );
		add_action( 'created_author', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2 );
		add_action( 'created_media_contact', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2 );

	}

}

Taxonomies::init();
