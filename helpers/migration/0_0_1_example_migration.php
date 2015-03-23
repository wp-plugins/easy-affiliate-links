<?php
/*
 * -> 0.0.1
 *
 * Example Migration
 */

// Successfully migrated to 0.0.1
$migrate_version = '0.0.1';
update_option( 'eafl_migrate_version', $migrate_version );
if( $notices ) EasyAffiliateLinks::get()->helper( 'notices' )->add_admin_notice( '<strong>Easy Affiliate Links</strong> Successfully migrated to 0.0.1+' );