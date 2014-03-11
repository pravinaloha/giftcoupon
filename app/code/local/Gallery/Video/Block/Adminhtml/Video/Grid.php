<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_Block_Adminhtml_video_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
      $this->setId('videoGrid');
      $this->setDefaultSort('video_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  /**
   * Prpared collection
   * @param null
   * @return unknown
   *
   **/
  protected function _prepareCollection()
  {
      $collection = Mage::getModel('video/video')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  /**
   * Add columns to Grid
   * @param null
   * @return unknown
   *
   **/
  protected function _prepareColumns()
  {

      $this->addColumn('video_id', array(
          'header'    => Mage::helper('video')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'video_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('video')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
	  
      $this->addColumn('small_image', array(
          'header'    => Mage::helper('video')->__('Small Image'),
          'align'     =>'left',
          'type'	    => 'image',
          'renderer'  => 'video/adminhtml_widget_grid_column_renderer_smallimage',
          'index'     => 'small_image',
      ));	  
	   
	  
	  $this->addColumn('url', array(
          'header'    => Mage::helper('video')->__('URL'),
          'align'     =>'left',
          'type'	    => 'text',
          'index'     => 'url',
      ));	  	  
	  
	  $this->addColumn('position', array(
          'header'    => Mage::helper('video')->__('Video Type'),
          'align'     =>'left',
          'type'	    => 'text',
          'width'     => '50px',		  
          'index'     => 'position',
      ));	  	  

    $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('video')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('video')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
    ));
			
		$this->addExportType('*/*/exportCsv', Mage::helper('video')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('video')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  /**
   * Mass action for delete or status change
   * @param null
   * @return unknown
   *
   **/
  protected function _prepareMassaction()
  {
      $this->setMassactionIdField('video_id');
      $this->getMassactionBlock()->setFormFieldName('video');

      $this->getMassactionBlock()->addItem('delete', array(
           'label'    => Mage::helper('video')->__('Delete'),
           'url'      => $this->getUrl('*/*/massDelete'),
           'confirm'  => Mage::helper('video')->__('Are you sure?')
      ));

      $statuses = Mage::getSingleton('video/status')->getOptionArray();

      array_unshift($statuses, array('label'=>'', 'value'=>''));
      $this->getMassactionBlock()->addItem('status', array(
          'label'       => Mage::helper('video')->__('Change status'),
          'url'         => $this->getUrl('*/*/massStatus', array('_current'=>true)),
          'additional'  => array(
              'visibility'  => array(
                  'name'    => 'status',
                  'type'    => 'select',
                  'class'   => 'required-entry',
                  'label'   => Mage::helper('video')->__('Status'),
                  'values'  => $statuses
                   )
                 )
          ));
      return $this;
  }

  /**
   * Function to get Row URL
   * @param Object $row
   * @return Integer roe_id
   *
   **/
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
