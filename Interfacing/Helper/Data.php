<?php

class Lovat_Interfacing_Helper_Data extends Mage_Core_Helper_Abstract
{
	const ATTRIBUTES = array('from', 'to');

	public function validationApiGetDataFromTo($from, $to)
	{
		if ($this->is_Date($from) != false and $this->is_Date($to) != false) {
			$from = new \DateTime($from);
			$to = new \DateTime($to);
			return [
				'from' => $from->format('Y-m-d h:i:s'),
				'to' => $to->format('Y-m-d h:i:s')
			];
		}
		return false;
	}

	public function importantAttributes($attributes)
	{
		$arr2 = array_flip(self::ATTRIBUTES);
		$arr3 = array_diff_key($arr2, $attributes);
		return array_diff_key($arr3, $attributes);
	}

	public function is_Date($str)
	{
		return strtotime($str);
	}
}
