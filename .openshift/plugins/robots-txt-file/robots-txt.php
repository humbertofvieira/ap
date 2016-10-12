<?php
/**
Plugin Name: WordPress Robots.txt File
Plugin URI: http://usefulblogging.com/wordpress-robots-txt-file
Description: Simply Create or Edit Robots.txt File From Your WordPress Dashboard.
Version: 1.4
Author: Ataul Ghani
Author URI: http://usefulblogging.com
Requires at least: 4.0
Tested Up to: 4.6.1
Stable Tag: trunk
License: GPL v2
*/

!defined('ABSPATH') && exit;

define('WP_ROBOTS_TXT_DIR', plugin_dir_path(__FILE__));

require_once WP_ROBOTS_TXT_DIR . 'inc/core.php';
if (is_admin()) {
    require_once WP_ROBOTS_TXT_DIR . 'inc/options-page.php';
    CD_RDTE_Admin_Page::init();
}

add_filter('robots_txt', 'cd_rdte_filter_robots', 10, 2);
register_activation_hook(__FILE__, 'cd_rdte_activation');
register_deactivation_hook(__FILE__, 'cd_rdte_deactivation');
