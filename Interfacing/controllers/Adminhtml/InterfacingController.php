<?php
/**
 * User: Daniil Krok
 */

class Lovat_Interfacing_Adminhtml_InterfacingController extends Mage_Adminhtml_Controller_Action
{
	protected function _isAllowed()
	{
		return true;
	}

	public function indexAction()
	{
		$this->loadLayout();
		$this->_setActiveMenu('interfacing');
		$contentBlock = $this->getLayout()->createBlock('interfacing/adminhtml_interfacing');
		$this->_addContent($contentBlock);
		$this->renderLayout();
	}

	public function newAction()
	{
		$model = Mage::getModel('interfacing/interfacing')->getCollection()
			->addFieldToSelect(['key']);

		if (!empty($model->getData())) {
			$modelData = $model->getData();
			Mage::register('lovat_api_key', $modelData[0]['key']);
		}

		$this->loadLayout()->_setActiveMenu('interfacing/interfacing');
		$this->_addContent($this->getLayout()->createBlock('interfacing/adminhtml_interfacing_add'));
		$this->renderLayout();
	}

	public function saveAction()
	{
		if ($postData = $this->getRequest()->getPost()) {

			$model = Mage::getModel('interfacing/interfacing')->getCollection()
				->addFieldToSelect(['interfacing_id']);

			$data = $model->getData();

			if (!empty($model->getData())) {
				$model = Mage::getModel('interfacing/interfacing')->load($data[0]['interfacing_id']);
				$model->setData('key', $postData['key']);
				if ($model->save()) Mage::getSingleton('adminhtml/session')->addSuccess('Ключь был успешно обновлен.');
				else Mage::getSingleton('adminhtml/session')->addError('Произошла ошибка при обновление ключа.');
			} else {
				$model = Mage::getModel('interfacing/interfacing');
				$model->setData($postData);
				if ($model->save()) Mage::getSingleton('adminhtml/session')->addSuccess('Ключь был успешно обновлен.');
				else Mage::getSingleton('adminhtml/session')->addError('Произошла ошибка создание ключа.');
			}
		}

		$this->_redirect('*/*/');
	}
}