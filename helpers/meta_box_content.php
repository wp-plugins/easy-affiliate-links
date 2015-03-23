<?php
// Link should never be null. Construct just allows easy access to EAFL_Link functions in IDE.
if( is_null( $link ) ) $link = new EAFL_Link(0);
?>

<input type="hidden" name="eafl_link_nonce" value="<?php echo wp_create_nonce( 'link' ); ?>" />
<table class="eafl_form">
    <tr class="eafl_divider">
        <td><label for="eafl_name"><?php _e( 'Name', 'easy-affiliate-links' ); ?></label></td>
        <td><input type="text" name="eafl_name" id="eafl_name" value="<?php echo esc_attr( $link->name() ); ?>" /></td>
        <td><?php _e( 'Use this to identify the link.', 'easy-affiliate-links' ); ?> <?php _e( 'Not public.', 'easy-affiliate-links' ); ?></td>
    </tr>
    <tr>
        <td><label for="eafl_text"><?php _e( 'Link Text', 'easy-affiliate-links' ); ?></label></td>
        <td><input type="text" name="eafl_text" id="eafl_text" value="<?php echo esc_attr( $link->text() ); ?>" /></td>
        <td><?php _e( 'Text shown to visitors.', 'easy-affiliate-links' ); ?></td>
    </tr>
    <tr class="eafl_divider">
        <td><label for="eafl_url"><?php _e( 'Link URL', 'easy-affiliate-links' ); ?></label></td>
        <td><input type="text" name="eafl_url" id="eafl_url" value="<?php echo esc_attr( $link->url() ); ?>" /></td>
        <td><?php _e( 'Final destination for the link.', 'easy-affiliate-links' ); ?> <?php _e( 'Starts with http:// or https://', 'easy-affiliate-links' ); ?></td>
    </tr>
    <tr>
        <td><label for="eafl_slug"><?php _e( 'Shortlink Slug', 'easy-affiliate-links' ); ?></label></td>
        <td>
            <input type="text" name="eafl_slug" id="eafl_slug" value="<?php echo esc_attr( $link->slug() ); ?>" /></td>
        <td><?php _e( 'Part of the link your visitors will see.', 'easy-affiliate-links' ); ?></td>
    </tr>
    <tr class="eafl_divider eafl_link_preview">
        <td></td>
        <td colspan="2">
            <?php echo site_url( '/' . EasyAffiliateLinks::option( 'link_slug', 'recommends' ) . '/' ); ?><span id="eafl_link_preview"></span>
        </td>
    </tr>
    <tr class="eafl_radiobuttons">
        <td><?php _e( 'Target', 'easy-affiliate-links' ); ?></label></td>
        <td>
            <?php
            $target_options = array(
                '_self' => __( 'Open in same tab', 'easy-affiliate-links' ),
                '_blank' => __( 'Open in new tab', 'easy-affiliate-links' ),
            );
            $default_target = EasyAffiliateLinks::get()->option( 'link_target', '_blank' );

            $target = $link->target( true );
            $checked = array_key_exists( $target, $target_options ) ? '' : ' checked="checked"';

            echo '<input type="radio" name="eafl_target" id="eafl_target_default" value="default"' . $checked . '/><label for="eafl_target_default">' . __( 'Use Default', 'easy-affiliate-links' ) . ' (' . $target_options[$default_target] . ')</label><br/>';

            foreach( $target_options as $target_option => $target_option_description ) {
                $checked = $target != $target_option ? '' : ' checked="checked"';
                echo '<input type="radio" name="eafl_target" id="eafl_target_' . $target_option . '" value="' . $target_option . '"' . $checked . '/><label for="eafl_target_' . $target_option . '">' . $target_option_description . '</label><br/>';
            }
            ?>
        </td>
        <td><?php _e( 'Target to use for the shortlink.', 'easy-affiliate-links' ); ?></td>
    </tr>
    <tr class="eafl_radiobuttons">
        <td><?php _e( 'Redirect Type', 'easy-affiliate-links' ); ?></label></td>
        <td>
            <?php
            $redirect_types = array(
                301 => __( '301 Permanent', 'easy-affiliate-links' ),
                302 => __( '302 Temporary', 'easy-affiliate-links' ),
                307 => __( '307 Temporary', 'easy-affiliate-links' ),
            );
            $default_type = intval( EasyAffiliateLinks::get()->option( 'link_redirect_type', '301' ) );

            $redirect_type = $link->redirect_type( true );
            $checked = array_key_exists( $redirect_type, $redirect_types ) ? '' : ' checked="checked"';

            echo '<input type="radio" name="eafl_redirect_type" id="eafl_redirect_default" value="999"' . $checked . '/><label for="eafl_redirect_default">' . __( 'Use Default', 'easy-affiliate-links' ) . ' (' . $redirect_types[$default_type] . ')</label><br/>';

            foreach( $redirect_types as $possible_type => $possible_type_description ) {
                $checked = $redirect_type != $possible_type ? '' : ' checked="checked"';
                echo '<input type="radio" name="eafl_redirect_type" id="eafl_redirect_' . $possible_type . '" value="' . $possible_type . '"' . $checked . '/><label for="eafl_redirect_' . $possible_type . '">' . $possible_type_description . '</label><br/>';
            }
            ?>
        </td>
        <td><?php _e( 'Redirect type to use for the shortlink.', 'easy-affiliate-links' ); ?></td>
    </tr>
    <tr class="eafl_radiobuttons">
        <td><?php _e( 'Nofollow', 'easy-affiliate-links' ); ?></label></td>
        <td>
            <?php
            $nofollow_options = array(
                'follow' => __( 'Do not add nofollow attribute', 'easy-affiliate-links' ),
                'nofollow' => __( 'Add nofollow attribute', 'easy-affiliate-links' ),
            );
            $default_nofollow = EasyAffiliateLinks::get()->option( 'link_nofollow', '0' ) == '1' ? 'nofollow' : 'follow';

            $nofollow = $link->nofollow( true );
            $checked = in_array( $nofollow, $nofollow_options ) ? '' : ' checked="checked"';

            echo '<input type="radio" name="eafl_nofollow" id="eafl_nofollow_default" value="default"' . $checked . '/><label for="eafl_nofollow_default">' . __( 'Use Default', 'easy-affiliate-links' ) . ' (' . $nofollow_options[$default_nofollow] . ')</label><br/>';

            foreach( $nofollow_options as $nofollow_option => $nofollow_option_description ) {
                $checked = $nofollow != $nofollow_option ? '' : ' checked="checked"';
                echo '<input type="radio" name="eafl_nofollow" id="eafl_nofollow_' . $nofollow_option . '" value="' . $nofollow_option . '"' . $checked . '/><label for="eafl_nofollow_' . $nofollow_option . '">' . $nofollow_option_description . '</label><br/>';
            }
            ?>
        </td>
        <td><?php _e( 'Should we add the nofollow attribute to links.', 'easy-affiliate-links' ); ?></td>
    </tr>
</table>