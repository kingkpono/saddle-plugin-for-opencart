<?php
class ModelExtensionShippingSaddleshipping extends Model {
  function getQuote($address) {
    $this->load->language('shipping/saddleshipping');
 
   
 
    $method_data = array();
 
   
    //call saddle api
  
      $state_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id = ".$this->config->get('saddleshipping_merchant_state'));
$state_res=$state_query->rows;

$origin_state=$state_res[0]['name'];

//get delivery state

 $delivery_state_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id = ".$address['zone_id']);
$delivery_state_res= $delivery_state_query->rows;
$delivery_state=$delivery_state_res[0]['name'];

$origin_city=$this->config->get('saddleshipping_merchant_city');
$client_id=$this->config->get('saddleshipping_client_id');


$origin_name=$this->config->get('saddleshipping_merchant_name');
$origin_phone=$this->config->get('saddleshipping_merchant_phone');
$origin_street=$this->config->get('saddleshipping_merchant_street');
$origin_email=$this->config->get('saddleshipping_merchant_email');
$client_secret=$this->config->get('saddleshipping_client_secret');

//get order weight
$order_weight=$this->cart->getWeight();


$post='{ "delivery_state": "'.$delivery_state.'",
"delivery_lga": "'.$address['city'].'",
"pickup_state": "'.$origin_state.'",
"pickup_lga": "'.$origin_city.'",
"weight":'.$order_weight.',
"courier_id":"ksixga9",
"client_id":"'. $client_id.'" }';
$url= 'http://saddleng.com/v2/shipping_price';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json')
);
$response= json_decode(curl_exec($ch));


$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// close the connection, release resources used
curl_close($ch);
   if(!isset($response->error) && !isset($response->fail) && !isset($response->Warning))
   {
 $shipping_price=$response->{'Shipping Price'};
  $quote_data = array();
 
      $quote_data['saddleshipping'] = array(
        'code'     => 'saddleshipping.saddleshipping',
        'title'    => 'Saddle',
        'cost'     =>  $shipping_price,
        'tax_class_id' => 1,
        'text'     => $this->currency->format($shipping_price,$this->session->data['currency'])
      );

      $method_data = array(
        'code'     => 'saddleshipping',
        'title'    => 'Saddle',
        'quote'    => $quote_data,
        'sort_order' => $this->config->get('saddleshipping_sort_order'),
        'error'    => false
      );
    }//end if got shipping price

  

 
    return $method_data;
  }
}