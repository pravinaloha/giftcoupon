<?php

/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_DisplayController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index Action
     * @param null
     * @return unknown
     *
     **/
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }

    /**
     * Show Action
     * @param null
     * @return unknown
     *
     **/
    public function showAction()
    {
	    $video_id = $this->getRequest()->getParam('id');

  		if($video_id != null && $video_id != '')	{
			$video = Mage::getModel('video/video')->load($video_id)->getData();
		} else {
			$video = null;
		}	
		echo json_encode(array(
            'name'              => $video['title'],     
            'description'       => $video['shortdescription'], 
            'image'  			=> $video['small_image'],        
            'url'  				=> $video['url'],        
            'position'  		=> $video['position']      
        ));
    }
}
