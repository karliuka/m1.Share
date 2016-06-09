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
class Faonni_Share_Model_Resource_Summary 
	extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Set main entity table name and primary key field name
	 *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('faonni_share/summary', 'entity_id');
    }
	
    /**
     * Load an object by multiple fields
	 *
     * @param object $summary Faonni_Share_Model_Summary
     * @param array $fields should be array('column_name'=>'value', 'colum_name'=>'value')
     * @return Faonni_Share_Model_Resource_Summary
     */	
	public function loadByFields(Faonni_Share_Model_Summary $summary, $fields)
    {
        $read = $this->_getReadAdapter();
		
		if ($read && is_array($fields)) 
		{
			$where = array();
			foreach ($fields as $field => $value) {
				$where[] = sprintf('%s=:%s', $field, $field);
			}
			
			$select = $read->select()
				->from($this->getMainTable())
				->where(implode(' AND ', $where));
				
			$data = $read->fetchRow($select, $fields);	
			
		    if ($data) {
                $summary->setData($data);
            }
		}
        $this->unserializeFields($summary);
        $this->_afterLoad($summary);

        return $this;
    }
	
    /**
     * Load Unite count group by provider
	 *
     * @param int $entityTypeId
     * @param int $entityId
     * @param int $providerId	 
     * @return int
     */	
    public function getUniteCount($entityTypeId, $entityId, $providerId)
    {
        $read = $this->_getReadAdapter();
		
        $select = $read->select()
            ->from($this->getMainTable(), array('count' => new Zend_Db_Expr('SUM(count)')))
			->where('entity_type_id = ?', $entityTypeId, Zend_Db::INT_TYPE)
            ->where('share_entity_id = ?', $entityId, Zend_Db::INT_TYPE)
			->where('provider_id = ?', $providerId, Zend_Db::INT_TYPE)
			->group('provider_id');
			
        return $read->fetchOne($select);
    }
	
    /**
     * Load Summary count
	 *
     * @param int $entityTypeId
     * @param int $entityId	 
     * @return int
     */	
    public function getSummaryCount($entityTypeId, $entityId)
    {
        $read = $this->_getReadAdapter();
		
        $select = $read->select()
            ->from($this->getMainTable(), array('count' => new Zend_Db_Expr('SUM(count)')))
			->where('entity_type_id = ?', $entityTypeId, Zend_Db::INT_TYPE)
            ->where('share_entity_id = ?', $entityId, Zend_Db::INT_TYPE)
			->group('share_entity_id');
			
        return $read->fetchOne($select);
    }	
}