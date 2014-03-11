<?php
/**
 * Video Gallery 
 *
 * @category   Gallery
 * @package    Gallery_Video
 */
class Gallery_Video_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
     * Index Action
     * @param null
     * @return unknown
     *
     **/
    public function indexAction()
    {
        echo 111; die;
		$this->loadLayout();     
		$this->renderLayout();
    }
}
