<?php
	
	namespace \DC\Mongo;

	class Collection implements \DC\ICollection
	{
		public function find($collection, $filter = false, $sort = false, $limit = false)
		{
			return new Query($collection)
				->where($filter)
				->order($sort)
				->limit($limit);
		}

		public function add($collection, $data)
		{
			if( !($conn = Connection::getCollection($collection)) ) return false;
			return $conn->insertOne($data);
		}

		public function addMany($collection, $data)
		{
			if( !($conn = Connection::getCollection($collection)) ) return false;
			return $conn->insertMany($data);
		}

		static public function update($collection, $id, $data)
		{
			if( !($conn = Connection::getCollection($collection)) ) return false;

			return $collection->updateOne(
			    ['_id' => $id],
			    ['$set' => $data]
			);
		}

		static public function delete($collection, $id)
		{
			if( !($conn = Connection::getCollection($collection)) ) return false;
			return $conn->deleteOne(['_id' => $id]);
		}

		static public function deleteAll($collection, $where)
		{
			if( !($conn = Connection::getCollection($collection)) ) return false;
			return $conn->deleteMany($where);
		}
	}