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
class Faonni_Share_Model_Summary 
	extends Mage_Core_Model_Abstract
{
    /**
     * Set resource names
	 *
     * @return void
     */
    protected function _construct()
	{
       $this->_init('faonni_share/summary');
    }
	
    /**
     * Load an object by field
	 *
     * @return Faonni_Share_Model_Summary
     */	
	public function loadByFields($fields)
    {
        $this->getResource()->loadByFields($this, $fields);
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
        return $this->getResource()->getUniteCount($entityTypeId, $entityId, $providerId);
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
        return $this->getResource()->getSummaryCount($entityTypeId, $entityId);
    }	
}