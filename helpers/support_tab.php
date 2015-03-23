<?php

class EAFL_Support_Tab {

    public function __construct()
    {
        //add_action( 'admin_footer-easy_affiliate_link_page_eafl_admin', array( $this, 'add_support_tab' ) );
    }

    public function add_support_tab()
    {
        include( EasyAffiliateLinks::get()->coreDir . '/static/support_tab.html' );
    }
}