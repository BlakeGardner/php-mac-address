<?php

// require the class
require_once 'php-mac-address.php';

// initialize the class
$mac = new MAC_Address;

// get the mac address of the 'en1' interface
echo "Current MAC address: " . $mac->get_current_mac_address('en1') . "\n\n";

// generate a random mac address
echo "Generated MAC address: " . $mac->generate_mac_address() . "\n\n";

$valid_mac    = '00-B0-D0-86-BB-F7';
$invalid_mac  = '00-B0-D0-86-BB-FG';

echo "Validating {$valid_mac}... Result: ";
var_dump($mac->validate_mac_address($valid_mac));

echo "\n";

echo "Validating {$invalid_mac}... Result: ";
var_dump($mac->validate_mac_address($invalid_mac));

