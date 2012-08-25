<?php

// require the class
require_once 'php-mac-address.php';

// get the mac address of the eth0 interface
MAC_Address::get_current_mac_address('eth0');

// generate a random mac address
MAC_Address::generate_mac_address();

// validate an MAC address
MAC_Address::validate_mac_address('00-B0-D0-86-BB-F7');

// set a randomly generated MAC address on the eth0 interface
MAC_Address::set_fake_mac_address('eth0');

// set a specific MAC address on the eth0 interface
MAC_Address::set_fake_mac_address('eth0', '00:E4:01:2C:79:DA');