<?php

class EAFL_Notices {

    public function __construct()
    {
        add_action( 'admin_notices', array( $this, 'admin_notices' ) );
    }

    public function admin_notices()
    {
        // Check Permalink Settings
        global $wp_rewrite;
        if( empty( $wp_rewrite->permalink_structure ) ) {
            echo '<div class="error"><p><strong>Easy Affiliate Links</strong> ' . __( 'Our plugin depends on pretty permalinks. Please choose anything but the default setting over here:', 'easy-affiliate-links' ) . ' <a href="' . admin_url( 'options-permalink.php' ) . '">' . __( 'Permalink Settings', 'easy-affiliate-links' ) . '</a></p></div>';
        }

        // Other Notices
        if( $notices = get_option( 'eafl_deferred_admin_notices' ) ) {
            foreach( $notices as $notice ) {
                echo '<div class="updated"><p>'.$notice.'</p></div>';
            }

            delete_option('eafl_deferred_admin_notices');
        }
    }

    public function add_admin_notice( $notice )
    {
        $notices = get_option( 'eafl_deferred_admin_notices', array() );
        $notices[] = $notice;
        update_option( 'eafl_deferred_admin_notices', $notices );
    }

    public function activation_notice() {
        $notice  = '';
        $this->add_admin_notice( $notice );
    }
}