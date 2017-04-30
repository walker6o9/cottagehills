<?php
error_reporting(E_ALL); 
ini_set('display_errors','1');
 $companyId=14431;
 $deviceId="api";
 $password="bK6Vre2QtGZdZ5q7";
 $username="staging@stevekemph.com";
 $DEBUG = 1;

//************************************************
//********** GET TOKEN ***************************
//************************************************
function get_token(){
global $companyId,$deviceId,$password,$username,$DEBUG;
//$DEBUG =0;
$params = array("companyId"=>$companyId,
				"deviceId" =>$deviceId,
				"password" =>$password,
				"username" =>$username
				);

//$data_string =   "companyId".trim($params[0])."&deviceId=".trim($params[1])."&password=".trim($params[2])."&username=".trim($params[3]);
$data_string = json_encode($params);

//GET TOKEN
if($DEBUG==1)print_r($data_string);
$uri = "http://staging-exact-integration.posios.com/PosServer/rest/token";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'Content-Length: ' . strlen($data_string))
); 
$result = curl_exec($ch);
//$result = json_decode($result, true);
//Get Access Token on Successful Setup & Initialization of the User
if($DEBUG==1)print_r($result);
$result = json_decode($result,true);
if($DEBUG==1)print_r($result);
$access_token = $result['token'];
if($DEBUG==1)echo("<br>ACCESS TOKEN:". $access_token);
echo "<br><br>";
curl_close($ch);
return $access_token;
}


//************************************************
//*********** CREATE CUSTOMER ********************
//************************************************
function create_customer($token){
global $companyId,$deviceId,$password,$username,$DEBUG;

//$DEBUG =0;
$params = array(/*
  "city"=> "New York",
  "companyId" => $companyId,
  "country" => "USA",
  "credits" => 0,
  "customerCards" => array(    
      "code"=> "",
      "companyId"=> $companyId,
      "creationUserId"=> 0,
      "customerId"=> 0,
      "expiryDate"=> 0,
      "generatedDate"=> 0,
      "lastUsedDate"=> 0,
      "lastValueAddedDate"=> 0,
      "originalValue"=> 0,
      "remainingValue"=> 0,
      "type"=> "string",
      "uuid"=> "string"
    ),
  "deliveryCity"=> "New York",
  "deliveryCountry"=> "USA",
  "deliveryStreet"=> "73ST",
  "deliveryStreetNumber"=> "234",
  "deliveryZip"=> "1001",
  "email"=> "ramsesiden@yahoo.com",
  "firstName"=> "Omar",
  "id"=> 0123456789,
  "lastName"=> "Zorrilla",
  "modificationTime"=> "string",
  "note"=> "string",
  "street"=> "string",
  "streetNumber"=> "string",
  "telephone"=> "01122334455",
  "uuid"=> "string",
  "vatNumber"=> "string",
  "zip"=> "10001"
);
*/

  "city"=> "New York",
  "country"=> "USA",
  "deliveryCity"=> "Manhatan",
  "deliveryCountry"=> "USA",
  "deliveryStreet"=> "11ST",
  "deliveryStreetNumber"=> "2",
  "deliveryZip"=> "10001",
  "email"=> "ramsesiden@test14.com",
  "firstName"=> "test1",
  "lastName"=> "testlast1",
  "street"=> "Eleven street",
  "streetNumber"=> "3",
  "telephone"=> "123456789",
  "zip"=> "10001"
);

//$data_string =   "companyId".trim($params[0])."&deviceId=".trim($params[1])."&password=".trim($params[2])."&username=".trim($params[3]);
$data_string = json_encode($params);

//CREATE CUSTOMER
if($DEBUG==1)print_r($data_string);
$uri = "http://staging-exact-integration.posios.com/PosServer/rest/core/customer";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'X-Auth-Token:'. $token,
'Content-Length: ' . strlen($data_string))
); 
$result = curl_exec($ch);
if($DEBUG==1)print_r($result);
echo "<br><br>";
$result = json_decode($result,true);
if($DEBUG==1)print_r($result);
$customer_id = $result;
if($DEBUG==1)echo("<br>CUSTOMER ID:". $customer_id);
curl_close($ch);
return $customer_id;
}

//************************************************
//********** CREATE RESERVATION ******************
//************************************************
function create_reservation($token,$cid){
global $companyId,$deviceId,$password,$username,$DEBUG;

//$DEBUG =0;
//status = {CANCELLED, SEATED, UNKNOWN, ON_HOLD, TO_CHECK, CONFIRMED}
//Formats for endTime and starTime are not ok
$params = array(
  "companyId" =>$companyId,
  "customerId"=> $cid,
  "endTime"=> "2017-03-24T14:00:00Z",
  "floorId"=> 1,
  "id"=> 1,
  "notes"=> "Reserve this table for me",
  "reservationName"=> "New Reservation",
  "seats"=> 2,
  "startTime"=> "2017-03-24T13:00:00Z",
  "status"=> "TO_CHECK",
  "tableId"=> "1",
  "telephone"=> "33333333"
);
$data_string = json_encode($params);

if($DEBUG==1)print_r($data_string);
$uri = "http://staging-exact-integration.posios.com/PosServer/rest/reservation";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'X-Auth-Token:'. $token,
'Content-Length: ' . strlen($data_string))
); 
$result = curl_exec($ch);
//$result = json_decode($result, true);
//Get Access Token on Successful Setup & Initialization of the User
if($DEBUG==1)print_r($result);
$result = json_decode($result,true);
if($DEBUG==1)print_r($result);
$reservation_id = $result;
if($DEBUG==1)echo("<br>Reservation Number:". $reservation_id);
echo "<br><br>";
curl_close($ch);
return $reservation_id;
}

//************************************************
//********* CREATE PRODUCT ***********************
//************************************************
function create_product($token,$gid){
global $companyId,$deviceId,$password,$username,$DEBUG;
$gid = 1;

$params = array(
  "additions"=>
    array(
      "displayName" => "Irish Egg Rolls",
      "id"=> 1,
      "maxSelectedAmount"=> 8.25,
      "minSelectedAmount"=> 8.25,
      "multiselect"=> true,
      "name"=> "Irish Egg Rolls",
      "values"=>
       array(
          "id"=> 1,
          "info"=> "Corned beef cabbage and cheese fried in a wonton",
          "modifierId"=> 0,
          "name"=> "Irish Egg Rolls",
          "price"=> 8.25,
          "priceWithoutVAT"=> 8
        )
    ),
  "deliveryPrice"=> 9,
  "deliveryPriceWithoutVat"=> 8.7,
  "deliveryTaxClass"=> "VAT",
  "groupIds"=> array(
    1
  ),
  "id"=> 1,
  "imageLocation"=> "",
  "info"=> "Corned beef cabbage and cheese fried in a wonton",
  "name"=> "Irish Egg Rolls",
  "price"=> 8.25,
  "priceWithoutVat"=> 8,
  "productType"=> "Appetizers",
  "sequence"=> 0,
  "sku"=> "0c54a",
  "stockAmount"=> 1,
  "takeawayPrice"=> 0,
  "takeawayPriceWithoutVat"=> 8,
  "takeawayTaxClass"=> "Taxaway",
  "taxClass"=> "Tax",
  "visible"=> true
);
$data_string = json_encode($params);

if($DEBUG==1)print_r($data_string);
$uri = "http://staging-exact-integration.posios.com/PosServer/rest/inventory/productgroup/".$gid."/product";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'X-Auth-Token:'. $token,
'id:'.$gid,
'Content-Length: ' . strlen($data_string))
); 
$result = curl_exec($ch);
//$result = json_decode($result, true);
//Get Access Token on Successful Setup & Initialization of the User
if($DEBUG==1)print_r($result);
$result = json_decode($result,true);
if($DEBUG==1)print_r($result);
/*$reservation_id = $result;
if($DEBUG==1)echo("<br>Reservation Number:". $reservation_id);
echo "<br><br>";
curl_close($ch);
return $reservation_id;*/
}


//************************************************
//********** CREATE ORDER ************************
//************************************************
function create_order($token,$cid){
global $companyId,$deviceId,$password,$username,$DEBUG;

//$DEBUG =1;
$params = 
array (
  'companyId' => $companyId,
  'customerId' => $cid,
  'type' => 'delivery',
  'creationDate' => '2017-04-17T18:42:10-05:00',
  'deliveryDate' => '2017-04-17T19:45:00-05:00',
  'status' => 'ACCEPTED',
  'description' => 'YPDine OO',
  'orderItems' => 
  array (
    0 => 
    array (
      'productId' => 137050,
      'amount' => 1,
      'totalPrice' => 13.56,
      'totalPriceWithoutVat' => 12,
      'unitPrice' => 6.78,
      'unitPriceWithoutVat' => 6,
      'modifiers' => 
      array (
        0 => 
        array (
          'modifierId' => 1830,
          'modifierValueId' => 5947,
          'description' => 'Cheese',
          'modifierName' => 'Cheese',
          'price' => 3.39,
          'priceWithoutVat' => 3,
        ),
        1 => 
        array (
          'modifierId' => 1830,
          'modifierValueId' => 5948,
          'description' => 'Cheese',
          'modifierName' => 'Cheese',
          'price' => 3.39,
          'priceWithoutVat' => 3,
        ),
      ),
    ),
    1 => 
    array (
      'productId' => 137050,
      'amount' => 1,
      'totalPrice' => 5.65,
      'totalPriceWithoutVat' => 5,
      'unitPrice' => 5.65,
      'unitPriceWithoutVat' => 5,
    ),
  ),
 /* 'orderPayment' => 
  array (
    'amount' => 1,
    'paymentTypeId' => 4138,
    'paymentTypeTypeId' => 1,
  ),*/
  'orderTaxInfo' => 
  array (
    0 => 
    array (
      'tax' => 0.13,
      'taxRate' => 0.13,
      'totalWithTax' => 24.85,
      'totalWithoutTax' => 22,
    ),
  ),
);


$data_string = json_encode($params);

//GET TOKEN
if($DEBUG==1)print_r($data_string);
$uri = "http://staging-exact-integration.posios.com/PosServer/rest/onlineordering/customer/".$cid."/establishmentorder";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'X-Auth-Token:'. $token,
'customer'. $cid,
'Content-Length: ' . strlen($data_string))
); 
$result = curl_exec($ch);
//$result = json_decode($result, true);
//Get Access Token on Successful Setup & Initialization of the User
if($DEBUG==1)print_r($result);
$result = json_decode($result,true);
if($DEBUG==1)print_r($result);
$order = $result['id'];
if($DEBUG==1)echo("<br>ORDER:". $order);
curl_close($ch);
//return $access_token;

}
//************************************************
//    Function Get Modifiers
//************************************************

function get_modifiers($token){
global $companyId,$deviceId,$password,$username,$DEBUG;

$uri = "http://staging-exact-integration.posios.com/PosServer/rest/inventory/product/137150";//".$id."/product";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'X-Auth-Token:'. $token,
//'customer'. $cid,
//'Content-Length: ' . strlen($data_string)
)
); 
$result = curl_exec($ch);
//$result = json_decode($result, true);
//Get Access Token on Successful Setup & Initialization of the User
//if($DEBUG==1)print_r($result);
$result = json_decode($result,true);
if($DEBUG==1)/*print_r($result);*/var_dump($result);echo '<br><pre>';
print_r($result);
echo '</pre>';
//$access_token = $result['token'];
//if($DEBUG==1)echo("<br>ACCESS TOKEN:". $access_token);



curl_close($ch);
return $result;

}

//************************************************
//    Function Get Products
//************************************************

function get_products($token){
global $companyId,$deviceId,$password,$username,$DEBUG;

$uri = "http://staging-exact-integration.posios.com/PosServer/rest/inventory/product";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$uri);
//curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Accept: */*',
'X-Auth-Token:'. $token,
//'customer'. $cid,
//'Content-Length: ' . strlen($data_string)
)
); 
$result = curl_exec($ch);
//$result = json_decode($result, true);
//Get Access Token on Successful Setup & Initialization of the User
//if($DEBUG==1)print_r($result);
$result = json_decode($result,true);
if($DEBUG==1)/*print_r($result);*/var_dump($result);
//$access_token = $result['token'];
//if($DEBUG==1)echo("<br>ACCESS TOKEN:". $access_token);



curl_close($ch);
return $result;

}

//************************************************
//    MAIN CODE
//************************************************
$tok = get_token();
$cid = '32052';//create_customer($tok);
get_products($tok);
get_modifiers($tok);
//create_product($tok,1);
//create_reservation($tok,$cid);
//$order = create_order($tok,$cid);
?>