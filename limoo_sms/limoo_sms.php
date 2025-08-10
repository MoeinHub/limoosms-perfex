<?php
defined("BASEPATH") or exit("No direct script access allowed");

/*
Module Name: Limoo Sms Gateway
Description: Send SMS with limoo sms provider
Author: Moein Asiaii
Author URI: https://asiaii.ir
Version: 0.1
Requires at least: 2.9.0
*/

define('LIMOOSMS_MODULE_NAME', "limoo_sms");


/**
 * Adds the SMS SMSAPI module to the list of SMS gateways.
 *
 * @param array $gateways The array of SMS gateways.
 * @return array The updated array of SMS gateways.
 */
hooks()->add_filter('sms_gateways', function($gateways) {
    if( isset($gateways) && is_array($gateways) && LIMOOSMS_MODULE_NAME )
        array_push($gateways, LIMOOSMS_MODULE_NAME.DIRECTORY_SEPARATOR.'Sms_limoosms');

    return $gateways;
});


