<?php

class EAFL_Shortcode {

    public function __construct()
    {
        add_shortcode( 'eafl', array( $this, 'shortcode' ) );

        add_filter( 'mce_external_plugins', array( $this, 'tinymce_plugin' ) );
    }

    public function shortcode( $options )
    {
        $options = shortcode_atts( array(
            'id' => false
        ), $options );

        $output = '';
        $id = intval( $options['id'] );

        if( $id ) {
            $post = get_post( $id );

            if( !is_null( $post ) && $post->post_type == EAFL_POST_TYPE ) {
                $link = new EAFL_Link( $post );

                $nofollow = $link->nofollow() == 'nofollow' ? ' rel="nofollow"' : '';

                $output = '<a href="' . get_permalink( $id ) . '" target="' . $link->target() . '"' . $nofollow . '>' . $link->text() . '</a>';
            }
        }

        return $output;
    }

    public function tinymce_plugin( $plugin_array )
    {
        $plugin_array['easy_affiliate_links_shortcode'] = EasyAffiliateLinks::get()->coreUrl . '/js/tinymce_shortcode.js';
        return $plugin_array;
    }
}