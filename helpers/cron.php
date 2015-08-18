<?php

class EAFL_Cron {

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'schedule' ) );

        add_action( 'eafl_cron_clicks_summary', array( $this, 'cron_clicks_summary' ) );
    }

    public function schedule()
    {
//        if( !wp_next_scheduled( 'eafl_cron_clicks_summary' ) ) {
//            wp_schedule_event( time(), 'daily', 'eafl_cron_clicks_summary' );
//        }
    }

    public function cron_clicks_summary()
    {

    }
}