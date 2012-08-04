<?php

error_reporting(E_ALL);

class MAC_Address {

	public $system_interface;
	public $system_mac_address;
	public $mac_address_vals = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F");

	/**
	 * @return void
	 */
	public function __construct($interface) {
		if (php_sapi_name() != "cli") { // make sure this script is ran from the command line
			exit("\nYou must run this script from the command line\n\n");
		}
		if ($_ENV['LOGNAME'] != "root") { // make sure the user is root
			exit("\nYou must be root to run this script. Use sudo or su.\n\n");
		}
		$this->system_interface = $interface;
		$this->system_mac_address = $this->get_current_mac_address();
	}

	/**
	 * @return string generated MAC address
	 */
	public function generate_mac_address() {
		$vals = $this->mac_address_vals;
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
	 * Make sure a MAC adress string is in the correct format
	 * @param string $mac
	 * @return bool
	 */
	public function validate_mac_address($mac) {
		if (!empty($mac)) {
			$mac = str_replace(":", "", $mac);
			$mac = str_split($mac);
			if (count($mac) == 12) {
				foreach ($mac as $value) {
					if (!in_array($value, $this->mac_address_vals)) {
						return false;
					}
				}
				return true;
			}
		}
		return false;
	}

	/**
	 * @param string $cmd
	 * @return string output from command that was ran
	 */
	public function run_command($cmd) {
		if (!empty($cmd)) {
			ob_start();
			system($cmd);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}

	/**
	 * @return string Systems current MAC address
	 */
	public function get_current_mac_address() {
		if (!empty($this->system_interface)) {
			$ifconfig = $this->run_command("ifconfig | grep {$this->system_interface}");
			preg_match("/((?:(\d{1,2}|[a-fA-F]{1,2}){2})(?::|-*)){6}/", $ifconfig, $ifconfig);
			return trim(strtoupper($ifconfig[0]));
		}
	}

	/**
	 * @param string $mac
	 * @return bool Returns true on success else returns false
	 */
	public function set_fake_mac_address($mac = "") {
		if (empty($mac)) {
			$new_mac = $this->generate_mac_address();
		} else {
			$new_mac = $mac;
		}
		$this->run_command("ifconfig {$this->system_interface} down");
		$this->run_command("ifconfig {$this->system_interface} hw ether {$new_mac}");
		$this->run_command("ifconfig {$this->system_interface} up");
		if ($this->get_current_mac_address() == $new_mac) {
			return true;
		} else {
			return false;
		}
	}

}