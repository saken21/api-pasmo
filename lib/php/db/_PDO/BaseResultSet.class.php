<?php

// Generated by Haxe 3.3.0
class php_db__PDO_BaseResultSet implements sys_db_ResultSet{
	public function __construct($pdo, $typeStrategy) {
		if(!php_Boot::$skip_constructor) {
		$this->pdo = $pdo;
		$this->typeStrategy = $typeStrategy;
		$this->_fields = $pdo->columnCount();
		$this->_columnNames = (new _hx_array(array()));
		$this->_columnTypes = (new _hx_array(array()));
		$this->feedColumns();
	}}
	public $pdo;
	public $typeStrategy;
	public $_fields;
	public $_columnNames;
	public $_columnTypes;
	public function feedColumns() {
		$_g1 = 0;
		$_g = $this->_fields;
		while($_g1 < $_g) {
			$i = $_g1++;
			$data = $this->pdo->getColumnMeta($i);
			$tmp = $data["name"];
			$this->_columnNames->push($tmp);
			$tmp1 = $this->typeStrategy->map($data);
			$this->_columnTypes->push($tmp1);
			unset($tmp1,$tmp,$i,$data);
		}
	}
	public function hasNext() {
		throw new HException("must override");
	}
	public function nextRow() {
		throw new HException("must override");
	}
	public function next() {
		$row = $this->nextRow();
		$o = _hx_anonymous(array());
		{
			$_g1 = 0;
			$_g = $this->_fields;
			while($_g1 < $_g) {
				$i = $_g1++;
				{
					$tmp = $row[$i];
					$tmp1 = $this->_columnTypes[$i];
					$value = php_db__PDO_TypeStrategy::convert($tmp, $tmp1);
					$o->{$this->_columnNames[$i]} = $value;
					unset($value,$tmp1,$tmp);
				}
				unset($i);
			}
		}
		return $o;
	}
	public function results() {
		$list = new HList();
		while(true) {
			$tmp = !$this->hasNext();
			if($tmp) {
				break;
			}
			$tmp1 = $this->next();
			$list->add($tmp1);
			unset($tmp1,$tmp);
		}
		return $list;
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->__dynamics[$m]) && is_callable($this->__dynamics[$m]))
			return call_user_func_array($this->__dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call <'.$m.'>');
	}
	function __toString() { return 'php.db._PDO.BaseResultSet'; }
}