<?php

	namespace DC;

	class CollectionResult implements ArrayAccess, IteratorAggregate 
	{
		private $_data;
		private $_select;
		private $_filter;
		private $idByKey;

		function __construct($data)
		{
			$this->_data = (array) $data;
			//foreach ($this->_data as $key => $item) $this->setKeys($item, $key);
		}

		public function offsetSet($offset, $value) {
	        if (is_null($offset)) {
	            $this->_data[] = $value;
	        } else {
	            $this->_data[$offset] = $value;
	        }
	    }

	    public function offsetExists($offset) {
	        return $this->_data[$offset];
	    }

	    public function offsetUnset($offset) {
	        unset($this->_data[$offset]);
	    }

	    public function offsetGet($offset) {
	        return isset($this->_data[$offset]) ? $this->_data[$offset] : null;
	    }


		/*private function setKeys($item, $id)
		{
			foreach ($item as $key => $value) {
				if(is_object($value) || is_string($value) && strlen($value) > 20) continue;
				$idByKey["{$key}_{$value}"][] = $id;
			}
		}*/

		private function checkFilter($item)
		{
			if(!$this->_filter) return true;
			foreach ($this->_filter as $key => $val) if($item[$key] != $val) return false;

			return true;
		}

		private function getSelect($item)
		{
			if(!$this->_select) return true;
			$result = [];
			foreach ($this->_select as $field) if(isset($item[$field]) && $item[$field]) $result[$field] = $item[$field];

			return $result;
		}

		public function filter($arFilter)
		{
			$this->_filter = $arFilter;
			return $this;
		}

		public function select($arSelect)
		{
			$this->select = $arSelect;
			return $this;
		}

		public function apply()
		{
			$result = [];
			foreach ($this->_data as $item) {
				if(!$this->checkFilter($item)) continue;
				$result[] = $this->getSelect($item);
			}

			return $result;
		}
	}