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
class Faonni_Share_Helper_Data 
	extends Mage_Core_Helper_Abstract
{
    /**
     * Social share active setting path
	 *
     * @var string
     */
	const XML_SHARE_ACTIVE = 'faonni_share/common/active';
	
    /**
     * Social share image size setting path
	 *
     * @var string
     */
	const XML_SHARE_IMAGE_SIZE = 'faonni_share/common/size';
	
    /**
     * Social share unite count setting path
	 *
     * @var string
     */
	const XML_SHARE_UNITE = 'faonni_share/common/unite';
	
    /**
     * Social share summary count setting path
	 *
     * @var string
     */
	const XML_SHARE_SUMMARY = 'faonni_share/common/summary';
	
	/**
	 * Check whether Share can be used
	 *
	 * @return bool
	 */	
 	public function isEnabled()
	{
		return (bool)Mage::getStoreConfig(self::XML_SHARE_ACTIVE);
	}
	
	/**
	 * Check unite counts
	 *
	 * @return bool
	 */	
 	public function isUniteCount()
	{
		return (bool)Mage::getStoreConfig(self::XML_SHARE_UNITE);
	}
	
	/**
	 * Check unite counts
	 *
	 * @return bool
	 */		
	public function isSummaryCount()
	{
		return (bool)Mage::getStoreConfig(self::XML_SHARE_SUMMARY);
	}
	
    /**
     * Retrieve image size
	 *
     * @return array|bool
     */
    public function getSize()
    {
        $size = explode('x', strtolower(Mage::getStoreConfig(self::XML_SHARE_IMAGE_SIZE)));
		
        if(sizeof($size) == 2){
            return array(
                'width'  => ($size[0] > 0) ? $size[0] : null,
                'heigth' => ($size[1] > 0) ? $size[1] : null,
            );
        }
        return false;
    }	
}