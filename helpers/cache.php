<?php

class EAFL_Cache {

    private $cache;

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'check_manual_reset' ) );
        add_action( 'admin_init', array( $this, 'check_if_present' ) );

        // Check if reset is needed
        add_action( 'save_post', array( $this, 'check_save_post' ), 11, 2 );
    }

    public function check_manual_reset()
    {
        if( isset( $_GET['eafl_reset_cache'] ) ) {
            $this->reset();
            EasyAffiliateLinks::get()->helper( 'notices' )->add_admin_notice( '<strong>Easy Affiliate Links</strong> ' . __( 'The cache has been reset', 'easy-affiliate-links' ) );
        }
    }

    public function check_if_present()
    {
        $this->cache = get_option( 'wpurp_cache', false );

        if( !$this->cache ) {
            $this->reset();
        }
    }

    public function check_save_post( $id, $post )
    {
        if( $post->post_type == EAFL_POST_TYPE ) {
            $this->reset();
        }
    }

    public function reset()
    {
        $links_by_date = array();

        // Get all links one by one
        $limit = 100;
        $offset = 0;

        while(true) {
            $args = array(
                'post_type' => EAFL_POST_TYPE,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => $limit,
                'offset' => $offset,
            );

            $query = new WP_Query( $args );

            if (!$query->have_posts()) break;

            $posts = $query->posts;

            foreach( $posts as $post ) {
                $id = $post->ID;

                $categories = '';
                $terms = get_the_terms( $id, 'eafl_category' );

                if( $terms && !is_wp_error( $terms ) ) {

                    $category_terms = array();

                    foreach( $terms as $term ) {
                        $category_terms[] = $term->name;
                    }

                    $categories = join( ', ', $category_terms );
                }

                $links_by_date[] = array(
                    'ID' => $id,
                    'name' => $post->post_title,
                    'slug' => $post->post_name,
                    'text' => get_post_meta( $id, 'eafl_text', true ),
                    'url' => get_post_meta( $id, 'eafl_url', true ),
                    'categories' => $categories
                );

                wp_cache_delete( $id, 'posts' );
                wp_cache_delete( $id, 'post_meta' );
            }

            $offset += $limit;
            wp_cache_flush();
        }

        $cache = array(
            'links_by_date' => $links_by_date,
        );

        update_option( 'wpurp_cache', $cache );
        $this->cache = $cache;
    }

    public function get( $item )
    {
        if( !$this->cache ) {
            $this->cache = get_option( 'wpurp_cache', array() );
        }

        if( isset( $this->cache[$item] ) ) {
            return $this->cache[$item];
        }
    }
}