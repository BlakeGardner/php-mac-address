<?php

// require the class
require_once 'php-mac-address.php';
echo "\n";

// get the mac address of the eth0 interface
echo "Current MAC address: ";
var_dump(MAC_Address::get_current_mac_address('eth0'));
echo "\n";

// generate a random mac address
echo "Randomly generated MAC address: ";
var_dump(MAC_Address::generate_mac_address());
echo "\n";

// validate an MAC address
echo "Validating MAC address: ";
var_dump(MAC_Address::validate_mac_address('00-B0-D0-86-BB-F7'));
echo "\n";

// set a randomly generated MAC address on the eth0 interface
echo "Setting a randomly generated MAC address: ";
var_dump(MAC_Address::set_fake_mac_address('eth0'));
echo "\n";

// set a specific MAC address on the eth0 interface
echo "Setting a specific MAC address: ";
var_dump(MAC_Address::set_fake_mac_address('eth0', '00:E4:01:2C:79:DA'));
echo "\n";