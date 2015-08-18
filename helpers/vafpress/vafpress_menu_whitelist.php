<?php

function eafl_admin_link_slug_preview( $slug )
{
    return site_url( '/'.$slug.'/' );
}

VP_Security::instance()->whitelist_function( 'eafl_admin_link_slug_preview' );