<?php

class EAFL_Activate {

    public function __construct()
    {
        register_activation_hook( EasyAffiliateLinks::get()->pluginFile, array( $this, 'activate_plugin' ) );
    }

    public function activate_plugin()
    {
        EasyAffiliateLinks::get()->helper( 'notices' )->activation_notice();
        EasyAffiliateLinks::get()->helper( 'permalinks_flusher' )->set_flush_needed();
    }
}