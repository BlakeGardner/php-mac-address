<?php

echo "\n";

// require the class
require_once './src/BlakeGardner/MacAddress.php';

// import the class
use BlakeGardner\MacAddress;

// get the mac address of the eth0 interface
echo "Current MAC address: ";
var_dump(MacAddress::getCurrentMacAddress('eth0'));
echo "\n";

// generate a random mac address
echo "Randomly generated MAC address: ";
var_dump(MacAddress::generateMacAddress());
echo "\n";

// validate an MAC address
echo "Validating MAC address: ";
var_dump(MacAddress::validateMacAddress('00-B0-D0-86-BB-F7'));
echo "\n";

// set a randomly generated MAC address on the eth0 interface
echo "Setting a randomly generated MAC address: ";
var_dump(MacAddress::setFakeMacAddress('eth0'));
echo "\n";

// set a specific MAC address on the eth0 interface
echo "Setting a specific MAC address: ";
var_dump(MacAddress::setFakeMacAddress('eth0', '00:E4:01:2C:79:DA'));
echo "\n";