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
class Faonni_Share_Model_Provider
	extends Varien_Object
{
    /**
     * Resource model
	 *
     * @var Faonni_Share_Model_Resource_Abstract
     */
    protected $_resource;

    /**
     * Collection model
	 *
     * @var Faonni_Share_Model_Resource_Provider_Collection
     */
    protected $_collection;

    /**
     * Check whether provider can be used
	 *
     * @return bool
     */
    public function isAvailable()
    {
		return (bool)$this->getActive();
    }
	
    /**
     * Get count
	 *
     * @return int
     */
    public function getCount()
    {
        return $this->hasData('count') 
				? (int)$this->getData('count') 
				: 0;
    }
	
    /**
     * Get Provider resource model
	 *
     * @return Faonni_Share_Model_Resource_Abstract
     */
    public function getResource()
    {
        if (null === $this->_resource){
            $this->_resource = Mage::getResourceModel('faonni_share/' . $this->getId());
        }
        return $this->_resource;
    }
	
    /**
     * Get Full Share URL
	 *
     * @return string
     */	
	public function getShareUrl()
	{
		return $this->getResource()->getShareUrl();
	}	
	
    /**
     * Load count
	 *
     * @return int|bool
     */	
	public function loadCount($url)
	{
		return $this->getResource()->loadCount($url);
	}	
	
    /**
     * Get collection instance
	 *
     * @return Faonni_Share_Model_Resource_Collection
     */
    public function getCollection()
    {
        if (null === $this->_collection){
			$this->_collection = Mage::getResourceModel('faonni_share/provider_collection');
		}
		return $this->_collection;
    }

    /**
     * Load Provider data
	 *
     * @param string $id
     * @return Faonni_Share_Model_Provider
     */
    public function load($id)
    {
        return $this->getCollection()->getItemByColumnValue('id', $id);
    }	
}