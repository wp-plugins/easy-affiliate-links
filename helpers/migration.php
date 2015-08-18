<?php

class EAFL_Migration {

    public function __construct()
    {
        add_action( 'admin_init', array( $this, 'migrate_if_needed' ) );
    }

    public function migrate_if_needed()
    {
        // Get current migrated to version
        $migrate_version = get_option( 'eafl_migrate_version', false );

        if( !$migrate_version ) {
            $notices = false;
            $migrate_version = '0.0.1';
        } else {
            $notices = true;
        }

        $migrate_special = '';
        if( isset( $_GET['eafl_migrate'] ) ) {
            $migrate_special = $_GET['eafl_migrate'];
        }

        //if( $migrate_version < '0.0.1' ) require_once( EasyAffiliateLinks::get()->coreDir . '/helpers/migration/0_0_1_example_migration.php');

	    // Each version update once
	    if( $migrate_version < EAFL_VERSION ) {
		    EasyAffiliateLinks::get()->helper( 'cache' )->reset(); // Reset cache

		    update_option( 'eafl_migrate_version', EAFL_VERSION );
	    }
    }
}