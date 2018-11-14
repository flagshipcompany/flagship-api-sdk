# flagship-api-sdk

Library to use FlagShip API

# License: MIT
Please go through the documentation at https://docs.smartship.io/ for all information about the API.

#Installation

```
composer require flagshipcompany/flagship-api-sdk
```

#Usage
```
<?php

require_once './vendor/autoload.php';

use Flagship\Shipping\Flagship;
use Flagship\Shipping\Exceptions\PrepareShipmentException;


$flagship = new Flagship('MY_FLAGSHIP_ACCESS_TOKEN', 'MY_DOMAIN');

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
```
