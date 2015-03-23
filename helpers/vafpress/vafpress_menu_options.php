<?php

// Include part of site URL hash in HTML settings to update when site URL changes
$sitehash = substr( base64_encode( site_url() ), 0, 8 );

$admin_menu = array(
    'title' => 'Easy Affiliate Links ' . __( 'Settings', 'easy-affiliate-links' ),
    'logo'  => EasyAffiliateLinks::get()->coreUrl . '/img/icon_100.png',
    'menus' => array(
//=-=-=-=-=-=-= GENERAL =-=-=-=-=-=-=
        array(
            'title' => __( 'General', 'easy-affiliate-links' ),
            'name' => 'general',
            'icon' => 'font-awesome:fa-cogs',
            'controls' => array(
                array(
                    'type' => 'section',
                    'title' => __( 'Slug', 'easy-affiliate-links' ),
                    'name' => 'general_section_slug',
                    'fields' => array(
                        array(
                            'type' => 'textbox',
                            'name' => 'link_slug',
                            'label' => __( 'Slug', 'easy-affiliate-links' ),
                            'description' => __( 'Make sure to flush your permalinks after changing this. Direct links to the old slug will be broken.', 'easy-affiliate-links' ),
                            'default' => 'recommends',
                            'validation' => 'required',
                        ),
                        array(
                            'type' => 'html',
                            'name' => 'link_slug_preview' . $sitehash,
                            'binding' => array(
                                'field'    => 'link_slug',
                                'function' => 'eafl_admin_link_slug_preview',
                            ),
                        ),
                    ),
                ),
                array(
                    'type' => 'section',
                    'title' => __( 'Defaults', 'easy-affiliate-links' ),
                    'name' => 'general_section_defaults',
                    'fields' => array(
                        array(
                            'type' => 'radiobutton',
                            'name' => 'link_target',
                            'label' => __( 'Default Target', 'easy-affiliate-links' ),
                            'items' => array(
                                array(
                                    'value' => '_self',
                                    'label' => __( 'Open in same tab', 'easy-affiliate-links' ),
                                ),
                                array(
                                    'value' => '_blank',
                                    'label' => __( 'Open in new tab', 'easy-affiliate-links' ),
                                ),
                            ),
                            'default' => array(
                                '_blank',
                            ),
                        ),
                        array(
                            'type' => 'radiobutton',
                            'name' => 'link_redirect_type',
                            'label' => __( 'Default Redirect Type', 'easy-affiliate-links' ),
                            'items' => array(
                                array(
                                    'value' => '301',
                                    'label' => __( '301 Permanent', 'easy-affiliate-links' ),
                                ),
                                array(
                                    'value' => '302',
                                    'label' => __( '302 Temporary', 'easy-affiliate-links' ),
                                ),
                                array(
                                    'value' => '307',
                                    'label' => __( '307 Temporary', 'easy-affiliate-links' ),
                                ),
                            ),
                            'default' => array(
                                '301',
                            ),
                        ),
                        array(
                            'type' => 'toggle',
                            'name' => 'link_nofollow',
                            'label' => __( 'Default Use Nofollow', 'easy-affiliate-links' ),
                            'default' => '0',
                        ),
                    ),
                ),
            ),
        ),
//=-=-=-=-=-=-= CUSTOM CODE =-=-=-=-=-=-=
        array(
            'title' => __( 'Custom Code', 'easy-affiliate-links' ),
            'name' => 'custom_code',
            'icon' => 'font-awesome:fa-code',
            'controls' => array(
                array(
                    'type' => 'codeeditor',
                    'name' => 'custom_code_public_css',
                    'label' => __( 'Public CSS', 'easy-affiliate-links' ),
                    'theme' => 'github',
                    'mode' => 'css',
                ),
            ),
        ),
//=-=-=-=-=-=-= FAQ & SUPPORT =-=-=-=-=-=-=
        array(
            'title' => __( 'FAQ & Support', 'easy-affiliate-links' ),
            'name' => 'faq_support',
            'icon' => 'font-awesome:fa-book',
            'controls' => array(
                array(
                    'type' => 'notebox',
                    'name' => 'faq_support_notebox',
                    'label' => __( 'Need more help?', 'easy-affiliate-links' ),
                    // TODO Support link
                    'description' => '<a href="mailto:support@bootstrapped.ventures" target="_blank">Easy Affiliate Links ' .__( 'FAQ & Support', 'easy-affiliate-links' ) . '</a>',
                    'status' => 'info',
                ),
            ),
        ),
    ),
);