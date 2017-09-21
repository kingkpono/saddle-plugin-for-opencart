
<?php
 echo $header;  
echo $column_left;
echo '<center>';

if($has_weight)
{
	
if(isset($shipping_price))
{
?>
	<h2>Shipping Price</h2><form method="post" action="<?php echo $action;?>">
	
	
	<div> <input type="hidden" value="<?php echo $order_id; ?>" name="order_id"/></div>
	<div> <input type="hidden" value="<?php echo $shipping_price;?>" name="shipping_price"/></div>
	<div><b>₦<?php echo $shipping_price;?></b></div>
	<div >
	<br/>
		<button name="submit" class="action- scalable primary" type="submit">Post Shipment</button>
		
	</div>
</form>
<?php }else{
	
	echo '<div class="alert alert-danger">'.$warning.'</div>';
	}

  }else
  {
  	echo '<div class="alert alert-danger">Some items do not have weight, please update their weight in Products to get shipping price</div>';
  }

echo '</center>';
echo $footer;	
?>
