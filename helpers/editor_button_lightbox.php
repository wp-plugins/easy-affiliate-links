<?php
wp_enqueue_style( 'eafl-jquery-ui-css',
    'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css',
    false,
    EAFL_VERSION,
    false );
iframe_header();
?>
<div id="eafl_lightbox_tabs">
    <ul>
        <li><a href="#eafl_tab_select"><?php _e( 'Select Link', 'easy-affiliate-links' ); ?></a></li>
        <li><a href="#eafl_tab_add"><?php _e( 'Add Link', 'easy-affiliate-links' ); ?></a></li>
    </ul>
    <div id="eafl_tab_select">
        <table id="eafl_select_link">
            <thead>
            <tr>
                <th scope="col">&nbsp;</th>
                <th scope="col"><?php _e( 'Name', 'easy-affiliate-links' ); ?></th>
                <th scope="col"><?php _e( 'Link', 'easy-affiliate-links' ); ?></th>
                <th scope="col"><?php _e( 'Category', 'easy-affiliate-links' ); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $links = EasyAffiliateLinks::get()->helper( 'cache' )->get( 'links_by_date' );
            foreach( $links as $link ) { ?>
            <tr>
                <td><button class="eafl_use_link button button-primary" data-id="<?php echo $link['ID']; ?>" data-name="<?php echo esc_attr( $link['name'] ); ?>" data-text="<?php echo esc_attr( $link['text'] ); ?>"><?php _e( 'Use', 'easy-affiliate-links' ); ?></button></td>
                <td>
                    <?php echo $link['name']; ?>
                    <span class="eafl_shortlink"><?php echo site_url( '/' . EasyAffiliateLinks::option( 'link_slug', 'recommends' ) . '/' . $link['slug'] ); ?></span>
                </td>
                <td><a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['text']; ?></a></td>
                <td><?php echo $link['categories']; ?></td>
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