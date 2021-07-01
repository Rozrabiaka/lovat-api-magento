<?php

class Lovat_Interfacing_Model_Resource_Interfacing_Collection extends  Mage_Core_Model_Resource_Db_Collection_Abstract
{
	public function _construct()
	{
		$this->_init("interfacing/interfacing");
	}

}