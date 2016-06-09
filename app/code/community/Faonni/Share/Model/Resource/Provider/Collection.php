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
class Faonni_Share_Model_Resource_Provider_Collection 
	extends Varien_Data_Collection
{
    /**
     * Social share setting path
	 *
     * @var string
     */
	const XML_PROVIDER_DATA = 'faonni_share';
	
    /**
     * Load data
	 *
     * @param bool $printQuery
     * @param bool $logQuery
     * @return Faonni_Share_Model_Resource_Provider_Collection
     */
    public function load($printQuery=false, $logQuery=false)
    {
        if(empty($this->_items)){
			$items = Mage::getStoreConfig(self::XML_PROVIDER_DATA);
            foreach ($items as $group => $item){ 
				if('common' == $group) continue;
				$provider = Mage::getModel('faonni_share/provider', $item);
				if($provider->isAvailable()) $this->addItem($provider);
            }
        }
		usort($this->_items, array($this, 'uSort'));		
        return $this;
    }
	
	/**
	 * usort array
	 *
	 * @param string $a
	 * @param string $b 
	 * @return int
	 */		
	public function uSort($a, $b)
    {
		if (!isset( $a['sort']) || !isset( $b['sort'])) return 0;
		if ($a['sort'] == $b['sort']) return 0;
		return ($a['sort'] < $b['sort']) ? -1 : 1;
    }
	
    /**
     * Convert items array to array for select options
	 *
     * @param string $valueField
     * @param string $labelField
     * @return array
     */
    protected function _toOptionArray($valueField='id', $labelField='title', $additional=array())
    {
        $res = array();
        $additional['value'] = $valueField;
        $additional['label'] = $labelField;

        foreach ($this as $item) {
            foreach ($additional as $code => $field) {
                $data[$code] = $item->getData($field);
            }
            $res[] = $data;
        }
        return $res;
    }	
}
