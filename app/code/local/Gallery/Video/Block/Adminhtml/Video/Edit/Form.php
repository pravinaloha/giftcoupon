<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_Adminhtml_video_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  /**
   * Prapared Admin Edit video form
   *
   * @param null
   * @return unknown
   *
   **/
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                        'id' => 'edit_form',
                        'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                        'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                       )
                    );

      $form->setUseContainer(true);
      $this->setForm($form);
      return parent::_prepareForm();
  }

}
