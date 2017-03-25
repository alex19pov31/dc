<?php

	namespace DC;

	interface ICollection 
	{
		static public function find($collection, $filter = false, $sort = false, $limit = false);
		static public function add($collection, $data);
		static public function addMany($collection, $data);
		static public function update($collection, $id, $data);
		static public function delete($collection, $id);
		static public function deleteAll($collection, $where);
	}