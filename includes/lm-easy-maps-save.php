<?php

/**
 * Save the metabox data
 */
function lmeasymaps_save_maps_meta( $post_id, $post ) {
	global $post;

	// Return if the user doesn't have edit permissions.
	if (!current_user_can('edit_post', $post_id)) return $post_id;

	// Verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times.
	if (!isset($_POST['indirizzo']) || !wp_verify_nonce($_POST['lmemaps_fields'], LMEMAPS_BASENAME_FILE)) return $post_id;
	if (!isset($_POST['zoom']) || !wp_verify_nonce($_POST['lmemaps_fields'], LMEMAPS_BASENAME_FILE)) return $post_id;
	if (!isset($_POST['altezza']) || !wp_verify_nonce($_POST['lmemaps_fields'], LMEMAPS_BASENAME_FILE)) return $post_id;
	if (!isset($_POST['larghezza']) || !wp_verify_nonce($_POST['lmemaps_fields'], LMEMAPS_BASENAME_FILE)) return $post_id;
	
	// Now that we're authenticated, time to save the data.
	// This sanitizes the data from the field and saves it into an array $punti_meta.
	$punti_meta['center'] = sanitize_text_field($_POST['indirizzo']);
	$punti_meta['zoom'] = sanitize_text_field($_POST['zoom']);
	$punti_meta['altezza'] = sanitize_text_field($_POST['altezza']);
	$punti_meta['larghezza'] = sanitize_text_field($_POST['larghezza']);
	
	$key = 'lm-easy-maps-'.$post_id;
	$value = json_encode($punti_meta);
	
	if ('revision' === $post->post_type) return;
		
		// If the custom field already has a value, update it.
		if (get_post_meta($post_id, $key, false)) update_post_meta($post_id, $key, $value);
		// If the custom field doesn't have a value, add it.
		else add_post_meta( $post_id, $key, $value);
		
		// Delete the meta key if there's no value
		if (!$value) delete_post_meta( $post_id, $key );
}
add_action( 'save_post', 'lmeasymaps_save_maps_meta', 1, 2 );