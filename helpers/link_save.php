<?php

class EAFL_Link_Save {

    public function __construct()
    {
        add_action( 'wp_ajax_add_easy_affiliate_link', array( $this, 'ajax_add_from_lightbox' ) );
        add_action( 'admin_post_add_easy_affiliate_link', array( $this, 'add_from_lightbox' ) );
        add_action( 'save_post', array( $this, 'save' ), 10, 2 );
    }

    public function ajax_add_from_lightbox()
    {
        if( check_ajax_referer( 'link', 'eafl_link_nonce', false ) )
        {
            echo json_encode( array(
                'name' => esc_attr( $_POST['eafl_name'] ),
                'text' => esc_attr( $_POST['eafl_text'] ),
                'ID' => $this->create_link(),
            ) );
        }

        wp_die();
    }

    public function add_from_lightbox()
    {
        if ( !isset( $_POST['eafl_link_nonce'] ) || !wp_verify_nonce( $_POST['eafl_link_nonce'], 'link' ) ) {
            return;
        }

        $this->create_link();
    }

    private function create_link()
    {
        $post = array(
            'post_status' => 'publish',
            'post_type' => EAFL_POST_TYPE,
        );

        return wp_insert_post( $post );
    }

    public function save( $post_id, $post )
    {
        if( $post->post_type == EAFL_POST_TYPE )
        {
            if ( !isset( $_POST['eafl_link_nonce'] ) || !wp_verify_nonce( $_POST['eafl_link_nonce'], 'link' ) ) {
                return;
            }

            $link = new EAFL_Link( $post_id );

            // Handle name and slug
            $title = isset( $_POST['eafl_name'] ) ? $_POST['eafl_name'] : null;
            $slug = isset( $_POST['eafl_slug'] ) ? $this->convertToSlug( $_POST['eafl_slug'] ) : null;

            $update_post = array(
                'ID' => $post_id,
                'post_title' => $title,
                'post_name' => $slug,
            );

            remove_action( 'save_post', array( $this, 'save' ), 10, 2 );
            wp_update_post( $update_post );
            add_action( 'save_post', array( $this, 'save' ), 10, 2 );

            // Handle metadata
            $fields = $link->fields();

            foreach ( $fields as $field )
            {
                $old = get_post_meta( $post_id, $field, true );
                $new = isset( $_POST[$field] ) ? $_POST[$field] : null;

                // Field specific adjustments
                if( isset( $new ) && $field == 'link_prefix' ) {
                    $new = $this->convertToSlug( $new );
                }

                // Update or delete meta data if changed
                if( isset( $new ) && $new != $old ) {
                    update_post_meta( $post_id, $field, $new );
                } elseif ( $new == '' && $old ) {
                    delete_post_meta( $post_id, $field, $old );
                }
            }
        }
    }

    public function convertToSlug( $text )
    {
        $text = strtolower( $text );
        $text = str_replace( ' ', '-', $text );
        $text = preg_replace( "/-+/", "-", $text );
        $text = preg_replace( "/[^\w-]+/", "", $text );

        return $text;
    }
}