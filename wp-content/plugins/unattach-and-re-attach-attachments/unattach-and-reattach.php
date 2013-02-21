<?php
/*************************************************************************
Plugin Name:  Unattach and Re-attach Media Attachments
Plugin URI:   
Description:  Allows to unattach and reattach images and other attachments from within the media library page.
Version:      1.1
Author:       davidn.de
**************************************************************************/


/*
 * Deletes 'post_parent' from an attachment to unattach attachment.
 */
function uar__unattach_attachment() {
	global $wpdb;
	
	if (!empty($_REQUEST['post_id'])) {
		$wpdb->update($wpdb->posts, array('post_parent'=>0),
		  array('id' => (int)$_REQUEST['post_id'], 'post_type' => 'attachment'));
	}
	
	wp_redirect(admin_url('upload.php'));
	exit;
}

/*
 * Implements action 'admin_menu' to provide a callback for
 * uar__unattach_attachment().
 */
function uar__admin_menu() {
	if ( current_user_can( 'upload_files' ) ) {
		//this is hacky but couldn't find the right hook
		add_submenu_page('tools.php', 'Unattach Media', 'Unattach', 'upload_files', 'unattach', 'uar__unattach_attachment');
		remove_submenu_page('tools.php', 'unattach');
	}
}
add_action( 'admin_menu', 'uar__admin_menu' );


/*
 * Implements filter 'manage_upload_columns' to replace column 'parent' with
 * out custom column 'extended_parent'.
 */
function uar__manage_upload_columns($columns) {
  unset($columns['parent']);
  $columns['extended_parent'] = __( 'Parent', 'uar');
  return $columns;
}
add_filter("manage_upload_columns", 'uar__manage_upload_columns');

/*
 * Implementes action 'manage_media_custom_column' to add a column into the
 * media page with link Attach, Unattach, Re-Attach.
 */
function uar__manage_media_custom_column($column_name, $id) {
  $post = get_post($id);

  // Only act on our custom column extended_parent.
  if ($column_name != 'extended_parent') return;

  if ($post->post_parent) {
    if (get_post($post->post_parent)) $title = _draft_or_post_title($post->post_parent);
    $url_unattach = admin_url('tools.php?page=unattach&noheader=true&post_id=' . $post->ID);
    
    ?>
			<strong><a href="<?php echo get_edit_post_link( $post->post_parent ); ?>"><?php echo $title ?></a></strong>, <?php echo get_the_time(__('Y/m/d')); ?>
			<br />
			<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Re-Attach'); ?></a>
			<br />
			<a href="<?php echo esc_url( $url_unattach ); ?>" title="<?php echo __( "Unattach this media item.", 'uar'); ?>"><?php echo __( 'Unattach') ?></a>

	  <?php 
      } else { 
    ?>
			<?php _e('(Unattached)'); ?><br />
			<a class="hide-if-no-js" onclick="findPosts.open('media[]','<?php echo $post->ID ?>');return false;" href="#the-list"><?php _e('Attach'); ?></a>
	  <?php
		}
}
add_action("manage_media_custom_column", 'uar__manage_media_custom_column', 0, 2);

?>