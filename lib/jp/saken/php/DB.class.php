<?php

// Generated by Haxe 3.3.0
class jp_saken_php_DB {
	public function __construct(){}
	static $_host = "localhost";
	static $_user = "root";
	static $_password = "root";
	static function init($host, $user, $password) {
		jp_saken_php_DB::$_host = $host;
		jp_saken_php_DB::$_user = $user;
		jp_saken_php_DB::$_password = $password;
	}
	static function getConnection($dbname) {
		return php_db_PDO::open("mysql:host=" . _hx_string_or_null(jp_saken_php_DB::$_host) . ";dbname=" . _hx_string_or_null($dbname) . ";charset=utf8", jp_saken_php_DB::$_user, jp_saken_php_DB::$_password, null);
	}
	static function getData($list) {
		$results = (new _hx_array(array()));
		{
			$tmp = $list->iterator();
			while(true) {
				$tmp1 = !$tmp->hasNext();
				if($tmp1) {
					break;
				}
				$info = $tmp->next();
				$results->push($info);
				unset($tmp1,$info);
			}
		}
		return $results;
	}
	static function getJSON($list) {
		$results = (new _hx_array(array()));
		{
			$tmp = $list->iterator();
			while(true) {
				$tmp1 = !$tmp->hasNext();
				if($tmp1) {
					break;
				}
				$info = $tmp->next();
				$tmp2 = haxe_Json::phpJsonEncode($info, null, null);
				$results->push($tmp2);
				unset($tmp2,$tmp1,$info);
			}
		}
		return $results->toString();
	}
	static function isNG($value) {
		return _hx_deref(new EReg("\"|'| |/", ""))->match($value);
	}
	static function getReplacedQuotation($params) {
		{
			$tmp = $params->keys();
			while(true) {
				$tmp1 = !$tmp->hasNext();
				if($tmp1) {
					break;
				}
				$p = $tmp->next();
				$tmp2 = new EReg("\"", "g");
				$value = $tmp2->replace($params->get($p), "\"");
				{
					$v = _hx_deref(new EReg("'", "g"))->replace($value, "'");
					$params->set($p, $v);
					unset($v);
				}
				unset($value,$tmp2,$tmp1,$p);
			}
		}
		return $params;
	}
	function __toString() { return 'jp.saken.php.DB'; }
}
