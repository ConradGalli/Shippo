<?php   
global $woocommerce, $wpdb, $table_prefix;
$prefixbox = $wpdb->prefix;
$site = get_site_url(); 
if ($_GET ['order_id']) {
	$order_id = $_GET ['order_id'];
	$order = get_post ( $order_id );
	if (! $order || $order->post_type != 'shop_order') {	
?>

<?php
	} else {
		$order = new WC_Order ( $order->ID );
		$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));		
		$shipping_info ['recipient'] = array (
				'country_code' => $order->shipping_country,
				'company' => $order->shipping_company,
				'contact_name' => $order->shipping_first_name . ' ' . $order->shipping_last_name,
				'address1' => $order->shipping_address_1,
				'address2' => $order->shipping_address_2,
				'city' => $order->shipping_city,
				'state' => $order->shipping_state,
				'postcode' => $order->shipping_postcode,
				'phone' => $order->billing_phone,
				'ShippingM' => $order->shipping_method_title
		);
  		$admin_email = get_option('admin_email');  
	}
}

?>

<?php if (empty($order_id)){ ?>

<div class="error fade">
	<p>
		Sorry the order you're trying to access to create a label for doesn't exist, please go to the <a href="edit.php?post_type=shop_order">order lists</a> and select one.
	</p>
</div>



<?php } else {  ?> 


<div id="shippo_wanderlust" class="wrap">
 	    <h2>Generate Shipping Labels</h2>
		<input type="hidden" value="<?php echo $order_id;  ?>" id="order_id" name="order_id" />

	    <?php
	    $presets = get_option ( 'wc_usps_label_presets', array () );
	    if (! is_array ( $presets ))
	    	$presets = unserialize ( $presets );
	    
   		if (isset ( $_POST ['shipment_processs'] )) {
   		$orderid =  $_GET ['order_id'];

		$client_country =$_POST ['shipment_country'];  
		$client_company = $order->shipping_company;
		$client_name = $order->shipping_first_name . ' ' . $order->shipping_last_name;
		$client_fname =  $order->shipping_first_name;
		$client_lname = $order->shipping_last_name;
		$client_address1 = $order->shipping_address_1. ' ' . $order->shipping_address_2;
		$client_address1a = $order->shipping_address_1;
		$client_address2 = $order->shipping_address_2;
		$client_city = $order->shipping_city;
		$client_state = $order->shipping_state;
		$client_zip = $order->shipping_postcode;
		$client_phone = $order->billing_phone;
        $client_email = $order->billing_email;	
		$shipping_info_items = array ();
		$total_weight = 0;
 						$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
						$dimensionmul = 0;
 						if ($dimension_unit == 'in') { $dimensionmul = 1;}
						if ($dimension_unit == 'm') { $dimensionmul =  39.3701;}
						if ($dimension_unit == 'cm') {  $dimensionmul =  0.393701;}
						if ($dimension_unit == 'mm') { $dimensionmul =  0.0393701;}
						if ($dimension_unit == 'yd') { $dimensionmul =  36;}
 					 	$largocaja = $_POST ['shipment_packages_length'] * $dimensionmul;
					 	$anchocaja =$_POST ['shipment_packages_width'] * $dimensionmul;
					 	$altocaja =$_POST ['shipment_packages_height'] * $dimensionmul;
						$valorpaquete =$_POST ['shipment_packages_value']; 
					 	$girth = 2*	($altocaja + $anchocaja);					
					 	$shipping_info ['items'] = $shipping_info_items;
						$shipping_info ['total_weight'] = $total_weight;
  					 	$pesototal =$_POST ['shipment_packages_weight'];
 	    $today = date("m/d/Y"); 
 	    $date = strtotime( date('Y-m-d') );
		//$shippingMethod2  = $order->shipping_method_title;
	    $shippingMethod2  = $shipment_methods; 
if ($error != false) { ?>
<div style="float: left;background: aliceblue;padding: 20px;border-radius: 10px;width: 100%;">
<h1>We found some errors, please fix:</h1>
<span><?php echo $error; ?></span>
</div>
<?php } else { 	 ?>	
<?php }	 ?>	    
 
<?php }	echo '<script>var shipment_presets =' . json_encode($presets) . '</script>'; ?>	  
<form action="" method="post" id="wps_poll_question">
		<div style="clear: both">
			<div id="toinfo" style="float: right; margin-right: 40px;max-width: 30%;">
				<h3>Shipping To.</h3>
			
			<?php 

	 			//verify address
				$client_country = $order->shipping_country;  
				$client_company = $order->shipping_company;
				$client_name = $order->shipping_first_name . ' ' . $order->shipping_last_name;
				$client_fname =  $order->shipping_first_name;
				$client_lname = $order->shipping_last_name;
				$client_address1 = $order->shipping_address_1. ' ' . $order->shipping_address_2;
				$client_address1a = $order->shipping_address_1;
				$client_address2 = $order->shipping_address_2;
				$client_city = $order->shipping_city;
				$client_state = $order->shipping_state;
				$client_zip = $order->shipping_postcode;
				$client_phone = $order->billing_phone;
				$client_email = $order->billing_email; 
			   	if($client_country == 'US'){
					$to_address =  Shippo_Address::
    				create(
						array(
						"object_purpose" => 'QUOTE',
 						"object_source" => 'VALIDATOR',
						"name"    => $client_name,
						"company" => $client_company,
						"street1" => $client_address1a,
						"street2" => $client_address2,
						"city"    => $client_city,
						"state"   => $client_state,
						"zip"     => $client_zip,
						"phone"   => $client_phone,
						"country" => $client_country,
						"email" => $client_email,
						"residential" => $residential,
					));
					   //echo(var_dump($to_address)) .'</br>';	
 	    		}
			  
 
 		  
			  
				?>
			<?php if(!empty($to_address)){ ?>
					<strong><?php echo $to_address['name'];?></strong><br />
					<?php if(!empty($to_address['company'])){ echo $to_address['company'] . '<br />';}?>
					<?php echo $to_address['street1'];?> <?php echo $to_address['street2'];?> <br />
					<?php echo $to_address['city'];?>, <?php echo $to_address['state'];?>, <?php echo $to_address['zip'];?> <br />
					Contact Phone: <?php echo $to_address['phone'];?>  <br />
					Contact Email: <?php echo $to_address['email'];?>  <br />
					<br /> 
 			<?php } else {	?>
				
					<strong><?php echo $order->shipping_first_name . ' ' . $order->shipping_last_name;?></strong><br />
					<?php echo $order->shipping_address_1;?>	<?php if(!empty($order->shipping_address_2)) echo $order->shipping_address_2;?> <br />
					<?php echo $order->shipping_city;?>, <?php echo $order->shipping_state;?>, <?php echo $order->shipping_country;?>, <?php echo $order->shipping_postcode;?><br />
					Contact phone: <?php echo $order->billing_phone;?><br /> <br /> 
				
			<?php } ?>
				
				
			<div id="labels">
				<?php		$shippo_shipping_labela = get_post_meta($order_id, 'shippo_shipping_label_1');
							$shippo_shipping_labelb = get_post_meta($order_id, 'shippo_shipping_label_2');
							$shippo_shipping_labelc = get_post_meta($order_id, 'shippo_shipping_label_3');
							if (!empty($shippo_shipping_labela)){ 
								echo'<div id="label_one"><div style="cursor: pointer;" class="print" data-imgid="'.$shippo_shipping_labela[0].'"><a href="#"><img src="'.$shippo_shipping_labela[0].'" width="150" height="auto"></a></div></div>';}
							if (!empty($shippo_shipping_labelb)){ 
								echo'<div id="label_two"><div style="cursor: pointer;" class="print" data-imgid="'.$shippo_shipping_labelb[0].'"><a href="#"><img src="'.$shippo_shipping_labelb[0].'" width="150" height="auto"></a></div></div>';}
							if (!empty($shippo_shipping_labelc)){ 
								echo'<div id="label_three"><div style="cursor: pointer;" class="print" data-imgid="'.$shippo_shipping_labelc[0].'"><a href="#"><img src="'.$shippo_shipping_labelc[0].'" width="150" height="auto"></a></div></div>';}
				?>
				<div id="label_one"></div>
				<div id="label_two"></div>
				<div id="label_three"></div>
				<?php 
			  		if(!empty($shippo_shipping_labela)) {
 						
			  	?>
				<div id="refund_shippo" style="width: auto;" class="button button-primary tips" data-order="<?php echo $order_id;?>">Refund Label</div>
				<?php } ?>
			</div>

			</div>

<div style="float: left; margin:0px;">
	<div id="order-info">
				<?php /* GET ORDER INFO */
					global $woocommerce;
					$order_info = new WC_Order($order_id);
					$items = $order_info->get_items();
	   				$productinorder =  count($items);
	   				$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));			
	   				$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
	   				$client_country = $order_info->shipping_country;
					$order_totals  = get_post_meta($order_id, '_order_total' ); 
					$table_name = $wpdb->prefix . "woocommerce_order_items";
					$sql = "SELECT order_item_name FROM  $table_name WHERE order_id = $order_id AND order_item_type = 'shipping'";
					$shippingpaid = $wpdb->get_results ( $sql );
				?>

		<h1>Order Info</h1>
			<h3>Order ID: <?php  echo $order_id = $_GET ['order_id'];?>  <a href="post.php?post=<?php echo $order_id;?>&action=edit">Edit Order</a></h3> 
			<h4 style="margin: 0px;">Order Value  $ <?php echo $order_totals[0];?></h4>
			<h4 style="margin: 0px;">Shipping Method <span style="color:#444;"><?php echo $shippingpaid[0]->order_item_name ;?>  </span></h4>
			<h4 style="margin: 0px;">Products in the Order <?php echo $productinorder;?> <span style="cursor:pointer; color:#444;text-transform: none;">more info</span> </h4>
<div class="products">
		<?php /* SHOW ORDER INFO */   
		if ( sizeof( $items ) > 0 ) { 
			    $i = 0;
		    	$sum = 0;
		    	$prod = 0;
		    	$totales =  array();
							foreach( $items as $item ) {    				 
								if ( $item['product_id'] > 0 ) {
								 	$productid = $item['product_id']; 
									$productidweight  = get_post_meta($productid, '_weight' ); 
									$prodcutdimentionslength = get_post_meta($productid, '_length');
									$prodcutdimentionswidth = get_post_meta($productid, '_width');
									$prodcutdimentionsheight = get_post_meta($productid, '_height');
		   							$pweight = $productidweight[0];
		   							$i++; 
		   							$prod += $item['item_meta']['_qty']['0']; 
		        					$totales[] = $item['item_meta']['_qty']['0'];
 								echo '<div class="col1">';  	
 								echo '<li style="font-weight: bold;">Product ' .	$i . '</li>'; 
							 	echo '<li>Name: ' .	$item['name'] . '</li>'; 
							 	echo '<li>Quantity: ' .	$item['item_meta']['_qty']['0'] . '</li>'; 
								$variation = $item['variation_id'];
								if ( ! empty( $variation) ) { 	
									$productidweight2  = get_post_meta($variation, '_weight' ); 
									$prodcutdimentionslength2 = get_post_meta($variation, '_length');
									$prodcutdimentionswidth2 = get_post_meta($variation, '_width');
									$prodcutdimentionsheight2 = get_post_meta($variation, '_height'); 
									$pweightb = $productidweight2[0];
									if(empty( $pweightb)) {
									echo '<li>Variation Weight: ' .	$pweight . $weight_unit .'</li>'; 
										$sum += $pweight * $prod; 
									} else {
									echo '<li>Variation Weight: ' .	$pweightb . $weight_unit .'</li>';
										$sum += $pweightb * $prod;
									}
									if(!empty($prodcutdimentionslength2[0])){
										echo '<li>Length: ' .	$prodcutdimentionslength2[0]. $dimension_unit . '</li>'; 
									} else {
										echo '<li>Length: ' .	$prodcutdimentionslength[0]. $dimension_unit . '</li>';
									}
									if(!empty($prodcutdimentionswidth2[0])){
										echo '<li>Width ' .	$prodcutdimentionswidth2[0]. $dimension_unit . '</li>';  
									} else {
										echo '<li>Width ' .	$prodcutdimentionswidth[0]. $dimension_unit . '</li>';
									}									
									if(!empty($prodcutdimentionsheight2[0])){
										echo '<li>Height: ' .	$prodcutdimentionsheight2[0]. $dimension_unit . '</li>';
									} else {
										echo '<li>Height: ' .	$prodcutdimentionsheight[0]. $dimension_unit . '</li>';
									}									
									
								} else {
 									$sum += $pweight * $prod; 
								 	echo '<li>Weight: ' .	$pweight. $weight_unit .'</li>'; 
									echo '<li>Length: ' .	$prodcutdimentionslength[0]. $dimension_unit . '</li>'; 
									echo '<li>Width ' .	$prodcutdimentionswidth[0]. $dimension_unit . '</li>'; 
									echo '<li>Height: ' .	$prodcutdimentionsheight[0]. $dimension_unit . '</li>';
								}
							 	echo '</div>';  	
 
								} 
							}  $itemtotales = array_sum($totales); 
							$ordertotalw =  $sum ;
		} ?>
</div>
	<?php  
		 $default = esc_attr( get_option('woocommerce_default_country') );
		 $country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );  

		 if ($client_country != $country)  {
		 $customs_info_description = get_option( 'pvit_shippowanderlust_customsdescription' );
		 $customs_info_contents_type = get_option( 'pvit_shippowanderlust_customstype' );

		 echo '<h4>International Order</h4>';
		 echo '<small>Product Description: </small><small>'. $customs_info_description .'</small><br>';
		 echo '<small>Contents Type: </small><small>' . $customs_info_contents_type .' *</small><br>';
		 echo '<small>* documents, gift, merchandise, returned_goods, sample, other</small>';
	} ?>
</div>


<div id="boxs-packs">

<script type="text/javascript">
jQuery(document).ready(function(){
		 jQuery('#shipment_country').val(jQuery('#tocountry option:selected').text()); 
		 jQuery('.products').hide();
		 jQuery('.removep').hide();
		 jQuery('#get_rates').hide();
		 jQuery('#generatel').hide();


		jQuery('#order-info h4 span').click(function(){
			if( jQuery('.products').is(':visible') ) {jQuery('.products').fadeOut();}
			else {jQuery('.products').fadeIn(200);}
		});

		jQuery('.removebox').click(function(){
			jQuery(this).parent().removeClass("active");
			jQuery(this).parent().fadeOut();
		});
	

		jQuery('#shipment_packages_preset').change(function(){
			//jQuery('.boxs').fadeOut();
			//jQuery('.removep').fadeIn(600);
			jQuery('#get_rates').fadeIn();
			//jQuery('.boxs').removeClass("active");
			 var box = jQuery('#shipment_packages_preset').val();
			     jQuery('#shipment_package_'+ box).addClass("active");
				 jQuery('#shipment_package_'+ box).insertAfter('#shipment_packages_container'); 
	 			 jQuery('#shipment_package_'+ box).fadeIn(200);
	 			 jQuery('#shipment_packages_weight').val(jQuery('.active ul li #weight').val()); 
	 			 jQuery('#shipment_packages_height').val(jQuery('.active ul li #height').val()); 
	 			 jQuery('#shipment_packages_length').val(jQuery('.active ul li #length').val()); 
	 			 jQuery('#shipment_packages_width').val(jQuery('.active ul li #width').val()); 
	 			 jQuery('#shipment_packages_value').val(jQuery('.active ul li #value').val()); 
			
 				if (box.length > 3) {
					//jQuery('.removep').hide(); 
					//jQuery('.boxs').fadeOut();
					//jQuery('.boxs').removeClass("active");
					//jQuery('#get_rates').hide();
 					//jQuery('#shipment_packages_container').append( '<div class="boxs flat"><input class="active" type="text" name="flat[]" value="' + jQuery('#shipment_packages_preset').val() + '"></div>');
 
				};

			return false;
		});
});
</script>

<?php 
	$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));			
 	$woocommerce_currency = get_woocommerce_currency();
			  
	// CHECK RESIDENTIAL //
	$selectedmethod = $shippingpaid[0]->order_item_name;
 	if (strpos($selectedmethod,'HOME_DELIVERY') !== false) {
		$residentials = 'checked';
	}
	// END CHECK RESIDENTIAL //			  
			  
?>
	

<h3>Package Info</h3> 
<small style="margin-top: -15px;float: left;margin-bottom: 10px;"> </small>
<small style="float: left;width: auto;">Request a signature</small>
	<select style="float: left;margin: 0px 10px;height: 25px;font-size: 9px;" id="shipment_signature">
		<option value="false">None</option>
		<option value="adult">Adult Signature</option>
		<option value="standard">Signature</option>
	</select>

<div style="float: left;clear: both;margin-top: 5px;">
	<input id="pvit_shippowanderlust_autoinsurance" style="float: left;margin: 1px 5px;" type="checkbox" name="pvit_shippowanderlust_autoinsurance" value="1" <?php checked(1, get_option('pvit_shippowanderlust_autoinsurance'));?> >	<small style="float: left;width: auto;">Insure Shipping</small> </br>
	<input id="residential_to_address" style="float: left;margin: 1px 5px;" type="checkbox" name="residential_to_address" value="1" <?php echo $residentials;?>> <small style="float: left;width: auto;">Residential Address</small> </br>
	<input id="email_label" style="float: left;margin: 1px 5px;" type="checkbox" name="pvit_shippowanderlust_email_label" value="1" <?php checked(1, get_option('pvit_shippowanderlust_email_label'));?> /><small style="float: left;width: auto;">Send Label via Email</small>
	<textarea style="float: left;clear: both;width: 265px;" id="sendtext" name="sendtext" class="replaceable-text" cols="45" rows="4" placeholder="Type your comment here"></textarea>
</div>

<?php $suma = round($sum);  echo '<h4 style="float: left;margin: 15px 0px;clear: both;">Total order weight <span style="color:#444;">' . $ordertotalw  . ' '. $weight_unit .' </span>  </h4>'; ?>

 

<h4 style="float: left;clear: both;">Choose a Box:</h4>
<?php 
			  
 $wanderlust_boxes = get_option( 'woocommerce_shipposhippingtool_settings' ); 
			  
	$table_name = $wpdb->prefix . "shippo_packages";
	$sql = "SELECT * FROM $table_name";
	$packages = $wpdb->get_results( $sql );
	$packagesn =  count($packages);
	$uspsflatboxes = get_option('pvit_shippowanderlust_usps');
	$fedexflatboxes = get_option('pvit_shippowanderlust_fedex');
	$upsflatboxes = get_option('pvit_shippowanderlust_ups');
	$dhlflatboxes = get_option('pvit_shippowanderlust_dhlbox');			  
			  

	echo '<select style="float: left;margin: 10px;" id="shipment_packages_preset">';
	echo '<option value="0">Select your Box</option>';
 	
		foreach( $wanderlust_boxes['boxes']  as $boxes ) {  
			if($boxes['enabled'] == '1'){
  				echo '<option value="'  . $boxes['name'] . '"> '  . $boxes['name'] . ' </option>';		
			}
 		}

	if ($uspsflatboxes == 1) {
		echo '<option value="Card"> Card </option>';
		echo '<option value="Letter"> Letter </option>';
		echo '<option value="Flat"> Flat </option>';
		echo '<option value="Parcel"> Parcel </option>';
		echo '<option value="LargeParcel"> LargeParcel </option>';
		echo '<option value="IrregularParcel"> IrregularParcel </option>';
		echo '<option value="FlatRateEnvelope"> FlatRateEnvelope </option>';
		echo '<option value="FlatRateLegalEnvelope"> FlatRateLegalEnvelope </option>';
		echo '<option value="FlatRatePaddedEnvelope"> FlatRatePaddedEnvelope </option>';
		echo '<option value="FlatRateGiftCardEnvelope"> FlatRateGiftCardEnvelope </option>';
		echo '<option value="FlatRateWindowEnvelope"> FlatRateWindowEnvelope </option>';
		echo '<option value="FlatRateCardboardEnvelope"> FlatRateCardboardEnvelope </option>';
		echo '<option value="SmallFlatRateEnvelope"> SmallFlatRateEnvelope </option>';
		echo '<option value="SmallFlatRateBox"> SmallFlatRateBox </option>';
		echo '<option value="MediumFlatRateBox"> MediumFlatRateBox </option>';
		echo '<option value="LargeFlatRateBox"> LargeFlatRateBox </option>';
		echo '<option value="RegionalRateBoxA"> RegionalRateBoxA </option>';
		echo '<option value="RegionalRateBoxB"> RegionalRateBoxB </option>';
		echo '<option value="RegionalRateBoxC"> RegionalRateBoxC </option>';
		echo '<option value="LargeFlatRateBoardGameBox"> LargeFlatRateBoardGameBox </option>';
	}
	if ($fedexflatboxes == 1) {
		echo '<option value="FedExEnvelope"> FedEx Envelope </option>';
		echo '<option value="FedExBox"> FedEx Box </option>';
		echo '<option value="FedExPak"> FedEx Pak </option>';
		echo '<option value="FedExTube"> FedEx Tube </option>';
		echo '<option value="FedEx10kgBox"> FedEx 10kg Box </option>';
		echo '<option value="FedEx25kgBox"> FedEx 25kg Box </option>';
	}
	if ($upsflatboxes == 1) {
		echo '<option value="UPSLetter"> UPS Letter </option>';
		echo '<option value="UPSExpressBox"> UPS Express Box </option>';
		echo '<option value="UPS25kgBox"> UPS 25kg Box </option>';
		echo '<option value="UPS10kgBox"> UPS 10kg Box </option>';
		echo '<option value="Tube"> Tube </option>';
		echo '<option value="Pak"> Pak </option>';
		echo '<option value="Pallet"> Pallet </option>';
		echo '<option value="SmallExpressBox"> Small Express Box </option>';
		echo '<option value="MediumExpressBox"> Medium Express Box </option>';
		echo '<option value="LargeExpressBox"> Large Express Box </option>';
	}
	if ($dhlflatboxes == 1) {
		echo '<option value="JumboDocument"> Jumbo Document </option>';
		echo '<option value="JumboParcel"> Jumbo Parcel </option>';
		echo '<option value="Document"> Document </option>';
		echo '<option value="DHLFlyer"> DHL Flyer </option>';
		echo '<option value="Domestic"> Domestic </option>';
		echo '<option value="ExpressDocument"> Express Document </option>';
		echo '<option value="DHLExpressEnvelope"> DHL Expres sEnvelope </option>';
		echo '<option value="JumboBox"> Jumbo Box </option>';
		echo '<option value="JumboJuniorDocument"> Jumbo Junior Document </option>';
		echo '<option value="JuniorJumboBox"> Junior Jumbo Box </option>';
		echo '<option value="JumboJuniorParcel"> Jumbo Junior Parcel </option>';
		echo '<option value="OtherDHLPackaging"> Other DHL Packaging </option>';
		echo '<option value="Parcel"> Parcel </option>';
	}
	echo '</select>';
 ?>
<a style="float: left;clear: both;margin: -15px 0px 15px 0px;font-size: 11px;" href="<?php echo wp_nonce_url(admin_url('admin.php?page=wc-settings&tab=shipping&section=wc_shipping_wanderlust_shippo#packing_options')); ?>">Manage Boxes</a>
			
<div style="display:none;" class="save" id="push-me">Save Changes</div>
<div style="display:none;"  class="add"  id="push-me2">Add Box</div>
 
<div id="shipment_packages_container">

	<div style="display:none;float: left;" class="boxs" id="shipment_add_ckage">
		<h4 style="color:#444;">New Box</h4>
			<ul>
				<li style="float:left;margin-right:5px;"><label for="boxname">Box Name:</label><br /><input style="width: 140px;" id="nombre" type="text" name="boxname" size="5" /> </li>
				<li style="float:left;margin-right:5px;"><label for="shipment_weight">Weight<span> *</span>:</label><br /><input id="weight" type="text" name="shipment_weight[]" size="5" /><?php echo  $weight_unit;?>.</li>
				<li style="float:left;margin-right:5px;"><label for="shipment_height">Height<span> *</span>:</label><br /><input id="height" type="text" name="shipment_height[]" size="5" /> <?php echo  $dimension_unit;?>.</li>
				<li style="float:left;margin-right:5px;"><label for="shipment_length">Length<span> *</span>:</label><br /><input id="length" type="text" name="shipment_length[]" size="5"  /> <?php echo  $dimension_unit;?>.</li>
				<li style="float:left;margin-right:5px;"><label for="shipment_width">Width<span> *</span>:</label><br /><input id="width" type="text" name="shipment_width[]" size="5" /> <?php echo  $dimension_unit;?>.</li>
				<li style="float:right;"><label for="shipment_value">Declared Value<span> *</span>:</label><br /><input id="value" type="text" name="shipment_value[]" size="5" /> <?php echo $woocommerce_currency; ?>.</li>
				<br style="clear:both" />
			</ul>
	</div>


	<?php
	if(!empty($wanderlust_boxes['boxes'])){		  
		foreach( $wanderlust_boxes['boxes']  as $boxes ) {  

			$boxname = $boxes['name'];  
			$height = $boxes['height']; 
			$weight = $boxes['box_weight'] + $lbs; 
			$weightoz = $boxes['box_weight'] + $sum; 
			$length = $boxes['length']; 
			$width = $boxes['width']; 
			$order_totals  = get_post_meta($order_id, '_order_total' ); 
			$order_shipping  = get_post_meta($order_id, '_order_shipping' );
			$text = $order_totals[0] - $order_shipping[0]; 
			$insurecost = $text * 0.01; 
			$boxid = $boxes['name']; 



			echo '<div style="display:none;float: left;" class="boxs" id="shipment_package_' .   $boxid .  '">';
			echo '<h4 style="color:#444;">Box: ' .    $boxname .  '</h4> <h5 style="cursor: pointer;float: left;position: absolute;margin: -34px -18px;font-size: 8px;color: white;background: rgb(165, 12, 12);border-radius: 16px;padding: 3px;width: 10px;height: 10px;line-height: 10px;text-align: center;" class="removebox">X</h5>';
			echo '<ul>';
			echo '<li style="float:left;margin-right:5px;"><label for="boxname">Box Name:</label><br /><input style="width: 140px;" id="nombre" type="text" name="boxname" size="5" value="' .    $boxname .  '" /> </li>';
			echo '<li style="float:left;margin-right:5px;"><label for="shipment_weight">Weight<span> *</span>:</label><br /><input id="weight" data-weight="' .    $weightoz .  '" type="text" name="shipment_weight[]" size="5" value="' .    $weight .  '" /> ' . $weight_unit .' .</li>';
			echo '<li style="float:left;margin-right:5px;"><label for="shipment_height">Height<span> *</span>:</label><br /><input id="height" type="text" name="shipment_height[]" size="5" value="' .    $height .  '" /> '.$dimension_unit .'.</li>';
			echo '<li style="float:left;margin-right:5px;"><label for="shipment_length">Length<span> *</span>:</label><br /><input id="length" type="text" name="shipment_length[]" size="5" value="' .    $length .  '" /> '.$dimension_unit .'.</li>';
			echo '<li style="float:left;margin-right:5px;"><label for="shipment_width">Width<span> *</span>:</label><br /><input id="width" type="text" name="shipment_width[]" size="5" value="' . $width . '" /> '.$dimension_unit .'.</li>';
			echo '<li style="float:right;"><label for="shipment_value">Declared Value<span> *</span>:</label><br /><input id="value" type="text" name="shipment_value[]" size="5" value="'. $text .'"/> '. $woocommerce_currency .'.</li>';
			echo '<br style="clear:both" /></ul>';
			echo '<div style="display:none;color: red;font-size: 11px;" class="insurance"></div>';		
			echo '</div> ';


		} 
	}
	?>	
</div>

<div style="display:none !important;"  class="removep"  id="push-me3">Delete Box</div>

<input type="hidden" value="<?php echo $sum;  ?>" id="shipment_packages_weight_flat" name="shipment_packages_weight_flat" />
<input type="hidden" value="" id="shipment_packages_weight" name="shipment_packages_weight" />
<input type="hidden" value="" id="shipment_packages_height" name="shipment_packages_height" />
<input type="hidden" value="" id="shipment_packages_length" name="shipment_packages_length" />
<input type="hidden" value="" id="shipment_packages_width" name="shipment_packages_width" />
<input type="hidden" value="" id="shipment_packages_value" name="shipment_packages_value" />
<input type="hidden" value="" id="shipment_country" name="shipment_country" />
<input type="hidden" value="<?php echo $prefixbox;  ?>" id="prefixbox" name="prefixbox" />
<input type="hidden" value="<?php echo $text;  ?>" id="insurances" name="insurances" />			
			

<div id="flash" style="float: left;clear: both;display:none;" ><img  style="width: 20px;" src="<?php echo plugins_url('includes/img/ajax-loader.gif',dirname(__FILE__));?>" align="absmiddle"> <span class="loading">Loading...</span></div>
<div style="float: left;clear: both;display:none;" id="test-div"></div>	
<div id="get_rates" style="width: 230px;clear: both;float: left;"    class="button-primary" />Get Rates</div>
</div>
	</div>
<br style="clear: both" />
</div>
<p style="margin-top: 10px; width: 100%; clear: both;">
<div id="generatel" class="button-primary" style="display: inline-block; text-align: center;">Buy Label</div>
</form>
</div>


 <script type="text/javascript"> 
	jQuery('body').on('click', '.print',function(e){
		e.preventDefault();
			  var image = jQuery(this).data("imgid");
			  var win = window.open('', 'Image', 'resizable=yes,...');
			  if (win.document) {
			
 				win.document.writeln('<style type="text/css" media="print">');
			    win.document.writeln(".page {margin: none;max-width: 100% !important;}.print {display: none !important;}");
      			win.document.writeln("</style>");	 
				  
      			win.document.writeln("<style type='text/css' media='screen'>");
      			win.document.writeln(".print {background-color: #f2f2f2;border: 1px solid #bbb;border-radius: 11px;-webkit-border-radius: 11px;-moz-border-radius: 11px;color: #000;display: block;font-size: .90em;height: 22px;width: 30px;line-height: 22px;padding-left: 20px;padding-right: 20px;text-decoration: none;margin-top: 7px;font: normal 14px/150% Verdana, Arial, Helvetica, sans-serif;}");  
      			win.document.writeln("</style>");				  
				  
				win.document.writeln('<a class="print" href="#" onclick="window.print()">Print</a><br class="print">');
				win.document.writeln('<img style="width: 340px;" src="'+ image +'" alt="image" />');
			  }
		  return false;
	});

</script>

<?php }  ?> 