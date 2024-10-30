<?php
/**
 * LM Easy Maps selector widget
 *
 * Crea un widget in cui è possibile inserire un titolo e una mappa
 * creata con il plugin "LM Easy Maps" e un pulsante per un link
 * https://#
 * @Text Domain: lm-easy-maps
 * @Domain Path: /languages
 * @author leonardoboss, marsy79
 * @version 1.1
 * @copyright Copyright (c) 2020, leonardoboss, marsy79
 */

class LMEasyMaps extends WP_Widget {

 
	public function __construct() {
		parent::__construct (
			'LMEasyMaps', // ID del widget
			__('LMEasyMaps', 'lm-easy-maps'), //Nome del widget che appare nell'interfaccia
			array('description' => __('Show one map!', 'lm-easy-maps' ),) //Descrizione del Widget
		);
	}
  
	function widget($args, $instance) {
		// PART 1: Extracting the arguments + getting the values
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$mappa = empty($instance['mappa']) ? '' : $instance['mappa'];
		$link = empty($instance['link']) ? '' : $instance['link'];
		$pulsante = empty($instance['pulsante']) ? '' : $instance['pulsante'];

		// Before widget code, if any
		echo (isset($before_widget)?$before_widget:'');

		// PART 2: The title and the text output
		if (!empty($title))	echo $before_title . $title . $after_title;
		?>
		<div style="height: 60px"></div>
		<?php
		if (!empty($mappa)) echo do_shortcode('[LMEasyMaps map_id="lm-easy-maps-'.$mappa.'"]');
		if (!empty($link)): ?>
			<div align="center" style="margin: 60px">
				<a href="<?php echo $link; ?>" type="button" class="btn btn-primary btn-lg"><?php echo $pulsante; ?></a>
			</div>
<?php	endif;

		// After widget code, if any  
		echo (isset($after_widget)?$after_widget:'');
	}
 
	public function form( $instance ) {
		if (isset($instance['title'])) $title = $instance['title'];
		else $title = __('New title', 'lm-easy-maps');	  

		if (isset($instance['mappa'])) $mappa = $instance['mappa'];
		else $mappa = __('Select a map', 'lm-easy-maps');
		
		if (isset($instance['link'])) $link = $instance['link'];
		else $link ='';
		
		if (isset($instance['pulsante'])) $pulsante = $instance['pulsante'];
		else $pulsante = __('Insert text for button', 'lm-easy-maps');

		 // PART 2-3: Display the fields
		 ?>
		 
		<p> <!-- PART 2: Widget Title field START -->
			<label for="<?php echo $this->get_field_id('title'); ?>">Title: 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p> <!-- Widget Title field END -->

			<!-- PART 3: Widget City field START -->
		<p>

		<?php	
		global $wpdb;
		$sql = "
			select $wpdb->posts.ID, $wpdb->posts.post_title from $wpdb->postmeta, $wpdb->posts
			where meta_key like 'lm-easy-maps-%'
				and $wpdb->postmeta.post_id = $wpdb->posts.ID
				and $wpdb->posts.post_status = 'publish'
			";
		$rows = $wpdb->get_results($sql);
		
		$rowcount = $wpdb->num_rows;
		?>
		  <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Map','lm-easy-maps')?>:
			<select class='widefat' id="<?php echo $this->get_field_id('mappa'); ?>" name="<?php echo $this->get_field_name('mappa'); ?>" type="text">
		<?php foreach ($rows as &$arr_result):
				foreach ($arr_result as $k => $v):
					if ($k == 'ID') $post_id = $v;
					if ($k == 'post_title'): ?>
			  <option value='<?php echo ($post_id) ?>'<?php echo ($mappa==$v)?'selected':''; ?>>
				<?php echo ($v) ?>
			  </option>
		<?php 		endif;
				endforeach;
			endforeach; ?>
			</select>                
		  </label>
		 </p>
		 <!-- Widget City field END -->

		<div>
			<p>
				<label for="radiosi"><?php _e("Insert a link in the appropriate field to display the button",'lm-easy-maps')?>:</label>
			</p>
			<p> <!-- PART 2: Widget Title field START -->
				<label for="<?php echo $this->get_field_id('pulsante'); ?>"><?php _e('Button text','lm-easy-maps')?>:
					<input class="widefat" id="<?php echo $this->get_field_id('pulsante'); ?>" name="<?php echo $this->get_field_name('pulsante'); ?>" type="text" value="<?php echo esc_attr($pulsante); ?>" />
				</label>
			</p> <!-- Widget Title field END -->
			<p> <!-- PART 2: Widget Title field START -->
				<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link','lm-easy-maps')?>: 
					<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
				</label>
			</p> <!-- Widget Title field END -->
		</div>
		<?php
	}

	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['mappa'] = $new_instance['mappa'];
		$instance['link'] = $new_instance['link'];
		$instance['pulsante'] = $new_instance['pulsante'];
		return $instance;
	}
  
}

add_action( 'widgets_init', create_function('', 'return register_widget("LMEasyMaps");') );
?>