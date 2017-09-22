<?php
class ControllerExtensionShippingSaddleshipping extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/shipping/saddleshipping');

		$this->document->setTitle($this->language->get('heading_title'));
		 $this->load->model('localisation/order_status');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('saddleshipping', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_none'] = $this->language->get('text_none');

		$data['entry_cost'] = $this->language->get('entry_cost');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/shipping/saddleshipping', 'token=' . $this->session->data['token'], true)
		);

		$data['action'] = $this->url->link('extension/shipping/saddleshipping', 'token=' . $this->session->data['token'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=shipping', true);

		
		

		if (isset($this->request->post['saddleshipping_status'])) {
			$data['saddleshipping_status'] = $this->request->post['saddleshipping_status'];
		} else {
			$data['saddleshipping_status'] = $this->config->get('saddleshipping_status');
		}
		
		
		

                if (isset($this->request->post['saddleshipping_shipment_status_id'])) {
			$data['saddleshipping_shipment_status_id'] = $this->request->post['saddleshipping_shipment_status_id'];
                       
		} else {
			$data['saddleshipping_shipment_status_id'] = $this->config->get('saddleshipping_shipment_status_id');
		}
		
		$this->load->model('extension/shipping/saddleshipping');
		
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		

		// - get states data from loaded model
		$data['states'] = $this->model_extension_shipping_saddleshipping->getStatesData();
		
		
		if (isset($this->request->post['saddleshipping_merchant_id'])) {
			$data['saddleshipping_merchant_id'] = $this->request->post['saddleshipping_merchant_id'];
		} else {
			$data['saddleshipping_merchant_id'] = $this->config->get('saddleshipping_merchant_id');
		}

       if (isset($this->request->post['saddleshipping_client_id'])) {
			$data['saddleshipping_client_id'] = $this->request->post['saddleshipping_client_id'];
		} else {
			$data['saddleshipping_client_id'] = $this->config->get('saddleshipping_client_id');
		}

		if (isset($this->request->post['saddleshipping_client_secret'])) {
			$data['saddleshipping_client_secret'] = $this->request->post['saddleshipping_client_secret'];
		} else {
			$data['saddleshipping_client_secret'] = $this->config->get('saddleshipping_client_secret');
		}

		if (isset($this->request->post['saddleshipping_merchant_name'])) {
			$data['saddleshipping_merchant_name'] = $this->request->post['saddleshipping_merchant_name'];
		} else {
			$data['saddleshipping_merchant_name'] = $this->config->get('saddleshipping_merchant_name');
		}

		 if (isset($this->request->post['saddleshipping_merchant_email'])) {
			$data['saddleshipping_merchant_email'] = $this->request->post['saddleshipping_merchant_email'];
		} else {
			$data['saddleshipping_merchant_email'] = $this->config->get('saddleshipping_merchant_email');
		}

		if (isset($this->request->post['saddleshipping_merchant_phone'])) {
			$data['saddleshipping_merchant_phone'] = $this->request->post['saddleshipping_merchant_phone'];
		} else {
			$data['saddleshipping_merchant_phone'] = $this->config->get('saddleshipping_merchant_phone');
		}

		 if (isset($this->request->post['saddleshipping_merchant_street'])) {
			$data['saddleshipping_merchant_street'] = $this->request->post['saddleshipping_merchant_street'];
		} else {
			$data['saddleshipping_merchant_street'] = $this->config->get('saddleshipping_merchant_street');
		}
          if (isset($this->request->post['saddleshipping_merchant_city'])) {
			$data['saddleshipping_merchant_city'] = $this->request->post['saddleshipping_merchant_city'];
		} else {
			$data['saddleshipping_merchant_city'] = $this->config->get('saddleshipping_merchant_city');
		}

		if (isset($this->request->post['saddleshipping_merchant_state'])) {
			$data['saddleshipping_merchant_state'] = $this->request->post['saddleshipping_merchant_state'];
		} else {
			$data['saddleshipping_merchant_state'] = $this->config->get('saddleshipping_merchant_state');
		}

                if (isset($this->request->post['saddleshipping_test_mode'])) {
			$data['saddleshipping_test_mode'] = $this->request->post['saddleshipping_test_mode'];
		} else {
			$data['saddleshipping_test_mode'] = $this->config->get('saddleshipping_test_mode');
		}

		if (isset($this->request->post['saddleshipping_sort_order'])) {
			$data['saddleshipping_sort_order'] = $this->request->post['saddleshipping_sort_order'];
		} else {
			$data['saddleshipping_sort_order'] = $this->config->get('saddleshipping_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/shipping/saddleshipping', $data));
	}

       public function shippingprice()
       {



$order_id=$this->request->get['order_id'];


$order_query = $this->db->query("SELECT shipping_zone,shipping_city FROM " . DB_PREFIX . "order WHERE order_id =".$order_id);
$order_res=$order_query->rows;
$order=$order_res[0];

$client_secret=$this->config->get('saddleshipping_client_secret');
//get order weight
$order_weight=0;

$products_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id =".$order_id);
$products=$products_query->rows;



$state_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id = ".$this->config->get('saddleshipping_merchant_state'));
$state_res=$state_query->rows;
			
$origin_state=$state_res[0]['name'];
$origin_city=$this->config->get('saddleshipping_merchant_city');
$client_id=$this->config->get('saddleshipping_client_id');


foreach($products as $item)
{
$weight_query = $this->db->query("SELECT weight FROM " . DB_PREFIX . "product WHERE product_id =".$item['product_id']);
$weight_res=$weight_query->rows;
$order_weight+=$weight_res[0]['weight'];

}
$post='{ "delivery_state": "'.$order['shipping_zone'].'",
"delivery_lga": "'.$order['shipping_city'].'",
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
$data['shipping_price']=$response->{'Shipping Price'};

}else
{
     
$data['warning']=$response->{'Warning'};

} 

    if($order_weight!="" && $order_weight !=null && $order_weight>0)
    $data['has_weight']=true;
    else
      $data['has_weight']=false;

     $data['order_id']=$order_id;
      
        $data['token']=$this->session->data['token'];
$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
      		$data['action'] = $this->url->link('extension/shipping/saddleshipping/postdelivery', 'token=' . $this->session->data['token'], true);

		$this->response->setOutput($this->load->view('extension/shipping/saddleshippingprice', $data));
        }

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/shipping/saddleshipping')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	 
	
  
   public function postdelivery() {
     
   $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
     
  
$order_id=$this->request->post['order_id'];
$shipping_price=$this->request->post['shipping_price'];
$order_query = $this->db->query("SELECT shipping_zone,shipping_city,payment_method,shipping_firstname,shipping_lastname,telephone,email,shipping_address_1,date_added FROM " . DB_PREFIX . "order WHERE order_id =".$order_id);
$order_res=$order_query->rows;
$order=$order_res[0];


$state_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "zone WHERE zone_id = ".$this->config->get('saddleshipping_merchant_state'));
$state_res=$state_query->rows;
			
$origin_state=$state_res[0]['name'];
$origin_city=$this->config->get('saddleshipping_merchant_city');
$client_id=$this->config->get('saddleshipping_client_id');
$origin_name=$this->config->get('saddleshipping_merchant_name');
$origin_phone=$this->config->get('saddleshipping_merchant_phone');
$origin_street=$this->config->get('saddleshipping_merchant_street');
$origin_email=$this->config->get('saddleshipping_merchant_email');
$client_secret=$this->config->get('saddleshipping_client_secret');
//get order weight
$order_weight=0;

$products_query = $this->db->query("SELECT op.*,p.weight,p.image FROM " . DB_PREFIX . "order_product op, " . DB_PREFIX . "product p WHERE op.product_id=p.product_id AND order_id =".$order_id);
$products=$products_query->rows;

foreach($products as $item)
{
$weight_query = $this->db->query("SELECT weight FROM " . DB_PREFIX . "product WHERE product_id =".$item['product_id']);
$weight_res=$weight_query->rows;
$order_weight+=$weight_res[0]['weight'];
}

//post to delivery
$pickup_date= $order['date_added'];   
//shipping street
 $shipping_street=$order['shipping_address_1'];
 
 $output="";
 $httpcode="";
 $tracking_code="";
 $pod=0;
 $payment_method=$order['payment_method'];
 $pod=0;
 if($payment_method=="cod")
    $pod=1;
	
foreach($products as $item)
{

$fullname=$order['shipping_firstname'].' '.$order['shipping_lastname'];
$delivery_post='{"transaction_id":"'.$order_id.'",    
"client_id":"'.$client_id.'",  
"item_cost":"'.$item['price'].'",
"delivery_cost":'.$shipping_price.',       
"courier_id":"ksixga9", 
"pickup_address":"'.$origin_street.'",  
"pickup_location":"'.$origin_city.'",   
"pickup_contactname":"'.$origin_name.'",    
"pickup_contactnumber":"'.$origin_phone.'", 
"pickup_contactemail":"'.$origin_email.'",  
"delivery_address":"'.$shipping_street.'",  
"delivery_location":"'.$order['shipping_city'].'",  
"delivery_contactname":"'.$fullname.'",   
"delivery_contactnumber":"'.$order['telephone'].'",    
"delivery_contactemail":"'.$order['email'].'", 
"item_name":"'.$item['name'].'", 
"item_size":"", 
"item_weight":"'.$item['weight'].'", 
"item_color":"-",   
"item_quantity":"'.$item['quantity'].'",   
"image_location":"'.$this->config->get('config_url').'image/'.$item['image'].'",  
"fragile":"1",  
"perishable":"1",
"pre_auth":"0",
"status":"0",
"POD": "'.$pod.'"
}';
   if($this->config->get('saddleshipping_test_mode'))
  $url= "http://test.saddleng.com/v2/delivery";
   else
    $url= "http://saddleng.com/v2/delivery";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $delivery_post);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'client-id: '.$client_id,
'client-secret: '.$client_secret
));
 
$resp= curl_exec($ch);
$delivery_response= json_decode($resp);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// close the connection, release resources used
curl_close($ch);
if(!isset($delivery_response->error) && !isset($delivery_response->fail))
{
    $tracking_code=$delivery_response->delivery_id;
    $output.=$delivery_response->success;
    $output.="; Delivery ID ".$tracking_code;
}else
{
    if(isset($delivery_response->error)){
        $output.=$delivery_response->error;
    }
    if(isset($delivery_response->fail)){
        $output.=$delivery_response->fail;
    }
}
  
}//end for each
if(!isset($delivery_response->error) && !isset($delivery_response->fail))
{
 $this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id = ".$this->config->get('saddleshipping_shipment_status_id')." WHERE order_id=".$order_id);
 $this->db->query("INSERT INTO " . DB_PREFIX . "order_history(order_id,order_status_id,comment) VALUES(".$order_id.",".$this->config->get('saddleshipping_shipment_status_id').",'".$output."')");

 
}

$data['response']= $output;
$data['back_to_orders_link']=$this->url->link('sale/order/info', 'token=' . $this->session->data['token']."&order_id=".$order_id, true);

//end debit on delivery
 
    // call the "View" to render the output
    	$this->response->setOutput($this->load->view('extension/shipping/saddleresponse', $data));
  }
	
	
	
}
