<?php

class  Lovat_Interfacing_Block_Adminhtml_Interfacing_Add extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();

		$this->_objectId = 'interfacing_id';
		$this->_blockGroup = 'interfacing';
		$this->_controller = 'adminhtml_interfacing';
		$this->_mode = 'add';
		$this->_headerText = Mage::helper("interfacing")->__("Lovat Api создать новый ключь доступа");

		$this->_removeButton('reset');
	}

}