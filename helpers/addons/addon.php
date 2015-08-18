<?php

class EAFL_Addon {

    public $addonDir;
    public $addonUrl;
    public $addonName;

    public function __construct( $name )
    {
        $this->addonDir = EasyAffiliateLinks::get()->coreDir . '/addons/' . $name;
        $this->addonUrl = EasyAffiliateLinks::get()->coreUrl . '/addons/' . $name;
        $this->addonName = $name;
    }
}