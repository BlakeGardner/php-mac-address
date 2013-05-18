<?php

namespace BlakeGardner;

/**
 * This class allows you to preform various operations with
 * Media Access Control (MAC addresses) on UNIX type systems.
 * 
 * @author Blake Gardner <blakegardner[at]cox.net>
 * @copyright Copyright (c) 2012, Blake Gardner
 * @license MIT License (see License.txt)
 */
class MacAddress
{

    /**
     * Regular expression for matching and validating a MAC address
     * @var string
     */
    private static $valid_mac = "([0-9A-F]{2}[:-]){5}([0-9A-F]{2})";

    /**
     * An array of valid MAC address characters
     * @var array
     */
    private static $mac_address_vals = array(
        "0", "1", "2", "3", "4", "5", "6", "7",
        "8", "9", "A", "B", "C", "D", "E", "F"
     );

    /**
     * Change the MAC address of the network interface specified
     * @param string $interface Name of the interface e.g. eth0
     * @param string $mac The new MAC address to be set to the interface
     * @return bool Returns true on success else returns false
     */
    public static function setFakeMacAddress($interface, $mac = null)
    {

        // if a valid mac address was not passed then generate one
        if (!self::validateMacAddress($mac)) {
            $mac = self::generateMacAddress();
        }

        // bring the interface down, set the new mac, bring it back up
        self::runCommand("ifconfig {$interface} down");
        self::runCommand("ifconfig {$interface} hw ether {$mac}");
        self::runCommand("ifconfig {$interface} up");

        // TODO: figure out if there is a better method of doing this
        // run DHCP client to grab a new IP address
        self::runCommand("dhclient {$interface}");

        // run a test to see if the operation was a success
        if (self::getCurrentMacAddress($interface) == $mac) {
            return true;
        }

        // by default just return false
        return false;
    }

    /**
     * @return string generated MAC address
     */
    public static function generateMacAddress()
    {
        $vals = self::$mac_address_vals;
        if (count($vals) >= 1) {
            $mac = array("00"); // set first two digits manually
            while (count($mac) < 6) {
                shuffle($vals);
                $mac[] = $vals[0] . $vals[1];
            }
            $mac = implode(":", $mac);
        }
        return $mac;
    }

    /**
     * Make sure the provided MAC address is in the correct format
     * @param string $mac
     * @return bool true if valid; otherwise false
     */
    public static function validateMacAddress($mac)
    {
        return (bool) preg_match("/^" . self::$valid_mac . "$/i", $mac);
    }

    /**
     * Run the specified command and return it's output
     * @param string $command
     * @return string Output from command that was ran
     */
    protected static function runCommand($command)
    {
        return shell_exec($command);
    }

    /**
     * Get the system's current MAC address
     * @param string $interface The name of the interface e.g. eth0
     * @return string|bool Systems current MAC address; otherwise false on error
     */
    public static function getCurrentMacAddress($interface)
    {
        $ifconfig = self::runCommand("ifconfig {$interface}");
        preg_match("/" . self::$valid_mac . "/i", $ifconfig, $ifconfig);
        if (isset($ifconfig[0])) {
            return trim(strtoupper($ifconfig[0]));
        }
        return false;
    }
}
