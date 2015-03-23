<?php

class EAFL_Premium_Addon {

    public $addonDir;
    public $addonUrl;
    public $addonName;

    public function __construct( $name )
    {
        $this->addonDir = EasyAffiliateLinksPremium::get()->premiumDir . '/addons/' . $name;
        $this->addonUrl = EasyAffiliateLinksPremium::get()->premiumUrl . '/addons/' . $name;
        $this->addonName = $name;
    }
}