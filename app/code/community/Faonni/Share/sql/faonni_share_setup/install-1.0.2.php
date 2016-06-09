<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_Share
 * @copyright   Copyright (c) 2015 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'faonni_share/summary'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('faonni_share/summary'))
	->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
		), 'Entity Id')	
    ->addColumn('entity_type_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'unsigned'  => true,
		'nullable'  => false,
        ), 'Entity Type Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
		'unsigned'  => true,
        ), 'Store Id')		
    ->addColumn('share_entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		'nullable'  => false,
        ), 'Entity Id')			
    ->addColumn('provider_id', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
        'nullable'  => false,
        ), 'Provider Id')	
    ->addColumn('count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'unsigned'  => true,
		'nullable'  => false,
        ), 'Share Count')
		
	->addIndex($installer->getIdxName('faonni_share/summary', array('entity_type_id')),
        array('entity_type_id'))
	->addIndex($installer->getIdxName('faonni_share/summary', array('store_id')),
        array('store_id'))			
	->addIndex($installer->getIdxName('faonni_share/summary', array('provider_id')),
        array('provider_id'))
	->addIndex($installer->getIdxName('faonni_share/summary', array('share_entity_id')),
        array('share_entity_id'))			

	->addIndex($installer->getIdxName('faonni_share/summary', array('entity_type_id', 'store_id', 'share_entity_id', 'provider_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('entity_type_id', 'store_id', 'share_entity_id', 'provider_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))	
		
    ->addForeignKey($installer->getFkName('faonni_share/summary', 'entity_type_id', 'eav/entity_type', 'entity_type_id'),
        'entity_type_id', $installer->getTable('eav/entity_type'), 'entity_type_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
		
	->addForeignKey($installer->getFkName('faonni_share/summary', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);	

$installer->getConnection()->createTable($table);
$installer->endSetup();