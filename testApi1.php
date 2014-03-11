<?php

//header('Content-Type: application/xml');
error_reporting('E_ALL');

ini_set('display_errors', 1);

$client = @new SoapClient("https://ws-proto.bloyal.com/3.0.1/OrderProcessing.svc?wsdl"); //soap handle

try {

    $crediancials = array(
        'Domain' => 'FascTest',
        'UserName' => 'Magento',
        'Password' => 'magento1234!',
        'ApplicationId' => '982938b6-e700-4f53-8363-ad9e03d44026',
        'DeviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD');


    $customerInfo = array(
        'Address1' => 'pune',
        'City' => 'pune',
        'Country' => 'india',
        'EmailAddress' => 'test@gmail.com',
        'FirstName' => 'test',
        'LastName' => 'test1',
        'State' => 'alaska',
        'ZipCode' => '123231',
    );


    $lineInfo = array(0 => array(
            'ShipmentNumber' => 5,
            'QuantityOrdered' => 1.000,
            'TaxDetails' => array(0=>array('Amount' => 0.000, 'Code' => 'AK', 'Rate' => 1.0000)),
            'Discount' => 0.000,
            'Product' => array('LookupCode' => 'EVT0038', 'Name' => '2008 Reserve Pinot Grigio', 'Price' => 500.000, 'Weight' => 21.000),
            'ExternalId' => '100000005',
            'Comment' => '',
    ));


    $paymentInfo = array(
        'Amount' => '15.0M',
        'TenderCode' => 'CASH',
    );


    $shipmentInfo = array('OrderShipment' => array(
            'Recipient' => $customerInfo,
            'Tax' => '0.00',
            'TaxDetails' => array('Amount' => '2.0M', 'Code' => 'AK', 'Rate' => 1.0000),
            'TotalAmount' => 5.000,
            'CarrierCode' => 'UPG',
            'ServiceCode' => 'UPG',
            'Charge' => 5.000,
            'Type' => 'Ship',
    ));



    $salesTransactionInfoToBloyal = array(
        'Title' => 'Web Store Order: 2014-03-04 13:28:57',
        'Customer' => $customerInfo,
        'Shipments' => $shipmentInfo,
        'Lines' => $lineInfo,
        );

    $params = array(
        'credential' => $crediancials,
        'deviceKey' => 'PVXSVXCYBG-PYHAPVMEIA-PXLRJSODSD',
        'order' => $salesTransactionInfoToBloyal,
        'options' => array('Validate','CreateCustomer'));


     $arrResult = $client->SubmitOrder($params)->SubmitOrderResult;
    echo '<pre>';
    print_r($params);
    echo 2222;
    die;
} catch (Exception $e) { //while an error has occured
    echo "==> Error: " . $e->getMessage(); //we print this
    exit();
}


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
            'Title' => 'Web Store Order: 2014-03-04 15:48:18',
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
                            'ShipmentNumber' => '21',
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

            'ExternalId' => '100000017',
            'Comment' => 'Credit Card: xxxx-1111 amount $148.05 authorize - successful. Authorize.Net Transaction ID 0.  Transaction ID: &quot;0&quot;.',
        ),

    'options' => array
        (
            '0' => 'Validate',
            '1' => 'CreateCustomer',
        )

);



echo '<pre>';
print_r($arr);


?>