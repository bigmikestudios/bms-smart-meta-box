<?php
/**
 * Meta box generator for WordPress
 * Compatible with custom post types
 *
 * Support input types: text, textarea, checkbox, select, radio
 *
 * @author: Mike Lathrop, forked from original by Nikolay Yordanov <me@nyordanov.com> http://nyordanov.com
 * @version: 1.0
 *
 */

class SmartMetaBox {
	
	protected $meta_box;
	
	protected $id;
	static $prefix = '_smartmeta_';

	// create meta box based on given data
	
	public function __construct($id, $opts) {
		if (!is_admin()) return;
		
		require_once('smart_meta_fields/file_meta.php');
		$this->meta_box = $opts;
		$this->id = $id;
		add_action('add_meta_boxes', array(&$this,
			'add'
		));
		add_action('save_post', array(&$this,
			'save'
		));
	}

	// Add meta box for multiple post types or templates
	
	public function add() {
		$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
		$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
		
		foreach ($this->meta_box['pages'] as $page) {
			// if template is unset, or this post uses the template...
			if ( !($this->meta_box['template']) or (in_array($template_file, $this->meta_box['template'])) ) {
					add_meta_box($this->id, $this->meta_box['title'], array(&$this,
					'show'
				) , $page, $this->meta_box['context'], $this->meta_box['priority']);
			}
		}
	}

	// Callback function to show fields in meta box
	
	public function show($post) {

		// Use nonce for verification
		echo '<input type="hidden" name="' . $this->id . '_meta_box_nonce" value="', wp_create_nonce('smartmetabox' . $this->id) , '" />';
		echo '<table class="form-table">';
		foreach ($this->meta_box['fields'] as $field) {
			
			extract($field);
			$id = self::$prefix . $id;
			$value = self::get($field['id']);
			$values = self::get($field['id'], false);
			
			$i = 0;
			foreach($values as $value) {
				// if it's a relationship, we only do this once.
				if ( 
				      ( ($field['type'] == 'relationship') && ($i++ == 0) ) 
					or 
					  ( $field['type'] != 'relationship')
					) {
						
					if (empty($value) && !sizeof(self::get($field['id'], false))) {
						$value = isset($field['default']) ? $default : '';
					}
					echo '<tr>', '<th style="width:20%"><label for="', $id, '">', $name, '</label></th>', '<td>';
					include "smart_meta_fields/$type.php";
					if (isset($desc)) {
						echo '&nbsp;<span class="description">' . $desc . '</span>';
					}
					echo '</td></tr>';
				}
			}
			
			if ( ($field['multiple'] == true ) or (empty($value) && !sizeof(self::get($field['id'], false))) ) {
				// we can have multiples, so add another blank one to fill.
				$value = isset($field['default']) ? $default : '';
				echo '<tr>', '<th style="width:20%"><label for="', $id, '">', $name, '</label></th>', '<td>';
				include "smart_meta_fields/$type.php";
				if (isset($desc)) {
					echo '&nbsp;<span class="description">' . $desc . '</span>';
				}
				echo '</td></tr>';
			}
				
			// unset extracted fields...
			foreach($field as $key=>$value) { unset($$key);	}
		}
		echo '</table>';
		
	}

	// Save data from meta box
	
	public function save($post_id) {
		
		// verify nonce
		if (!isset($_POST[$this->id . '_meta_box_nonce']) || !wp_verify_nonce($_POST[$this->id . '_meta_box_nonce'], 'smartmetabox' . $this->id)) {
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ('post' == $_POST['post_type']) {
			if (!current_user_can('edit_post', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
		foreach ($this->meta_box['fields'] as $field) {
			// print_r($field);
			$name = self::$prefix . $field['id'];
			$sanitize_callback = (isset($field['sanitize_callback'])) ? $field['sanitize_callback'] : '';
			// special case for relationships
			if ($field['type'] == 'relationship') {
				self::delete($field['id']);
				if (is_array($_POST[$name])) {
					foreach($_POST[$name] as $value) {
						$my_post = get_post($value);
						
						$add = false;
						if (is_array($field['post_type'])) {
							if (in_array($my_post->post_type, $field['post_type'])) {
								$add = true;
							}
						} else if ($my_post->post_type == $field['post_type']) {
							$add = true;
						}
						if ($add) add_post_meta($post_id, $name, $value);
					}
				}
			} else {
				$old = self::get($field['id'], true, $post_id);
				$new = $_POST[$name];
				if (isset($_POST[$name]) || isset($_FILES[$name])) {
					if ($field['multiple'] == true) {
						self::delete($field['id']);
						if (is_array($_POST[$name])) {
							foreach($_POST[$name] as $value) {
								if (strlen(trim($value)) > 0) {
									add_post_meta($post_id, $name, $value);
								}
							}
						}
					} else {
						self::set($field['id'], $new, $post_id, $sanitize_callback);
					}
				} elseif ($field['type'] == 'checkbox') {
					self::set($field['id'], 'false', $post_id, $sanitize_callback);
				} else {
					self::delete($field['id'], $name);
				}
			}
		}
	}
	static function get($name, $single = true, $post_id = null) {
		global $post;
		return get_post_meta(isset($post_id) ? $post_id : $post->ID, self::$prefix . $name, $single);
	}
	static function set($name, $new, $post_id = null, $sanitize_callback = '') {
		global $post;
        
		$id = (isset($post_id)) ? $post_id : $post->ID;
		$meta_key = self::$prefix . $name;
		$new = ($sanitize_callback != '' && is_callable($sanitize_callback)) ? call_user_func($sanitize_callback, $new, $meta_key, $id) : $new;
		return update_post_meta($id, $meta_key, $new);
	}
	static function delete($name, $post_id = null) {
		global $post;
		return delete_post_meta(isset($post_id) ? $post_id : $post->ID, self::$prefix . $name);
	}
};
/*
function add_smart_meta_box($id, $opts) {
	new SmartMetaBox($id, $opts);
}
*/

