<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_video extends Mage_Core_Block_Template
{
	/**
	 * Render Layout
	 * @param null
	 * @return unknown
	 *
	 **/
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    /**
	 * Function to get video
	 * @param null
	 * @return unknown
	 *
	 **/
    public function getvideo()     
    { 
        return Mage::getModel('video/video')->getCollection()
				->addFieldToFilter('status',1)
				->setOrder('position','DESC')
				->load();
    }

    /**
	 * Function to get most recent videos
	 * @param null
	 * @return unknown
	 *
	 **/
	public function getMostRecentvideo()
	{
		$videoCollection = Mage::getModel('video/video')
						->getCollection()
						->addFieldToFilter('status',1)
						->setOrder('position',"DESC")
						->setPageSize(5)
						->load();
		return $videoCollection;
	}
}
