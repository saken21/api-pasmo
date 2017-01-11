<?php

// Generated by Haxe 3.3.0
class Type {
	public function __construct(){}
	static function typeof($v) {
		if($v === null) {
			return ValueType::$TNull;
		}
		$tmp = is_array($v);
		if($tmp) {
			$tmp1 = is_callable($v);
			if($tmp1) {
				return ValueType::$TFunction;
			}
			return ValueType::TClass(_hx_qtype("Array"));
		}
		$tmp2 = is_string($v);
		if($tmp2) {
			$tmp3 = _hx_is_lambda($v);
			if($tmp3) {
				return ValueType::$TFunction;
			}
			return ValueType::TClass(_hx_qtype("String"));
		}
		$tmp4 = is_bool($v);
		if($tmp4) {
			return ValueType::$TBool;
		}
		$tmp5 = is_int($v);
		if($tmp5) {
			return ValueType::$TInt;
		}
		$tmp6 = is_float($v);
		if($tmp6) {
			return ValueType::$TFloat;
		}
		$tmp7 = $v instanceof _hx_anonymous;
		if($tmp7) {
			return ValueType::$TObject;
		}
		$tmp8 = $v instanceof _hx_enum;
		if($tmp8) {
			return ValueType::$TObject;
		}
		$tmp9 = $v instanceof _hx_class;
		if($tmp9) {
			return ValueType::$TObject;
		}
		$c = _hx_ttype(get_class($v));
		$tmp10 = $c instanceof _hx_enum;
		if($tmp10) {
			return ValueType::TEnum($c);
		}
		$tmp11 = $c instanceof _hx_class;
		if($tmp11) {
			return ValueType::TClass($c);
		}
		return ValueType::$TUnknown;
	}
	function __toString() { return 'Type'; }
}
