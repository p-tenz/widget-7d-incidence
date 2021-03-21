<?php
/**
 * Trigger this file on uninstall of the plugin
 * 
 * @package IncidenceWidgetPlugin
 * 
 */

 // security check that uninstall is called from Wordpress
 if ( ! defined( 'WP_PLUGIN_UNINSTALL' ) ) {
     die;
 }

// // clear database data: all posts  custom post
// // get all posts of type 'book'
//  $books = get_posts(array('post_type' => 'book', 'numberposts' => -1));  // post_type name must be same as in register_post_type, -1 means all

//  foreach($books as $book) {
//      wp_delete_post($book->ID, true);   // delete post even if it is in trash
//  }

//  // delete via SQL
//  global wpdb;

//  wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'book'");
//  wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );