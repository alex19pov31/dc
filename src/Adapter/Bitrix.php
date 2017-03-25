<?php

	namespace \DC\Adapter;

	abstract class Bitrix
	{
		protected $_iblocks;
		protected $_element;

		public function __construct($arIblocks)
		{
			$this->_iblocks = (array) $arIblocks;
		}

		public function start()
		{
			AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("Adapter\Bitrix", "add"));
			AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("Adapter\Bitrix", "update"));
			AddEventHandler("iblock", "OnAfterIBlockElementDelete", Array("Adapter\Bitrix", "delete"));
		}

		protected function add($data)
		{
			if(!$this->checkIblock($data['IBLOCK_ID'])) return false;
			$this->_element = $this->getElement(['IBLOCK_ID' => $data['IBLOCK_ID'], 'ID' => $data['ID']]);
		}

		protected function update($data)
		{
			if(!$this->checkIblock($data['IBLOCK_ID'])) return false;
			$element = $this->getElement(['IBLOCK_ID' => $data['IBLOCK_ID'], 'ID' => $data['ID']]);
		}

		protected function delete($data)
		{
			if(!$this->checkIblock($data['IBLOCK_ID'])) return false;
		}

		protected function checkIblock($id)
		{
			return in_array($id, $this->_iblocks);
		}

		protected function getIblockElement($filter)
		{
			if(!CModule::IncludeModule("iblock")) return false;

			$res = CIBlockElement::GetList([], $filter);
			return array_merge($res->GetFields(), ['PROPERTIES' => $res->GetProperties()]);
		}

		protected function getElement($filter)
		{
			$iblockElement = $this->getIblockElement($filter);
			if(!$iblockElement || empty($iblockElement)) return false;

			$element = [];
			$properties = $iblockElement['PROPERTIES'];
			unset($iblockElement['PROPERTIES']);

			foreach ($iblockElement as $name => $value) {
				if(stripos($name, '~') > -1) continue;

				$key = strtolower($name);
				$element[$key] = $value;
			}

			foreach ($properties as $name => $prop) {
				if(!$prop['VALUE'] || empty($prop['VALUE'])) continue;

				$key = strtolower($name);
				$element[$key] = $prop['VALUE'];
			}

			return $element;
		}

		private function getId($data)
		{
			return "{$data['IBLOCK_ID']}_{$data['ID']}";
		}

		private function getNameCollection($data)
		{
			return "iblock";//"ib{$data['IBLOCK_ID']}";
		}
	}