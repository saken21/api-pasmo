<?php

// Generated by Haxe 3.3.0
class db_table_Histories {
	public function __construct(){}
	static $TABLE_NAME = "histories";
	static $FULL_COLUMNS = "id,card_id,term,history_date,client,transportation,departure,destination,is_round,price,comment,is_charge,last_modified_time";
	static function get($cardID, $term) {
		$_g = new haxe_ds_StringMap();
		$_g->set("card_id", $cardID);
		$_g->set("term", $term);
		$text = db_table_Histories::select("id,card_id,term,history_date,client,transportation,departure,destination,is_round,price,comment,is_charge,last_modified_time", $_g, " order by history_date asc");
		return haxe_Json::phpJsonDecode($text);
	}
	static function set($id, $cardID, $term, $price, $params) {
		{
			$v = db_Utils::getNow();
			$params->set("last_modified_time", $v);
		}
		$tmp = null;
		if($id !== null) {
			$_g = new haxe_ds_StringMap();
			$_g->set("id", $id);
			$tmp1 = db_table_Histories::select("id", $_g, null);
			$tmp = db_Utils::exists($tmp1);
		} else {
			$tmp = false;
		}
		if($tmp) {
			db_table_Histories::update($id, $cardID, $term, $price, $params);
		} else {
			db_table_Histories::insert($cardID, $term, $price, $params);
		}
	}
	static function delete($id) {
		db_table_Histories::returnBalance($id);
		db_Connector::delete("histories", $id);
	}
	static function select($columns, $params = null, $option = null) {
		if($option === null) {
			$option = "";
		}
		return db_Connector::select("histories", $columns, $params, $option);
	}
	static function update($id, $cardID, $term, $price, $params) {
		db_table_Histories::returnBalance($id);
		db_table_Balances::cutdown($cardID, $term, $price);
		$_g = new haxe_ds_StringMap();
		$_g->set("id", $id);
		db_Connector::update("histories", $params, $_g);
	}
	static function insert($cardID, $term, $price, $params) {
		db_table_Balances::cutdown($cardID, $term, $price);
		db_Connector::insert("histories", $params);
	}
	static function returnBalance($id) {
		$_g = new haxe_ds_StringMap();
		$_g->set("id", $id);
		$text = db_table_Histories::select("card_id,term,price", $_g, null);
		$tmp = haxe_Json::phpJsonDecode($text);
		$last = $tmp[0];
		$tmp1 = $last->card_id;
		$tmp2 = $last->term;
		$tmp3 = Std::parseInt($last->price);
		db_table_Balances::add($tmp1, $tmp2, $tmp3);
	}
	function __toString() { return 'db.table.Histories'; }
}
