<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_Adminhtml_video_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  /**
   * default constructor
   * @param null
   * @return unknown
   *
   **/
  public function __construct()
  {
      parent::__construct();
      $this->setId('video_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('video')->__('Item Information'));
  }

  /**
   * Add Heading in video gallry layout
   * @param null
   * @return unknown
   *
   **/
  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('video')->__('Item Information'),
          'title'     => Mage::helper('video')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('video/adminhtml_video_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}
