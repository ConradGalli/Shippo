<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Shipping_Wanderlust_Shippo class.
 *
 * @extends WC_Shipping_Method
 */
class WC_Shipping_Wanderlust_Shippo extends WC_Shipping_Method {
	private $found_rates;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id                               = 'shipposhippingtool';
		$this->method_title                     = __( 'Shippo Shipping Tool', 'wc_wanderlust' );
		$this->method_description               = __( 'The <strong>Shippo Shipping Tool</strong> extension obtains rates dynamically from the Shippo API during cart/checkout.', 'wc_wanderlust' );
		$this->init();
	}

    /**
     * init function.
     */
    private function init() {
    	global $woocommerce;
		// Load the settings.
		$this->init_form_fields();
		$this->init_settings();

		// Define user set variables
		$this->title           = $this->get_option( 'title', $this->method_title );
		$this->availability    = $this->get_option( 'availability', 'all' );
		$this->countries       = $this->get_option( 'countries', array() );
		$this->filter_rates    = explode(",", $this->get_option( 'filter_rates' ));
		$this->order_rates = $this->get_option( 'order_rates' );
		$this->show_fedex_rates = $this->get_option( 'show_fedex_rates' );
		$this->show_usps_rates = $this->get_option( 'show_usps_rates' );
		$this->show_ups_rates = $this->get_option( 'show_ups_rates' );
		$this->show_dhl_rates = $this->get_option( 'show_dhl_rates' );
		$this->show_canada_rates = $this->get_option( 'show_canada_rates' );
		$this->extrachargefedex     = $this->get_option( 'extrachargefedex' );
		$this->extrachargeusps     = $this->get_option( 'extrachargeusps' );
		$this->extrachargeups     = $this->get_option( 'extrachargeups' );
		$this->extrachargecanada     = $this->get_option( 'extrachargecanada' );	
		$this->extrachargedhl     = $this->get_option( 'extrachargedhl' );		
		$this->debug           = ( $bool = $this->get_option( 'debug' ) ) && $bool == 'yes' ? true : false;
		$this->insure_contents = ( $bool = $this->get_option( 'insure_contents' ) ) && $bool == 'yes' ? true : false;
		$this->shipment_signature = $this->get_option( 'shipment_signature' );
		$this->packing_method  = $this->get_option( 'packing_method', 'per_item' );
		$this->boxes           = $this->get_option( 'boxes', array( ));
		$this->residential     = ( $bool = $this->get_option( 'residential' ) ) && $bool == 'yes' ? true : false;
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
	}
     /**
     * Output a message
     */
    public function debug( $message, $type = 'notice' ) {
    	if ( $this->debug ) {
    		if ( version_compare( WOOCOMMERCE_VERSION, '2.1', '>=' ) ) {
    			wc_add_notice( $message, $type );
    		} else {
    			global $woocommerce;

    			$woocommerce->add_message( $message );
    		}
		}
    }

 	/**
	 * admin_options function.
	 */
	public function admin_options() {
		// Show settings
		parent::admin_options();
	}

    /**
     * init_form_fields function.
     */
    public function init_form_fields() {
	    $this->form_fields  = include( 'data/data-settings.php' );
    }

	/**
	 * generate_box_packing_html function.
	 */
	public function generate_box_packing_html() {
		ob_start();
		include( 'views/html-box-packing.php' );
		return ob_get_clean();
	}

	/**
	 * validate_box_packing_field function.
	 *
	 * @param mixed $key
	 */
	public function validate_box_packing_field( $key ) {
 		$boxes_name     = isset( $_POST['boxes_name'] ) ? $_POST['boxes_name'] : array();
		$boxes_length     = isset( $_POST['boxes_length'] ) ? $_POST['boxes_length'] : array();
		$boxes_width      = isset( $_POST['boxes_width'] ) ? $_POST['boxes_width'] : array();
		$boxes_height     = isset( $_POST['boxes_height'] ) ? $_POST['boxes_height'] : array();
		$boxes_box_weight = isset( $_POST['boxes_box_weight'] ) ? $_POST['boxes_box_weight'] : array();
		$boxes_max_weight = isset( $_POST['boxes_max_weight'] ) ? $_POST['boxes_max_weight'] :  array();
		$boxes_enabled    = isset( $_POST['boxes_enabled'] ) ? $_POST['boxes_enabled'] : array();

		$boxes = array();

		if ( ! empty( $boxes_length ) && sizeof( $boxes_length ) > 0 ) {
			for ( $i = 0; $i <= max( array_keys( $boxes_length ) ); $i ++ ) {

				if ( ! isset( $boxes_length[ $i ] ) )
					continue;

				if ( $boxes_length[ $i ] && $boxes_width[ $i ] && $boxes_height[ $i ] ) {
 					$boxes[] = array(
 						'name'     =>  $boxes_name[ $i ] ,
						'length'     => floatval( $boxes_length[ $i ] ),
						'width'      => floatval( $boxes_width[ $i ] ),
						'height'     => floatval( $boxes_height[ $i ] ),
						'box_weight' => floatval( $boxes_box_weight[ $i ] ),
						'max_weight' => floatval( $boxes_max_weight[ $i ] ),
						'enabled'    => isset( $boxes_enabled[ $i ] ) ? true : false
					);
				}
			}
		}
		return $boxes;
	}

	 

    /**
     * Get packages - divide the WC package into packages/parcels suitable for a wanderlust quote
     */
    public function get_wanderlust_packages( $package ) {
    	switch ( $this->packing_method ) {
	    	case 'box_packing' :
	    		return $this->box_shipping( $package );
	    	break;
	    	case 'per_item' :
	    	default :
	    		return $this->per_item_shipping( $package );
	    	break;
    	}
    }


    /**
     * per_item_shipping function.
     *
     * @access private
     * @param mixed $package
     * @return array
     */
    private function per_item_shipping( $package ) {
    	global $woocommerce;

            $weight_unit = get_option('woocommerce_weight_unit');     
            $dimension_unit = get_option('woocommerce_dimension_unit' );
	    $to_ship  = array();
	    $group_id = 1;


    	// Get weight of order
    	foreach ( $package['contents'] as $item_id => $values ) {

    		if ( ! $values['data']->needs_shipping() ) {
    			$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wc_wanderlust' ), $item_id ), 'error' );
    			continue;
    		}

    		if ( ! $values['data']->get_weight() ) {
	    		$this->debug( sprintf( __( 'Product # is missing weight. Aborting.', 'wc_wanderlust' ), $item_id ), 'error' );
	    		return;
    		}

    		$group = array();
 
    		$group = array(
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => $values['quantity'],
				'Weight' => array(
					'Value' => max( '0.5', round( woocommerce_get_weight( $values['data']->get_weight(), $weight_unit ), 2 ) ),
					'Units' => $weight_unit
		    	),
		    	'packed_products' => array( $values['data'] )
    		);

			if ( $values['data']->length && $values['data']->height && $values['data']->width ) {

				$dimensions = array( $values['data']->length, $values['data']->width, $values['data']->height );

				sort( $dimensions );

				$group['Dimensions'] = array(
					'Length' => max( 1, round( woocommerce_get_dimension( $dimensions[2], 'in' ), 2 ) ),
					'Width'  => max( 1, round( woocommerce_get_dimension( $dimensions[1], 'in' ), 2 ) ),
					'Height' => max( 1, round( woocommerce_get_dimension( $dimensions[0], 'in' ), 2 ) ),
					'Units'  => $dimension_unit
				);
			}

			$group['InsuredValue'] = array( 
				'Amount'   => round( $values['data']->get_price() * $values['quantity'] ), 
				'Currency' => get_woocommerce_currency() 
			);

			$to_ship[] = $group;

			$group_id++;
    	}
 		return $to_ship;
    }

    /**
     * box_shipping function.
     *
     * @access private
     * @param mixed $package
     * @return array
     */
    private function box_shipping( $package ) {
    	global $woocommerce;

            $weight_unit = get_option('woocommerce_weight_unit');     
            $dimension_unit = get_option('woocommerce_dimension_unit' );
	  	if ( ! class_exists( 'WC_Boxpack' ) )
	  		include_once 'box-packer/class-wc-boxpack.php';

	    $boxpack = new WC_Boxpack();

	    // Define boxes
		foreach ( $this->boxes as $key => $box ) {
			if ( ! is_numeric( $key ) )
				continue;

			if ( ! $box['enabled'] )
				continue;

			$newbox = $boxpack->add_box( $box['length'], $box['width'], $box['height'], $box['box_weight'] );

			if ( isset( $box['id'] ) )
				$newbox->set_id( $box['id'] );

			if ( $box['max_weight'] )
				$newbox->set_max_weight( $box['max_weight'] );
		}

		// Add items
		foreach ( $package['contents'] as $item_id => $values ) {

			if ( ! $values['data']->needs_shipping() ) {
    			$this->debug( sprintf( __( 'Product # is virtual. Skipping.', 'wc_wanderlust' ), $item_id ), 'error' );
    			continue;
    		}

			if ( $values['data']->length && $values['data']->height && $values['data']->width && $values['data']->weight ) {

				$dimensions = array( $values['data']->length, $values['data']->height, $values['data']->width );

				for ( $i = 0; $i < $values['quantity']; $i ++ ) {
					$boxpack->add_item(
						woocommerce_get_dimension( $dimensions[2], 'in' ),
						woocommerce_get_dimension( $dimensions[1], 'in' ),
						woocommerce_get_dimension( $dimensions[0], 'in' ),
						woocommerce_get_weight( $values['data']->get_weight(), $weight_unit ),
						$values['data']->get_price(),
						array(
							'data' => $values['data']
						)
					);
				}

			} else {
				$this->debug( sprintf( __( 'Product # is missing dimensions. Aborting.', 'wc_wanderlust' ), $item_id ), 'error' );
				return;
			}
		}

		// Pack it
		$boxpack->pack();

		// Get packages
		$packages = $boxpack->get_packages();
		$to_ship  = array();
		$group_id = 1;

		foreach ( $packages as $package ) {

			$dimensions = array( $package->length, $package->width, $package->height );

			sort( $dimensions );

    		$group = array(
				'GroupNumber'       => $group_id,
				'GroupPackageCount' => 1,
				'Weight' => array(
					'Value' => max( '0.5', round( $package->weight, 2 ) ),
					'Units' => $weight_unit
		    	),
		    	'Dimensions'        => array(
					'Length' => max( 1, round( $dimensions[2], 2 ) ),
					'Width'  => max( 1, round( $dimensions[1], 2 ) ),
					'Height' => max( 1, round( $dimensions[0], 2 ) ),
					'Units'  => $dimension_unit
				),
				'InsuredValue'      => array( 
					'Amount'   => round( $package->value ), 
					'Currency' => get_woocommerce_currency() 
				),
				'packed_products' => array()
    		);
			
    		foreach ( $package->packed as $packed ) {
    			$group['packed_products'][] = $packed->get_meta( 'data' );
    		}

    		$to_ship[] = $group;

    		$group_id++;
		}
		if($this->debug == 'yes') {	echo '<pre style="height:200px;">' . print_r( $to_ship, true ) . '</pre>'; }

		return $to_ship;
    }

    
    private function get_weight_ratio() {
        //units conversion
        //weight to oz
        $weight_units = array(
            'kg' => 35.274,
            'g' => 0.035274,
            'lbs' => 16,
            'oz' => 1,
        );
        $weight_unit_ratio = $weight_units[get_option('woocommerce_weight_unit')];
        return $weight_unit_ratio;
    }
 
    /**
     * get_wanderlust_requests function.
     *
     * @access private
     * @return void
     */
    private function get_wanderlust_requests( $wanderlust_packages, $package ) {
	   	global $woocommerce, $wpdb;

            $weight_unit = get_option('woocommerce_weight_unit');     
            $dimension_unit = get_option('woocommerce_dimension_unit' );
			$woocommerce_shippo_customs_info_description = get_option( 'pvit_shippowanderlust_customsdescription' );
			$woocommerce_shippo_customs_info_hs_tariff_number = get_option( 'pvit_shippowanderlust_customshs' );
			$woocommerce_shippo_customs_info_contents_type = get_option( 'pvit_shippowanderlust_customstype' );
			$woocommerce_shippo_company = get_option( 'pvit_shippowanderlust_sender_company' ); 
			$woocommerce_shippo_street1 = get_option( 'pvit_shippowanderlust_sender_address1' );
			$woocommerce_shippo_city = get_option( 'pvit_shippowanderlust_shipper_city' );
			$woocommerce_shippo_state = get_option( 'pvit_shippowanderlust_sender_state' );
			$woocommerce_shippo_zip = get_option( 'pvit_shippowanderlust_shipper_zipcode' );
			$woocommerce_shippo_phone = get_option( 'pvit_shippowanderlust_shipper_phone' );
			$woocommerce_shippo_country = get_option( 'pvit_shippowanderlust_shipper_country' );
			$woocommerce_shippo_insurance = get_option( 'pvit_shippowanderlust_autoinsurance' );	
			$woocommerce_shippo_email = get_option( 'pvit_shippowanderlust_shipper_email' );		
			$woocommerce_currency = get_woocommerce_currency();
			$woocommerce_shippo_username = get_option( 'pvit_shippowanderlust_username' );
			$woocommerce_shippo_password = get_option( 'pvit_shippowanderlust_password' );
			Shippo::setCredentials($woocommerce_shippo_username, $woocommerce_shippo_password);

 
	    $customer = $woocommerce->customer;
				
	    try {
			if (empty($customer->shipping_country)){
					$to_address =  array(
 						'object_purpose' => 'QUOTE',
						'street1'    => $customer->get_address(),
						'street2' => $customer->get_address_2(),		
						'city'    => $customer->get_city(),
						'state'   => $customer->get_state(),
						'zip'    => $customer->get_postcode(),
						'country'  => $customer->get_country(),				
					  );		
			} else {
					$to_address =  array(
 						'object_purpose' => 'QUOTE',
						'street1'    => $customer->get_shipping_address(),
						'street2' => $customer->get_shipping_address_2(),						
						'city'    => $customer->get_shipping_city(),
						'state'   => $customer->get_shipping_state(),
						'zip'    => $customer->get_shipping_postcode(),
						'country'  => $customer->get_shipping_country(),				
					  );		
			}			 
 		
			$from_address =  array(
					'object_purpose' => 'QUOTE',
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
			
			$weight_unitsa = $wanderlust_packages[0]['Weight']['Units'];		
			$sum = 0;
			if ($weight_unitsa=='lbs') { $sum = 16;}
			if ($weight_unitsa=='oz') { $sum = 1;}
			if ($weight_unitsa=='g') { $sum =  0.035274;}
			if ($weight_unitsa=='kg') { $sum = 35.274;}

			$dimension_unit = esc_attr( get_option('woocommerce_dimension_unit' ));
			$dimensionmul = 0;
			if ($dimension_unit == 'in') { $dimensionmul = 1;}
			if ($dimension_unit == 'm') { $dimensionmul =  39.3701;}
			if ($dimension_unit == 'cm') { $dimensionmul =  0.393701;}
			if ($dimension_unit == 'mm') { $dimensionmul =  0.0393701;}
			if ($dimension_unit == 'yd') { $dimensionmul =  36;}
			
			$boxes = array();	
			foreach($wanderlust_packages as $singlebox){
			$quantity = $singlebox['GroupPackageCount'];
			$lenght = $singlebox['Dimensions']['Length'] * $dimensionmul * $quantity;
			$width = $singlebox['Dimensions']['Width'] * $dimensionmul * $quantity;
			$height = $singlebox['Dimensions']['Height'] * $dimensionmul * $quantity;
			$weight = $singlebox['Weight']['Value'] * $sum * $quantity;
			$boxes[] = 
				array(
						'length' => $lenght, 
						'width' => $width, 
						'height' => $height,
				    	'distance_unit'=> 'in',
						'weight' => $weight,
				    	'mass_unit'=> 'lb',
				);				
			
		}				

				if ($to_address->country != $from_address->country) {
                    //international shipment
                    // CustomsItem: create     
					$weight_unit_ratio = $this->get_weight_ratio();
                    $customs_items = array();
                    foreach ($woocommerce->cart->get_cart() as $package) {
                        $productId = $package['product_id'];
                        $item = get_product($productId);
                        $quantity = $package['quantity'];
                        $weight = $item->get_weight();
                        //check if variable product
                        if ($item->is_type('variable')) {
                            $variation_id = $package['data']->variation_id;
                            $product_variatons = new WC_Product_Variation($variation_id);
                            $weight = $product_variatons->get_weight();
                        }
						//example CustomsItems object. This is only required for int'l shipment only.
						$customs_item[] = array(
							'description'=> get_post_meta($productId, '_shippo_product_description', true),
							'quantity'=> $quantity,
							'net_weight'=> ceil($weight * $weight_unit_ratio),
							'mass_unit'=> 'in',
							'value_amount'=> $item->get_price(),
							'value_currency'=> 'USD',
							'origin_country'=> $from_address->country
						);

                    }
					#Creating the CustomsDeclaration
					#(CustomsDeclarations are only required for international shipments)
					$customs_declaration = Shippo_CustomsDeclaration::create(
					array(
						'contents_type'=> $woocommerce_easypost_customs_info_contents_type,
						'contents_explanation'=> '',
						'non_delivery_option'=> 'RETURN',
						'certify'=> 'true',
						'certify_signer'=> $from_address->name,
						'items'=> $customs_item
					));
                }

			if($this->insure_contents == 'true'){
				$insurance = $woocommerce->cart->total;
			} else {
				$insurance = 0;
			}
$shipment_signature = $this->shipment_signature;
$shipment = Shippo_Shipment::create(
array(
    'object_purpose'=> 'QUOTE',
    'address_from'=> $from_address,
    'address_to'=> $to_address,
    'parcel'=> $boxes[0],
    'submission_type'=> 'PICKUP',
    'insurance_amount'=> $insurance,
    'insurance_currency'=> 'USD',
    'extra'=> '{"signature_confirmation": '. $shipment_signature .'}',
    'customs_declaration'=> $customs_declaration["object_id"]
));		
		if($this->debug == 'yes') {	echo '<pre style="height:200px;">' . print_r( $shipment, true ) . '</pre>'; }
 		 
  				$attempts = 0;
				while (($shipment["object_status"] == "QUEUED" || $shipment["object_status"] == "WAITING") && $attempts < 10){
					$shipment = Shippo_Shipment::retrieve($shipment["object_id"]);
					$attempts +=1;}

				//Get all rates for shipment.
				$rates = Shippo_Shipment::get_shipping_rates(array('id'=> $shipment["object_id"]));
 				foreach ($rates["results"] as $key) {
						$rate = array(
			          		'id' => sprintf("%s-%s", $key["provider"], $key["servicelevel_name"]),
			          		'label' => sprintf("%s %s", $key["provider"] , $key["servicelevel_name"]),
			          		'cost' => $key["amount"],
			          		'calc_tax' => 'per_item'
			        	);	
						$this->add_rate( $rate );
				}			 				 	 
 		 
 	} catch (Exception $e) {
			//print_r($e);
 		//echo 'Caught exception: ',  $e->getMessage(), "\n";
 	}
    	return $requests;
    }

    

    /**
     * calculate_shipping function.
     *
     * @param mixed $package
     */
    public function calculate_shipping( $package ) {
    	// Clear rates
    	$this->found_rates = array();

    	// Debugging
    	$this->debug( __( 'shippo debug mode is on - to hide these messages, turn debug mode off in the settings.', 'wc_wanderlust' ) );

		// Get requests		
		$wanderlust_packages    = $this->get_wanderlust_packages( $package );
		$wanderlust_requests    = $this->get_wanderlust_requests( $wanderlust_packages, $package );
 		
 
		// Ensure rates were found for all packages
		$packages_to_quote_count = sizeof( $wanderlust_requests );

		if ( $this->found_rates ) {
			foreach ( $this->found_rates as $key => $value ) {
				if ( $value['packages'] < $packages_to_quote_count )
					unset( $this->found_rates[ $key ] );
			}
		}
    }     
}