<?php
function LMEasyMaps_modifica_mappa () {
	global $wpdb;
	global $post;
	
	$lmEasyMapId = 'lm-easy-maps-'.$post->ID;
	$res_select = $wpdb->get_row("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '$lmEasyMapId'");
	
	if ($res_select != '' ) {
		$map_value = $res_select ->meta_value;	
		/* lettura dal db */	
		$map = json_decode($map_value);

		$indirizzo = $map->center;
		$zoom = $map->zoom;
		$width = $map->larghezza;
		$height = $map->altezza;
	}
	else {
		$indirizzo = 'Napoli';
		$zoom = '13';
		$width = '100%';
		$height = '100%';
	}

	if($width != '100%') $width = $width.'px';
	if($height != '100%') $height = $height.'px';
	?>
<style>
	.input-area {
		margin-top:10px;
	}
	.help {
		color: #878787;
		margin-top: -10px;
	}
	.dimensioni {
		display: none;
		margin-bottom: 20px;
	}
	.mapouter {
		border: 2px solid #0073aa;
		padding:5px;
	}
	.input100 {
		width: 100%;
	}
	label {
		font-weight: bold;
	}
</style>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php _e(get_admin_page_title()) ?></h1>
	<br><br>
	<div align="center">
		<div class="mapouter">
			<div class="gmap_canvas">
				<iframe width="<?php _e($width) ?>" height="<?php _e($height) ?>" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php _e($indirizzo) ?>&t=&z=<?php _e($zoom) ?>&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
				<a href="https://www.embedgooglemap.org"></a>
			</div>

			<style>
				.mapouter {
					position:relative;
					text-align:right;
					height:<?php _e($height) ?>;
					width:<?php _e($width) ?>;
				}
				.gmap_canvas {
					overflow:hidden;
					background:none!important;
					height:100%;
					width:100%;
				}
			 </style>
		</div>
	</div>	
	<div class="input-area">
		<form method='post'>
			<div class="address">
				<p>
					<label for="indirizzo"><?php _e('Address','lm-easy-maps')?></label>
					<input type="text" id="indirizzo" name="indirizzo" value="<?php _e($indirizzo) ?>" title="Map marker" class="input100"><br>
					<p class="help"><?php _e('Insert an address, point of interest or GPS coordinates (latitude, longitude)','lm-easy-maps')?></p>
				</p>
			</div>
			<label for="zoom"><?php _e('Zoom','lm-easy-maps')?></label>
			<input type="number" id="zoom" name="zoom" value="<?php _e($zoom) ?>" title="<?php _e('Insert the zoom level','lm-easy-maps')?>" size="2" style="width: 60px">

			<br><br>
			<h3><?php _e('Choose the size of the map','lm-easy-maps')?></h3>
		<p class="help"><?php _e('Choose whether to set a fixed dimension in <b> pixels </b> of the map or to cover all available space','lm-easy-maps')?></p>
			<p>
		<?php
		if ($height =='100%' && $width =='100%') $checked = 'full';
		else $checked = 'px';
			
		?>
				<label for="full"><?php _e('All the space','lm-easy-maps')?></label>
				<input type="radio" name="dimensioni" value="full" id="full" <?php if ($checked == 'full') echo 'checked' ?>>			
				<label for="px"><?php _e('Fixed size','lm-easy-maps')?></label>
				<input type="radio" name="dimensioni" value="px" id="px" <?php if ($checked == 'px') echo 'checked' ?>>
			</p>
			<div class="dimensioni">
				<label for="altezza"><?php _e('Height','lm-easy-maps')?></label>
				<input type="text" id="altezza" name="altezza" value="<?php _e(str_replace('px','',$height)) ?>">
				<label for="larghezza"><?php _e('Width','lm-easy-maps')?></label>
				<input type="text" id="larghezza" name="larghezza" value="<?php _e(str_replace('px','',$width)) ?>">

			</div>
		</div>
	</form>
</div>

<script>
	jQuery(document).ready(function() {
			if (jQuery('[name="dimensioni"]:checked').val() == 'px') {
				jQuery('.dimensioni').css('display','block');
			}
		});
	var alt = '';
	var lar = '';
	if (jQuery('[name="dimensioni"]:checked').val() == 'full') {
		alt = '100%';
		lar = '100%';
		jQuery("#larghezza").val(lar);
		jQuery("#gmap_canvas").attr('width',lar);
		jQuery('.mapouter').css('width',lar);
		jQuery('.gmap_canvas').css('width',lar);
		jQuery("#altezza").val(alt);
		jQuery("#gmap_canvas").attr('height',alt);
		jQuery('.mapouter').css('height',alt);
		jQuery('.gmap_canvas').css('height',alt);		
	}
	jQuery('[name="dimensioni"]').on('change',function() {
		var h = jQuery('.gmap_canvas').outerHeight();
		var w = jQuery('.gmap_canvas').outerWidth();
		if (jQuery('[name="dimensioni"]:checked').val() == 'px') {
			if (jQuery("#altezza").val() == '100%' && alt == '100%') jQuery("#altezza").val(h);
			else {
				jQuery("#altezza").val(alt);
				jQuery("#gmap_canvas").attr('height',alt);
				jQuery('.mapouter').css('height',alt);
				jQuery('.gmap_canvas').css('height',alt);
			}
			if (jQuery("#larghezza").val() == '100%' && lar == '100%') jQuery("#larghezza").val(w);
			else {
				jQuery("#larghezza").val(lar);
				jQuery("#gmap_canvas").attr('width',lar);
				jQuery('.mapouter').css('width',lar);
				jQuery('.gmap_canvas').css('width',lar);				
			}
			jQuery('.dimensioni').css('display','block');
		}
		else {
			lar = jQuery("#larghezza").val();
			alt = jQuery("#altezza").val();
			jQuery('.dimensioni').css('display','none');
			jQuery("#altezza").val('100%');
			jQuery("#larghezza").val('100%');
			jQuery("#gmap_canvas").attr('height','100%');
			jQuery('.mapouter').css('height','100%');
			jQuery('.gmap_canvas').css('height','100%');
			jQuery("#gmap_canvas").attr('width','100%');
			jQuery('.mapouter').css('width','100%');
			jQuery('.gmap_canvas').css('width','100%');		
		}
	});
	
	jQuery("#indirizzo").on('keyup',function(){
		jQuery("#gmap_canvas").attr('src','https://maps.google.com/maps?q='+jQuery("#indirizzo").val()+'&t=&z='+jQuery("#zoom").val()+'&ie=UTF8&iwloc=&output=embed')
	});
	jQuery("#zoom").bind('change keyup',function(){
		jQuery("#gmap_canvas").attr('src','https://maps.google.com/maps?q='+jQuery("#indirizzo").val()+'&t=&z='+jQuery("#zoom").val()+'&ie=UTF8&iwloc=&output=embed')
	});
	jQuery("#altezza").bind('change keyup',function(){
		jQuery("#gmap_canvas").attr('height',jQuery("#altezza").val());
		jQuery('.mapouter').css('height',jQuery("#altezza").val());
		jQuery('.gmap_canvas').css('height',jQuery("#altezza").val());
	});
	jQuery("#larghezza").bind('change keyup',function(){
		jQuery("#gmap_canvas").attr('width',jQuery("#larghezza").val());
		jQuery('.mapouter').css('width',jQuery("#larghezza").val());
		jQuery('.gmap_canvas').css('width',jQuery("#larghezza").val());
	});		

</script>	
<?php
	
}