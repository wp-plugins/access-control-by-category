<?php
/*
Plugin Name: Access Control by Category
Plugin URI: http://dev.coziplace.com
Description:  Visitors must logged on to see the content of any posts under "Subscribed" category. Any texts within [subscribed] shortcode will also be restricted to logged-in users. This can be used as a simple membership system. Need full version of this plugin, please visit <a href="http://dev.coziplace.com"> Official Page </a> of this plugin.
Author: Narin Olankijanan
Version: 1.2
Author URI: http://dev.coziplace.com
License: GPLv2
*/

/* Copyright 2012 Narin Olankijanan (email: narin@dekisugi.net)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this progam; if not, write to the Free Software Foundation, Inc. 51 Franklin St, Fifth floor, Boston MA 02110-1301 USA
*/
add_shortcode('subscribed', 'dk_shortcode');

function dk_shortcode ($attr, $content) {

  if (is_user_logged_in()) {
      return $content;
  } else {
      return "[You must log in to view the remaining texts...]";
  }
}


add_filter('the_content', 'dk_res_post');

function dk_res_post($content){
        global $post; 
	$post_id = $post->ID;
        $cats = wp_get_post_categories( $post_id );
	$is_restricted = false;
	$post_categories = wp_get_post_categories( $post_id );
	
	foreach($post_categories as $c){
		$cat = get_category( $c );
     	        if ($cat->name == "Subscribed") {
                  $is_restricted = true;
                  break;
                }		
        }
	if ($is_restricted AND !is_user_logged_in()) {
          return "[You must log in to see the full content of this post.]";
     
	} else {
          return $content;
        }
}



/* EOF */