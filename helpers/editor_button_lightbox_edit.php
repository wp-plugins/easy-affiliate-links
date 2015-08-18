<?php
wp_enqueue_style( 'eafl-jquery-ui-css',
    'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
    false,
    EAFL_VERSION,
    false );
iframe_header();
?>
<style type="text/css">.xdebug-error.xe-notice { display: none; }</style>
<div id="eafl_lightbox_tabs">
	<ul>
		<li><a href="#eafl_tab_shortcode"><?php _e( 'Edit Text', 'easy-affiliate-links' ); ?></a></li>
		<li><a href="#eafl_tab_edit"><?php _e( 'Edit Link', 'easy-affiliate-links' ); ?></a></li>
	</ul>
	<div id="eafl_tab_shortcode">
		<table class="eafl_form">
			<tr>
				<td><label for="shortcode_link_text"><?php _e( 'Link Text', 'easy-affiliate-links' ); ?></label></td>
				<td><input type="text" name="shortcode_link_text" id="shortcode_link_text" value="<?php echo esc_attr( $_GET['eafl_text'] ); ?>"/></td>
				<td><?php _e( 'Text shown to visitors.', 'easy-affiliate-links' ); ?></td>
			</tr>
		</table>
		<?php submit_button( __( 'Edit Link Text', 'easy-affiliate-links' ), 'primary', 'shortcode_link_submit' ); ?>
	</div>
	<div id="eafl_tab_edit">
		<form id="eafl_edit_from_lightbox" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
			<input type="hidden" name="action" value="edit_easy_affiliate_link">
			<?php
			$link_id = intval( $_GET['eafl_id'] );
			$link = new EAFL_Link( $link_id );
			include( EasyAffiliateLinks::get()->coreDir . '/helpers/meta_box_content.php' );
			?>
			<input type="hidden" name="eafl_id" id="eafl_id" value="<?php echo $link_id; ?>" />
			<?php submit_button( __( 'Edit Link', 'easy-affiliate-links' ) ); ?>
		</form>
	</div>
</div>

<?php
iframe_footer();
die();