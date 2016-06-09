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
abstract class Faonni_Share_Model_Resource_Abstract
	extends Varien_Object
{
    /**
     * The share URL
	 *
     * @var string
     */
	protected $_shareUrl;

	/**
     * The count URL
	 *
     * @var string
     */
	protected $_countUrl;
	
    /**
     * Get Share Provider URL
	 *
     * @return string
     */	
	abstract public function getShareUrl();
	
    /**
     * Get Share object
	 *
     * @return object
     */	
	public function getShareObject()
	{
		$object = Mage::registry('faonni_share');
		if(!$object){
			Mage::throwException(Mage::helper('faonni_share')->__('Empty share object.'));
		}
		return $object;
	}
	
    /**
     * request
	 *
     * @return object
     */	
	public function request($url)
	{
		$client = new Zend_Http_Client($url, array(  
			'adapter'     => 'Zend_Http_Client_Adapter_Curl',  
			'curloptions' => array(CURLOPT_SSL_VERIFYPEER => false),  
		));
		return $client->request(Zend_Http_Client::GET);
	}		
}