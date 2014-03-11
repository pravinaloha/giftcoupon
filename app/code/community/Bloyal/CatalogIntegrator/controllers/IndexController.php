<?php

/**
 * bLoyal
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade bLoyal to newer
 * versions in the future. If you wish to customize bLoyal for your
 * needs please refer to http://www.bloyal.com for more information.
 *
 * @category    Bloyal
 * @package     Bloyal_Master
 * @copyright   Copyright (c) 2014 bLoyal Inc. (http://www.bloyal.com)
 * @license     http://www.bloyal.com
 */

/**
 * Captcha block
 *
 * @category   Community
 * @package    Bloyal_CatalogIntegrator
 * @author     Bloyal Team
 */
class Bloyal_CatalogIntegrator_IndexController extends Mage_Core_Controller_Front_Action {

    /**
     * To get catalog model instance
     * @var type 
     */
    private $_model;

    /**
     * Index action 
     *
     * @param null
     * @return unknown
     */
    public function indexAction() {
        
        $this->_model = Mage::getSingleton('bloyalCatalog/cron');
        Mage::log('In Controller Catalog:'. $_REQUEST['catalog']);
        $this->_model->syncProductsByCatalog($_REQUEST['catalog']);
        echo 111; die;
    }

}