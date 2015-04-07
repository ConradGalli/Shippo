<?php
/*
Plugin Name: Woocommerce Shippo Shipping Tool
Plugin URI: http://shop.wanderlust-webdesign.com/
Description: Provides an integration for Shippo for Woocommerce by Wanderlust Web Design.  <strong>Requires PHP Version:5.3.24</strong>
Version: 1.0
Author: wanderlust-webdesign.com
Author URI: http://wanderlust-webdesign.com
*/


/**
 * Required functions
 */
	require_once( 'woo-includes/woo-functions.php' );
	require_once('includes/lib/live/Shippo.php');

/**
 * Plugin page links
 */
	function wc_wanderlust_shippo_plugin_links( $links ) {

		$plugin_links = array(
			'<a href="http://wanderlust-webdesign.com/contact/">' . __( 'Support', 'wc_wanderlust' ) . '</a>',
			'<a href="http://shop.wanderlust-webdesign.com/">' . __( 'More Plugins', 'wc_wanderlust' ) . '</a>',
		);

		return array_merge( $plugin_links, $links );
	}

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_wanderlust_shippo_plugin_links' );

/**
 * Check if WooCommerce is active
 */
if ( is_woocommerce_active() ) {

	$showrates = get_option('pvit_shippowanderlust_rates');
	if ($showrates == 1) {
		/**
		 * woocommerce_init_shipping_table_rate function.
		 *
		 * @access public
		 * @return void
		 */
		function wc_wanderlust_shippo_init() {
			include_once( 'includes/class-wc-shipping-wanderlust.php' );
		}

		add_action( 'woocommerce_shipping_init', 'wc_wanderlust_shippo_init' );

		/**
		 * wc_wanderlust_add_method function.
		 *
		 * @access public
		 * @param mixed $methods
		 * @return void
		 */
		function wc_wanderlust_shippo_add_method( $methods ) {
			$methods[] = 'WC_Shipping_Wanderlust_Shippo';
			return $methods;
		}

		add_filter( 'woocommerce_shipping_methods', 'wc_wanderlust_shippo_add_method' );
		add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_true' );

		/**
		 * wc_wanderlust_scripts function.
		 */
		function wc_wanderlust_shippo_scripts() {
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		add_action( 'admin_enqueue_scripts', 'wc_wanderlust_shippo_scripts' );

	}

 	// Order of Plugin Loading Requires this line, should not be necessary
 	require_once(dirname(__FILE__) . '/includes/functions.php');

	function wanderlust_shippo_install() {
	   global $wpdb;
	   $table_name = $wpdb->prefix . "shippo_packages";
	   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		   $sql = "CREATE TABLE $table_name (id mediumint(9) NOT NULL AUTO_INCREMENT,name tinytext NOT NULL,text text NOT NULL,height VARCHAR(55) DEFAULT '' NOT NULL,width VARCHAR(55) DEFAULT '' NOT NULL,length VARCHAR(55) DEFAULT '' NOT NULL,weight VARCHAR(55) DEFAULT '' NOT NULL,url VARCHAR(55) DEFAULT '' NOT NULL,UNIQUE KEY id (id));";
		   $sql2 = "INSERT INTO $table_name (id, name, text, url, height, width, length, weight) VALUES (NULL, 'normal-demo', '2', '2', '2', '2', '2', '2')";       
		   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		   dbDelta( $sql );
		   dbDelta( $sql2 );
	   }
	}
	register_activation_hook( __FILE__, 'wanderlust_shippo_install' );



// add_action( 'add_meta_boxes', 'wanderlust_shippo_add_boxes');

	function wanderlust_shippo_add_boxes(){
	 	add_meta_box( 'shippo_data', __( 'Shipping Label', 'woocommerce' ), 'woocommerce_wanderlust_shippo_meta_box', 'shop_order', 'normal', 'low' );
	}

	function woocommerce_wanderlust_shippo_meta_box($post){
	 	print sprintf("<a href='%2\$s' style='text-align:center;display:block;'><img style='max-width:%1\$s' src='%2\$s' ></a>",'450px', get_post_meta( $post->ID, 'shippo_shipping_label_1', true));
	}

	function shippo_label_load_admin_js(){
		add_action( 'admin_enqueue_scripts', 'shippo_label_enqueue_admin_js' );
	}

	function shippo_label_enqueue_admin_js(){	
		wp_enqueue_script( 'shippo-label-admin-script', plugins_url('includes/js/admin.js',__FILE__), array( 'jquery' ) );
		wp_enqueue_script( 'shippo-label-admin-print', plugins_url('includes/js/print.js',__FILE__), array( 'jquery' ) );
	}


	function shippo_wanderlust_labels_admin() {
		$my_page = add_submenu_page( 'woocommerce','Wanderlust Labels', 'Generate Label', 'manage_woocommerce', 'shippo-create-shipment', 'shippo_create_shipment' );
 		add_action( 'load-' . $my_page, 'shippo_label_load_admin_js' );
 		$my_page = add_submenu_page( 'woocommerce','Wanderlust Shipping Tool Settings', 'Shippo Shipping Settings', 'manage_woocommerce', 'shippo-config', 'shippo_config' );
		add_action( 'load-' . $my_page, 'shippo_label_load_admin_js' );
		wp_register_style( 'wanderlustStylesheet', plugins_url('includes/css/style.css', __FILE__) );
		wp_enqueue_style( 'wanderlustStylesheet' );
		wp_enqueue_script( 'shippo-label-admin-script', plugins_url('includes/js/admin.js',__FILE__), array( 'jquery' ) );

  	}
	add_action( 'admin_menu', 'shippo_wanderlust_labels_admin' );
	
    function remove_shippo_menu_pages() {
    $remove_submenu = remove_shippo_submenu_page('woocommerce', 'manage_woocommerce');
    remove_shippo_submenu_page( 'woocommerce' ,'shippo-create-shipment' );
    }

	function shippo_create_shipment() {
		if ( !current_user_can( 'manage_woocommerce' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		require_once(dirname(__FILE__) . '/includes/admin-index.php');
	}

 	function shippo_config(){
		if ( !current_user_can( 'manage_woocommerce' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}	
		require_once(dirname(__FILE__) . '/includes/admin-config.php');
	}


function woocommerce_pvit_shippo_label_create_box_content($column) {
	global $post;
 	$order = new WC_Order( $post->ID );
    
    switch ($column) {
      case "order_actions" :

  			?>
			<?php $shippo_shipping_labela = get_post_meta($post->ID, 'shippo_shipping_label_1');	
			if (empty($shippo_shipping_labela)){ ?>
  				<a class="button" href="<?php echo wp_nonce_url(admin_url('admin.php?page=shippo-create-shipment&order_id='.$post->ID), 'print-shippo-label'); ?>"><?php _e('Generate Label', 'woocommerce-pvit-shippo'); ?></a>
			<?php } else { ?>
  				<a class="button" href="<?php echo wp_nonce_url(admin_url('admin.php?page=shippo-create-shipment&order_id='.$post->ID), 'print-shippo-label'); ?>"><?php _e('Generate Label', 'woocommerce-pvit-shippo'); ?></a>
			<?php } ?>
 	<?php
  		  break;
    }
	}
	
	add_action('manage_shop_order_posts_custom_column', 'woocommerce_pvit_shippo_label_create_box_content', 4);	
	add_action('add_meta_boxes', 'woocommerce_shippo_box_add_box');

	function woocommerce_shippo_box_add_box() {
		add_meta_box( 'woocommerce-shippo-box', __( 'Wanderlust Shipping Labels', 'woocommerce-shippo' ), 'woocommerce_shippo_box_create_box_content', 'shop_order', 'side', 'default' );
	}
	function woocommerce_shippo_box_create_box_content() {
		global $post;
		  $order = new WC_Order( $post->ID );
		  $shipid = get_post_meta($post->ID, '_wanderlustshipid');
		  $shiporderid = get_post_meta($post->ID, '_wanderlustshiporderid');
		if (empty($shipid)){ echo'<style>#label-package-info, #label-info{display:none;} </style>';}

		?>
 		<div class="shippo-single">
<?php $shippo_shipping_labela = get_post_meta($post->ID, 'shippo_shipping_label_1');
if (!empty($shippo_shipping_labela)){ 
	echo'<h3>Label 1</h3><div id="label_one"><div style="cursor: pointer;text-align: center;" class="print" data-imgid="'.$shippo_shipping_labela[0].'"><a href="#"><img src="'.$shippo_shipping_labela[0].'" width="150" height="auto"></a></div></div>'; 
} ?>
<?php $shippo_shipping_labelb = get_post_meta($post->ID, 'shippo_shipping_label_2');
if (!empty($shippo_shipping_labelb)){ 
	echo'</br><h3>Label 2</h3><div id="label_one"><div style="cursor: pointer;text-align: center;" class="print" data-imgid="'.$shippo_shipping_labelb[0].'"><a href="#"><img src="'.$shippo_shipping_labelb[0].'" width="150" height="auto"></a></div></div>'; 
} ?>	
<?php $shippo_shipping_labelc = get_post_meta($post->ID, 'shippo_shipping_label_3');
if (!empty($shippo_shipping_labelc)){ 
	echo'</br><h3>Label 3</h3><div id="label_one"><div style="cursor: pointer;text-align: center;" class="print" data-imgid="'.$shippo_shipping_labelc[0].'"><a href="#"><img src="'.$shippo_shipping_labelc[0].'" width="150" height="auto"></a></div></div>'; 
} ?>			
					
<?php $shippo_shipping_labela = get_post_meta($post->ID, 'shippo_shipping_label_1');	$site = get_site_url();  if (empty($shippo_shipping_labela)){ ?>
<a class="button" href="<?php echo wp_nonce_url(admin_url('admin.php?page=shippo-create-shipment&order_id='.$post->ID), 'print-shippo-label'); ?>"><?php _e('Generate Label', 'woocommerce-pvit-shippo'); ?></a>
<?php } ?>
				
		  
		</div>	
 
 		<?php
	}
}