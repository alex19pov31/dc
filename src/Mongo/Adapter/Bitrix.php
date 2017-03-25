<?php

namespace \DC\Mongo\Adapter;

class Bitrix extends \DC\Adapter\Bitrix
{
	use \DC\Mongo;

	protected function add($data)
	{
		parent::add($data);
		Collection::add($this->getNameCollection($data), $this->_element);
	}

	protected function update($data)
	{
		parent::update($data);
		Collection::update($this->getNameCollection($data), $this->getId($data), $this->_element);
	}

	protected function delete($data)
	{
		parent::delete($data);
		Collection::update($this->getNameCollection($data), $this->getId($data));
	}
}