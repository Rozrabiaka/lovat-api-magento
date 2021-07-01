<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
	->newTable($installer->getTable('interfacing/interfacing'))
	->addColumn(
		'interfacing_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null,
		array(
			'identity' => true,
			'unsigned' => true,
			'nullable' => false,
			'primary' => true,
		), 'Unique identifier'
	)
	->addColumn(
		'key', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(), 'key'
	);

if (!$installer->getConnection()->isTableExists($table->getName())) {
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();