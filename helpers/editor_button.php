<?php

class EAFL_Editor_Button
{

    public function __construct()
    {
        add_action( 'init', array( $this, 'filter_buttons' ) );
        add_action( 'wp_ajax_eafl_lightbox', array( $this, 'lightbox_content' ) );
    }

    public function filter_buttons()
    {
        if ( current_user_can( 'edit_posts' ) ) {
            add_filter( 'mce_external_plugins', array( $this, 'add_button' ) );
            add_filter( 'mce_buttons', array( $this, 'register_button' ) );

            $this->assets();
        }
    }

    public function assets()
    {
        EasyAffiliateLinks::get()->helper( 'assets' )->add(
            array(
                'file' => '/js/editor_button.js',
                'public' => true,
                'admin' => true,
                'deps' => array(
                    'jquery',
                ),
                'data' => array(
                    'name' => 'eafl_button',
                    'ajax_url' => EasyAffiliateLinks::get()->helper('ajax')->url(),
                ),
            )
        );
    }

    public function text_editor_button()
    {
        echo '<script type="text/javascript" charset="utf-8">


	</script>

	<style>
	.quicktags-toolbar input[value="affiliate link"],
	.quicktags-toolbar input[value="quick add affiliate link"] {
		text-decoration: underline;
		font-style: italic;
	}</style>';
    }

    public function add_button( $plugin_array )
    {
        $plugin_array['easy_affiliate_links'] = EasyAffiliateLinks::get()->coreUrl . '/js/editor_button_tinymce.js';
        return $plugin_array;
    }

    public function register_button( $buttons )
    {
        array_push( $buttons, 'easy_affiliate_links' );
        return $buttons;
    }

    public function lightbox_content()
    {
        include( EasyAffiliateLinks::get()->coreDir . '/helpers/editor_button_lightbox.php' );
    }
}