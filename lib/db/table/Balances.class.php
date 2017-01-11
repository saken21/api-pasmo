<?php

// Generated by Haxe 3.3.0
class db_table_Balances {
	public function __construct(){}
	static $TABLE_NAME = "balances";
	static $FULL_COLUMNS = "id,card_id,term,value,last_modified_time";
	static function get($cardID, $term) {
		$_g = new haxe_ds_StringMap();
		$_g->set("card_id", $cardID);
		$_g->set("term", $term);
		$text = db_table_Balances::select("value", $_g);
		$json = haxe_Json::phpJsonDecode($text);
		if($json->length > 0) {
			return _hx_array_get($json, 0)->value;
		}
		$_g1 = new haxe_ds_StringMap();
		$_g1->set("card_id", $cardID);
		$text1 = db_table_Balances::select("max(term)", $_g1);
		$tmp = haxe_Json::phpJsonDecode($text1);
		$tmp1 = $tmp[0];
		$lastTerm = Reflect::getProperty($tmp1, "max(term)");
		$_g2 = new haxe_ds_StringMap();
		$_g2->set("card_id", $cardID);
		$_g2->set("term", $lastTerm);
		$text2 = db_table_Balances::select("value", $_g2);
		$tmp2 = haxe_Json::phpJsonDecode($text2);
		$value = _hx_array_get($tmp2, 0)->value;
		db_table_Balances::insert($cardID, $term, $value);
		return $value;
	}
	static function cutdown($cardID, $term, $diff) {
		$_g = new haxe_ds_StringMap();
		$_g->set("card_id", $cardID);
		$_g->set("term", $term);
		db_Connector::calculate("balances", "value", -$diff, $_g);
	}
	static function add($cardID, $term, $diff) {
		db_table_Balances::cutdown($cardID, $term, -$diff);
	}
	static function select($columns, $params = null) {
		return db_Connector::select("balances", $columns, $params);
	}
	static function insert($cardID, $term, $value) {
		$_g = new haxe_ds_StringMap();
		$_g->set("card_id", $cardID);
		$_g->set("term", $term);
		$_g->set("value", $value);
		{
			$value1 = db_Utils::getNow();
			$_g->set("last_modified_time", $value1);
		}
		db_Connector::insert("balances", $_g);
	}
	function __toString() { return 'db.table.Balances'; }
}
