<?php

class  Lovat_Interfacing_Block_Adminhtml_Interfacing_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function _construct()
	{
		$this->setId('interfacing_id');
		$this->_blockGroup = 'interfacing';
		$this->_controller = 'adminhtml_interfacing';
		$this->setDefaultSort('interfacing_id');
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('interfacing/interfacing')->getCollection();
		$this->setCollection($collection);

		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$helper = Mage::helper('interfacing');

		$this->addColumn('interfacing_id', array(
			'header' => $helper->__('Индефикатор'),
			'index' => 'interfacing_id',
			'filter' => false,
			'align' => 'center',
		));

		$this->addColumn('key', array(
			'header' => $helper->__('Ключь доступа Lovat Api'),
			'index' => 'key',
			'filter' => false,
			'sortable' => false,
			"align" => "center",
		));

		return parent::_prepareColumns();
	}
}