<?php

class EAFL_Plugin_Action_Link {

    public function __construct()
    {
        add_filter( 'plugin_action_links_easy-affiliate-links/easy-affiliate-links.php', array( $this, 'action_links' ) );
    }

    public function action_links( $links )
    {
        //$links[] = '<a href="'. get_admin_url(null, 'edit.php?post_type=recipe&page=wpurp_admin') .'">'.__( 'Settings', 'wp-ultimate-recipe' ).'</a>';
        $links[] = '<a href="http://www.bootstrappedventures.com" target="_blank">'.__( 'More information', 'easy-affiliate-links' ).'</a>';

        return $links;
    }
}