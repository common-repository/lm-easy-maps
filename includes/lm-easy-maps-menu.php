<?php
/**
 * Registers LM Easy Map post type.
 */

function LMEasyMaps_menu() {

	$labels = array(
		'name'               => __( 'LM Easy Maps', 'lm-easy-maps' ),
		'singular_name'      => __( 'LM Easy Map', 'lm-easy-maps' ),
		'add_new'            => __( 'Add new map', 'lm-easy-maps' ),
		'add_new_item'       => __( 'Add new map', 'lm-easy-maps' ),
		'edit_item'          => __( 'Edit map','lm-easy-maps' ),
		'new_item'           => __( 'Add new map', 'lm-easy-maps' ),
		'view_item'          => __( 'View map', 'lm-easy-maps' ),
		'search_items'       => __( 'Search map', 'lm-easy-maps' ),
		'not_found'          => __( 'Maps not found', 'lm-easy-maps' ),
		'not_found_in_trash' => __( 'Maps not found in the trash', 'lm-easy-maps' )
	);

	$supports = array(
		'title',
	);
	

	$args = array(
		'labels'               => $labels,
		'supports'             => $supports,
		'public'               => true,
		'capability_type'      => 'post',
		'rewrite'              => array( 'slug' => 'lm-easy-maps' ),
		'has_archive'          => true,
		'menu_position'        => 30,
		'menu_icon'            => 'dashicons-location-alt',
		'register_meta_box_cb' => 'add_lmemaps_metaboxes',
	);

	register_post_type( 'lm-easy-maps', $args );

}
add_action( 'init', 'LMEasyMaps_menu' );

function add_lmemaps_metaboxes() {

	add_meta_box(
		'lm_easy_maps',
		__( 'Map', 'lm-easy-maps' ),
		'lm_easy_maps',
		'lm-easy-maps',
		'normal',
		'high'
	);

}
// Questo è utile per aggiungere colonne in un post_type
// manage_***_posts_columns (al posto degli**** mettere lo  slug )
add_filter( 'manage_lm-easy-maps_posts_columns', 'set_custom_edit_lmemaps_columns' );

function set_custom_edit_lmemaps_columns( $columns ) {
  $date = $colunns['date'];
  unset( $columns['date'] );

  $columns['shortcode'] = __( 'ShortCode', 'lm-easy-maps' );
  $columns['date'] = __( 'Date', 'lm-easy-maps' );

  return $columns;
}


add_action( 'manage_lm-easy-maps_posts_custom_column' , 'custom_lmemaps_column', 10, 2 );

function custom_lmemaps_column( $column, $post_id ) {
	
  switch ( $column ) {
   case 'shortcode' :
        $short = '[LMEasyMaps map_id="lm-easy-maps-'.$post_id.'"]';
		echo $short;
      break;
  }
}

function lm_easy_maps() {
	global $post;

	// Nonce field to validate form request came from current site
	wp_nonce_field( LMEMAPS_BASENAME_FILE, 'lmemaps_fields' );
	LMEasyMaps_modifica_mappa();
}
