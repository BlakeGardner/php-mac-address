#PHP MAC Address

This is a PHP class for MAC address manipulation on top of Unix, Linux and Mac
OS X operating systems. it was primarily written to help with spoofing for
wireless security audits.

##Capabilities

  * Verify you are executing it from the command line
  * Verify you are running the script as an administrator
  * Generate new random MAC addresses
  * Validate MAC addresses
  * Get the current system’s MAC address
  * Set or “spoof” any MAC address you want

##Examples

``` php

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

```
