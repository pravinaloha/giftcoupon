<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Model_Mysql4_video_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	/**
	 * Default Constructor
	 * @param null
	 * @return unknown
	 *
	 **/
    public function _construct()
    {
        parent::_construct();
        $this->_init('video/video');
    }
}
