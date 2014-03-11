<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_Adminhtml_Widget_Grid_Column_Renderer_Smallimage extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	/**
	 * Render small Image
	 * @param Varien_Object $row
	 * @return unknown
	 *
	 **/
    public function render(Varien_Object $row)
    {
    	if (empty($row['small_image'])) echo '';
    	echo '<img src="'. Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).$row['small_image']. '"/>';
    }
}
