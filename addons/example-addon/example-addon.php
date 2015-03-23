<?php

class EAFL_Example_Addon extends EAFL_Addon {

    public function __construct( $name = 'example-addon' ) {
        parent::__construct( $name );
    }
}

EasyAffiliateLinks::loaded_addon( 'example-addon', new EAFL_Example_Addon() );