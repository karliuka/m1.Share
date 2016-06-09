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
class Faonni_Share_SummaryController 
	extends Mage_Core_Controller_Front_Action
{
    /**
     * update action
     */
    public function updateAction()
    {
		$result = array('error' => true);
		
		$id = $this->getRequest()->getPost('id', false);
		$type = $this->getRequest()->getPost('type', false);
		$entityId = (int)$this->getRequest()->getPost('entity', false);
		
		if($id && $type && $entityId){
			
			$shareObject = new Varien_Object(array('id' => $entityId, 'type' => $type));
			Mage::dispatchEvent('faonni_share_summary_update_before', array('share_object' => $shareObject));
			
			if($shareObject->getEntityTypeId()){
				$provider = Mage::getModel('faonni_share/provider')->load($id);
				if($provider && $provider->isAvailable()){
					$count = (int)$provider->loadCount($shareObject->getUrl());
					
					$data = array(
						'entity_type_id'  => $shareObject->getEntityTypeId(),
						'store_id'        => Mage::app()->getStore()->getId(),
						'share_entity_id' => $entityId,
						'provider_id'     => $provider->getId()
					);
					
					$summary = Mage::getModel('faonni_share/summary')->loadByFields($data);
					if(!$summary->getId()){
						$summary = Mage::getModel('faonni_share/summary');
						$summary->addData($data);
					}
					
					$summary->setCount($count);
					$summary->save();
					
					if(Mage::helper('faonni_share')->isSummaryCount()){
						$id = 'summary';
						$count = (int)$summary->getSummaryCount($shareObject->getEntityTypeId(), $entityId);
					}elseif(Mage::helper('faonni_share')->isUniteCount()){
						$count = (int)$summary->getUniteCount($shareObject->getEntityTypeId(), $entityId, $id);
					}
					
					$result = array('error' => false, 'count' => $count, 'id' => $id);
				}
			}
		}
		$this->getResponse()->setBody(json_encode($result));
    }	
}