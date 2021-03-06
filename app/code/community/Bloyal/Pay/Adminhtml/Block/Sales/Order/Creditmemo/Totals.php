<?php

class Bloyal_Pay_Adminhtml_Block_Sales_Order_Creditmemo_Totals extends Mage_Sales_Model_Order_Total_Abstract {

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals() {
        parent::_initTotals();
        $order = $this->getOrder();
        $amount = number_format((-$order->getGiftCardValue()), 2);
        if ($amount) {
            $this->addTotalBefore(new Varien_Object(array(
                'code' => 'bloyalgiftcard',
                'value' => $amount,
                'base_value' => $amount,
                'label' => $this->helper('pay')->__('Bloyal Gift Card Purchase'),
                    ), array('shipping', 'tax')));
        }

        return $this;
    }

}