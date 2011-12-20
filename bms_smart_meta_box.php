<?php

/**
 * @package BMS_Smart_Meta_Box
 * @author Mike Lathrop
 * @version 0.0.3
 */
/*
Plugin Name: BMS Smart Meta Box
Plugin URI: http://bigmikestudios.com
Description: Implements the Smart Meta Box class for other plugins
Version: 0.0.1
Author URI: http://bigmikestudios.com

THIS PLUGIN IS ONLY HERE TO MAKE THE CLASS FILE THAT INSTALLS WITH IT AVAILABLE TO OTHER PLUGINS.
*/

// Get Custom values with key "Expansion"

function bms_get_post_meta($post_id, $key) {
   global $wpdb;
   $sql = "SELECT m.meta_value FROM wp_postmeta m where m.meta_key = '$key' and m.post_id = '$post_id' order by m.meta_id";
   $results = $wpdb->get_results( $sql );
   $return = array();
   foreach( $results as $result )
   {
      $return[] = $result->meta_value;
      // Use value here
   }
   return $return;
}
   
?>