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
        <li><a href="#eafl_tab_select"><?php _e( 'Select Link', 'easy-affiliate-links' ); ?></a></li>
        <li><a href="#eafl_tab_add"><?php _e( 'Add Link', 'easy-affiliate-links' ); ?></a></li>
    </ul>
    <div id="eafl_tab_select">
        <table id="eafl_select_link">
            <thead>
            <tr>
	            <th scope="col"><?php _e( 'Category', 'easy-affiliate-links' ); ?></th>
                <th scope="col"><?php _e( 'Name', 'easy-affiliate-links' ); ?></th>
                <th scope="col"><?php _e( 'Add to Post', 'easy-affiliate-links' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $links = EasyAffiliateLinks::get()->helper( 'cache' )->get( 'links_by_date' );
            foreach( $links as $link ) { ?>
            <tr>
	            <td><?php echo $link['categories']; ?></td>
                <td>
                    <?php echo $link['name']; ?>
	                <a href="<?php echo $link['url']; ?>" class="eafl_shortlink" target="_blank"><?php echo site_url( '/' . EasyAffiliateLinks::option( 'link_slug', 'recommends' ) . '/' . $link['slug'] ); ?></a>
                </td>
	            <td>
		            <select class="eafl_use_link" data-id="<?php echo $link['ID']; ?>" data-name="<?php echo esc_attr( $link['name'] ); ?>">
			            <option value="eafl_select_link_text"><?php _e( 'Select Link Text', 'easy-affiliate-links' ); ?></option>
			            <?php
			            foreach( $link['text'] as $text ) {
				            echo '<option value="' . esc_attr( $text ) . '">' . $text . '</option>';
			            }
			            ?>
			            <option value="eafl_custom_link_text">...<?php _e( 'or use a custom text', 'easy-affiliate-links' ); ?></option>
		            </select>
	            </td>

            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="eafl_tab_add">
        <form id="eafl_add_from_lightbox" action="<?php echo admin_url( 'admin-post.php' ); ?>" method="post">
            <input type="hidden" name="action" value="add_easy_affiliate_link">
            <?php
            $link = null;
            include( EasyAffiliateLinks::get()->coreDir . '/helpers/meta_box_content.php' );
            ?>
            <?php submit_button( __( 'Add Link', 'easy-affiliate-links' ) ); ?>
        </form>
    </div>
</div>

<?php
iframe_footer();
die();