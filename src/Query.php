<?php

	namespace DC;

	abstract class Query {
		protected $_order;
		protected $_limit;
		protected $_where;
		protected $_select;

		public function select($arSelect)
		{
			$this->_select = $arSelect;
			return $this;
		}

		public function where($arWhere)
		{
			$this->_where = $arWhere;
			return $this;
		}

		public function limit($arLimit)
		{
			$this->_limit = $arLimit;
			return $this;
		}

		public function order($arOrder)
		{
			$this->_order = $arOrder;
			return $this;
		}

		abstract private function buildQuery();
		abstract public function all();
		abstract public function one();
	}