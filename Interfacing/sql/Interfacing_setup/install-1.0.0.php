<?php

/** @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;
$installer->startSetup();

//Альтернативный способ
$installer->run("
    CREATE TABLE IF NOT EXISTS `{$this->getTable('interfacing/interfacing')}` (
    `interfacing_id` int(11) NOT NULL AUTO_INCREMENT,
    `key` varchar(255) NOT NULL,
    PRIMARY KEY (`interfacing_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    ");

$installer->endSetup();