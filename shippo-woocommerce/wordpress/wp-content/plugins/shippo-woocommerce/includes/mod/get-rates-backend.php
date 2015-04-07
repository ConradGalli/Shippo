<?php
function getrates_shippo(){
	
	$default = esc_attr( get_option('woocommerce_default_country') );
	$woocommerce_currency = get_woocommerce_currency();

	$country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );  

	$woocommerce_shippo_customs_info_description = get_option( 'pvit_shippowanderlust_customsdescription' );
	$woocommerce_shippo_customs_info_hs_tariff_number = get_option( 'pvit_shippowanderlust_customshs' );
	$woocommerce_shippo_customs_info_contents_type = get_option( 'pvit_shippowanderlust_customstype' );
	$woocommerce_shippo_company = get_option( 'pvit_shippowanderlust_sender_company' ); 
 	$woocommerce_shippo_sender_name = get_option( 'pvit_shippowanderlust_sender_name' ); 
	$woocommerce_shippo_street1 = get_option( 'pvit_shippowanderlust_sender_address1' );
	$woocommerce_shippo_city = get_option( 'pvit_shippowanderlust_shipper_city' );
	$woocommerce_shippo_state = get_option( 'pvit_shippowanderlust_sender_state' );
	$woocommerce_shippo_zip = get_option( 'pvit_shippowanderlust_shipper_zipcode' );
	$woocommerce_shippo_phone = get_option( 'pvit_shippowanderlust_shipper_phone' );
	$woocommerce_shippo_country = get_option( 'pvit_shippowanderlust_shipper_country' );
	$woocommerce_shippo_email = get_option( 'pvit_shippowanderlust_shipper_email' );		


	$order_id =  $_POST ['orderid'];
	$order = new WC_Order ( $order_id  );

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
		
 	$name = str_replace("\'","'", $client_name);
 	$company = str_replace("\'","'", $client_company);
 	$street1 = str_replace("\'","'", $client_address1a);
 	$street2 = str_replace("\'","'", $client_address2);
 	$city = str_replace("\'","'", $client_city);
	$domestic = 'no';
	if($woocommerce_shippo_country == $client_country ){ $domestic = 'yes'; }	

 	$largocaja = $_POST ['lengthnuevo'];
 	$anchocaja =$_POST ['widthnuevo'];
 	$altocaja =$_POST ['heightnuevo'];
 	$valorpaquete =$_POST ['valuenuevo']; 
 	$shipping_info ['items'] = $shipping_info_items;
 	$shipping_info ['total_weight'] = $total_weight;
 	$pesototal =$_POST ['weightnuevo'];
 	$shipment_signature =$_POST ['shipment_signature'];
 	$residential_to_address =$_POST ['residential_to_address'];
 	$flatbox = $_POST ['service']; 
 
 	session_start();
 	$_SESSION['service'] = $_POST ['service']; 
 	$_SESSION['pesototal'] = $_POST ['weightnuevo']; 
 	$_SESSION['residential_to_address'] = $_POST ['residential_to_address'];

 	$items = $order->get_items();
 	$productinorder =  count($items);
 	$weight_unit = esc_attr( get_option('woocommerce_weight_unit' ));     
 	$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
		
 	$weight_unitsadd = 0;
 	if ($weight_unit=='lbs') { $weight_unitsadd = 16;}
 	if ($weight_unit=='oz') { $weight_unitsadd = 1;}
 	if ($weight_unit=='g') { $weight_unitsadd =  0.035274;}
 	if ($weight_unit=='kg') { $weight_unitsadd = 35.274;}	
		
  	$dimensionmul = 0;
 	if ($dimension_unit == 'in') { $dimensionmul = 1;}
 	if ($dimension_unit == 'm') { $dimensionmul =  39.3701;}
 	if ($dimension_unit == 'cm') { $dimensionmul =  0.393701;}
 	if ($dimension_unit == 'mm') { $dimensionmul =  0.0393701;}
 	if ($dimension_unit == 'yd') { $dimensionmul =  36;}		

  	$customs_item = array();

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
 										$hs_number  = get_post_meta($productid, '_hs_number' ); 
 										if(empty($hs_number)){$hs_number = $woocommerce_shippo_customs_info_hs_tariff_number;}
										$pweight = $productidweight[0] * $item['item_meta']['_qty']['0'];
										$i++; 
										$prod += $item['item_meta']['_qty']['0']; 
										$sum += $pweight; 
										$totales[] = $item['item_meta']['_qty']['0'];
										$variation = $item['variation_id'];
 										$product_weight = $pweight;

										if ( ! empty( $variation) ) { 	
											$productidweight2  = get_post_meta($variation, '_weight' ); 
											$prodcutdimentionslength2 = get_post_meta($variation, '_length');
											$prodcutdimentionswidth2 = get_post_meta($variation, '_width');
											$prodcutdimentionsheight2 = get_post_meta($variation, '_height'); 
											$pweightb = $productidweight2[0] * $item['item_meta']['_qty']['0'];
											if(!empty( $pweightb)) { $product_weight = $pweightb; }
											$sum += $pweight + $pweightb;
										} 
										if($domestic == 'no'){
											$customs_item[] = array(
												'description'=> 'T-Shirt',
												'quantity'=> '1',
												'net_weight'=> '1',
												'mass_unit'=> 'lb',
												'value_amount'=> '20',
												'value_currency'=> 'USD',
												'origin_country'=> 'US'									
											);
										}
									} 
								}  $itemtotales = array_sum($totales); 
	 }
		
		
 
			

	try {      

		
		$customs_declaration = Shippo_CustomsDeclaration::create(
		array(
			'contents_type'=> $woocommerce_shippo_customs_info_contents_type,
			'contents_explanation'=> $woocommerce_shippo_customs_info_description,
			'non_delivery_option'=> 'RETURN',
			'certify'=> 'true',
			'certify_signer'=> $woocommerce_shippo_company,
			'items'=> $customs_item
		));		
		
		if(empty($client_company)){ $residential = null;} else {$residential = true;}

		$to_address = 
				array(
					'object_purpose' => 'PURCHASE',
					'name'    => $name,
					'company' => $company,
					'street1' => $street1,
					'street2' => $street2,
					'city'    => $city,
					'state'   => $client_state,
					'zip'     => $client_zip,
					'country' => $client_country,
					'phone'   => $client_phone,
					'email' => $client_email,
			);
 		
 		$from_address =  array(
				'object_purpose' => 'PURCHASE',
				'name' => $woocommerce_shippo_sender_name,
				'company' => $woocommerce_shippo_company,
				'street1' => $woocommerce_shippo_street1,
				'city' => $woocommerce_shippo_city,
				'state' => $woocommerce_shippo_state,
				'zip' => $woocommerce_shippo_zip,
				'country' => $woocommerce_shippo_country,
				'phone' => $woocommerce_shippo_phone,
				'email' => $woocommerce_shippo_email
		);
 


				$parcel = array(
					'length'=> $largocaja,
					'width'=> $anchocaja,
					'height'=> $altocaja,
					'distance_unit'=> 'in',
					'weight'=> $pesototal,
					'mass_unit'=> 'lb',
				);
		
				if($domestic =='no'){
					$shipment = Shippo_Shipment::create( array(
						'object_purpose'=> 'PURCHASE',
						'address_from'=> $from_address,
						'address_to'=> $to_address,
						'parcel'=> $parcel,
						'submission_type'=> 'PICKUP',
						'insurance_amount'=> $valorpaquete,
						'insurance_currency'=> $woocommerce_currency,
						'extra'=> '{"signature_confirmation": true}',
						'customs_declaration'=> $customs_declaration["object_id"]
					)); 					
				} else {
					$shipment = Shippo_Shipment::create( array(
						'object_purpose'=> 'PURCHASE',
						'address_from'=> $from_address,
						'address_to'=> $to_address,
						'parcel'=> $parcel,
						'submission_type'=> 'PICKUP',
						'insurance_amount'=> $valorpaquete,
						'insurance_currency'=> $woocommerce_currency,
						'extra'=> '{"signature_confirmation": true}',
					)); 					
				}
			


			
				//Wait for rates to be generated
				$attempts = 0;
				while (($shipment["object_status"] == "QUEUED" || $shipment["object_status"] == "WAITING") && $attempts < 10){
					$shipment = Shippo_Shipment::retrieve($shipment["object_id"]);
					$attempts +=1;}

				//Get all rates for shipment.
				$rates = Shippo_Shipment::get_shipping_rates(array('id'=> $shipment["object_id"]));

				foreach ($rates["results"] as $key) {

					if ($key['provider'] == 'Fedex') {
						if($key['servicelevel_name'] == 'Ground') {
							$rate = $key['object_id'];
						}
					}
				}			 				 

			echo '<div>';
			echo '<h3>Shipping Rates </h3>';
			echo '<select id="service_option" name="service_selection">';
			   foreach ($rates["results"] as $key) { 
					echo '<option value="'. $key["object_id"] . '">' . '$' . $key["amount"] . ' - ' . $key["provider"] . ', '. $key["servicelevel_name"] . '</option>';
				}
			echo '</select>'; 
			echo '</div>';
		 
	
	} catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
die();}