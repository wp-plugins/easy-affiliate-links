<?php

class EAFL_Meta_Box {

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'add_meta_box' ));
    }

    public function add_meta_box()
    {
        add_meta_box(
            'eafl_meta_box',
            'Easy Affiliate Links',
            array( $this, 'meta_box_content' ),
            EAFL_POST_TYPE,
            'normal',
            'high'
        );
    }

    public function meta_box_content( $post )
    {
        $link = new EAFL_Link( $post );
        include( EasyAffiliateLinks::get()->coreDir . '/helpers/meta_box_content.php' );
    }
}