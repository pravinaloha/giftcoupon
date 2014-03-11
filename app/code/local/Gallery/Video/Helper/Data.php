<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Function to get video url
	 * @param null
	 * @return String Video URL
	 *
	 **/
	public function getvideoUrl()
	{
		return $this->_getUrl("video");
	}
	
	/**
	 * Function to get Image URL
	 * @param null
	 * @return String Image URL
	 *
	 **/
	public function getImageUrl(){
		return Mage::getBaseUrl('media').'videoImages';
	}
	
}
