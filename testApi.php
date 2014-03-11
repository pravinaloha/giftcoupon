<?php

//header('Content-Type: application/xml');
error_reporting('E_ALL');

ini_set('display_errors', 1);

$client = new SoapClient("https://ws-proto.bloyal.com/3.0.1/OrderProcessing.svc?wsdl"); //soap handle

try {

//    $crediancials = array(
//        'Domain' => 'FascTest',
//        'UserName' => 'Magento',
//        'Password' => 'magento1234!',
//        'ApplicationId' => '982938b6-e700-4f53-8363-ad9e03d44026',
//        'DeviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD');
//
//
//    $customerInfo = array(
//        'Address1' => 'pune',
//        'City' => 'pune',
//        'Country' => 'india',
//        'EmailAddress' => 'test@gmail.com',
//        'FirstName' => 'test',
//        'LastName' => 'test1',
//        'State' => 'alaska',
//        'ZipCode' => '123231',
//    );
//
//
//    $lineInfo = array(
//        'NetAmount' => '15.0M',
//        'Product' => array('LookupCode' => 'EVT0038', 'Name' => '2008 Reserve Pinot Grigio', 'Price' => '15.0M'),
//        'Quantity' => '3',
//        'TaxDetails' => array('Amount' => '0.0000', 'Code' => 'AK', 'Rate' => 1.0000),
//    );
//
//
//    $paymentInfo = array(
//        'Amount' => '15.0M',
//        'TenderCode' => 'CASH',
//    );
//
//
//    $shipmentInfo = array('TransactionShipment'=>array(
//        'CarrierCode' => 'UPS',
//        'Charge' => '2.0M',
//        'ServiceCode' => 'UPG',
//        'Type' => 'Ship',
//        'TaxDetails' => array('Amount' => '2.0M', 'Code' => 'AK', 'Rate' => 1.0000),
//        'Recipient' => $customerInfo,
//    ));
//
//
//
//    $salesTransactionInfoToBloyal = array(
//        'Customer' => $customerInfo,
//        'Shipments' => $shipmentInfo,
//        'Lines' => $lineInfo,
//        'Payments' => $paymentInfo,
//        'Channel' => 'POS');
//
//    $params = array(
//        'credential' => $crediancials,
//        'transaction' => $salesTransactionInfoToBloyal,
//        'options' => array());

    $arr = array(
    'credential' => array
        (
            'Domain' => 'FascTest',
            'UserName' => 'Magento',
            'Password' => 'magento1234!',
            'ApplicationId' => '982938b6-e700-4f53-8363-ad9e03d44026',
            'DeviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD',
        ),

    'deviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD',
    'order' => array
        (
            'Title' => 'Web Store Order: 2014-03-04 15:23:39',
            'Customer' => array
                (
                    'Address1' => 'submitOrderToBloyal',
                    'Address2' => '',
                    'BirthDate' => '2014-03-04',
                    'City' => 'Test',
                    'CompanyName' => '',
                    'EmailAddress' => 'pravinm@alohatechnology.com',
                    'Country' => 'US',
                    'FaxNumber' => '',
                    'FirstName' => 'Test',
                    'FirstName2' => '',
                    'LastName' => 'User',
                    'LastName2' => '',
                    'MobilePhone' => '',
                    'NickName' => '',
                    'Phone1' => '12321321321',
                    'Phone2' => '',
                    'State' => 'AK',
                    'ZipCode' => '411111',
                    'AccountNumber' => '',
                    'ExternalReferences' => '',
                    'SignupStoreCode' => '',
                    'ExternalId' => '1',
                ),

            'Shipments' => array
                (
                    'OrderShipment' => array
                        (
                            'Recipient' => array
                                (
                                    'Address1' => 'submitOrderToBloyal',
                                    'Address2' => '',
                                    'BirthDate' => '2014-03-04',
                                    'City' => 'submitOrderToBloyal',
                                    'CompanyName' => '',
                                    'Country' => 'US',
                                    'EmailAddress' => 'pravinm@alohatechnology.com',
                                    'FaxNumber' => '',
                                    'FirstName' => 'Test',
                                    'FirstName2' => '',
                                    'LastName' => 'User',
                                    'LastName2' => '',
                                    'MobilePhone' => '',
                                    'NickName' =>'', 
                                    'Phone1' => '12321321321',
                                    'Phone2' => '',
                                    'State' => 'AK',
                                    'ZipCode' => '411111',
                                    'Instructions' => '',
                                    'Primary' => '1',
                                    'Title' => 'Web Shipping Address',
                                ),

                            'Tax' => '0.0000',
                            'TaxDetails' => array
                                (
                                    '0' => array
                                        (
                                            'Amount' => '0.0000',
                                            'Code' => 'AK',
                                            'Rate' => '1.0000',
                                        )

                                ),

                            'TotalAmount' => '140.0600',
                            'CarrierCode' => 'UPS',
                            'ServiceCode' => 'GND',
                            'Charge' => '140.0600',
                            'Type' => 'Ship',
                        )

                ),

            'Lines' => array
                (
                    '0' => array
                        (
                            'ShipmentNumber' => '18',
                            'QuantityOrdered' => '1.0000',
                            'TaxDetails' => array
                                (
                                    '0' => array
                                        (
                                            'Amount' => '0.0000',
                                            'Code' => 'AK',
                                            'Rate' => '1.0000',
                                        )

                                ),

                            'Discount' => '0.0000',
                            'Product' => array
                                (
                                    'LookupCode' => 'WF-8711-SIL',
                                    'Name' => '1 Row Choker Silver',
                                    'Price' => '7.9900',
                                    'Weight' => '123.0000',
                                )

                        )

                ),

            'ExternalId' => '100000014',
            'Comment' => 'Credit Card: xxxx-1111 amount $148.05 authorize - successful. Authorize.Net Transaction ID 0.  Transaction ID: &quot;0&quot;.',
        ),

    'options' => array
        (
            '0' => 'Validate',
            '1' => 'CreateCustomer',
        )

);
    
    
     $arr2 = array(
    'credential' => array
        (
            'Domain' => 'FascTest',
            'UserName' => 'Magento',
            'Password' => 'magento1234!',
            'ApplicationId' => '982938b6-e700-4f53-8363-ad9e03d44026',
            'DeviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD',
        ),

    'trans' => array
        (
            'Customer' => array
                (
                    'Address1' => 'submitOrderToBloyal',
                    'Address2' => '',
                    'BirthDate' => '2014-03-04',
                    'City' => 'Test',
                    'CompanyName' => '',
                    'EmailAddress' => 'pravinm@alohatechnology.com',
                    'Country' => 'US',
                    'FaxNumber' => '',
                    'FirstName' => 'Test',
                    'FirstName2' => '',
                    'LastName' => 'User',
                    'LastName2' => '',
                    'MobilePhone' => '',
                    'NickName' => '',
                    'Phone1' => '12321321321',
                    'Phone2' => '',
                    'State' => 'AK',
                    'ZipCode' => '411111',
                    'AccountNumber' => '',
                    'ExternalReferences' => '',
                    'SignupStoreCode' => '',
                    'ExternalId' => '1',
                ),

            'Shipments' => array
                (
                    'TransactionShipment' => array
                        (
                            'Recipient' => array
                                (
                                    'Address1' => 'submitOrderToBloyal',
                                    'Address2' => '',
                                    'BirthDate' => '2014-03-04',
                                    'City' => 'submitOrderToBloyal',
                                    'CompanyName' => '',
                                    'Country' => 'US',
                                    'EmailAddress' => 'pravinm@alohatechnology.com',
                                    'FaxNumber' => '',
                                    'FirstName' => 'Test',
                                    'FirstName2' => '',
                                    'LastName' => 'User',
                                    'LastName2' => '',
                                    'MobilePhone' => '',
                                    'NickName' =>'', 
                                    'Phone1' => '12321321321',
                                    'Phone2' => '',
                                    'State' => 'AK',
                                    'ZipCode' => '411111',
                                    'Instructions' => '',
                                    'Primary' => '1',
                                    'Title' => 'Web Shipping Address',
                                ),

                            'Tax' => '0.0000',
                            'TaxDetails' => array
                                (
                                    '0' => array
                                        (
                                            'Amount' => '0.0000',
                                            'Code' => 'AK',
                                            'Rate' => '1.0000',
                                        )

                                ),

                            'TotalAmount' => '140.0600',
                            'CarrierCode' => 'UPS',
                            'ServiceCode' => 'GND',
                            'Charge' => '140.0600',
                            'Type' => 'Ship',
                        )

                ),

            'Lines' => array
                (
                    '0' => array
                        (
                            'ShipmentNumber' => '18',
                            'Quantity' => '1.0000',
                            'NetAmount' => '7.9900',
                            'TaxDetails' => array
                                (
                                    '0' => array
                                        (
                                            'Amount' => '0.0000',
                                            'Code' => 'AK',
                                            'Rate' => '1.0000',
                                        )

                                ),

                            'Discount' => '0.0000',
                            'Product' => array
                                (
                                    'LookupCode' => 'WF-8711-SIL',
                                    'Name' => '1 Row Choker Silver',
                                    'Price' => '7.9900',
                                    'Weight' => '123.0000',
                                )

                        )

                ),

            'Channel' => 'POS',
        ),

    'options' => array
        (
        )

);

    $arrResult = $client->SubmitOrder($arr)->SubmitOrderResult;
    echo '<pre>';
    print_r($arrResult);
    echo 2222;
    die;
} catch (Exception $e) { //while an error has occured
    echo "==> Error: " . $e->getMessage(); //we print this
    exit();
}
?>





        $arr = array(
            'credential' => array
                (
                'Domain' => 'FascTest',
                'UserName' => 'Magento',
                'Password' => 'magento1234!',
                'ApplicationId' => '982938b6-e700-4f53-8363-ad9e03d44026',
                'DeviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD',
            ),
            'trans' => array
                (
                'Customer' => array
                    (
                    'Address1' => 'submitOrderToBloyal',
                    'Address2' => '',
                    'BirthDate' => '2014-03-04',
                    'City' => 'Test',
                    'CompanyName' => '',
                    'EmailAddress' => 'pravinm@alohatechnology.com',
                    'Country' => 'US',
                    'FaxNumber' => '',
                    'FirstName' => 'Test',
                    'FirstName2' => '',
                    'LastName' => 'User',
                    'LastName2' => '',
                    'MobilePhone' => '',
                    'NickName' => '',
                    'Phone1' => '12321321321',
                    'Phone2' => '',
                    'State' => 'AK',
                    'ZipCode' => '411111',
                    'AccountNumber' => '',
                    'ExternalReferences' => '',
                    'SignupStoreCode' => '',
                ),
                'Lines' => array
                    (
                    '0' => array
                        (
                        'NetAmount' => '7.9900',
                        'Product' => array
                            (
                            'LookupCode' => 'WF-8711-SIL',
                            'Name' => '1 Row Choker Silver',
                            'Price' => '7.9900',
                        ),
                        'Quantity' => '1.0000',
                        'TaxDetails' => array
                            (
                            '0' => array
                                (
                                'Amount' => '0.0000',
                                'Code' => 'AK',
                                'Rate' => '1.0000',
                            )
                        ),
                    )
                ),
                'Payments' => array
                    (
                    '0' => array
                        (
                        'Amount' => '7.9900',
                        'TenderCode' => 'CASH',
                    )
                ),
                'Shipments' => array
                    (
                    'TransactionShipment' => array
                        (
                        'CarrierCode' => 'UPS',
                        'Charge' => '140.0600',
                        'Recipient' => array
                            (
                            'Address1' => '1234 Test Ave.',
                            'City' => 'Redmond',
                            'FirstName' => 'Test1',
                            'LastName' => 'User',
                            'State' => 'AK',
                            'ZipCode' => '411111',
                        ),
                        'ServiceCode' => 'GND',
                        'Type' => 'Ship',
                        'TaxDetails' => array
                            (
                            '0' => array
                                (
                                'Amount' => '0.0000',
                                'Code' => 'AK',
                                'Rate' => '1.0000',
                            )
                        ),
                    )
                ),
                'Channel' => 'POS',
            ),
            'options' => array
                (
                'All'
            )
        );


//        echo '<pre>';
//        print_r($arr);
//        die;
//
//        try {
//            $arrResult = $this->_masterModel->getApi()->CalculateSalesTransaction($arr);
//            print_r($arrResult);
//            die;
//            Mage::log($arrResult);
//
//            $this->_discountAmount = 700;
//
//            echo 111;
//            die($this->_discountAmount);
//        } catch (Exception $e) {
//            Mage::log($e->getMessage(), Zend_Log::DEBUG, 'bloyalDebug.log');
//            Mage::log($e->getMessage());
//        }

