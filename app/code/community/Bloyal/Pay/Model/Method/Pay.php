<?php

class Bloyal_Pay_Model_Method_Pay extends Mage_Payment_Model_Method_Abstract {

    const PAYMENT_METHOD_BLOYALGIFTCARD_CODE = 'bloyalgiftcard';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_BLOYALGIFTCARD_CODE;
    protected $_formBlockType = 'pay/form_pay';
    protected $_infoBlockType = 'pay/info_pay';
    protected $_discountAmount;
    private $_masterModel;

    /**
     * To initilize sales transaction elements.
     * @return boolean
     */
    protected function init() {

       $this->_masterModel = Mage::getModel('bloyalMaster/abstract');
        $options = array();

        try {
            
            echo '<pre>';

            $salesTransactionInfoToBloyal = array(
                'CouponCodes' => array('COLLEGE10'),
                'Customer' => $this->_masterModel->getCustomer(),
                'Lines' => $this->_masterModel->getLines(),
                'Payments' => $this->_masterModel->getPayments(),
                'Shipments' => $this->_masterModel->getShipments(),
                'Channel' => 'WebStore');

            $params = array(
                'credential' => $this->_masterModel->getCredentials(),
                'transaction' => $salesTransactionInfoToBloyal,
                'options' => $options);

            print_r($params);


            $arrResult = $this->_masterModel->getApi()->CalculateSalesTransaction($params);
            echo '<br>' . $this->_masterModel->getApi()->__getLastRequest();
            echo '<br>' . $this->_masterModel->getApi()->__getLastResponse();

            print_r($arrResult);
        } catch (SoapFault $fault) {
            ///echo 'Request : <br/><xmp>', $this->_masterModel->getApi()->__getLastRequest(),'</xmp><br/><br/> Error Message : <br/>',
            $fault->getMessage();
        }

        die;

        return true;
    }

    private function _getCustomer() {
        try {

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

    private function _getLines() {

        try {

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

            $this->_taxDetails = array('TaxDetail'=>array(
                'Amount' => $floatTax?$floatTax:0,
                'Code' => $objCustomer->getRegionCode(),
                'Rate' => $floatRate?$floatRate:0,
            ));

            $arrLineInfo['TaxDetails'] = $this->_taxDetails;

            return array('TransactionLine'=> $arrLineInfo);
        } catch (Exception $e) {
            Mage::log($e->getMessage());
            return array();
        }

//        print_r($arrLineInfo);
//        die;
    }

    private function _getPayments() {
        try {
            $paymentInfo = array(
                'Amount' => $this->_checkoutCart->getGrandTotal(),
                'TenderCode' => 'GIFTCARD',
            );
        } catch (Exception $e) {
            Mage::log($e->getMessage());
            return array();
        }

        return array('TransactionPayment'=>$paymentInfo);
    }

    private function _getShipments() {

        try {

            $strShpippingMethod = $this->_checkoutSession->getShippingAddress()->getShippingDescription();
            $agentInfo = $this->_orderModel->getShippingAgentInfo($strShpippingMethod);

            $shippingMethod = $this->_checkoutSession->getShippingAddress();
            $floatShippingCharge = $shippingMethod['shipping_amount'];

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

        return array('TransactionShipment'=>$shipmentInfo);
    }

    /**
     * Function to assign data to gifcard.
     * @param type $data
     * @return \Bloyal_Pay_Model_Method_Pay
     */
    public function assignData($data) {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
        $info = $this->getInfoInstance();
        $info->setGiftCardNo($data->getGiftCardNo());
        return $this;
    }

    public function assignGiftCardValueToQuote($gcNumber) {
        $errorMsg = 'Success!!';

        if (!$this->init())
            return $this;

        $giftCard[0]['gift_card_balance'] = $this->_discountAmount;

        if (empty($giftCard[0])) {
            //$errorCode = 'invalid_data';
            $errorMsg = $this->_getHelper()->__('Gift Card Number does not exist: ' . $gcNumber);
        } else {
            $info = $this->getInfoInstance();
            $info->setGiftCardValue(number_format(($giftCard[0]['gift_card_balance']), 2));
            $info->setGiftCardNo($gcNumber);
            $quote = $info->getQuote();
            if ($quote) {
                $info->getQuote()->setGiftCardValue(number_format(($giftCard[0]['gift_card_balance']), 2));
                $info->getQuote()->setGiftCardNo($gcNumber);
                $info->getQuote()->save();
            }
        }

        if ($errorMsg != 'Success!!') {
            Mage::throwException($errorMsg);
        }
        return $this;
    }

    public function assignGiftCardValueToOrder($gcNumber) {

        if (!$this->init())
            return $this;

        $errorMsg = 'Success!!';

        try {
            $dbRead = Mage::getSingleton('core/resource')->getConnection('core_read');
            $gcSQL = "SELECT gift_card_number,gift_card_balance FROM " . Mage::getConfig()->getTablePrefix() . "bloyal_gift_cards WHERE gift_card_number = '" . $gcNumber . "'";
            $qryResult = $dbRead->query($gcSQL);
            $giftCard = $qryResult->fetchAll();
        } catch (Exception $e) {
            Mage::throwException($e->getMessage());
            exit;
        }

        $giftCard[0]['gift_card_balance'] = $this->_discountAmount;
        if (empty($giftCard[0])) {
            //$errorCode = 'invalid_data';
            $errorMsg = $this->_getHelper()->__('Gift Card1 Number does not exist: ' . $gcNumber);
        } else {
            $order = Mage::getSingleton('sales/order');
            $order->save();
        }

        if ($errorMsg != 'Success!!') {
            Mage::throwException($errorMsg);
        }
        return $this;
    }

    public function validate() {
        parent::validate();
        $errorMsg = 'Success!!';
        $info = $this->getInfoInstance();
        $quote = $info->getQuote();
        $no = $info->getGiftCardNo();
        if (empty($quote)) {
            $quoteAfter = Mage::getSingleton('checkout/session')->getQuote()->getPayment();
            $no = $quoteAfter->getGiftCardNo();
            $this->assignGiftCardValueToOrder($no);
            $gcValue = $quoteAfter->getGiftCardValue();
            $value = Mage::getSingleton('checkout/session')->getQuote()->getGrandTotal();
        } else if ($quote) {
            $this->assignGiftCardValueToQuote($no);
            $gcValue = $quote->getGiftCardValue();
            $value = $quote->getGrandTotal();
        }
        if (empty($no) || empty($gcValue)) {
            $errorCode = 'invalid_data';
            $errorMsg = $this->_getHelper()->__('Gift Card2 Number is a required field');
        } else {
            if ($gcValue < $value) {
                $errorCode = 'invalid_data';
                $errorMsg = $this->_getHelper()->__('Gift Card funds: ' . $gcValue . ' have been applied, You will need an additional mode of payment to cover for the remaining cost.');
            } else if ($gcValue > $value) {
                $successMsg = $this->_getHelper()->__('Gift Card funds: ' . $gcValue . ' have been applied to the total, Your new gift card balance will be ' . ($gcValue - $value));
            }
        }

        if ($errorMsg != 'Success!!') {
            Mage::log($errorMsg);
            Mage::getSingleton('core/session')->addSuccess($errorMsg);
            Header('Location: ' . $_SERVER['/checkout/onepage/']);
            Exit();
        } else if ($successMsg) {
            if ($value > 0) {
                Mage::log($successMsg);
                Mage::getSingleton('core/session')->addSuccess($successMsg);
            }

            $strBloyalGift = Mage::getSingleton('core/session')->getBloyalGiftCard();
            if ($strBloyalGift && $strBloyalGift === $no)
                return $this;
            else {
                Mage::getSingleton('core/session')->setBloyalGiftCard($no);
                Header('Location: ' . $_SERVER['/checkout/onepage/']);
                Exit();
            }
        }
    }

}
?>
