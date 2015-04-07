function usps_label_add_package(){
	packages = Math.floor(jQuery('#shipment_packages').val()) + 1;
	var usps_label_package = '<div id="shipment_package_' + packages + '" style="margin-top:15px"><h4>Package.</h4><p><button type="button" class="button-secondary" onClick="usps_label_remove_package(' + packages + ');">Remove package</button></p><p><label for="shipment_preset">Save as preset</label><input type="checkbox" name="shipment_preset[]" value="1" style="margin-left:0.5em" /></p><ul><li style="float:left;margin-right:5px"><label for="shipment_weight">Weight<span> *</span>:</label><br /><input type="text" name="shipment_weight[]" size="5" /> lbs.</li><li style="float:left;margin-right:5px"><label for="shipment_height">Height<span> *</span>:</label><br /><input type="text" name="shipment_height[]" size="5" /> in.</li><li style="float:left;margin-right:5px"><label for="shipment_length">Length<span> *</span>:</label><br /><input type="text" name="shipment_length[]" size="5" /> in.</li><li style="float:left;margin-right:5px"><label for="shipment_width">Width<span> *</span>:</label><br /><input type="text" name="shipment_width[]" size="5" /> in.</li><li style="float:left;margin-right:5px"><label for="shipment_value">Declared Value<span> *</span>:</label><br /><input type="text" name="shipment_value[]" size="5" /> USD dollars.</li><br style="clear:both" /></ul></div>';
	jQuery('#shipment_packages_container').append(usps_label_package);
	
	jQuery('#shipment_packages').val(packages);
	return false;
}

function usps_label_remove_package(package){
	jQuery('#shipment_package_' + package).remove();
}

jQuery(document).ready(function(){
	jQuery("#sendtext").hide();
	jQuery("#shippo-results").hide();
	
	jQuery("#email_label").click(function(){ 
		if (jQuery('#email_label').attr('checked') ) {
						jQuery("#sendtext").fadeIn();
		} else {
			jQuery("#sendtext").hide();
		}
		
	});
	
	jQuery("#pvit_shippowanderlust_autoinsurance").click(function(){ 
		if (jQuery('#pvit_shippowanderlust_autoinsurance').attr('checked') ) {
						jQuery(".insurance").fadeIn();
		} else {
			jQuery(".insurance").hide();
		}
		
	});	
	
	

	jQuery("#push-me3").click(function(){  
		jQuery("#flash").fadeIn(400);
		var prefixbox = jQuery('#prefixbox').val();
		var greeting = jQuery('#shipment_packages_preset').val();
		var updatess = "DELETE FROM "+ prefixbox+"shippo_packages  WHERE id = "+ greeting +" ";
				jQuery.ajax({
				type: 'POST',
				cache: false,
				url: ajaxurl,
				data: {
				action: 'myAjaxseasy',
				updatess: updatess,
				                        },
				             success: function(data, textStatus, XMLHttpRequest){
				             			jQuery("#flash").hide();
				             			jQuery("#test-div").fadeIn(400);
				                            jQuery("#test-div").html('');
				                            jQuery("#test-div").append(data);
								 window.location.href = window.location.href;
										if( jQuery('#test-div').is(':visible') ) {setTimeout(function(){ jQuery('#test-div').fadeOut()}, 1000); }

				            },
				            error: function(MLHttpRequest, textStatus, errorThrown){alert(errorThrown);}
				});

	});

	jQuery("#push-me2").click(function(){  
		jQuery('.boxs').slideUp();
		jQuery('.boxs').removeClass("active");
		jQuery('#shipment_add_ckage').fadeIn();
		jQuery('#shipment_add_ckage').addClass("active");
		jQuery('#shipment_packages_preset').val('99');
	});

	 
	
	jQuery("#refund_shippo").click(function(){  
		var shippingid = jQuery('#refund_shippo').attr('data-order');		
		jQuery.ajax({
				type: 'POST',
				cache: false,
				url: ajaxurl,
				data: {
				action: 'refund_shippo',
				shippingid: shippingid,
				                        },
				             success: function(data, textStatus, XMLHttpRequest){
								jQuery("#label_three").html('');
								jQuery("#label_three").append(data);
				            },
				            error: function(MLHttpRequest, textStatus, errorThrown){alert(errorThrown);}
				});
		return false;
	});

	jQuery("#generatel").click(function(){  
			jQuery("#flash").fadeIn(400);
			jQuery("#test-div").hide();
			var order_id = jQuery('#order_id').val();
			var shipservice = jQuery('#service_option').val();
			jQuery("#generatel").hide();
 				jQuery.ajax({
					type: 'POST',
					cache: false,
 					url: ajaxurl,
					data: {
					action: 'buylabel_shippo',
					shipservice: shipservice,
					order_id: order_id,
	 				                        },
					             success: function(data, textStatus, XMLHttpRequest){
										  	console.log( data );
									 
					             			jQuery("#flash").hide();

											if (jQuery("#label_two").html().length > 0) {
												if (jQuery("#label_three").html().length === 0) {
													jQuery("#label_three").fadeIn(400);
													jQuery("#label_three").html('');
													jQuery("#label_three").append(data);
										   		} 
										   	} 

											if (jQuery("#label_one").html().length > 0) {
												if (jQuery("#label_two").html().length === 0) {
													jQuery("#label_two").fadeIn(400);
													jQuery("#label_two").html('');
													jQuery("#label_two").append(data);
										   		} 
										   	}  

											if (jQuery("#label_one").html().length === 0) {
												jQuery("#label_one").fadeIn(400);
												jQuery("#label_one").html('');
												jQuery("#label_one").append(data);
										   	}       





					                            jQuery("#get_rates").fadeIn();	 

					            },
					            error: function(MLHttpRequest, textStatus, errorThrown){alert(errorThrown);}
				});
				return false;

	});

	jQuery("#get_rates").click(function(){  
			jQuery("#flash").fadeIn(400);
			jQuery("#generatel").fadeOut(400);	
			jQuery("#test-div").fadeOut(400);			
			var orderid = jQuery("#order_id").val();
			var weightnuevo = jQuery(".active #weight").attr('data-weight');
			var heightnuevo = jQuery(".active #height").val();
			var lengthnuevo = jQuery(".active #length").val();
			var widthnuevo = jQuery(".active #width").val();
			var valuenuevo = jQuery(".active #value").val();
 			var shipment_signature = jQuery("#shipment_signature").val();
				if (jQuery("#residential_to_address").attr("checked") ) {
						var residential_to_address = "1";
					}
			jQuery("#get_rates").fadeOut();
				if (typeof jQuery(".active #weight").val() === "undefined") { 
					var weightnuevo = jQuery("#shipment_packages_weight_flat").val();
					var service = jQuery("#shipment_packages_preset").val();
				} 
				if (typeof jQuery(".active #value").val() === "undefined") { 
					var valuenuevo = jQuery("#insurances").val();
				} 	
 			var checkedInputs = jQuery(".active ul li input");
			var boxes = "";
			jQuery.each(checkedInputs, function(i, val) {
				boxes += val.value+",";
			});
			boxes = boxes.substring(0,(boxes.length-1));
		
 			var checkedInputss = jQuery(".flat input");
			var boxess = "";
			jQuery.each(checkedInputss, function(i, val) {
				boxess += val.value+",";
			});
			boxess = boxess.substring(0,(boxess.length-1));

			jQuery.ajax({
				type: 'POST',
				cache: false,
				url: ajaxurl,
				data: {
				action: 'getrates_shippo',
				orderid: orderid,
				boxes: boxes,
				boxess: boxess,
				weightnuevo: weightnuevo,
				heightnuevo: heightnuevo,
				lengthnuevo: lengthnuevo,
				widthnuevo: widthnuevo,
				valuenuevo: valuenuevo,
				service: service,
				shipment_signature: shipment_signature,
				residential_to_address: residential_to_address},
				             success: function(data){
				             	//console.log( data );
				             			jQuery("#flash").hide();
				             			jQuery("#test-div").fadeIn(400);
											jQuery("#test-div").html('');
				                            jQuery("#test-div").append(data);
 											jQuery("#generatel").fadeIn();

				                            	  

				            },
				            error: function(MLHttpRequest, textStatus, errorThrown){alert(errorThrown);}
				});
 			return false;

	});
	

 

	 




}); /* END READY */