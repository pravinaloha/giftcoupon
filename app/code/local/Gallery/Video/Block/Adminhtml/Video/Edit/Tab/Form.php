<?php

/**
 * Video Gallery Admin Block
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_Adminhtml_video_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prapared Admin add video form
     *
     * @param null
     * @return unknown
     *
     **/

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $this->setForm($form);

        $fieldset = $form->addFieldset('video_form', array('legend'=>Mage::helper('video')->__('Item information')));
       
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('video')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $fieldset->addField('shortdescription', 'textarea', array(
            'label'     => Mage::helper('video')->__('Short Description'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'shortdescription',
        ));

        $fieldset->addField('small_image', 'image', array(
            'label'     => Mage::helper('video')->__('Video Image'),
            'class'     => 'input-text required-entry required-file',
            'required'  => true,
            'name'      => 'small_image',
            'note'	    => 'Image Dimension: 232 * 218',
  	     ));

        $fieldset->addField('position', 'select', array(
            'label'     => Mage::helper('video')->__('Video Type'),
            'required'  => false,
            'name'      => 'position',
            'values'    => array(
                    array(
                        'value'     => 'youtube',
                        'label'     => Mage::helper('video')->__('YouTube Video'),
                    ),

                    array(
                        'value'     => 'aol',
                        'label'     => Mage::helper('video')->__('AOL Video'),
                    ),

                    array(
                        'value'     => 'vimeo',
                        'label'     => Mage::helper('video')->__('Vimeo Video'),
                    ),
              ),
          ));   

          $fieldset->addField('url', 'text', array(
                'label'     => Mage::helper('video')->__('Url'),
                'required'  => true,
                'name'      => 'url',
                'note'	    => 'example: http://www.example.com/',
      	  ));   
       	  	  

          if (!Mage::app()->isSingleStoreMode()) {
             $fieldset->addField('store_view', 'multiselect', array(
          		   'name'      => 'stores[]',
          		   'label'     => Mage::helper('video')->__('Store View'),
          		   'title'     => Mage::helper('video')->__('Store View'),
          		   'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
           ));
          }	else {
      		   $fieldset->addField('store_view', 'hidden', array(
      				   'name'      => 'stores[]',
      				   'value'     => Mage::app()->getStore(true)->getId()
      		   ));
        
          }
            
          if ( Mage::getSingleton('adminhtml/session')->getvideoData() )
          {
              $form->setValues(Mage::getSingleton('adminhtml/session')->getvideoData());
              Mage::getSingleton('adminhtml/session')->setvideoData(null);
          } elseif ( Mage::registry('video_data') ) {
              $form->setValues(Mage::registry('video_data')->getData());
          }
        
            return parent::_prepareForm();
      }
  }


?>
