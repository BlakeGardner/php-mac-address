<?php

class MAC_Address {
	
	/**
	 * Regular expression for matching and validating a MAC address
	 * @var string
	 */
	private $valid_mac = "([0-9A-F]{2}[:-]){5}([0-9A-F]{2})";
	
	public $mac_address_vals = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F");

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
		return (bool) preg_match("/^{$this->valid_mac}$/i", $mac);
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
	public function get_current_mac_address($interface) {
		if (!empty($interface)) {
			$ifconfig = $this->run_command("ifconfig {$interface}");
			preg_match("/{$this->valid_mac}/i", $ifconfig, $ifconfig);
			return trim(strtoupper($ifconfig[0]));
		}
	}

	/**
	 * @param string $mac
	 * @return bool Returns true on success else returns false
	 */
	public function set_fake_mac_address($mac = "", $interface) {
		if (empty($mac)) {
			$new_mac = $this->generate_mac_address();
		} else {
			$new_mac = $mac;
		}
		$this->run_command("ifconfig {$interface} down");
		$this->run_command("ifconfig {$interface} hw ether {$new_mac}");
		$this->run_command("ifconfig {$interface} up");
		if ($this->get_current_mac_address() == $new_mac) {
			return true;
		} else {
			return false;
		}
	}

}
