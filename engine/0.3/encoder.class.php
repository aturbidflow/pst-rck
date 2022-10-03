<?php

	class Encoder {
	
		private static $matrix = array(
			0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6',
			7 => '7', 8 => '8', 9 => '9', 10 => 'a', 11 => 'b', 12 => 'c', 13 => 'd',
			14 => 'e', 15 => 'f', 16 => 'g', 17 => 'h', 18 => 'i', 19 => 'j', 20 => 'k',
			21 => 'l', 22 => 'm', 23 => 'n', 24 => 'o', 25 => 'p', 26 => 'q', 27 => 'r',
			28 => 's', 29 => 't', 30 => 'u', 31 => 'v', 32 => 'w', 33 => 'x', 34 => 'y',
			35 => 'z', 36 => 'A', 37 => 'B', 38 => 'C', 39 => 'D', 40 => 'E', 41 => 'F',
			42 => 'G', 43 => 'H', 44 => 'I', 45 => 'J', 46 => 'K', 47 => 'L', 48 => 'M',
			49 => 'N', 50 => 'O', 51 => 'P', 52 => 'Q', 53 => 'R', 54 => 'S', 55 => 'T',
			56 => 'U', 57 => 'V', 58 => 'W', 59 => 'X', 60 => 'Y', 61 => 'Z', 62 => '!',
			63 => '_'
		);

		public static function Encode($array){
			$out = '';
			
			foreach ($array as $item){
				if (is_array($item)){
					$out .= Encoder::Encode($item);
				} else {
					$out .= Encoder::uLetter($item);
				}
			}
			return $out;
		}
		
		public static function Decode($str){
			$out = array();
			
			for ($i=0;$i<strlen($str);$i++){
				$out[] = Encoder::uNum($str[$i]);
			}
			return $out;
		}

		private static function uNum($text){
			$arr = array_flip(Encoder::$matrix);
			return $arr[$text];
		}
		
		private static function uLetter($num){
			return Encoder::$matrix[$num];
		}
	
	}

?>