<?php

class EAFL_Redirect {

    public function __construct()
    {
        add_action( 'template_redirect', array( $this, 'redirect' ), 1 );
    }

    public function redirect()
    {
        $post = get_post();

        if( $post->post_type == EAFL_POST_TYPE ) {
            $link = new EAFL_Link( $post );

            $url = $link->url();
            $redirect_type = $link->redirect_type();

            EasyAffiliateLinks::get()->helper( 'clicks' )->register( $link );

            wp_redirect( $url, $redirect_type );
            exit();
        }
    }
}