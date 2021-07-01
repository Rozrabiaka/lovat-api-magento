<?php
class Lovat_Interfacing_Block_Adminhtml_Interfacing extends Mage_Adminhtml_Block_Widget_Grid_Container
{

	public function __construct()
	{
		$this->_controller = 'adminhtml_interfacing';
		$this->_blockGroup = 'interfacing';
		$this->_headerText = Mage::helper('interfacing')->__('Lovat Api');
		$this->_addButtonLabel = Mage::helper('interfacing')->__('Token settings');
		parent::__construct();
	}
}