<?php

class EAFL_Ajax {

    public function __construct()
    {
    }

    public function url()
    {
        $ajaxurl = admin_url( 'admin-ajax.php' );
        $ajaxurl .= '?eafl_ajax=1';

        // WPML AJAX Localization Fix
        global $sitepress;
        if( isset( $sitepress) ) {
            $ajaxurl .= '&lang='.$sitepress->get_current_language();
        }

        return $ajaxurl;
    }
}