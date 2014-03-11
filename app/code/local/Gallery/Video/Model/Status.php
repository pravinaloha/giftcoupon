<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    /**
	 * Function to get Option array for status
	 * @param null
	 * @return array()
	 *
	 **/
    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('video')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('video')->__('Disabled')
        );
    }
}
