<?php

class EAFL_Taxonomies {
    
    public function __construct()
    {
        add_action( 'init', array( $this, 'register_link_category' ) );
    }

    public function register_link_category()
    {
        $name = 'Link Categories';
        $singular = 'Link Category';

        $name_lower = strtolower($name);

        $args = apply_filters( 'eafl_register_link_category',
            array(
                'labels' => array(
                    'name'                       => $name,
                    'singular_name'              => $singular,
                    'search_items'               => __( 'Search', 'easy-affiliate-links' ) . ' ' . $name,
                    'popular_items'              => __( 'Popular', 'easy-affiliate-links' ) . ' ' . $name,
                    'all_items'                  => __( 'All', 'easy-affiliate-links' ) . ' ' . $name,
                    'edit_item'                  => __( 'Edit', 'easy-affiliate-links' ) . ' ' . $singular,
                    'update_item'                => __( 'Update', 'easy-affiliate-links' ) . ' ' . $singular,
                    'add_new_item'               => __( 'Add New', 'easy-affiliate-links' ) . ' ' . $singular,
                    'new_item_name'              => __( 'New', 'easy-affiliate-links' ) . ' ' . $singular . ' ' . __( 'Name', 'easy-affiliate-links' ),
                    'separate_items_with_commas' => __( 'Separate', 'easy-affiliate-links' ) . ' ' . $name_lower . ' ' . __( 'with commas', 'easy-affiliate-links' ),
                    'add_or_remove_items'        => __( 'Add or remove', 'easy-affiliate-links' ) . ' ' . $name_lower,
                    'choose_from_most_used'      => __( 'Choose from the most used', 'easy-affiliate-links' ) . ' ' . $name_lower,
                    'not_found'                  => __( 'No', 'easy-affiliate-links' ) . ' ' . $name_lower . ' ' . __( 'found.', 'easy-affiliate-links' ),
                    'menu_name'                  => $name
                ),
                'hierarchical' => true,
                'rewrite' => false,
                'show_admin_column' => true
            )
        );

        register_taxonomy( 'eafl_category', EAFL_POST_TYPE, $args );
    }

}