<?php

class EAFL_Link {

    private $post;
    private $meta;
    private $fields = array(
        'eafl_nofollow',
        'eafl_prefix',
        'eafl_redirect_type',
        'eafl_target',
        'eafl_text',
        'eafl_url',
    );

    public function __construct( $post )
    {
        // Get associated post
        if( is_object( $post ) && $post instanceof WP_Post ) {
            $this->post = $post;
        } else if( is_numeric( $post ) ) {
            $this->post = get_post( $post );
        } else {
            throw new InvalidArgumentException( 'Affiliate Links can only be instantiated with a Post object or Post ID.' );
        }

        // Get metadata
        $this->meta = get_post_custom( $this->post->ID );
    }

    public function is_present( $field )
    {
        switch( $field ) {
            default:
                $val = $this->meta( $field );
                return isset( $val ) && trim( $val ) != '';
        }
    }

    public function meta( $field )
    {
        if( isset( $this->meta[$field] ) ) {
            return $this->meta[$field][0];
        }

        return null;
    }

    public function fields()
    {
        return $this->fields;
    }

    /**
     * Link fields
     */

    public function ID()
    {
        return $this->post ? $this->post->ID : 0;
    }

    public function name()
    {
        return $this->post ? $this->post->post_title : '';
    }

    public function nofollow( $keep_default = false)
    {
        $nofollow = $this->meta( 'eafl_nofollow' );

        if( !$keep_default && $nofollow == 'default' ) {
            $nofollow = EasyAffiliateLinks::get()->option( 'link_nofollow', '0' ) == '1' ? 'nofollow' : 'follow';
        }
        return $nofollow;
    }

    public function prefix()
    {
        return $this->meta( 'eafl_prefix' );
    }

    public function redirect_type( $keep_default = false)
    {
        $type = intval( $this->meta( 'eafl_redirect_type' ) );

        if( !$keep_default && $type == 999 ) {
            $type = intval( EasyAffiliateLinks::get()->option( 'link_redirect_type', '301' ) );
        }
        return $type;
    }

    public function slug()
    {
        return $this->post ? $this->post->post_name : '';
    }

    public function target( $keep_default = false)
    {
        $target = $this->meta( 'eafl_target' );

        if( !$keep_default && $target == 'default' ) {
            $target = EasyAffiliateLinks::get()->option( 'link_target', '_blank' );
        }
        return $target;
    }

    public function text()
    {
	    $text = maybe_unserialize( $this->meta( 'eafl_text' ) );
        return is_array( $text ) ? $text : array( $text );
    }

    public function url()
    {
        return $this->meta( 'eafl_url' );
    }
}