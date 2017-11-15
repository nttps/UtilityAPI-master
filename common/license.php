<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class license {

    private $array_licenseKey = array();

    public function __construct() {
        $this->getListLicenseKey();
    }

    public function licenseKey($domain, $licenseKey) {
        $verify = FALSE;
        foreach ($this->array_licenseKey as $keys => $value) {
            if ($value['domain'] == $domain && $licenseKey == $value['key']) {
                return TRUE;
            }
        }
        return $verify;
    }

    public function getListLicenseKey() {
        //dev mode
        $var = array('domain' => 'localhost',
            'key' => 'nagieos');
        array_push($this->array_licenseKey, $var);

        //prd mode
        $var = array('domain' => 'www.nagieos.com',
            'key' => 'nagieos');
        array_push($this->array_licenseKey, $var);
        $var = array('domain' => 'nagieos.com',
            'key' => 'nagieos');
        array_push($this->array_licenseKey, $var);

        //prd mode
        $var = array('domain' => 'nagieosbankapi.herokuapp.com',
            'key' => 'nagieos');
        array_push($this->array_licenseKey, $var);
    }

}
