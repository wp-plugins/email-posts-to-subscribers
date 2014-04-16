<?php
/*
Plugin Name: Email posts to subscribers
Plugin URI: http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/
Description: The aim of this plugin is One Time Configuration and Life Time Newsletter. This plugin generate a newsletter with the latest available posts in the blog and send to your subscriber. We can easily schedule the newsletter daily, weekly or monthly. 6 default templates available with this plugin also admin can create the templates using visual editor.
Version: 1.3
Author: Gopi Ramasamy
Donate link: http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/
Author URI: http://www.gopiplus.com/work/2014/03/28/wordpress-plugin-email-posts-to-subscribers/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  
Copyright 2014  Email posts to subscribers  (www.gopiplus.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

if (!session_id()) { session_start(); }
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.'defined.php');
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'stater.php');
add_action('admin_menu', array( 'elp_cls_registerhook', 'elp_adminmenu' ));
register_activation_hook(ELP_FILE, array( 'elp_cls_registerhook', 'elp_activation' ));
register_deactivation_hook(ELP_FILE, array( 'elp_cls_registerhook', 'elp_deactivation' ));
add_action( 'widgets_init', array( 'elp_cls_registerhook', 'elp_widget_loading' ));
add_shortcode( 'email-posts-subscribers', 'elp_shortcode' );
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'directly.php');

function elp_textdomain() 
{
	  load_plugin_textdomain( 'email-posts-to-subscribers' , false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'elp_textdomain');
?>