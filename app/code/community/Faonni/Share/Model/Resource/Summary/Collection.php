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
class Faonni_Share_Model_Resource_Summary_Collection 
	extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Set model name for collection items
	 *
     * @return void
     */
	public function _construct()
	{
		$this->_init('faonni_share/summary');
	}
	
    /**
     * Add collection filters by share entity id
	 *
     * @param mixed $entityId
     * @return Faonni_Share_Model_Resource_Summary_Collection
     */
    public function addEntityIdFilter($entityId)
    {
        if ($entityId && is_numeric($entityId)){
			$this->getSelect()->where('main_table.share_entity_id = ?', $entityId);
		}       
        return $this;
    }
	
    /**
     * Add collection filters by share entity type id
	 *
     * @param mixed $entityTypeId
     * @return Faonni_Share_Model_Resource_Summary_Collection
     */
    public function addEntityTypeIdFilter($entityTypeId)
    {
        if ($entityTypeId && is_numeric($entityTypeId)){
			$this->getSelect()->where('main_table.entity_type_id = ?', $entityTypeId);
		}       
        return $this;
    }
	
    /**
     * Add collection filters by store id
	 *
     * @param int $storeId
     * @return Faonni_Share_Model_Resource_Summary_Collection
     */
    public function addStoreIdFilter($storeId)
    {
        if ($storeId && is_numeric($storeId)){
			$this->getSelect()->where('main_table.store_id = ?', $storeId);
		}
        return $this;
    }	
}