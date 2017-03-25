<?php
	
	namespace \DC\Mongo;

	class Query extends \DC\Query
	{	
		private $collection;

		function __construct($collection)
		{
			$this->collection = $collection;
		}

		private function buildQuery()
		{
			$options = [];
			$query[] = $this->_filter ? $this->_filter : [];
			if($this->_order) $options['sort'] = $this->_order;
			if($this->_limit) $options['limit'] = $this->_limit;
			if($this->_select) $options['select'] = $this->_select;

			return array_merge($query, $options);
		}

		public function execute($query)
		{
			if(!($conn = Connection::getCollection($this->collection)) || !$query || empty($query)) return false;
			$rows = $conn->executeQuery($query);

			return $rows;
		}

		public function all()
		{
			$query = $this->buildQuery();
			if(!($conn = Connection::getCollection($this->collection))) return false;

			$rows = $conn->find($query);
			if(!$rows) return false;

			$result = [];
			foreach ($rows as $document) $result[] = $document;

			return new \DC\CollectionResult($rows);
		}

		public function one()
		{
			$query = $this->buildQuery();
			$rows = $this->execute($query);
			if(!$rows) return false;

			foreach ($rows as $document) return $document;
		}
	}