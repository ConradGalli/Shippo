<?php
global $woocommerce, $wpdb, $table_prefix;

add_action( 'wp_ajax_nopriv_myAjaxshippo', 'myAjaxshippo' );
add_action( 'wp_ajax_nopriv_myAjaxsshippo', 'myAjaxsshippo' );
add_action( 'wp_ajax_myAjaxsshippo', 'myAjaxsshippo' );
add_action( 'wp_ajax_myAjaxshippo', 'myAjaxshippo' );
add_action( 'wp_ajax_nopriv_getrates_shippo', 'getrates_shippo' );
add_action( 'wp_ajax_getrates_shippo', 'getrates_shippo' );
add_action( 'wp_ajax_nopriv_buylabel_shippo', 'buylabel_shippo' );
add_action( 'wp_ajax_buylabel_shippo', 'buylabel_shippo' );
add_action( 'wp_ajax_nopriv_labelinfo_shippo', 'labelinfo_shippo' );
add_action( 'wp_ajax_labelinfo_shippo', 'labelinfo_shippo' );
add_action( 'wp_ajax_nopriv_labelpackageinfo_shippo', 'labelpackageinfo_shippo' );
add_action( 'wp_ajax_labelpackageinfo_shippo', 'labelpackageinfo_shippo' );
add_action( 'wp_ajax_nopriv_insurepackage_shippo', 'insurepackage_shippo' );
add_action( 'wp_ajax_insurepackage_shippo', 'insurepackage_shippo' );
add_action( 'wp_ajax_nopriv_refund_shippo', 'refund_shippo' );
add_action( 'wp_ajax_refund_shippo', 'refund_shippo' );
add_action( 'wp_ajax_nopriv_myAjaxs_shippo', 'myAjaxs_shippo' );
add_action( 'wp_ajax_myAjaxs_shippo', 'myAjaxs_shippo' );

$woocommerce_shippo_username = get_option( 'pvit_shippowanderlust_username' );
$woocommerce_shippo_password = get_option( 'pvit_shippowanderlust_password' );
Shippo::setCredentials($woocommerce_shippo_username, $woocommerce_shippo_password);

 
require_once('mod/get-rates-backend.php');
require_once('mod/generate-label.php');
//require_once('mod/auto-generate.php');
require_once('mod/email_label.php');


$woocommerce_shippo_autogen = get_option( 'pvit_shippowanderlust_autogen' ); //check if auto label is enabled
if($woocommerce_shippo_autogen == 1){
	//add_action( 'woocommerce_order_status_processing', 'purchase_order');
}

function refund_shippo(){
						$shippingid =  $_POST ['shippingid'];
						$shippo_shipping_labelc = get_post_meta($shippingid, '_transaction_shippo');
						//print_r($shippo_shipping_labelc);
						
						$refund = Shippo_Refund::create (
							array(
    						'transaction'=> $shippo_shipping_labelc[0]['id'],
						));
						
						print_r($refund['object_status']);	
	die();
}

function myAjaxshippo(){global $wpdb;$update = $_POST['updatess'];$bodytag = str_replace("\'", "'", $update);$update2  = $wpdb->query($bodytag);$results = "Saved";$results = '<META HTTP-EQUIV="refresh" CONTENT="1">';die($results);}
function myAjaxsshippo(){global $wpdb;$update = $_POST['updatess'];$bodytag = str_replace("\'", "'", $update);$update2  = $wpdb->query($bodytag);$results = "Saved";die($results);}
function myAjaxs_shippo(){global $wpdb;$update = $_POST['updatess'];$bodytag = str_replace("\'", "'", $update);$update2  = $wpdb->query($bodytag);$results = "Saved";$results = '<META HTTP-EQUIV="refresh" CONTENT="1">';die($results);}


	add_action( 'woocommerce_product_options_shipping', 'woo_add_shippowanderlust_customshs_fields' );
	add_action( 'woocommerce_process_product_meta', 'woo_add_shippowanderlust_customshs_fields_save' );
	add_action( 'woocommerce_process_product_meta', 'woo_add_shippowanderlust_product_type_fields_save' );
	add_action( 'woocommerce_process_product_meta', 'woo_add_shippowanderlust_product_insurance_fields_save' );

	function woo_add_shippowanderlust_customshs_fields() {
	  global $woocommerce, $post;
	  echo '<div class="options_group">';
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_shippo_product_description', 
				'label'       => __( 'Product Description ', 'woocommerce' ), 
				'placeholder' => 'T-Shirt',
				'desc_tip'    => 'true',
				'default' 	  => ' ',
				'description' => __( 'Text description of your item.', 'woocommerce' ) ,
			)
		);
	  echo '</div>';
 
	}

	function woo_add_shippowanderlust_customshs_fields_save( $post_id ){
		$woocommerce_text_field = $_POST['_shippo_product_description'];
		if( !empty( $woocommerce_text_field ) )
			update_post_meta( $post_id, '_shippo_product_description', esc_attr( $woocommerce_text_field ) );
	}
	 
	 