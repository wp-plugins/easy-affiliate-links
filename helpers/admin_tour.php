<?php

class EAFL_Admin_Tour {

    public function __construct()
    {
        add_action( 'admin_enqueue_scripts', array( $this, 'load_pointers' ) );

//        add_filter( 'eafl_admin_tour-plugins', array( $this, 'pointer_plugins' ) );
    }

    /*
     * Pointers to be shown on the plugins page
     */
    public function pointer_plugins( $pointers )
    {
        $pointers['eafl_plugins_recipes'] = array(
            'target' => 'body',
            'options' => array(
                'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
                    __( '', 'easy-affiliate-links' ),
                    __( '', 'easy-affiliate-links' )
                ),
                'position' => array(
                    'edge' => 'top',
                    'align' => 'middle'
                )
            ),
        );

        return $pointers;
    }

    // Source: http://code.tutsplus.com/tutorials/integrating-with-wordpress-ui-admin-pointers--wp-26853
    public function load_pointers( $hook )
    {
        // Admin pointers were introduced in WP 3.3
        if( get_bloginfo( 'version' ) < '3.3' ) return;

        // Get the screen ID
        $screen = get_current_screen();
        $screen_id = $screen->id;

        // Get pointers for all screens
        $pointers = apply_filters( 'eafl_admin_tour', array() );

        // Get pointers for this screen
        $pointers = array_merge(
            $pointers,
            apply_filters( 'eafl_admin_tour-' . $screen_id, array() )
        );

        // No pointers? Then we stop.
        if ( ! $pointers || ! is_array( $pointers ) ) return;

        // Get dismissed pointers
        $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
        $valid_pointers = array();

        // Check pointers and remove dismissed ones.
        foreach ( $pointers as $pointer_id => $pointer ) {

            // Sanity check
            if ( in_array( $pointer_id, $dismissed ) || empty( $pointer ) || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
                continue;

            $pointer['pointer_id'] = $pointer_id;

            // Add the pointer to $valid_pointers array
            $valid_pointers['pointers'][] = $pointer;
        }

        // No valid pointers? Stop here.
        if ( empty( $valid_pointers ) ) return;

        // Add pointers style to queue.
        wp_enqueue_style( 'wp-pointer' );

        // Add pointers script and our own custom script to queue.
        wp_enqueue_script( 'eafl-admin-tour', EasyAffiliateLinks::get()->coreUrl . '/js/admin_tour.js', array( 'wp-pointer' ) );

        // Add pointer options to script.
        wp_localize_script( 'eafl-admin-tour', 'eafl_admin_tour', $valid_pointers );
    }
}