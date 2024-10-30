<?php
global $wpdb;
if (isset($a)):
	$lmEasyMapId = "{$a['map_id']}";
	$res_select = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$lmEasyMapId'");
	$rowcount = $wpdb->num_rows;
	if ($rowcount > 0):
		$map_value = $res_select ->meta_value;	
		$map = json_decode($map_value);
		$indirizzo = $map->center;
		$zoom = $map->zoom;
		$width = $map->larghezza;
		$height = $map->altezza;
		if($width != '100%') $width = $width.'px';
		if($height != '100%') $height = $height.'px';

		$mapString = '<div align="center" style="width:'.$width.';height:'.$height.'">';
		$mapString .= '<div class="mapouter">';
		$mapString .= '<div class="gmap_canvas">';
		$mapString .= '<iframe width="'.$width.'" height="'.$height.'"  src="https://maps.google.com/maps?q='.$indirizzo.'&t=&z='.$zoom.'&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>';
		$mapString .= '<a href="https://www.embedgooglemap.org"></a></div>';
		$mapString .= '<style>';
		$mapString .= '.mapouter { position:relative; text-align:right;	}';
		$mapString .= '.gmap_canvas { overflow:hidden; background:none!important; height:100%; width:100%; }';
		$mapString .= '</style></div></div>';
	endif;
endif;