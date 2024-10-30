<?php
/*
Plugin Name: Clickback
Plugin URI: https://plugins.svn.wordpress.org/clickback-web-tracker
description: Clickback adds a small line of code to the head of your WordPress site so you can identify companies who have visited your website but have not converted.
Version: 2.05
Author: The Clickback Community
Author URI: https://www.clickback.com/website-lead-generation-software/
License: GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: www.clickback.com
 */

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not designed to be called directly.';
	exit;
}

define('CBW_VERSION', '2.5.0');
define('CBW_PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(CBW_PLUGIN_DIR . 'class.clickbackWEB.php');

add_action("wp_head", "cbw_addjscript");

function plugin_add_settings_link( $links ) {

    $settings_link = '<a href="admin.php?page=cb_web">' . __( 'Settings' ) . '</a>';

    array_unshift($links, $settings_link);

  	return $links;
}

$plugin = plugin_basename( __FILE__ );

add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require_once( CBW_PLUGIN_DIR . 'class.clickbackWEB-admin.php' );
    add_action( 'admin_init', 'cb_web_settings_init' );
}
?>