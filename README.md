# flagship-api-sdk

Library to use FlagShip API

# License: MIT
Please go through the documentation at https://docs.smartship.io/ for all information about the API.

# Requirements

Composer
PHP 7.1

# Installation

```
composer require flagshipcompany/flagship-api-sdk : ^1.1
composer update
```

# Code Sample

```
<?php

use Flagship\Shipping\Flagship;
use Flagship\Shipping\Exceptions\QuoteException;

require_once './vendor/autoload.php';

$flagship = new Flagship('MY_ACCESS_TOKEN', 'https://api.smartship.io','MY_WEBSITE','API_VERSION');

$payload = [
    'from' =>[
        "name"=> "FlagShip Courier Solutions",
        "attn"=> "FCS",
        "address"=> "Brunswick Blvd",
        "suite"=> "148",
        "city"=> "Pointe-Claire",
        "country"=> "CA",
        "state"=> "QC",
        "postal_code"=> "H9R5P9",
        "phone"=> "18663208383",
        "ext"=> "",
        "department"=> "Reception",
        "is_commercial"=> true
    ],
    "to" => [
        "name"=> "FlagShip Courier Solutions",
        "attn"=> "FCS",
        "address"=> "Brunswick Blvd",
        "suite"=> "148",
        "city"=> "Pointe-Claire",
        "country"=> "CA",
        "state"=> "QC",
        "postal_code"=> "H9R5P9",
        "phone"=> "18663208383",
        "ext"=> "",
        "department"=> "Reception",
        "is_commercial"=> true
    ],
    "packages"=> [
        "items"=> [
            [
                "width"=> 22,
                "height"=> 22,
                "length"=> 22,
                "weight"=> 22,
                "description"=> "Item description"
            ],

        ],
        "units"=> "imperial",
        "type"=> "package",
        "content"=> "goods"
    ],
    "payment"=> [
        "payer"=> "F"
    ],
    "options"=> [
        "insurance"=> [
            "value"=> 123.45,
            "description"=> "Children books"
        ],
        "signature_required"=> false,
        "saturday_delivery"=> false,
        "reference"=> "123 test",
        "driver_instructions"=> "Doorbell broken, knock on door",
        "address_correction"=> true,
        "return_documents_as"=> "url",
        "shipment_tracking_emails"=> "jbeans@company.com;shipping1@company.com"
    ]
];

try{
    $rates = $flagship->createQuoteRequest($payload)->execute();
}
catch(QuoteException $e){
    echo $e->getMessage();
}

```

# Usage
```
<?php

require_once './vendor/autoload.php';

use Flagship\Shipping\Flagship;
use Flagship\Shipping\Exceptions\PrepareShipmentException;
use Flagship\Shipping\Exceptions\QuoteException;
use Flagship\Shipping\Exceptions\ConfirmShipmentException;

/*
 * MY_WEBSITE and API_VERSION are optional parameters
 */
$flagship = new Flagship('MY_FLAGSHIP_ACCESS_TOKEN', 'MY_DOMAIN','MY_WEBSITE','API_VERSION');

try{
    //example prepare shipment request

    $request = $flagship->prepareShipmentRequest([

  'from'=>[ ... ],
  'to' => [ ... ],
  'packages' => [ ... ],
   ...  
  ]);

  $response = $request->execute();
}
catch(PrepareShipmentException $e){
    echo $e->getMessage()."\n";
}

try{
    //example get quotes request

    $request = $flagship->createQuoteRequest([

  'from'=>[ ... ],
  'to' => [ ... ],
  'packages' => [ ... ],
   ...  
  ]);

  $rates = $request->execute(); //returns a collection of rates
  $rates->getCheapest();
  $rates->getFastest();
  $rates->getByCourier('UPS');
  $rates->sortByPrice();
  $rates->sortByTime();
}
catch(QuoteException $e){
    echo $e->getMessage()."\n";
}

try{
    //example confirm shipment request

    $request = $flagship->confirmShipmentRequest([

  'from'=>[ ... ],
  'to' => [ ... ],
  'packages' => [ ... ],
   ...  
  ]);

  $confirmedShipment = $request->execute(); //returns a collection of rates
  $confirmedShipment->getLabel(); //returns regular label
  $confirmedShipment->getThermalLabel(); //returns thermal label
  $confirmedShipment->getTotal();
  ...
}
catch(ConfirmShipmentException $e){
    echo $e->getMessage()."\n";
}

```
