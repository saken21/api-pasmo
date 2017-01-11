<?php

// Generated by Haxe 3.3.0
class db_Utils {
	public function __construct(){}
	static function getJoined($map, $separator = null) {
		if($separator === null) {
			$separator = " and ";
		}
		$array = (new _hx_array(array()));
		{
			$tmp = $map->keys();
			while(true) {
				$tmp1 = !$tmp->hasNext();
				if($tmp1) {
					break;
				}
				$key = $tmp->next();
				$tmp2 = _hx_string_or_null($key) . " = \"" . _hx_string_or_null($map->get($key));
				$array->push(_hx_string_or_null($tmp2) . "\"");
				unset($tmp2,$tmp1,$key);
			}
		}
		return $array->join($separator);
	}
	static function exists($value) {
		return _hx_len(haxe_Json::phpJsonDecode($value)) > 0;
	}
	static function existsInMap($map, $keys) {
		{
			$_g1 = 0;
			$_g = $keys->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				$tmp = $keys[$i];
				$tmp1 = !$map->exists($tmp);
				if($tmp1) {
					return false;
				}
				unset($tmp1,$tmp,$i);
			}
		}
		return true;
	}
	static function existsParams($array) {
		{
			$_g1 = 0;
			$_g = $array->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($array[$i] === null) {
					return false;
				}
				unset($i);
			}
		}
		return true;
	}
	static function getNow() {
		return Date::now()->toString();
	}
	static function getThisTerm() {
		return db_Utils::getTerm(null);
	}
	static function getLastTerm() {
		return db_Utils::getTerm(1);
	}
	static function getTerm($past = null) {
		if($past === null) {
			$past = 0;
		}
		$date = Date::now();
		$y = $date->getFullYear();
		$tmp = $date->getMonth();
		$m = $tmp + 1;
		$date->getDate();
		$m -= $past;
		$tmp1 = $m < 1;
		if($tmp1) {
			--$y;
			$m = 12;
		}
		$tmp2 = null;
		if($m < 10) {
			$tmp2 = "0" . _hx_string_rec($m, "");
		} else {
			$tmp2 = $m;
		}
		$tmp3 = Std::string($tmp2);
		return _hx_string_rec($y, "") . _hx_string_or_null($tmp3);
	}
	function __toString() { return 'db.Utils'; }
}
