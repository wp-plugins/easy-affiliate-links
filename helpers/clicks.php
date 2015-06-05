<?php

class EAFL_Clicks {

    public function __construct()
    {
    }

    public function register( $link )
    {
        require_once( EasyAffiliateLinks::get()->coreDir . '/vendor/Browser/lib/Browser.php' );

        $click = array(
            'browser' => new Browser(),
            'ip' => $this->get_user_ip(),
            'referer' => $_SERVER['HTTP_REFERER'],
            'request' => $_SERVER['REQUEST_URI'],
            'time' => time(),
            'user' => get_current_user_id(),
        );

        add_post_meta( $link->ID(), 'eafl_clicks', $click );

        $summary = get_post_meta( $link->ID(), 'eafl_clicks_summary', true );
        if( !is_array( $summary ) ) $summary = array();

        $year_month = date( 'Y-m' );
        $summary[$year_month] = isset( $summary[$year_month] ) ? $summary[$year_month] + 1 : 1;
        $summary['all'] = isset( $summary['all'] ) ? $summary['all'] + 1 : 1;

        update_post_meta( $link->ID(), 'eafl_clicks_summary', $summary );
    }

    public function summary( $link_id )
    {
        $summary = get_post_meta( $link_id, 'eafl_clicks_summary', true );
        if( !is_array( $summary ) ) $summary = array();

        $year_month = date( 'Y-m' );
        if( !isset( $summary[$year_month] ) ) $summary[$year_month] = 0;
        if( !isset( $summary['all'] ) ) $summary['all'] = 0;
        $summary['month'] = $summary[$year_month];

        return $summary;
    }

    // Source: http://stackoverflow.com/questions/6717926/function-to-get-user-ip-address
    private function get_user_ip()
    {
        foreach( array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key )
        {
            if( array_key_exists( $key, $_SERVER ) === true )
            {
                foreach( array_map( 'trim', explode( ',', $_SERVER[$key] ) ) as $ip )
                {
                    if( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false )
                    {
                        return $ip;
                    }
                }
            }
        }

        return '';
    }
}