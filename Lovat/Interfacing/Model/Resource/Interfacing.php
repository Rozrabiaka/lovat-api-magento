<?php

class Lovat_Interfacing_Model_Resource_Interfacing extends Mage_Core_Model_Resource_Db_Abstract
{
	protected function _construct()
	{
		$this->_init("interfacing/interfacing", "interfacing_id");
	}
}