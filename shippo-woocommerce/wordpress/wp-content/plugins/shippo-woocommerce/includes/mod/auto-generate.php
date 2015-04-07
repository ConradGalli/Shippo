<?php

	$woocommerce_easypost_autogen = get_option( 'pvit_shippowanderlust_autogen' ); //check if auto label is enabled
	if($woocommerce_easypost_autogen == 1){
		add_action( 'woocommerce_order_status_processing', 'purchase_order');
	}

	function purchase_order($order_id) { 
 		
		$order = new WC_Order( $order_id );
		//if ($order->status == 'processing') {
		
 		try {
			  $woocommerce_easypost_test = get_option( 'pvit_shippowanderlust_shipper_test' );
			  $woocommerce_easypost_test_api_key = get_option( 'pvit_shippowanderlust_testkey' );
			  $woocommerce_easypost_live_api_key = get_option( 'pvit_shippowanderlust_livekey' );
			  $woocommerce_easypost_customs_info_description = get_option( 'pvit_shippowanderlust_customsdescription' );
			  $woocommerce_easypost_customs_info_hs_tariff_number = get_option( 'pvit_shippowanderlust_customshs' );
			  $woocommerce_easypost_customs_info_contents_type = get_option( 'pvit_shippowanderlust_customstype' );
			  $woocommerce_easypost_company = get_option( 'pvit_shippowanderlust_sender_company' ); 
			  $woocommerce_easypost_street1 = get_option( 'pvit_shippowanderlust_sender_address1' );
			  $woocommerce_easypost_city = get_option( 'pvit_shippowanderlust_shipper_city' );
			  $woocommerce_easypost_state = get_option( 'pvit_shippowanderlust_sender_state' );
			  $woocommerce_easypost_zip = get_option( 'pvit_shippowanderlust_shipper_zipcode' );
			  $woocommerce_easypost_phone = get_option( 'pvit_shippowanderlust_shipper_phone' );
			  $woocommerce_easypost_country = get_option( 'pvit_shippowanderlust_shipper_country' );
			  $send_email = get_option( 'pvit_shippowanderlust_email_label' );
			  $woocommerce_easypost_insurance = get_option( 'pvit_shippowanderlust_autoinsurance_cost' );		
 	

			  //$chosen_shipping_methods = $woocommerce->session->get( 'chosen_shipping_methods' );
			  error_log(var_export($chosen_shipping_methods,1));
			  $wooorder        = new WC_Order($order_id);
			  $shipping     = $order->get_shipping_address();

			  $method = $wooorder->get_shipping_methods();
			  $method = array_values($method);
			  $shipping_method = $method[0]['method_id'];
			  $ship_arr = explode('|',$shipping_method);
			  $ship_arrb = explode('-',$ship_arr[0]);
 
			  if(count($ship_arr) >= 2){
				 				  
 				 
				  
 				$order->to_address->name = sprintf("%s %s", $wooorder->shipping_first_name, $wooorder->shipping_last_name);
				$order->to_address->phone = $wooorder->billing_phone;

 				$name = str_replace("\'","'", $order->to_address->name);
 				$company = str_replace("\'","'", $order->to_address->company);
				$street1 = str_replace("\'","'", $order->to_address->street1);
				$street2 = str_replace("\'","'", $order->to_address->street2);
				$city = str_replace("\'","'", $order->to_address->city);
				  
			 
				  if($order->to_address->country == 'US') { $to_address = $to_address->verify(); }

				 
			 
					$countlabels = 0;
					// CHECK ALL SHIMPMENTS -- STARTS
					foreach($order['shipments'] as $shipment)  {
						$countlabels++; 

						// UPDATE ORDER INFO -- STARTS
						$today = date("m/d/Y"); 
						$date = strtotime( date('Y-m-d') );
						$tracking_provider = strtolower($shipment->selected_rate->carrier);
						update_post_meta($order_id, 'easypost_shipping_label_' . $countlabels, $shipment->postage_label->label_url); 
						update_post_meta($order_id, '_tracking_number',  $shipment->tracking_code);
						update_post_meta($order_id, '_tracking_provider', $tracking_provider );   
						update_post_meta($order_id, '_date_shipped', $date);
						update_post_meta($order_id, '_wanderlustshipid', $shipment->id);
						update_post_meta($order_id, '_wanderlustshiporderid', $_SESSION['multilabel']);				
						$wooorder->update_status('completed', 'order_note'); //check this			

						$wooorder->add_order_note(
							sprintf(
							  "Shipping label available at: '%s'",
							  $shipment->postage_label->label_url
							)
						);

						$wooorder->add_order_note(
							sprintf(
							  "Tracking Code: '%s'",
							  $shipment->tracking_code
							)
						);	
						// UPDATE ORDER INFO -- ENDS

						// SEND VIA EMAIL -- STARTS
						if ($_SESSION['send_email'] == 1) {
							$sendto = get_option( 'pvit_shippowanderlust_email_label_to' );  
								if (!empty($sendto)){ 
									$sendfrom = get_option( 'pvit_shippowanderlust_email_label_from' );
									$mesage = $sendtext;
									$mailer = new AttachMailer($sendfrom, $sendto, "Shipping Label", $mesage);
									$mailer->attachFile($shipment->postage_label->label_url);
									$mailer->send() ? "envoye": "probleme envoi";
								}  
						}   
						// SEND VIA EMAIL -- ENDS

						// SAVE LABEL ON FTP -- STARTS
						$save_path = plugin_dir_path ( __FILE__ ) . 'generated_labels/';
						$save_url = plugin_dir_url(dirname(__FILE__)) . 'mod/generated_labels/';
						$fp = fopen($save_path . $shipment->tracking_code . '.png', 'wb'); //Create PNG or PDF file
						$content = file_get_contents($shipment->postage_label->label_url);
						fwrite($fp, $content); 
						fclose($fp);
						// SAVE LABEL ON FTP -- ENDS

						// SHOW LABEL IMAGES -- STARTS
						echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $save_url . $shipment->tracking_code .'.png"><a href="#"><img src="'. $save_url . $shipment->tracking_code .'.png" width="150" height="auto" alt="'. $shipment->selected_rate->service .'" title="'. $shipment->selected_rate->service .'"></a></div>';
						// SHOW LABEL IMAGES -- ENDS
					}
					// CHECK ALL SHIMPMENTS -- ENDS  
			  }
			}
 	catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	  
	} //ENDS BUY LABEL