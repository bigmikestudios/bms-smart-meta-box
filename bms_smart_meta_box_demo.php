<?php
/**
 * @package bms_smart_meta_box
 * @author Mike Lathrop
 * @version 0.0.1
 */
/*
Plugin Name: BMS Smart Meta Box Demo
Plugin URI: http://bigmikestudios.com
Depends: bms-smart-meta-box/bms_smart_meta_box.php
Description: Demonstrates the use of the BMS Smart Meta Box plugin
Version: 0.0.1
Author URI: http://bigmikestudios.com
*/



// =============================================================================

//////////////////////////
//
// ADD META BOX
//
//////////////////////////

if (is_admin()) {
	if (!class_exists('SmartMetaBox')) {
		require_once(ABSPATH . "wp-content/plugins/bms-smart-meta-box/SmartMetaBox.php");
	}
		
			
	new SmartMetaBox('demo', array(
		'title'     => 'BMS Portfolio',
		'pages'     => array('page'),
		'context'   => 'normal',
		'priority'  => 'high',
		'fields'    => array(
			array(
				'name' => 'Attached Image(s)',
				'id' => 'smp_attached_images',
				'type' => 'attached-images',
				'desc' => 'this field just shows the attached images'
			),
			
			array(
				'name' => 'Text',
				'id' => 'smb_text',
				'default' => 'default',
				'desc' => 'Description',
				'type' => 'text',
			),
			array(
				'name' => 'Textarea',
				'id' => 'smb_textarea',
				'default' => 'default',
				'desc' => 'Description',
				'type' => 'textarea',
			),
			array(
				'name' => 'Editor',
				'id' => 'smb_editor',
				'default' => 'default',
				'desc' => 'Description',
				'type' => 'editor',
			),
			array(
				'name' => 'Checkbox',
				'id' => 'smb_checkbox',
				'default' => 'true',
				'desc' => 'Description',
				'type' => 'checkbox',
			),
			array(
				'name' => 'Checkbox Group',
				'id' => 'smb_chekbox_group',
				'type' => 'checkbox-group',
				'options' => array(
					'This',
					'That',
					'The Other',
					)
			),	
			array(
				'name' => 'Select',
				'id' => 'smb_select',
				'default' => 'second-val',
				'desc' => 'Description',
				'type' => 'select',
				'options' => array(
					'first-val' => 'First',
					'second-val' => 'Second',
				)
			),
			array(
				'name' => 'Radios',
				'id' => 'smb_radio',
				'default' => 'second-val',
				'desc' => 'Description',
				'type' => 'radio',
				'options' => array(
					'first-val' => 'First',
					'second-val' => 'Second',
				)
			),
			array(
				'name' => 'Relationship',
				'type' => 'relationship',
				'id' => 'smb_relationship',
				'desc' => 'Description',
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
			),
		)
	));
}
?>
