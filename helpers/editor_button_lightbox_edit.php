<?php
wp_enqueue_style( 'eafl-jquery-ui-css',
    'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
    false,
    EAFL_VERSION,
    false );
iframe_header();
?>
<form id="eafl_edit_from_lightbox" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
    <input type="hidden" name="action" value="edit_easy_affiliate_link">
    <?php
    $link_id = intval( $_GET['eafl_id'] );
    $link = new EAFL_Link( $link_id );
    include( EasyAffiliateLinks::get()->coreDir . '/helpers/meta_box_content.php' );
    ?>
    <input type="hidden" name="eafl_id" value="<?php echo $link_id; ?>" />
    <?php submit_button( __( 'Edit Link', 'easy-affiliate-links' ) ); ?>
</form>

<?php
iframe_footer();
die();