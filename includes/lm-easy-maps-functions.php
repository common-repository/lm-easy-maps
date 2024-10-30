<?php

require_once (LMEMAPS_INCLUDE_PATH . 'lm-easy-maps-menu.php');
require_once (LMEMAPS_INCLUDE_PATH . 'lm-easy-maps-modifica.php');
require_once (LMEMAPS_INCLUDE_PATH . 'lm-easy-maps-widget.php');
require_once (LMEMAPS_INCLUDE_PATH . 'lm-easy-maps-save.php');
require_once (LMEMAPS_FRONT_END_PATH . 'lm-easy-map.php'); 



function frammenti_load_textdomain() {
	load_plugin_textdomain( 'lm-easy-maps', false, LMEMAPS_BASENAME_DIR.'/languages/' ); 
}
add_action('plugins_loaded', 'frammenti_load_textdomain');

function LMEasyMaps_shortcut($atts) {
	$a = shortcode_atts(array('map_id' => ''), $atts);
	$mapString ='';
	include LMEMAPS_FRONT_END_PATH . 'lm-easy-map.php';
	return $mapString;
}
add_shortcode( 'LMEasyMaps', 'LMEasyMaps_shortcut' );
add_filter( 'widget_text', 'do_shortcode' );