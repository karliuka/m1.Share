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
class Faonni_Share_Model_Observer
{
    /**
     * Set share object
	 *
     * @param Varien_Event_Observer $observer
     * @return Faonni_Share_Model_Observer
     */
    public function setShareObject($observer)
    {
		$product = $observer->getEvent()->getProduct();
		$helper = Mage::helper('faonni_share');
		
		if($product && $helper->isEnabled()){

			if(false !== ($size = $helper->getSize())){
				$image = Mage::helper('catalog/image')->init($product, 'image')
					->resize($size['width'], $size['heigth']);
			} else $image = Mage::helper('catalog/image')->init($product, 'image');

			$object = new Varien_Object(array(
				'id'          => $product->getId(),
				'title'       => $product->getName(),
				'url'         => $product->getUrlModel()->getUrl($product, array('_ignore_category' => true)),
				'image'       => $image,
				'description' => $product->getShortDescription(),
				'type'        => 'product'
			));
			
			Mage::register('faonni_share', $object);
		}
        return $this;
    }
	
    /**
     * Set Summary Collection
	 *
     * @param Varien_Event_Observer $observer
     * @return Faonni_Share_Model_Observer
     */
    public function setSummaryCollection($observer)
    {
		if(!Mage::helper('faonni_share')->isEnabled()){
			return $this;
		}
		
		$product = $observer->getEvent()->getProduct();
		if($product){
			$store = Mage::app()->getStore();
			$unite = Mage::helper('faonni_share')->isUniteCount();
			
			$collection = Mage::getResourceModel('faonni_share/summary_collection')
				->addEntityTypeIdFilter($product->getResource()->getTypeId())
				->addEntityIdFilter($product->getId());

			if($unite){
				$collection
					->addExpressionFieldToSelect('unite', 'SUM({{main_table.count}})', 'main_table.count')
					->getSelect()->group('main_table.provider_id');
			} else {
				$collection->addStoreIdFilter($store->getId());
			}

			$summary = array();
			foreach($collection as $share){
				$count = $unite ? $share->getUnite() : $share->getCount();
				$summary[$share->getProviderId()] = $count;
			}
			Mage::register('share_summary', $summary);
			//print_r(Mage::app()->getStore()->getConfig('faonni_share'));
		}
        return $this;
    }
	
    /**
     * get Entity Type
	 *
     * @param Varien_Event_Observer $observer
     * @return Faonni_Share_Model_Observer
     */
    public function getEntityType($observer)
    {
		if(!Mage::helper('faonni_share')->isEnabled()){
			return $this;
		}
		
		$object = $observer->getEvent()->getShareObject();
		if($object && 'product' == $object->getType() && $object->getId()){
			$product = Mage::getModel('catalog/product')->load($object->getId());
			$object->setEntityTypeId(
				$product->getResource()->getTypeId()
			);
			$object->setUrl(
				$product->getUrlModel()->getUrl($product, array('_ignore_category' => true))
			);
		}
        return $this;
    }	
}