<?php

class EAFL_Post_Type {

    public function __construct()
    {
        add_action( 'init', array( $this, 'register_post_type' ), 1);
    }

    public function register_post_type()
    {
        $slug = EasyAffiliateLinks::option( 'link_slug', 'recommends' );

        $name = __( 'Affiliate Links', 'easy-affiliate-links' );
        $singular = __( 'Affiliate Link', 'easy-affiliate-links' );
        
        $args = apply_filters( 'eafl_register_post_type',
            array(
                'labels' => array(
                    'name' => $name,
                    'singular_name' => $singular,
                    'add_new' => __( 'Add New', 'easy-affiliate-links' ),
                    'add_new_item' => __( 'Add New', 'easy-affiliate-links' ) . ' ' . $singular,
                    'edit' => __( 'Edit', 'easy-affiliate-links' ),
                    'edit_item' => __( 'Edit', 'easy-affiliate-links' ) . ' ' . $singular,
                    'new_item' => __( 'New', 'easy-affiliate-links' ) . ' ' . $singular,
                    'view' => __( 'View', 'easy-affiliate-links' ),
                    'view_item' => __( 'View', 'easy-affiliate-links' ) . ' ' . $singular,
                    'search_items' => __( 'Search', 'easy-affiliate-links' ) . ' ' . $name,
                    'not_found' => __( 'No', 'easy-affiliate-links' ) . ' ' . $name . ' ' . __( 'found.', 'easy-affiliate-links' ),
                    'not_found_in_trash' => __( 'No', 'easy-affiliate-links' ) . ' ' . $name . ' ' . __( 'found in trash.', 'easy-affiliate-links' ),
                    'parent' => __( 'Parent', 'easy-affiliate-links' ) . ' ' . $singular,
                ),
                'public' => true,
                'menu_position' => 20,
                'supports' => false,
                'taxonomies' => array(),
                'menu_icon' => EasyAffiliateLinks::get()->coreUrl . '/img/icon_16.png',
                'has_archive' => false,
                'rewrite' => array(
                    'slug' => $slug
                )
            )
        );

        register_post_type( EAFL_POST_TYPE, $args );
    }
}