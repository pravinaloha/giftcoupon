<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_Adminhtml_video extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Default Constructor
	 * @param null
	 * @return unknown
	 *
	 **/
	public function __construct()
	{
		$this->_controller = 'adminhtml_video';
		$this->_blockGroup = 'video';
		$this->_headerText = Mage::helper('video')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('video')->__('Add Item');
		parent::__construct();
	}
}
