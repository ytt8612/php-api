<?php
class Lib_CarryConversion {

	// sixty-four into the bit
	private $carry = 64;
	// sixty-four bit hash table
	private $hash = array(
			'0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5',
			'6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => 'a', '11' => 'b',
			'12' => 'c', '13' => 'd', '14' => 'e', '15' => 'f', '16' => 'g', '17' => 'h',
			'18' => 'i', '19' => 'j', '20' => 'k', '21' => 'l', '22' => 'm', '23' => 'n',
			'24' => 'o', '25' => 'p', '26' => 'q', '27' => 'r', '28' => 's', '29' => 't',
			'30' => 'u', '31' => 'v', '32' => 'w', '33' => 'x', '34' => 'y', '35' => 'z',
			'36' => 'A', '37' => 'B', '38' => 'C', '39' => 'D', '40' => 'E', '41' => 'F',
			'42' => 'G', '43' => 'H', '44' => 'I', '45' => 'J', '46' => 'K', '47' => 'L',
			'48' => 'M', '49' => 'N', '50' => 'O', '51' => 'P', '52' => 'Q', '53' => 'R',
			'54' => 'S', '55' => 'T', '56' => 'U', '57' => 'V', '58' => 'W', '59' => 'X',
			'60' => 'Y', '61' => 'Z', '62' => '_', '63' => '-', 'a' => '10', 'b' => '11',
			'c' => '12', 'd' => '13', 'e' => '14', 'f' => '15', 'g' => '16', 'h' => '17',
			'i' => '18', 'j' => '19', 'k' => '20', 'l' => '21', 'm' => '22', 'n' => '23',
			'o' => '24', 'p' => '25', 'q' => '26', 'r' => '27', 's' => '28', 't' => '29',
			'u' => '30', 'v' => '31', 'w' => '32', 'x' => '33', 'y' => '34', 'z' => '35',
			'A' => '36', 'B' => '37', 'C' => '38', 'D' => '39', 'E' => '40', 'F' => '41',
			'G' => '42', 'H' => '43', 'I' => '44', 'J' => '45', 'K' => '46', 'L' => '47',
			'M' => '48', 'N' => '49', 'O' => '50', 'P' => '51', 'Q' => '52', 'R' => '53',
			'S' => '54', 'T' => '55', 'U' => '56', 'V' => '57', 'W' => '58', 'X' => '59',
			'Y' => '60', 'Z' => '61', '_' => '62', '-' => '63'
					);
					private static $_handle;

					public static function getInstance() {
						if (!is_object(self::$_handle))
							self::$_handle = new self();
						return self::$_handle;
					}

					private function __construct() {
						// initialization todo
					}

					/*
					 * decimal to sixty-four bit
					*/

					public function dec2sfb($dec) {
						if (strlen($dec) > 15)
							return 'Value entered is invalid';
						$outs = '';
						$base = intval($dec . '');
						do {
							$outs = $this->hash[($base % $this->carry) . ''] . $outs;
							$base = intval($base / $this->carry);
						} while ($base != 0);
						return $outs;
					}

					/*
					 * sixty-four bit to decimal
					*/

					public function sfb2dec($sfb) {
						if (strlen($sfb) > 9)
							return 'Value entered is invalid';
						$out_queue = array();
						$base = strrev($sfb);
						$baselen = strlen($base);
						while ($baselen != 0) {
							$byte = $base[--$baselen . ''];
							if (!in_array($byte, $this->hash))
								break;
							$item_v = intval($this->hash[$byte]) * pow($this->carry, $baselen);
							array_push($out_queue, $item_v);
						}
						return array_sum($out_queue);
					}

}