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
 * @package    Bloyal_Master
 * @author     Bloyal Team
 */
class Bloyal_Master_Model_Abstract extends Mage_Core_Model_Abstract {

    /**
     * Api resource
     *
     * @var String
     */
    protected $_api = '';

    /**
     * Mage Api resource
     * 
     * @var string
     */
    protected $_mageApi = '';

    /**
     * credentials
     *
     * @var string
     */
    protected $_credentials = '';

    /**
     * Session ID
     *
     * @var string
     */
    protected $_sessionId = '';

    /**
     * Default socket timeout
     *
     * @var string
     */
    protected $_defaultSocketTimeout = '';

    /**
     * Default mysql timeout
     *
     * @var string
     */
    protected $_defaultMysqlTimeout = '';

    /**
     * Product details data
     *
     * @var array
     */
    protected $_productData = '';

    /**
     * Get default ini safe mode.
     *
     * @var String
     */
    private $_iniSafeMode;
    private $_checkoutCart;
    private $_checkoutSession;
    private $_orderModel;
    private $_taxDetails;

    /**
     * To initilize sales transaction elements.
     * @return boolean
     */
    private function init() {
        $this->_checkoutCart = Mage::getModel('checkout/cart')->getQuote();
        $this->_checkoutSession = Mage::getSingleton('checkout/session')->getQuote();
        $this->_orderModel = Mage::getModel('bloyalOrder/order');

        return true;
    }

    /**
     * Function to unset Mage Api 
     *
     * @param none
     * @return unknown
     */
    protected function unsetMageApi() {

        if ($this->_defaultSocketTimeout)
            ini_set('default_socket_timeout', $this->_defaultSocketTimeout);
        if ($this->_defaultMysqlTimeout)
            ini_set('mysql.connect_timeout', $this->_defaultMysqlTimeout);
        if ($this->_mageApi)
            unset($this->_mageApi, $this->_sessionId, $this->_defaultSocketTimeout, $this->_defaultMysqlTimeout);

        return $this;
    }

    /**
     * Function to get mage Client
     *
     * @param none
     * @return unknown
     */
    public function getMageClient() {

        if (empty($this->_sessionId)) {
            // First unset mage pai
            $this->unsetMageApi();

            //Set default socket timeout
            $this->_defaultSocketTimeout = ini_get('default_socket_timeout');
            ini_set('default_socket_timeout', 300);

            // Set default mysql timeout
            $this->_defaultMysqlTimeout = ini_get('mysql.connect_timeout');
            ini_set('mysql.connect_timeout', 300);

            try {

                $helper = Mage::helper('bloyalMaster');
                $_helper = Mage::helper('bloyalCatalog');
                $magentoUser = $helper->getBloyalConfig('general/magento_admin');
                $magentoPass = $helper->getBloyalConfig('general/magento_pass');
                if (trim($magentoUser) == '' || trim($magentoPass) == '') {
                    // Send notification for No Store Found
                    $_helper->sendNotification('Create magento user and password for SOAP Service as intruction give in installation guide and completed bloyal setting .', '');

                    // Write into log file for that
                    $_helper->log('Create magento user and password for SOAP Service as intruction give in installation guide and completed bloyal setting .', Bloyal_CatalogIntegrator_Model_Catalog::EXCEPTION_FILE);
                    $_helper->log('Create magento user and password for SOAP Service as intruction give in installation guide and completed bloyal setting .', Bloyal_CatalogIntegrator_Model_Catalog::REGULAR_FILE);

                    return false;
                }
                $option = array('trace' => 1);

                try {
                    $this->_mageApi = new SoapClient(Mage::getUrl() . 'api/soap?wsdl', $option);
                    $this->setSessionId($this->_mageApi->login($magentoUser, $magentoPass));
                } catch (SoapFault $fault) {
                    // <xmp> tag displays xml output in html
                    echo 'Request : <br/><xmp>',
                    $this->_mageApi->__getLastRequest(),
                    '</xmp><br/><br/> Error Message : <br/>',
                    $fault->getMessage();
                }
            } catch (Exception $e) {
                $this->unsetMageApi();
                return false;
            }
        } else {

            return $this->_mageApi;
        }

        return $this->_mageApi;
    }

    /**
     * Get Session ID
     *
     * @param none
     * @return string
     */
    public function getSessionId() {

        return $this->_sessionId;
    }

    /**
     * Set session ID
     *
     * @param String $id
     * @return object
     */
    public function setSessionId($id) {

        $this->_sessionId = $id;
        return $this;
    }

    /**
     * Send curl request
     *
     * @param string $action
     * @return String
     */
    protected function sendCurlRequest($action = '') {
        $helper = Mage::helper('bloyalMaster');

        try {

            // This is for api url redirection.
            $this->_iniSafeMode = ini_get('safe_mode');
            ini_set('safe_mode', false);

            $strBaseApiUrl = $helper->apiUrl;
            $strApiDemo = $helper->getBloyalConfig('general/domain');
            $strUserName = $helper->getBloyalConfig('general/username');
            $strPassword = $helper->getBloyalConfig('general/password');

            $strContent = '';

            if ($action !== '' && $action != null) {
                $posturl = $strBaseApiUrl . $strApiDemo . '/' . $action;
                Mage::log('API Call : ' . $posturl);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $posturl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_USERPWD, "$strUserName:$strPassword");
                curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $strContent);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                $response = curl_exec($ch);

                curl_close($ch);
                ini_set('safe_mode', $this->_iniSafeMode);
                return $response;
            }
        } catch (Exception $e) {
            $helper->logException($e, Bloyal_CatalogIntegrator_Model_Catalog::EXCEPTION_FILE);
        }
        return false;
    }

    /**
     * Parse Curl response
     *
     * @param string $strAction 
     * @return Object
     */
    public function getCurlResponse($strAction) {
        $helper = Mage::helper('bloyalMaster');
        $response = $this->sendCurlRequest($strAction);
        if ($response) {
            return $helper->parseXmlToArray($response);
        } else {
            return false;
        }
    }

    /**
     * Create Soap products into magento
     *
     * @param $products array()
     * @return Integrer $productId
     */
    protected function createSoapProducts($products) {
        $_helper = Mage::helper('bloyalCatalog');
        $attributeSet = $_helper->getGeneralConfig('general/product_attributeset');

        //Create products into magento from bloyal
        $productId = $this->getMageClient()->call($this->getSessionId(), 'catalog_product.create', array('simple', $attributeSet, 'product_sku', $products));

        $this->updateSoapInventory($productId, $products);

        return $productId;
    }

    /**
     * Update Soap products into magento
     *
     * @param $productId Integer
     * @param $products array()
     * @return Boolean
     */
    protected function updateSoapProducts($productId, $products) {
        // Set arguments
        $arguments = array($productId, $products);

        // Update products into magento from bloyal
        $boolean = $this->getMageClient()->call($this->getSessionId(), 'catalog_product.update', $arguments);

        //Update stock inventory
        $this->updateSoapInventory($productId, $products);

        // return boolean for update
        return $boolean;
    }

    /**
     * Get product info from magento
     *
     * @param $strSku String
     * @return Integer 
     */
    protected function getMagentoProductsInfo($strSku) {
        // get Product info from magento 
        $result = $this->getMageClient()->call($this->getSessionId(), 'catalog_product.info', $strSku);

        if (isset($result['product_id']) && $result['product_id']) {
            return $result['product_id'];
        } else {
            return 0;
        }
    }

    /**
     * Update Soap products stock into magento
     *
     * @param $productId Integer
     * @param $products array()
     * @return 
     */
    private function updateSoapInventory($productId, $arrInventoryData) {

        $productsInventory = array(
            'qty' => $arrInventoryData['qty'],
            'is_in_stock' => ($arrInventoryData['qty'] ? 1 : 0),
            'manage_stock' => 1,
        );

        // Set arguments
        $arguments = array($productId, $productsInventory);

        // Update products stock into magento from bloyal
        $result = $this->getMageClient()->call($this->getSessionId(), 'product_stock.update', $arguments);
    }

    public function getApi() {

        if (!$this->_api) {
            $helper = Mage::helper('bloyalMaster');
            try {
                $arrOptions = array('trace' => 1);
                $this->_api = @new SoapClient($helper->getBloyalConfig('general/bloyal_api_url'), $arrOptions);
            } catch (Exception $e) {
                $helper->sendNotification('Connectivity problem', '');
                return false;
            }
        }
        return $this->_api;
    }

    public function getCredentials() {

        if (!$this->_credentials) {

            $helper = Mage::helper('bloyalMaster');
            $this->_credentials = array('Domain' => $helper->getBloyalConfig('general/domain'),
                'UserName' => $helper->getBloyalConfig('general/username'),
                'Password' => $helper->getBloyalConfig('general/password'),
                'ApplicationId' => $helper->getBloyalConfig('general/app_id'),
                'DeviceKey' => $helper->getBloyalConfig('general/device_key'));
        }

        return $this->_credentials;
    }

    public function getCustomer() {
        try {

            if (!$this->init())
                return $this;

            $checkout = Mage::getSingleton('checkout/session')->getQuote();
            $customer = $checkout->getBillingAddress();
            $address = $customer->getStreet();
            $customerInfo = array(
                'Address1' => $address[0],
                'City' => $customer->getCity(),
                'Country' => $customer->getCountry(),
                'EmailAddress' => $customer->getEmail(),
                'FirstName' => $customer->getFirstname(),
                'LastName' => $customer->getLastname(),
                'State' => $customer->getRegion(),
                'ZipCode' => $customer->getPostcode(),
            );
        } catch (Exception $e) {

            Mage::log($e->getMessage());
            return array();
        }
        return $customerInfo;
    }

    public function getLines() {

        try {

            if (!$this->init())
                return $this;

            $arrLineInfo = array();
            //Get all products from cart

            $intIndex = 0;
            $arrLineInfo['NetAmount'] = $this->_checkoutCart->getGrandTotal();
            $arrLineInfo['Quantity'] = $this->_checkoutCart->getItemsQty();

            $objProducts = $this->_checkoutSession->getAllItems();
            foreach ($objProducts as $product) {
                $arrLineInfo['Product']['LookupCode'] = $product->getSku();
                $arrLineInfo['Product']['Name'] = $product->getName();
                $arrLineInfo['Product']['Price'] = $product->getPrice();
            }

            $arrTotals = $this->_checkoutSession->getTotals();

            if (isset($arrTotals['tax'])) {
                $floatTax = round($arrTotals['tax']->getValue()); //Tax value if present
            } else {
                $floatTax = null;
            }

            $objCustomer = $this->_checkoutSession->getBillingAddress();
            $custTax = $objCustomer->getTaxClassId();

            $taxRequest = new Varien_Object();
            $taxRequest->setCountryId($objCustomer->getCountry());
            $taxRequest->setRegionId($objCustomer->getRegion());
            $taxRequest->setPostcode($objCustomer->getPostcode());
            $taxRequest->setStore(Mage::app()->getStore());
            $taxRequest->setCustomerClassId($custTax);
            $taxRequest->setProductClassId(2);  // 2=taxable id (all our products are taxable)

            $taxCalculationModel = Mage::getSingleton('tax/calculation');
            $floatRate = $taxCalculationModel->getRate($taxRequest);

            $this->_taxDetails = array('TaxDetail' => array(
                    'Amount' => $floatTax ? $floatTax : 0,
                    'Code' => $objCustomer->getRegionCode(),
                    'Rate' => $floatRate ? $floatRate : 0,
            ));

            $arrLineInfo['TaxDetails'] = $this->_taxDetails;

            return array('TransactionLine' => $arrLineInfo);
        } catch (Exception $e) {
            Mage::log($e->getMessage());
            return array();
        }

//        print_r($arrLineInfo);
//        die;
    }

    public function getPayments() {
        try {

            if (!$this->init())
                return $this;

            $paymentInfo = array(
                'Amount' => $this->_checkoutCart->getGrandTotal(),
                'TenderCode' => 'GIFTCARD',
            );
        } catch (Exception $e) {
            Mage::log($e->getMessage());
            return array();
        }

        return array('TransactionPayment' => $paymentInfo);
    }

    public function getShipments() {

        try {
            if (!$this->init())
                return $this;

            $shippingMethod = $this->_checkoutSession->getShippingAddress();
            $floatShippingCharge = $shippingMethod['shipping_amount'];

            if (Mage::getSingleton('customer/session')->isLoggedIn() == 0)
                return $shipmentInfo = array(
                    'CarrierCode' => null,
                    'Charge' => $floatShippingCharge,
                    'ServiceCode' => null,
                    'Type' => 'Ship',
                    'Recipient' => $this->getCustomer(),
                );

            $strShpippingMethod = $this->_checkoutSession->getShippingAddress()->getShippingDescription();
            $agentInfo = $this->_orderModel->getShippingAgentInfo($strShpippingMethod, true);



            $shipmentInfo = array(
                'CarrierCode' => $agentInfo['carrier_code'],
                'Charge' => $floatShippingCharge,
                'ServiceCode' => $agentInfo['service_code'],
                'Type' => 'Ship',
                'Recipient' => $this->_getCustomer(),
            );
        } catch (Exception $e) {

            Mage::log($e->getMessage());
            return array();
        }

        return array('TransactionShipment' => $shipmentInfo);
    }

}
