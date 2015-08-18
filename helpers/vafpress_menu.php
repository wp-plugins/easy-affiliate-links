<?php

class EAFL_Vafpress_Menu {

    public function __construct()
    {
        add_action( 'after_setup_theme', array( $this, 'vafpress_menu_init' ) );
    }

    public function vafpress_menu_init()
    {
        require_once( EasyAffiliateLinks::get()->coreDir . '/helpers/vafpress/vafpress_menu_whitelist.php');
        require_once( EasyAffiliateLinks::get()->coreDir . '/helpers/vafpress/vafpress_menu_options.php');

        new VP_Option(array(
            'is_dev_mode'           => false,
            'option_key'            => 'eafl_option',
            'page_slug'             => 'eafl_admin',
            'template'              => $admin_menu,
            'menu_page'             => 'edit.php?post_type=easy_affiliate_link',
            'use_auto_group_naming' => true,
            'use_exim_menu'         => true,
            'minimum_role'          => 'manage_options',
            'layout'                => 'fluid',
            'page_title'            => __( 'Settings', 'easy-affiliate-links' ),
            'menu_label'            => __( 'Settings', 'easy-affiliate-links' ),
        ));
    }
}