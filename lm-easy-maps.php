<?php
/*
Plugin Name: LM Easy Maps
Description: Generatore di Mappe Google, shortcodes e widget
Author: leonardoboss, marsy79
Text Domain: lm-easy-maps
Domain Path: /languages
Version: 1.1
*/
define ("LMEMAPS_BASENAME_FILE", basename(__FILE__));
define ("LMEMAPS_BASENAME_DIR", basename( dirname( __FILE__ ) ));
define ('LMEMAPS_INCLUDE_PATH', plugin_dir_path(__FILE__) . 'includes/');

define ('LMEMAPS_FRONT_END_PATH', plugin_dir_path(__FILE__) . 'front-end/');

require_once plugin_dir_path(__FILE__) . 'includes/lm-easy-maps-functions.php';

