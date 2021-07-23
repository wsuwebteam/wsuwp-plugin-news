<?php

namespace WSUWP\Plugin\News;


class Taxonomies
{

	private static $custom_fields = array(
		'media_contact' => array(
			'organization' => array(
				'label' => 'Organization/Affiliation',
				'description' => ''
			),
			'email' => array(
				'label' => 'Email',
				'description' => ''
			),
			'phone_number' => array(
				'label' => 'Phone Number',
				'description' => ''
			),
		),
		'author' => array(
			'organization' => array(
				'label' => 'Organization/Affiliation',
				'description' => ''
			),
			'email' => array(
				'label' => 'Email',
				'description' => ''
			),
		)
	);

	public static function register_taxonomies()
	{

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
		register_taxonomy('author', 'news_article', $authors);
		register_taxonomy('media_contact', 'press_release', $media_contacts);

	}

	public static function taxonomy_custom_edit_fields($tag)
	{

		$t_id = $tag->term_id;
		$term_meta = get_option("taxonomy_term_$t_id");
		$custom_fields = self::$custom_fields[$tag->taxonomy];

		foreach ($custom_fields as $key => $field) {
			self::render_edit_field($key, $field, $term_meta);
		}

	}

	public static function taxonomy_custom_add_fields($taxonomy_slug)
	{

		$custom_fields = self::$custom_fields[$taxonomy_slug];

		foreach ($custom_fields as $key => $field) {
			self::render_add_field($key, $field);
		}

	}

	public static function render_edit_field($key, $field, $term_meta){
	?>
		<tr class="form-field">
			<th scope="row">
				<label for="<?= $key ?>"><?= _e($field['label']) ?></label>
			</th>
			<td>
				<input type="text" name="term_meta[<?= $key ?>]" id="term_meta[<?= $key ?>]" size="40" value="<?= $term_meta[$key] ?>">
				<p class="description"><?= $field['description'] ?></p>
			</td>
		</tr>
	<?
	}

	public static function render_add_field($key, $field){
	?>
		<div class="form-field">
			<label for="<?= $key ?>"><?= _e($field['label']) ?></label>
			<input name="term_meta[<?= $key ?>]" id="term_meta[<?= $key ?>]" type="text" value="" size="40">
			<p><?= $field['description'] ?></p>
		</div>
	<?
	}

	public static function save_taxonomy_custom_fields($term_id)
	{

		if ( isset( $_POST['term_meta'] ) ) {
			$t_id = $term_id;
			$term_meta = get_option( "taxonomy_term_$t_id" );
			$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ){
				if ( isset( $_POST['term_meta'][$key] ) ){
					$term_meta[$key] = $_POST['term_meta'][$key];
				}
			}

			//save the option array
			update_option( "taxonomy_term_$t_id", $term_meta );
		}

	}

	public function init()
	{

		add_action('init', __CLASS__ . '::register_taxonomies');

		add_action('author_add_form_fields', __CLASS__ . '::taxonomy_custom_add_fields', 10, 2);
		add_action('media_contact_add_form_fields', __CLASS__ . '::taxonomy_custom_add_fields', 10, 2);
		add_action('author_edit_form_fields', __CLASS__ . '::taxonomy_custom_edit_fields', 10, 2);
		add_action('media_contact_edit_form_fields', __CLASS__ . '::taxonomy_custom_edit_fields', 10, 2);

		add_action('edited_author', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2);
		add_action('edited_media_contact', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2);
		add_action('created_author', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2);
		add_action('created_media_contact', __CLASS__ . '::save_taxonomy_custom_fields', 10, 2);

	}
}

(new Taxonomies)->init();
