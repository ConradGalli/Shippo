<?php
	function buylabel_shippo(){
			$shippowanderlust_completed = get_option( 'pvit_shippowanderlust_completed' );
			$order_id =  $_POST ['order_id'];
			$orders = new WC_Order ( $order_id  );
			$sendtext = $_POST ['sendtext'];
			session_start();
			$_SESSION['shipservice'] = $_POST ['shipservice'];

			try {
					$transaction = Shippo_Transaction::create(array('rate'=> $_SESSION['shipservice']));
					$attempts = 0;
					while (($transaction["object_status"] == "QUEUED" || $transaction["object_status"] == "WAITING") && $attempts < 10){
						$transaction = Shippo_Transaction::retrieve($transaction["object_id"]);
						$attempts +=1;}


					if ($transaction["object_status"] == "SUCCESS"){
					} else {
						echo($transaction["messages"]);
					}
				
					 
					  $date = strtotime( date('Y-m-d') );
					  $tracking_provider = strtolower($transaction['messages'][0]['source']);
 					  update_post_meta($order_id, 'shippo_shipping_label_1', $transaction['label_url']); 
					  update_post_meta($order_id, '_tracking_number',  $transaction['tracking_number']);
					  update_post_meta($order_id, '_tracking_provider', $tracking_provider );   
					  update_post_meta($order_id, '_date_shipped', $date);
					  update_post_meta($order_id, '_transaction_shippo', $transaction);
					  if($shippowanderlust_completed == '1') {$orders->update_status('completed', 'order_note');}
					  
						$orders->add_order_note(
						  sprintf(
							  "Shipping label available at: '%s'",
							  $transaction['label_url']
						  )
						);

						$orders->add_order_note(
						  sprintf(
							  "Tracking Code: '%s'",
							  $transaction['tracking_number']
						  )
						);
      

	
						$save_path = plugin_dir_path ( __FILE__ ) . 'generated_labels/';
						$save_url = plugin_dir_url(dirname(__FILE__)) . 'mod/generated_labels/';
	
						$fp = fopen($save_path . $transaction['tracking_number'] . '.png', 'wb');
						$content = file_get_contents($transaction['label_url']);
						fwrite($fp, $content); //Create PNG or PDF file
						fclose($fp);
	
						echo '<h3>Shipping Label</h3>';   
						echo  '<div style="cursor: pointer;" class="print"  data-imgid="'. $save_url . $transaction['tracking_number'] .'.png"><a href="#"><img src="'. $save_url .  $transaction['tracking_number'] .'.png" width="150" height="auto" alt="'. $transaction['tracking_number'] .'" title="'. $transaction['tracking_number'] .'"></a></div>';
 						
			} catch (Exception $e) {
				echo 'Caught exception: ',  $e->getMessage(), "\n"; // ERRORS -- STARTS/ENDS
			}
		die();
	} // END FUNCTION //
	add_action('buylabel_hook', 'buylabel');
?>