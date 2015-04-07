<?php 
$validation = true;
$error = "";
if(isset($_POST['pvit_shippowanderlust_shipper_config_save'])){
	if(!empty($_POST['pvit_shippowanderlust_username'])){add_option('pvit_shippowanderlust_username',$_POST['pvit_shippowanderlust_username']);update_option('pvit_shippowanderlust_username', $_POST['pvit_shippowanderlust_username']);}else{$error .= "We need your shippo Test Key <br />";}
	if(!empty($_POST['pvit_shippowanderlust_password'])){add_option('pvit_shippowanderlust_password',$_POST['pvit_shippowanderlust_password']);update_option('pvit_shippowanderlust_password', $_POST['pvit_shippowanderlust_password']);}else{$error .= "We need your shippo Live Key <br />";}
	if(!empty($_POST['pvit_shippowanderlust_customstype'])){add_option('pvit_shippowanderlust_customstype',$_POST['pvit_shippowanderlust_customstype']);update_option('pvit_shippowanderlust_customstype', $_POST['pvit_shippowanderlust_customstype']);}else{$error .= "You need to insert Customs Info <br />";}	
	if(!empty($_POST['pvit_shippowanderlust_sender_name'])){add_option('pvit_shippowanderlust_sender_name',$_POST['pvit_shippowanderlust_sender_name']);update_option('pvit_shippowanderlust_sender_name', $_POST['pvit_shippowanderlust_sender_name']);}else{$error .= "We need your Sender Name <br />";}
	if(!empty($_POST['pvit_shippowanderlust_sender_company'])){add_option('pvit_shippowanderlust_sender_company',$_POST['pvit_shippowanderlust_sender_company']);update_option('pvit_shippowanderlust_sender_company', $_POST['pvit_shippowanderlust_sender_company']);}
	if(!empty($_POST['pvit_shippowanderlust_sender_address1'])){add_option('pvit_shippowanderlust_sender_address1',$_POST['pvit_shippowanderlust_sender_address1']);update_option('pvit_shippowanderlust_sender_address1', $_POST['pvit_shippowanderlust_sender_address1']);}else{$error .= "We need your Sender Address 1<br />";}
	if(!empty($_POST['pvit_shippowanderlust_sender_address2'])){add_option('pvit_shippowanderlust_sender_address2',$_POST['pvit_shippowanderlust_sender_address2']);update_option('pvit_shippowanderlust_sender_address2', $_POST['pvit_shippowanderlust_sender_address2']);}else {update_option('pvit_shippowanderlust_sender_address2', '');}
	if(!empty($_POST['pvit_shippowanderlust_sender_state'])){add_option('pvit_shippowanderlust_sender_state',$_POST['pvit_shippowanderlust_sender_state']);update_option('pvit_shippowanderlust_sender_state', $_POST['pvit_shippowanderlust_sender_state']);}else{$error .= "We need your Sender State<br />";}	
	if(!empty($_POST['pvit_shippowanderlust_shipper_city'])){add_option('pvit_shippowanderlust_shipper_city',$_POST['pvit_shippowanderlust_shipper_city']);update_option('pvit_shippowanderlust_shipper_city', $_POST['pvit_shippowanderlust_shipper_city']);}else{$error .= "We need your Sender City<br />";}
	if(!empty($_POST['pvit_shippowanderlust_shipper_phone'])){add_option('pvit_shippowanderlust_shipper_phone',$_POST['pvit_shippowanderlust_shipper_phone']);update_option('pvit_shippowanderlust_shipper_phone', $_POST['pvit_shippowanderlust_shipper_phone']);}else{$error .= "We need your Sender Phone<br />";}
	if(!empty($_POST['pvit_shippowanderlust_shipper_zipcode'])){add_option('pvit_shippowanderlust_shipper_zipcode',$_POST['pvit_shippowanderlust_shipper_zipcode']);update_option('pvit_shippowanderlust_shipper_zipcode', $_POST['pvit_shippowanderlust_shipper_zipcode']);}else{$error .= "We need your Sender Zip Code<br />";}
	if(!empty($_POST['pvit_shippowanderlust_shipper_country'])){add_option('pvit_shippowanderlust_shipper_country',$_POST['pvit_shippowanderlust_shipper_country']);update_option('pvit_shippowanderlust_shipper_country', $_POST['pvit_shippowanderlust_shipper_country']);}else{$error .= "We need your Sender Country Code<br />";}
	if(!empty($_POST['pvit_shippowanderlust_shipper_email'])){add_option('pvit_shippowanderlust_shipper_email',$_POST['pvit_shippowanderlust_shipper_email']);update_option('pvit_shippowanderlust_shipper_email', $_POST['pvit_shippowanderlust_shipper_email']);}else{$error .= "We need your Sender Email<br />";}

	if($_POST['pvit_shippowanderlust_email_label'] == 1){add_option('pvit_shippowanderlust_email_label',1);update_option('pvit_shippowanderlust_email_label', 1);}else{add_option('pvit_shippowanderlust_email_label',0);update_option('pvit_shippowanderlust_email_label', 0);}
	if(!empty($_POST['pvit_shippowanderlust_email_label_to'])){add_option('pvit_shippowanderlust_email_label_to',$_POST['pvit_shippowanderlust_email_label_to']);update_option('pvit_shippowanderlust_email_label_to', $_POST['pvit_shippowanderlust_email_label_to']);}else{ }
	if(!empty($_POST['pvit_shippowanderlust_email_label_from'])){add_option('pvit_shippowanderlust_email_label_from',$_POST['pvit_shippowanderlust_email_label_from']);update_option('pvit_shippowanderlust_email_label_from', $_POST['pvit_shippowanderlust_email_label_from']);} else {update_option('pvit_shippowanderlust_email_label_from', '');}

	if($_POST['pvit_shippowanderlust_auto_weight'] == 1){add_option('pvit_shippowanderlust_auto_weight',1);update_option('pvit_shippowanderlust_auto_weight', 1);}else{add_option('pvit_shippowanderlust_auto_weight',0);update_option('pvit_shippowanderlust_auto_weight', 0);}
	if($_POST['pvit_shippowanderlust_usps_service'] == 1){add_option('pvit_shippowanderlust_usps_service',1);update_option('pvit_shippowanderlust_usps_service', 1);}else{add_option('pvit_shippowanderlust_usps_service',0);update_option('pvit_shippowanderlust_usps_service', 0);}

	if(!empty($_POST['pvit_shippowanderlust_usps_service_first'])){add_option('pvit_shippowanderlust_usps_service_first',$_POST['pvit_shippowanderlust_usps_service_first']);update_option('pvit_shippowanderlust_usps_service_first', $_POST['pvit_shippowanderlust_usps_service_first']);} else {update_option('pvit_shippowanderlust_usps_service_first', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_priority'])){add_option('pvit_shippowanderlust_usps_service_priority',$_POST['pvit_shippowanderlust_usps_service_priority']);update_option('pvit_shippowanderlust_usps_service_priority', $_POST['pvit_shippowanderlust_usps_service_priority']);} else {update_option('pvit_shippowanderlust_usps_service_priority', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_express'])){add_option('pvit_shippowanderlust_usps_service_express',$_POST['pvit_shippowanderlust_usps_service_express']);update_option('pvit_shippowanderlust_usps_service_express', $_POST['pvit_shippowanderlust_usps_service_express']);} else {update_option('pvit_shippowanderlust_usps_service_express', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_parcel'])){add_option('pvit_shippowanderlust_usps_service_parcel',$_POST['pvit_shippowanderlust_usps_service_parcel']);update_option('pvit_shippowanderlust_usps_service_parcel', $_POST['pvit_shippowanderlust_usps_service_parcel']);} else {update_option('pvit_shippowanderlust_usps_service_parcel', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_critical'])){add_option('pvit_shippowanderlust_usps_service_critical',$_POST['pvit_shippowanderlust_usps_service_critical']);update_option('pvit_shippowanderlust_usps_service_critical', $_POST['pvit_shippowanderlust_usps_service_critical']);} else {update_option('pvit_shippowanderlust_usps_service_critical', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_first_international'])){add_option('pvit_shippowanderlust_usps_service_first_international',$_POST['pvit_shippowanderlust_usps_service_first_international']);update_option('pvit_shippowanderlust_usps_service_first_international', $_POST['pvit_shippowanderlust_usps_service_first_international']);} else {update_option('pvit_shippowanderlust_usps_service_first_international', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_first_pkg_international'])){add_option('pvit_shippowanderlust_usps_service_first_pkg_international',$_POST['pvit_shippowanderlust_usps_service_first_pkg_international']);update_option('pvit_shippowanderlust_usps_service_first_pkg_international', $_POST['pvit_shippowanderlust_usps_service_first_pkg_international']);} else {update_option('pvit_shippowanderlust_usps_service_first_pkg_international', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_priority_international'])){add_option('pvit_shippowanderlust_usps_service_priority_international',$_POST['pvit_shippowanderlust_usps_service_priority_international']);update_option('pvit_shippowanderlust_usps_service_priority_international', $_POST['pvit_shippowanderlust_usps_service_priority_international']);} else {update_option('pvit_shippowanderlust_usps_service_priority_international', '');}
	if(!empty($_POST['pvit_shippowanderlust_usps_service_expres_international'])){add_option('pvit_shippowanderlust_usps_service_expres_international',$_POST['pvit_shippowanderlust_usps_service_expres_international']);update_option('pvit_shippowanderlust_usps_service_expres_international', $_POST['pvit_shippowanderlust_usps_service_expres_international']);} else {update_option('pvit_shippowanderlust_usps_service_expres_international', '');}


	if($_POST['pvit_shippowanderlust_fedex_service'] == 1){add_option('pvit_shippowanderlust_fedex_service',1);update_option('pvit_shippowanderlust_fedex_service', 1);}else{add_option('pvit_shippowanderlust_fedex_service',0);update_option('pvit_shippowanderlust_fedex_service', 0);}

	if(!empty($_POST['pvit_shippowanderlust_fedex_service_ground'])){add_option('pvit_shippowanderlust_fedex_service_ground',$_POST['pvit_shippowanderlust_fedex_service_ground']);update_option('pvit_shippowanderlust_fedex_service_ground', $_POST['pvit_shippowanderlust_fedex_service_ground']);} else {update_option('pvit_shippowanderlust_fedex_service_ground', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_twoday'])){add_option('pvit_shippowanderlust_fedex_service_twoday',$_POST['pvit_shippowanderlust_fedex_service_twoday']);update_option('pvit_shippowanderlust_fedex_service_twoday', $_POST['pvit_shippowanderlust_fedex_service_twoday']);} else {update_option('pvit_shippowanderlust_fedex_service_twoday', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_twodayam'])){add_option('pvit_shippowanderlust_fedex_service_twodayam',$_POST['pvit_shippowanderlust_fedex_service_twodayam']);update_option('pvit_shippowanderlust_fedex_service_twodayam', $_POST['pvit_shippowanderlust_fedex_service_twodayam']);} else {update_option('pvit_shippowanderlust_fedex_service_twodayam', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_express'])){add_option('pvit_shippowanderlust_fedex_service_express',$_POST['pvit_shippowanderlust_fedex_service_express']);update_option('pvit_shippowanderlust_fedex_service_express', $_POST['pvit_shippowanderlust_fedex_service_express']);} else {update_option('pvit_shippowanderlust_fedex_service_express', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_standard'])){add_option('pvit_shippowanderlust_fedex_service_standard',$_POST['pvit_shippowanderlust_fedex_service_standard']);update_option('pvit_shippowanderlust_fedex_service_standard', $_POST['pvit_shippowanderlust_fedex_service_standard']);} else {update_option('pvit_shippowanderlust_fedex_service_standard', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_first'])){add_option('pvit_shippowanderlust_fedex_service_first',$_POST['pvit_shippowanderlust_fedex_service_first']);update_option('pvit_shippowanderlust_fedex_service_first', $_POST['pvit_shippowanderlust_fedex_service_first']);} else {update_option('pvit_shippowanderlust_fedex_service_first', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_priority'])){add_option('pvit_shippowanderlust_fedex_service_priority',$_POST['pvit_shippowanderlust_fedex_service_priority']);update_option('pvit_shippowanderlust_fedex_service_priority', $_POST['pvit_shippowanderlust_fedex_service_priority']);} else {update_option('pvit_shippowanderlust_fedex_service_priority', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_inteconomy'])){add_option('pvit_shippowanderlust_fedex_service_inteconomy',$_POST['pvit_shippowanderlust_fedex_service_inteconomy']);update_option('pvit_shippowanderlust_fedex_service_inteconomy', $_POST['pvit_shippowanderlust_fedex_service_inteconomy']);} else {update_option('pvit_shippowanderlust_fedex_service_inteconomy', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_intfirst'])){add_option('pvit_shippowanderlust_fedex_service_intfirst',$_POST['pvit_shippowanderlust_fedex_service_intfirst']);update_option('pvit_shippowanderlust_fedex_service_intfirst', $_POST['pvit_shippowanderlust_fedex_service_intfirst']);} else {update_option('pvit_shippowanderlust_fedex_service_intfirst', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_intpriority'])){add_option('pvit_shippowanderlust_fedex_service_intpriority',$_POST['pvit_shippowanderlust_fedex_service_intpriority']);update_option('pvit_shippowanderlust_fedex_service_intpriority', $_POST['pvit_shippowanderlust_fedex_service_intpriority']);} else {update_option('pvit_shippowanderlust_fedex_service_intpriority', '');}
	if(!empty($_POST['pvit_shippowanderlust_fedex_service_groundhome'])){add_option('pvit_shippowanderlust_fedex_service_groundhome',$_POST['pvit_shippowanderlust_fedex_service_groundhome']);update_option('pvit_shippowanderlust_fedex_service_groundhome', $_POST['pvit_shippowanderlust_fedex_service_groundhome']);} else {update_option('pvit_shippowanderlust_fedex_service_groundhome', '');}


	if($_POST['pvit_shippowanderlust_dhl_service'] == 1){add_option('pvit_shippowanderlust_dhl_service',1);update_option('pvit_shippowanderlust_dhl_service', 1);}else{add_option('pvit_shippowanderlust_dhl_service',0);update_option('pvit_shippowanderlust_dhl_service', 0);}
	
	if(!empty($_POST['pvit_shippowanderlust_dhl_service_expressww'])){add_option('pvit_shippowanderlust_dhl_service_expressww',$_POST['pvit_shippowanderlust_dhl_service_expressww']);update_option('pvit_shippowanderlust_dhl_service_expressww', $_POST['pvit_shippowanderlust_dhl_service_expressww']);} else {update_option('pvit_shippowanderlust_dhl_service_expressww', '');}
	if(!empty($_POST['pvit_shippowanderlust_dhl_service_medicalexpnondoc'])){add_option('pvit_shippowanderlust_dhl_service_medicalexpnondoc',$_POST['pvit_shippowanderlust_dhl_service_medicalexpnondoc']);update_option('pvit_shippowanderlust_dhl_service_medicalexpnondoc', $_POST['pvit_shippowanderlust_dhl_service_medicalexpnondoc']);} else {update_option('pvit_shippowanderlust_dhl_service_medicalexpnondoc', '');}
	if(!empty($_POST['pvit_shippowanderlust_dhl_service_expresswwnondoc'])){add_option('pvit_shippowanderlust_dhl_service_expresswwnondoc',$_POST['pvit_shippowanderlust_dhl_service_expresswwnondoc']);update_option('pvit_shippowanderlust_dhl_service_expresswwnondoc', $_POST['pvit_shippowanderlust_dhl_service_expresswwnondoc']);} else {update_option('pvit_shippowanderlust_dhl_service_expresswwnondoc', '');}

	if($_POST['pvit_shippowanderlust_ups_service'] == 1){add_option('pvit_shippowanderlust_ups_service',1);update_option('pvit_shippowanderlust_ups_service', 1);}else{add_option('pvit_shippowanderlust_ups_service',0);update_option('pvit_shippowanderlust_ups_service', 0);}
	
	if(!empty($_POST['pvit_shippowanderlust_ups_service_ground'])){add_option('pvit_shippowanderlust_ups_service_ground',$_POST['pvit_shippowanderlust_ups_service_ground']);update_option('pvit_shippowanderlust_ups_service_ground', $_POST['pvit_shippowanderlust_ups_service_ground']);} else {update_option('pvit_shippowanderlust_ups_service_ground', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_standards'])){add_option('pvit_shippowanderlust_ups_service_standards',$_POST['pvit_shippowanderlust_ups_service_standards']);update_option('pvit_shippowanderlust_ups_service_standards', $_POST['pvit_shippowanderlust_ups_service_standards']);} else {update_option('pvit_shippowanderlust_ups_service_standards', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_saver'])){add_option('pvit_shippowanderlust_ups_service_saver',$_POST['pvit_shippowanderlust_ups_service_saver']);update_option('pvit_shippowanderlust_ups_service_saver', $_POST['pvit_shippowanderlust_ups_service_saver']);} else {update_option('pvit_shippowanderlust_ups_service_saver', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_expres'])){add_option('pvit_shippowanderlust_ups_service_expres',$_POST['pvit_shippowanderlust_ups_service_expres']);update_option('pvit_shippowanderlust_ups_service_expres', $_POST['pvit_shippowanderlust_ups_service_expres']);} else {update_option('pvit_shippowanderlust_ups_service_expres', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_expresplus'])){add_option('pvit_shippowanderlust_ups_service_expresplus',$_POST['pvit_shippowanderlust_ups_service_expresplus']);update_option('pvit_shippowanderlust_ups_service_expresplus', $_POST['pvit_shippowanderlust_ups_service_expresplus']);} else {update_option('pvit_shippowanderlust_ups_service_expresplus', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_expedited'])){add_option('pvit_shippowanderlust_ups_service_expedited',$_POST['pvit_shippowanderlust_ups_service_expedited']);update_option('pvit_shippowanderlust_ups_service_expedited', $_POST['pvit_shippowanderlust_ups_service_expedited']);} else {update_option('pvit_shippowanderlust_ups_service_expedited', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_nda'])){add_option('pvit_shippowanderlust_ups_service_nda',$_POST['pvit_shippowanderlust_ups_service_nda']);update_option('pvit_shippowanderlust_ups_service_nda', $_POST['pvit_shippowanderlust_ups_service_nda']);} else {update_option('pvit_shippowanderlust_ups_service_nda', '');}
	if(!empty($_POST['pvit_shippowanderlust_ups_service_ndas'])){add_option('pvit_shippowanderlust_ups_service_ndas',$_POST['pvit_shippowanderlust_ups_service_ndas']);update_option('pvit_shippowanderlust_ups_service_ndas', $_POST['pvit_shippowanderlust_ups_service_ndas']);} else {update_option('pvit_shippowanderlust_ups_service_ndas', '');}					
	if(!empty($_POST['pvit_shippowanderlust_ups_service_ndaea'])){add_option('pvit_shippowanderlust_ups_service_ndaea',$_POST['pvit_shippowanderlust_ups_service_ndaea']);update_option('pvit_shippowanderlust_ups_service_ndaea', $_POST['pvit_shippowanderlust_ups_service_ndaea']);} else {update_option('pvit_shippowanderlust_ups_service_ndaea', '');}	
	if(!empty($_POST['pvit_shippowanderlust_ups_service_2da'])){add_option('pvit_shippowanderlust_ups_service_2da',$_POST['pvit_shippowanderlust_ups_service_2da']);update_option('pvit_shippowanderlust_ups_service_2da', $_POST['pvit_shippowanderlust_ups_service_2da']);} else {update_option('pvit_shippowanderlust_ups_service_2da', '');}	
	if(!empty($_POST['pvit_shippowanderlust_ups_service_2daa'])){add_option('pvit_shippowanderlust_ups_service_2daa',$_POST['pvit_shippowanderlust_ups_service_2daa']);update_option('pvit_shippowanderlust_ups_service_2daa', $_POST['pvit_shippowanderlust_ups_service_2daa']);} else {update_option('pvit_shippowanderlust_ups_service_2daa', '');}	
	if(!empty($_POST['pvit_shippowanderlust_ups_service_3ds'])){add_option('pvit_shippowanderlust_ups_service_3ds',$_POST['pvit_shippowanderlust_ups_service_3ds']);update_option('pvit_shippowanderlust_ups_service_3ds', $_POST['pvit_shippowanderlust_ups_service_3ds']);} else {update_option('pvit_shippowanderlust_ups_service_3ds', '');}	

	
 	if($_POST['pvit_shippowanderlust_usps'] == 1){add_option('pvit_shippowanderlust_usps',1);update_option('pvit_shippowanderlust_usps', 1);}else{add_option('pvit_shippowanderlust_usps',0);update_option('pvit_shippowanderlust_usps', 0);}
 	if($_POST['pvit_shippowanderlust_fedex'] == 1){add_option('pvit_shippowanderlust_fedex',1);update_option('pvit_shippowanderlust_fedex', 1);}else{add_option('pvit_shippowanderlust_fedex',0);update_option('pvit_shippowanderlust_fedex', 0);}
 	if($_POST['pvit_shippowanderlust_ups'] == 1){add_option('pvit_shippowanderlust_ups',1);update_option('pvit_shippowanderlust_ups', 1);}else{add_option('pvit_shippowanderlust_ups',0);update_option('pvit_shippowanderlust_ups', 0);}
  	if($_POST['pvit_shippowanderlust_dhlbox'] == 1){add_option('pvit_shippowanderlust_dhlbox',1);update_option('pvit_shippowanderlust_dhlbox', 1);}else{add_option('pvit_shippowanderlust_dhlbox',0);update_option('pvit_shippowanderlust_dhlbox', 0);}
	
	if($_POST['pvit_shippowanderlust_autogen'] == 1){add_option('pvit_shippowanderlust_autogen',1);update_option('pvit_shippowanderlust_autogen', 1);}else{add_option('pvit_shippowanderlust_autogen',0);update_option('pvit_shippowanderlust_autogen', 0);}
 
	
 	if($_POST['pvit_shippowanderlust_rates'] == 1){add_option('pvit_shippowanderlust_rates',1);update_option('pvit_shippowanderlust_rates', 1);}else{add_option('pvit_shippowanderlust_rates',0);update_option('pvit_shippowanderlust_rates', 0);}

 	if($_POST['pvit_shippowanderlust_customshmore'] == 1){add_option('pvit_shippowanderlust_customshmore',1);update_option('pvit_shippowanderlust_customshmore', 1);}else{add_option('pvit_shippowanderlust_customshmore',0);update_option('pvit_shippowanderlust_customshmore', 0);}
 	
	if($_POST['pvit_shippowanderlust_completed'] == 1){add_option('pvit_shippowanderlust_completed',1);update_option('pvit_shippowanderlust_completed', 1);}else{add_option('pvit_shippowanderlust_completed',0);update_option('pvit_shippowanderlust_completed', 0);}
	
	
		
	if($_POST['pvit_shippowanderlust_shipper_enable'] == 1){		
		add_option('pvit_shippowanderlust_shipper_enable',1);update_option('pvit_shippowanderlust_shipper_enable', 1);
	}else{
		add_option('pvit_shippowanderlust_shipper_enable',0);update_option('pvit_shippowanderlust_shipper_enable', 0);
	}
	if($_POST['pvit_shippowanderlust_shipper_test'] == 1){		
		add_option('pvit_shippowanderlust_shipper_test',1);update_option('pvit_shippowanderlust_shipper_test', 1);
	}else{
		add_option('pvit_shippowanderlust_shipper_test',0);update_option('pvit_shippowanderlust_shipper_test', 0);
	}
}
	if(!empty($error)){?>
<div class="error fade">
<p><?php echo $error;?></p>
</div>
<?php 
}
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	 jQuery('.shippowanderlustinfo').hide();
	 jQuery('.senderinfo').hide();
	 jQuery('.packagesizes').hide();
	 jQuery('.emailsettings').hide();
	 jQuery('.insurancesettings').hide();	
	 jQuery('.servicesnames').hide();	
	
	
 	if (jQuery('#pvit_shippowanderlust_customshmore').attr('checked') ) {  
		jQuery('.customshs').prop('disabled',true); 
	} else { 
		jQuery('.customshs').prop('disabled',false);
	}
	
 
	
	jQuery('#pvit_shippowanderlust_customshmore').click(function(){
 			if (jQuery('#pvit_shippowanderlust_customshmore').attr('checked') ) {  jQuery('.customshs').prop('disabled',true); } else { jQuery('.customshs').prop('disabled',false);}	
	});	
	
	 
	jQuery('#shippowanderlustinfo').click(function(){
		if( jQuery('.shippowanderlustinfo').is(':visible') ) {jQuery('.shippowanderlustinfo').fadeOut();}
		else {jQuery('.shippowanderlustinfo').fadeIn(200);}
	});

	jQuery('#senderinfo').click(function(){
		if( jQuery('.senderinfo').is(':visible') ) {jQuery('.senderinfo').fadeOut();}
		else {jQuery('.senderinfo').fadeIn(200);}
	});

	jQuery('#pluginoptions').click(function(){
		if( jQuery('.pluginoptions').is(':visible') ) {jQuery('.pluginoptions').fadeOut();}
		else {jQuery('.pluginoptions').fadeIn(200);}
	});	

	jQuery('#packagesizes').click(function(){
		if( jQuery('.packagesizes').is(':visible') ) {jQuery('.packagesizes').fadeOut();}
		else {jQuery('.packagesizes').fadeIn(200);}
	});
	
	jQuery('#servicesnames').click(function(){
		if( jQuery('.servicesnames').is(':visible') ) {jQuery('.servicesnames').fadeOut();}
		else {jQuery('.servicesnames').fadeIn(200);}
	});	
	
	jQuery('#emailsettings').click(function(){
		if( jQuery('.emailsettings').is(':visible') ) {jQuery('.emailsettings').fadeOut();}
		else {jQuery('.emailsettings').fadeIn(200);}
	});	
	
	jQuery('#insurancesettings').click(function(){
		if( jQuery('.insurancesettings').is(':visible') ) {jQuery('.insurancesettings').fadeOut();}
		else {jQuery('.insurancesettings').fadeIn(200);}
	});		


});

</script>


<div style="margin-top: 20px">
	<form action="" method="post">
<div style="clear: both;min-width: 275px;">	
		<p>Welcome to Shippo Shipping Plugin</p>

		<h2 id="shippowanderlustinfo" style="cursor:pointer;float: left;clear: both;width: 250px;">Shipping API Information <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<div class="shippowanderlustinfo" style="float: left;clear: both;">

		<table class="form-table postbox">
		<tbody>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_shippowanderlust_username">Shippo User</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_shippowanderlust_username" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_shippowanderlust_username')?>" />
		</fieldset></td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_shippowanderlust_password">Shippo Password</label>
		</th>
		<td class="forminp">
		<fieldset>
			<input name="pvit_shippowanderlust_password" type="password" size="45" class="input medium" value="<?php echo get_option('pvit_shippowanderlust_password')?>"  />
		</fieldset></td>
			</tr>

			<tr valign="top">
		<th scope="row" class="titledesc">
			<label for="pvit_shippowanderlust_customstype">Customs Info - Contents Type</label> 
			<small>Please fill on each product the customs info.</small>
		</th>
		<td class="forminp">
			<fieldset>
			<select name="pvit_shippowanderlust_customstype">
				<option <?php $customtype = get_option('pvit_shippowanderlust_customstype'); if ($customtype == 'MERCHANDISE' ) echo 'selected'; ?> value="MERCHANDISE">MERCHANDISE</option>
				<option <?php if ($customtype == 'DOCUMENTS' ) echo 'selected'; ?> value="DOCUMENTS">DOCUMENTS</option>
				<option <?php if ($customtype == 'GIFT' ) echo 'selected'; ?> value="GIFT">GIFT</option>
				<option <?php if ($customtype == 'RETURN_' ) echo 'selected'; ?> value="RETURN_">RETURN</option>
				<option <?php if ($customtype == 'SAMPLE' ) echo 'selected'; ?> value="SAMPLE">SAMPLE</option>
				<option <?php if ($customtype == 'OTHER' ) echo 'selected'; ?> value="OTHER">OTHER</option>				
			</select>
 		</fieldset>
 		</td>
			</tr>

		</tbody></table>

			 
	</div>	
</div>			

<div style="clear: both;float: left;min-width: 275px;">	
		<h2 id="senderinfo" style="cursor:pointer;float: left;clear: both;width: 250px;">Sender Address <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>

		<table  class="form-table senderinfo postbox">
		<tbody>

			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_sender_name">Sender Name <span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input	name="pvit_shippowanderlust_sender_name" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_shippowanderlust_sender_name')?>" />
			</fieldset></td>
			</tr>
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_sender_company">Sender Company:</label> 
			</th>
			<td class="forminp">
			<fieldset>
				 <input name="pvit_shippowanderlust_sender_company" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_shippowanderlust_sender_company')?>" />
			</fieldset></td>
			</tr>
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_sender_address1">Sender Address 1<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input	name="pvit_shippowanderlust_sender_address1" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_shippowanderlust_sender_address1')?>" />
			</fieldset></td>
			</tr>		

			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_sender_address2">Sender Address 2:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input name="pvit_shippowanderlust_sender_address2" type="text" size="45" class="input medium" value="<?php echo get_option('pvit_shippowanderlust_sender_address2')?>" />
			</fieldset></td>
			</tr>					

			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_sender_state">State <span>(2 Digit) *</span>:</label> 
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_shippowanderlust_sender_state" value="<?php echo get_option('pvit_shippowanderlust_sender_state')?>" placeholder="CA" />
			</fieldset></td>
			</tr>		
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_shipper_city">City<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_shippowanderlust_shipper_city" value="<?php echo get_option('pvit_shippowanderlust_shipper_city')?>" />
			</fieldset></td>
			</tr>								
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_shipper_city">Country Code <span>(US) *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				<input type="text" size="45" name="pvit_shippowanderlust_shipper_country" value="<?php echo get_option('pvit_shippowanderlust_shipper_country')?>"  placeholder="US" />
			</fieldset></td>
			</tr>			
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_shipper_phone">Phone number<span> *</span>:</label> 
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_shippowanderlust_shipper_phone" value="<?php echo get_option('pvit_shippowanderlust_shipper_phone')?>"  placeholder="123-123-1234" />
			</fieldset></td>
			</tr>		
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_shipper_zipcode">ZipCode<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_shippowanderlust_shipper_zipcode" value="<?php echo get_option('pvit_shippowanderlust_shipper_zipcode')?>" />
			</fieldset></td>
			</tr>											
			<tr valign="top">
			<th scope="row" class="titledesc">
				 <label for="pvit_shippowanderlust_shipper_email">Email<span> *</span>:</label>
			</th>
			<td class="forminp">
			<fieldset>
				 <input type="text" size="45" name="pvit_shippowanderlust_shipper_email" value="<?php echo get_option('pvit_shippowanderlust_shipper_email')?>" />
			</fieldset></td>
			</tr>	
		</tbody></table>	



</div>

<div style="clear: both;float: left;min-width: 275px;">	

		<h2 id="packagesizes" style="cursor:pointer;float: left;clear: both;width: 250px;">Predefined Package Sizes <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<table  class="form-table packagesizes postbox">

		<tbody>
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_usps">Show USPS: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_usps" value="1" <?php checked(1, get_option('pvit_shippowanderlust_usps'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_fedex">Show FedEx: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_fedex" value="1" <?php checked(1, get_option('pvit_shippowanderlust_fedex'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_ups">Show UPS: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_ups" value="1" <?php checked(1, get_option('pvit_shippowanderlust_ups'));?> /> Enabled
			</fieldset></td>
			</tr>
			
			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_dhlbox">Show DHL: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_dhlbox" value="1" <?php checked(1, get_option('pvit_shippowanderlust_dhlbox'));?> /> Enabled
			</fieldset></td>
			</tr>			
			
			
		 
		</tbody>
			<small style="float: left;clear: both;">These Predefined Packages will only return rates for their respective carrier. (Ex. FedExEnvelope - FedExBox - FedExPak - FedExTube)</small>

</table>
	
	 

		<h2 id="emailsettings" style="cursor:pointer;float: left;clear: both;width: 250px;">Email Settings <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>
		<table  class="form-table emailsettings postbox">
		<tbody>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_email_label">Send labels via email: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_email_label" value="1" <?php checked(1, get_option('pvit_shippowanderlust_email_label'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_email_label_to">Send To: </label>
			</th>
			<td class="forminp">
			<fieldset>
				 	<input type="text" size="45" name="pvit_shippowanderlust_email_label_to" value="<?php echo get_option('pvit_shippowanderlust_email_label_to')?>" />
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_email_label_from">Send From: </label>
			</th>
			<td class="forminp">
			<fieldset>
				 	<input type="text" size="45" name="pvit_shippowanderlust_email_label_from" value="<?php echo get_option('pvit_shippowanderlust_email_label_from')?>" />
			</fieldset></td>
			</tr>
		 
		</tbody></table>	
	
 	 		
	 

		<h2 id="pluginoptions" style="cursor:pointer;float: left;clear: both;width: 250px;">Plugin Options <img src="<?php echo plugins_url('includes/img/up-arrow-icon.png',dirname(__FILE__));?>" style="position: absolute;margin: -3px 5px;width: 24px;" /> </h2>

		<table  class="form-table pluginoptions postbox">
		<tbody> 

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_shipper_zipcode">Activate Testing Mode: </label>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_shipper_test" value="1" <?php checked(1, get_option('pvit_shippowanderlust_shipper_test'));?> /> Enabled
			</fieldset></td>
			</tr>

			<tr valign="top">
			<th scope="row" class="titledesc">
				  <label for="pvit_shippowanderlust_rates">Enable Rates at checkout: </label>
				  <small>Enable this as shipping method</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_rates" value="1" <?php checked(1, get_option('pvit_shippowanderlust_rates'));?> /> Enabled
			<small><a href="<?php echo wp_nonce_url(admin_url('admin.php?page=wc-settings&tab=shipping&section=wc_shipping_wanderlust_shippo')); ?>">Settings</a></small>
			</fieldset></td>
			</tr>		
			
			<tr valign="top">
			<th scope="row" class="titledesc">
			<label for="pvit_shippowanderlust_autogen">Auto Generate Label on payment Received:</label> 
				<small style="float: left;">Will move the order to completed.</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_autogen" value="1" <?php checked(1, get_option('pvit_shippowanderlust_autogen'));?> /> Enabled
			</fieldset></td>
			</tr>
			
			<tr valign="top">
			<th scope="row" class="titledesc">
			<label for="pvit_shippowanderlust_completed">Change to Completed</label> 
				<small style="float: left;">Will move the order to completed after label is generated.</small>
			</th>
			<td class="forminp">
			<fieldset>
				  <input type="checkbox" name="pvit_shippowanderlust_completed" value="1" <?php checked(1, get_option('pvit_shippowanderlust_completed'));?> /> Enabled
			</fieldset></td>
			</tr>			
					
		</tbody></table>	

 
</div>		
		<p style="margin-top: 10px; width: 100%; clear: both">
			<input type="submit" name="pvit_shippowanderlust_shipper_config_save" value="<?php _e('Save Configuration');?>" class="button-primary" />
		</p>
	</form>
</div>

<style>	tbody{padding: 20px !important;position: relative;float: left;}</style>