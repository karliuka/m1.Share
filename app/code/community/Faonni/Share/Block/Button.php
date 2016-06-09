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
class Faonni_Share_Block_Button
	extends Mage_Core_Block_Template
{
    /**
     * Collection model
	 *
     * @var Faonni_Share_Model_Resource_Provider_Collection
     */
    protected $_collection;
	
	/**
	 * Check unite counts
	 *
	 * @return bool
	 */		
	public function isSummaryCount()
	{
		return Mage::helper('faonni_share')->isSummaryCount();
	}	
	
    /**
     * Get provider collection
	 *
     * @return Faonni_Share_Model_Resource_Collection
     */
    public function getCollection()
    {
        if (null === $this->_collection){
			$this->_collection = Mage::getResourceModel('faonni_share/provider_collection');
			$summary = Mage::registry('share_summary');
			
			foreach($this->_collection as $provider){
				$id = $provider->getId();
				if (isset($summary[$id])) $provider->setCount($summary[$id]);
			}
			//print_r($summary);
		}
		return $this->_collection;
    }
	
    /**
     * Get Share object 
	 *
     * @return object
     */	
	public function getShareObject()
	{
		$object = Mage::registry('faonni_share');
		if(!$object){
			Mage::throwException($this->__('Empty share object.'));
		}
		return $object;
	}	
	
	/**
	 * Return Js Config active providers
	 *
	 * @return array
	 */		
	public function getJsConfig()
	{
		foreach($this->_collection as $provider){
			$provider->setUrl($provider->getShareUrl());
		}
		$config = $this->getCollection()->toArray(array('id', 'url', 'width', 'height'));
		$config['url'] = Mage::getUrl('share/summary/update');
		
		return json_encode($config);
	}
	
    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::helper('faonni_share')->isEnabled()) {
            return '';
        }
        return parent::_toHtml();
    }	
}