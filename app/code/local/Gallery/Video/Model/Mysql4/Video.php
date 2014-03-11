<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Model_Mysql4_video extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Default Constructor
	 * @param null
	 * @return unknown
	 *
	 **/
    public function _construct()
    {    
        // Note that the video_id refers to the key field in your database table.
        $this->_init('video/video', 'video_id');
    }
}
