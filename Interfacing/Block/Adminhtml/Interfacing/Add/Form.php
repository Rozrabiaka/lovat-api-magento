<?php

class Lovat_Interfacing_Block_Adminhtml_Interfacing_Add_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
			"id" => "edit_form",
			"action" => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('interfacing_id'))),
			"method" => "post",
		));

		$apiKey = Mage::registry('lovat_api_key');
		$fieldset = $form->addFieldset("interfacing_add_form", array('legend' => 'Lovat Api создать новый ключь доступа'));

		if (!empty($apiKey)) {
			$fieldset->addField('apiKey', 'text', array(
				'label' => Mage::helper('interfacing')->__('Текущий ключь'),
				'name' => 'apiKey',
				'value' => $apiKey,
				'disabled' => true,
				'after_element_html' => '<div style="margin: 3px 0;">Ваш текущий ключь доступа. <span style="font-weight:bold">&#8593;</span></div>',
			));
		}

		$fieldset->addField('key', 'text', array(
			'label' => Mage::helper('interfacing')->__('Новый ключь'),
			'required' => true,
			'name' => 'key',
			'value' => substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 40),
			'readonly' => true,
			'after_element_html' => '<div style="margin: 3px 0;">Новый ключь. <span style="font-weight:bold">&#8593;</span></div>
									<div style="margin: 15px 0;">Важно! Если токен существует - то система заменит существующий на новый. Если токена в системе нету - токен будет сгенерирован.</div>
									<div style="margin: 1px 0;">Предоставьте программисту сгенерированный ключь доступа и API KEY название <span style="font-weight:bold;">x-lovat-api-key</span></div>',
		));

		$form->setUseContainer(true);
		$this->setForm($form);

		return parent::_prepareForm();
	}

}