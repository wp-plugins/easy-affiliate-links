<?php

class EAFL_Vafpress_Shortcode {

    public function __construct()
    {
        //add_action( 'after_setup_theme', array( $this, 'vafpress_shortcode_init' ) );
    }

    public function vafpress_shortcode_init()
    {
        require_once( EasyAffiliateLinks::get()->coreDir . '/helpers/vafpress/vafpress_shortcode_whitelist.php');
        require_once( EasyAffiliateLinks::get()->coreDir . '/helpers/vafpress/vafpress_shortcode_options.php');

        new VP_ShortcodeGenerator(array(
            'name'           => 'eafl_shortcode_generator',
            'template'       => $shortcode_generator,
            'modal_title'    => 'Easy Affiliate Links ' . __( 'Shortcodes', 'easy-affiliate-links' ),
            'button_title'   => 'Easy Affiliate Links',
            'types'          => EasyAffiliateLinks::option( 'shortcode_editor_post_types', array( 'post', 'page', 'recipe' ) ),
            'main_image'     => EasyAffiliateLinks::get()->coreUrl . '/img/icon_20.png',
            'sprite_image'   => EasyAffiliateLinks::get()->coreUrl . '/img/icon_sprite.png',
        ));
    }
}