# flagship-api-sdk

Library to use FlagShip API

# License: MIT
Please go through the documentation at https://docs.smartship.io/ for all information about the API.

# Installation

```
composer require flagshipcompany/flagship-api-sdk : ^1.1
composer update
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
