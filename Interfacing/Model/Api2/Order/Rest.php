<?php

class Lovat_Interfacing_Model_Api2_Order_Rest extends Lovat_Interfacing_Model_Api2_Order
{
	const COUNT_PAGE_SIZE = 5000;
	const API_KEY = 'x-lovat-api-key';

	protected function _retrieveCollection()
	{
		$apiKey = Mage::app()->getRequest()->getHeader(self::API_KEY);

		if (!empty($apiKey)) {
			$model = Mage::getModel('interfacing/interfacing')->load($apiKey, 'key');
			if (!empty($model->getData())) {
				$params = $this->getRequest()->getParams();
				$reqAttributes = Mage::helper('interfacing')->importantAttributes($params);
				if (!empty($reqAttributes)) {
					$reqAttString = '';
					$i = 0;
					foreach ($reqAttributes as $key => $attribute) {
						if ($i == 0) $reqAttString .= ' ' . $key;
						else $reqAttString .= ' , ' . $key;
						$i++;
					}

					$this->_critical("Please, enter required attributes:" . $reqAttString,
						Mage_Api2_Model_Server::HTTP_OK);
				}

				$from = $params['from'];
				$to = $params['to'];

				$validateData = Mage::helper('interfacing')->validationApiGetDataFromTo($from, $to);

				if (!$validateData) {
					$this->_critical("Problem with data, please complete required parameters such as 'from' and 'to' or make sure the date format is correct",
						Mage_Api2_Model_Server::HTTP_BAD_REQUEST);
				}

				$p = 1;
				if (!empty($params['p']) AND !is_int($params['p'])) $p = (int)$params['p'];

				$orderCollection = Mage::getModel('sales/order')->getCollection()
					->addFieldToSelect(['increment_id', 'global_currency_code', 'status', 'updated_at', 'total_due', 'shipping_address_id', 'total_refunded', 'total_paid', 'tax_amount'])
					->addAttributeToFilter('main_table.created_at', array('from' => $from, 'to' => $to))
					->addAttributeToFilter('main_table.status', array('in' => array(
						Mage_Sales_Model_Order::STATE_COMPLETE,
						Mage_Sales_Model_Order::STATE_CLOSED
					)));
				$orderCollection->getSelect()->joinLeft(
					['billingTable' => 'sales_flat_order_address'],
					"main_table.entity_id = billingTable.parent_id AND billingTable.address_type = 'billing'",
					['vat_id', 'country_id', 'city', 'address_type']
				);
				$orderCollection->getSelect()->joinLeft(
					['orderItem' => 'sales_flat_order_item'],
					"main_table.entity_id = orderItem.order_id",
					['tax_amount', 'tax_percent']
				);
				$orderCollection->setPageSize(self::COUNT_PAGE_SIZE)
					->setCurPage($p);

				if (($orderCollection->getSize() + self::COUNT_PAGE_SIZE) >= ($p * self::COUNT_PAGE_SIZE)) {
					$data = array();
					$remainingData = $this->remainingAmount($from, $to, $p);
					$data['orders'] = $orderCollection->getData();
					$data['remainingData'] = $remainingData;

					return $data;
				} else {
					$this->_critical('Could not find data for your request', Mage_Api2_Model_Server::HTTP_OK);
				}

				$this->_critical('Something went wrong', Mage_Api2_Model_Server::HTTP_OK);
			}

			$this->_critical("Access denied",
				Mage_Api2_Model_Server::HTTP_UNAUTHORIZED);
		}
	}

	public function remainingAmount($from, $to, $p)
	{
		$collection = Mage::getModel('sales/order')->getCollection()
			->addFieldToSelect(['entity_id'])
			->addAttributeToFilter('main_table.status', array('in' => array(
				Mage_Sales_Model_Order::STATE_COMPLETE,
				Mage_Sales_Model_Order::STATE_CLOSED
			)))
			->addAttributeToFilter('main_table.created_at', ['from' => $from, 'to' => $to]);

		$count = $collection->count();
		$remainingData = $count - ($p * self::COUNT_PAGE_SIZE);

		if ($remainingData < 0) {
			$remainingData = 0;
		}

		$returnArray[] = [
			'remaining_data' => $remainingData,
			'count' => $count,
			'limit' => self::COUNT_PAGE_SIZE,
			'offset' => $p
		];

		return $returnArray;
	}
}