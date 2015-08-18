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
            'id' => false,
	        'text' => false,
        ), $options );

        $output = '';
        $id = intval( $options['id'] );

        if( $id ) {
            $post = get_post( $id );

            if( !is_null( $post ) && $post->post_type == EAFL_POST_TYPE ) {
                $link = new EAFL_Link( $post );

                $nofollow = $link->nofollow() == 'nofollow' ? ' rel="nofollow"' : '';
	            $url = rtrim( get_permalink( $id ), '/' );

	            $text = $options['text'] ? $options['text'] : $link->text()[0];

                $output = '<a href="' . $url . '" target="' . $link->target() . '"' . $nofollow . '>' . $text . '</a>';
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