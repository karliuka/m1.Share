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
class Faonni_Share_Model_Resource_Pinterest
	extends Faonni_Share_Model_Resource_Abstract
{
    /**
     * The token URL
	 *
     * @var string
     */
	protected $_shareUrl = 'http://pinterest.com/pin/create/link/';
	
    /**
     * The count URL
	 *
     * @var string
     */
	protected $_countUrl = 'http://api.pinterest.com/v1/urls/count.json?callback=count&url=';
	
    /**
     * The URL used when authenticating a user after the question mark ?
	 *
     * @var array
     */	
	protected $_shareQuery = array(
	
    /**
     * The URL of the page to share. This value should be url encoded
	 *
     * @var string
     */	
	'url' => '',
	
    /**
     * The image of the page to share. This value should be url encoded
	 *
     * @var string
     */	
	'media' => '',	
	
    /**
     * The description of the page to share. This value should be url encoded
	 *
     * @var string
     */	
	'description' => '',		
	);

    /**
     * Get Full Share URL
	 *
     * @return string
     */	
	public function getShareUrl()
	{	
		$this->_shareQuery = array_merge(
			$this->_shareQuery, array(
				'url' => $this->getShareObject()->getUrl(),
				'media' => htmlspecialchars($this->getShareObject()->getImage()),
				'description' => $this->getShareObject()->getTitle()
			)
		);
		return $this->_shareUrl . '?' . http_build_query($this->_shareQuery);
	}
	
    /**
     * Get count
	 *
     * @return int
     */	
	public function loadCount($url)
	{	
		$response = $this->request($this->_countUrl . urlencode($url));
		if ($response->isSuccessful()){
			$data = preg_replace('#^count\((.*)\)$#si', '\\1', $response->getBody());
			$json = json_decode($data, true);
			if(isset($json['count'])) return intval($json['count']);
		}
		return null;	
	}
}