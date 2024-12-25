<?php

/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;

if (! defined('ABSPATH'))
	exit; // Exit if accessed directly

require_once('ImportHelpers.php');
require_once('MediaHandling.php');

class WooCommerceCoreImport extends ImportHelpers
{
	private static $woocommerce_core_instance = null, $media_instance;

	public static function getInstance()
	{

		if (WooCommerceCoreImport::$woocommerce_core_instance == null) {
			WooCommerceCoreImport::$woocommerce_core_instance = new WooCommerceCoreImport;
			WooCommerceCoreImport::$media_instance = new MediaHandling();
			return WooCommerceCoreImport::$woocommerce_core_instance;
		}
		return WooCommerceCoreImport::$woocommerce_core_instance;
	}
	public function woocommerce_orders_import($data_array, $mode, $check, $unikey, $unikey_name, $line_number, $order_meta_data, $update_based_on)
	{
		global $wpdb;
		$helpers_instance = ImportHelpers::getInstance();
		global $core_instance;

		$log_table_name = $wpdb->prefix . "import_detail_log";

		$updated_row_counts = $helpers_instance->update_count($unikey, $unikey_name);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];
		if (class_exists('WC_Order')) {
			// Create a new order instance
			if ($mode == 'Insert') {
				$order = wc_create_order();
				$order_id = $order->save();
				$mode_of_affect = 'Inserted';
				if (is_wp_error($order_id) || $order_id == '') {
					$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this Order. " . $order_id->get_error_message();
					$core_instance->detailed_log[$line_number]['state'] = 'Skipped';
					$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
					return array('MODE' => $mode, 'ERROR_MSG' => $order_id->get_error_message());
				}
				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Order ID: ' . $order_id;
				$core_instance->detailed_log[$line_number]['id'] = $order_id;
				$core_instance->detailed_log[$line_number]['adminLink'] = get_edit_post_link($order_id, true);
				$core_instance->detailed_log[$line_number]['state'] = 'Inserted';
				$wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE $unikey_name = '$unikey'");
			} elseif ($mode == 'Update') {
				$order_id = $data_array['ORDERID'];
				$update_query = "select ID from {$wpdb->prefix}posts where ID = $order_id";
				$ID_result = $wpdb->get_results($update_query);
				if (is_array($ID_result) && !empty($ID_result)) {
					$retID = $ID_result[0]->ID;
					$data_array['ID'] = $retID;
					// wp_update_post($data_array);
					$mode_of_affect = 'Updated';

					$core_instance->detailed_log[$line_number]['Message'] = 'Updated Order ID: ' . $retID;
					$core_instance->detailed_log[$line_number]['id'] = $retID;
					$core_instance->detailed_log[$line_number]['adminLink'] = get_edit_post_link($retID, true);
					$core_instance->detailed_log[$line_number]['state'] = 'Updated';
					$wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE $unikey_name = '$unikey'");
				} else {

					$core_instance->detailed_log[$line_number]['Message'] = "Skipped.";
					$core_instance->detailed_log[$line_number]['state'] = 'Skipped';
					$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
					return array('MODE' => $mode);
				}
				$order = wc_get_order($data_array['ORDERID']);
			} else {
				$core_instance->detailed_log[$line_number]['Message'] = "Skipped.";
				$core_instance->detailed_log[$line_number]['state'] = 'Skipped';
				$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
				return array('MODE' => $mode);
			}
		}
		$item_name = $order_meta_data['item_name'];
		$item_qty = $order_meta_data['item_qty'];
		$products = explode(',', $item_name);
		$quantities = explode(',', $item_qty);
		if ($mode == 'Insert') {
			$queried_titles = array();
			foreach ($products as $products_value) {
				$title = ltrim($products_value);
				if (is_numeric($products_value)) {
					$product_ids = $products_value;
				} elseif (!in_array($title, $queried_titles)) {
					$product_ids[] = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title ='$title' AND post_type='product' AND post_status='publish'");
					if ($product_ids !== null) {
						$queried_titles[] = $title;
					}
				}
			}
			for ($i = 0; $i < count($product_ids); $i++) {
				$my_product = wc_get_product($product_ids[$i]);
				if (!empty($my_product)) {
					if ($my_product->is_type('variable')) {
						$variations = $my_product->get_children();
						for ($i = 0; $i < count($variations); $i++) {
							$quantity  = !empty($quantities[$i]) ? $quantities[$i] : '';
							$variation = !empty($variations[$i]) ? wc_get_product($variations[$i]) : '';
							if (!empty($variation) && $variation->exists()) {
								$order->add_product($variation, $quantity);
							}
						}
					} else {
						$quantity = !empty($quantities[$i]) ? $quantities[$i] : '';
						if (isset($product_ids[$i]) && !empty($product_ids[$i])) {
							$order->add_product(wc_get_product($product_ids[$i]), $quantity);
						}
					}
				}
			}
		}
		// Set customer information
		$customer_user = $order_meta_data['customer_user'];
		if (is_numeric($customer_user)) {
			$customer_user_id = $customer_user;
		} else {
			$email = $customer_user;
			$customer_user_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}users WHERE user_email='$email'");
		}
		$customer_note = $data_array['customer_note'];

		// Replace with the customer's user ID
		$order->set_customer_id($customer_user_id);
		$billing_first_name = isset($order_meta_data['billing_first_name']) ? $order_meta_data['billing_first_name'] : '';
		$billing_last_name = isset($order_meta_data['billing_last_name']) ? $order_meta_data['billing_last_name'] : '';
		$billing_company = isset($order_meta_data['billing_company']) ? $order_meta_data['billing_company'] : '';
		$billing_address_1 = isset($order_meta_data['billing_address_1']) ? $order_meta_data['billing_address_1'] : '';
		$billing_address_2 = isset($order_meta_data['billing_address_2']) ? $order_meta_data['billing_address_2'] : '';
		$billing_city = isset($order_meta_data['billing_city']) ? $order_meta_data['billing_city'] : '';
		$billing_postcode = isset($order_meta_data['billing_postcode']) ? $order_meta_data['billing_postcode'] : '';
		$billing_country = isset($order_meta_data['billing_country']) ? $order_meta_data['billing_country'] : '';
		$billing_phone = isset($order_meta_data['billing_phone']) ? $order_meta_data['billing_phone'] : '';
		$billing_email = isset($order_meta_data['billing_email']) ? $order_meta_data['billing_email'] : '';
		$billing_state = isset($order_meta_data['billing_state']) ? $order_meta_data['billing_state'] : '';
		$shipping_first_name = isset($order_meta_data['shipping_first_name']) ? $order_meta_data['shipping_first_name'] : '';
		$shipping_last_name = isset($order_meta_data['shipping_last_name']) ? $order_meta_data['shipping_last_name'] : '';
		$shipping_company = isset($order_meta_data['shipping_company']) ? $order_meta_data['shipping_company'] : '';
		$shipping_address_1 = isset($order_meta_data['shipping_address_1']) ? $order_meta_data['shipping_address_1'] : '';
		$shipping_address_2 = isset($order_meta_data['shipping_address_2']) ? $order_meta_data['shipping_address_2'] : '';
		$shipping_city = isset($order_meta_data['shipping_city']) ? $order_meta_data['shipping_city'] : '';
		$shipping_postcode = isset($order_meta_data['shipping_postcode']) ? $order_meta_data['shipping_postcode'] : '';
		$shipping_country = isset($order_meta_data['shipping_country']) ? $order_meta_data['shipping_country'] : '';
		$shipping_phone = isset($order_meta_data['shipping_phone']) ? $order_meta_data['shipping_phone'] : '';
		$shipping_email = isset($order_meta_data['shipping_email']) ? $order_meta_data['shipping_email'] : '';
		$shipping_state = isset($order_meta_data['shipping_state']) ? $order_meta_data['shipping_state'] : '';



		// Set billing and shipping address (replace with actual details)
		$billing_address = array(
			'first_name' => $billing_first_name,
			'last_name'  => $billing_last_name,
			'address_1'  => $billing_address_1,
			'address_2'  => $billing_address_2,
			'city'       => $billing_city,
			'state'      => $billing_state,
			'postcode'   => $billing_postcode,
			'country'    => $billing_country,
			'email'      => $billing_email,
			'phone'      => $billing_phone,
			'company' => $billing_company
		);
		$shipping_address = array(
			'first_name' => $shipping_first_name,
			'last_name'  => $shipping_last_name,
			'address_1'  => $shipping_address_1,
			'address_2'  => $shipping_address_2,
			'city'       => $shipping_city,
			'state'      => $shipping_state,
			'postcode'   => $shipping_postcode,
			'country'    => $shipping_country,
			'email'      => $shipping_email,
			'phone'      => $shipping_phone,
			'company' => $shipping_company
		);
		$order->set_address($billing_address, 'billing');
		$order->set_address($shipping_address, 'shipping');

		// Set payment method (replace with actual payment method)
		$payment_method = $order_meta_data['payment_method']; // Direct bank transfer
		$order_currency = $order_meta_data['order_currency'];

		$order->set_payment_method($payment_method);
		$order->set_customer_note($customer_note);
		$order->set_currency($order_currency);
		// Calculate totals
		$order->calculate_totals();
		
		$order->update_meta_data( 'ywot_tracking_code', $order_meta_data['ywot_tracking_code'] );
		$order->update_meta_data( 'ywot_tracking_postcode', $order_meta_data['ywot_tracking_postcode']);
		$order->update_meta_data( 'ywot_carrier_id', $order_meta_data['ywot_carrier_id'] );
		$order->update_meta_data( 'ywot_pick_up_date', $order_meta_data['ywot_pick_up_date'] );
		$order->update_meta_data( 'ywot_estimated_delivery_date', $order_meta_data['ywot_estimated_delivery_date'] );
		$order->update_meta_data( 'ywot_picked_up', $order_meta_data['ywot_picked_up'] );

		$order_id = $order->save();
		// $order = wc_get_order( $order_id );
		// $order->set_status( 'wc-completed' );
		$module = $wpdb->get_var("SELECT post_type FROM {$wpdb->prefix}posts where id=$order_id");
		$order_status = $data_array['order_status'];
		global $wpdb;
		if ($module == 'shop_order_placehold') {
			if (!empty($order_status)) {
				$wpdb->get_results("Update {$wpdb->prefix}wc_orders set status='$order_status' where id=$order_id");
			}
		} else {
			if (!empty($order_status)) {
				$wpdb->get_results("Update {$wpdb->prefix}posts set post_status='$order_status' where id=$order_id");
			}
		}
		$wpdb->update(
			$wpdb->prefix . 'posts',
			array(
				'post_excerpt' => $customer_note,
			),
			array('id' => $order_id)
		);
		// Save the order
		$returnArr['ID'] = $order_id;
		$returnArr['MODE'] = $mode_of_affect;
		return $returnArr;
	}

	public function woocommerce_coupons_import($data_array , $mode , $check , $unikey , $unikey_name, $line_number) {
		global $wpdb; 
		$helpers_instance = ImportHelpers::getInstance();
		global $core_instance;
		$log_table_name = $wpdb->prefix ."import_detail_log";

		$updated_row_counts = $helpers_instance->update_count($unikey,$unikey_name);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];

		$returnArr = array();
		
		$data_array['post_type'] = 'shop_coupon';
		$data_array['post_title'] = $data_array['coupon_code'];
		$data_array['post_name'] = $data_array['coupon_code'];
		if(isset($data_array['description'])) {
			$data_array['post_excerpt'] = $data_array['description'];
		}

		/* Post Status Options */
		if ( !empty($data_array['coupon_status']) ) {
			$data_array = $helpers_instance->assign_post_status( $data_array );
		} else {
			$data_array['coupon_status'] = 'publish';
		}

		if ($mode == 'Insert') {
			$retID = wp_insert_post($data_array);
			$mode_of_affect = 'Inserted';
			
			if(is_wp_error($retID) || $retID == '') {
				$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this Coupon. " . $retID->get_error_message();
				$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
				return array('MODE' => $mode, 'ERROR_MSG' => $retID->get_error_message());
			}
			$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Coupon ID: ' . $retID;
			$wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE $unikey_name = '$unikey'");

		} else {
				if($check == 'COUPONID'){
					$coupon_id = $data_array['COUPONID'];
					$post_type = $data_array['post_type'];
					$update_query = "select ID from {$wpdb->prefix}posts where ID = '$coupon_id' and post_type = '$post_type' and post_status not in('trash','draft') order by ID DESC";
					$ID_result = $wpdb->get_results($update_query);

					if (is_array($ID_result) && !empty($ID_result)) {
						$retID = $ID_result[0]->ID;
						$data_array['ID'] = $retID;
						wp_update_post($data_array);
						$mode_of_affect = 'Updated';

						$core_instance->detailed_log[$line_number]['Message'] = 'Updated Coupon ID: ' . $retID;
						$wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE $unikey_name = '$unikey'");			
					} else{
						$core_instance->detailed_log[$line_number]['Message'] = "Skipped.";
						$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
						return array('MODE' => $mode);
					}
				}
				else{
					$core_instance->detailed_log[$line_number]['Message'] = "Skipped.";
					$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
					return array('MODE' => $mode);
				}
			//} 
		}
		$returnArr['ID'] = $retID;
		$returnArr['MODE'] = $mode_of_affect;
		return $returnArr;
	}

	public function woocommerce_product_import($data_array, $mode, $check, $unikey_value, $unikey_name, $hash_key, $line_number, $unmatched_row, $wpml_values = null)
	{
		try{
			if(!empty($product_meta_data)){
				$post_values = array_merge($post_values,$product_meta_data);
			}
		$helpers_instance = ImportHelpers::getInstance();
		global $wpdb;
		global $core_instance, $sitepress;

		$logTableName = $wpdb->prefix . "import_detail_log";

		$data_array['PRODUCTSKU'] = isset($data_array['PRODUCTSKU']) ? $data_array['PRODUCTSKU'] : '';
		$data_array['PRODUCTSKU'] = trim($data_array['PRODUCTSKU']);
		if (isset($data_array['PRODUCTSKU'])) {
			$core_instance->detailed_log[$line_number]['SKU'] = $data_array['PRODUCTSKU'];
		}
		if (isset($core_array['VARIATIONSKU'])) {
			$core_instance->detailed_log[$line_number]['SKU'] = $data_array['VARIATIONSKU'];
		}
		$returnArr = array();
		$assigned_author = '';
		$getResult = '';
		$mode_of_affect = 'Inserted';

		// Assign post type
		$data_array['post_type'] = 'product';
		$data_array = $core_instance->import_core_fields($data_array);
		$post_type = $data_array['post_type'];

		if ($check == 'ID') {
			if (isset($data_array['ID'])) {
				$ID = $post_values['ID'];
				$getResult =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE ID = '$ID' AND post_type = '$post_type' AND post_status != 'trash' order by ID DESC ");
			}
		}
		if ($check == 'post_title') {
			if (isset($data_array['post_title'])) {
				$title = $data_array['post_title'];
				$getResult =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title = '$title' AND post_type = '$post_type' AND post_status != 'trash' order by ID DESC ");
			}
		}
		if ($check == 'post_name') {
			if (isset($data_array['post_name'])) {
				$name = $data_array['post_name'];

				if ($sitepress != null && is_plugin_active('wpml-ultimate-importer/wpml-ultimate-importer.php')) {
					$languageCode = $wpml_values['language_code'];
					$getResult =  $wpdb->get_results("SELECT DISTINCT p.ID FROM {$wpdb->prefix}posts p join {$wpdb->prefix}icl_translations pm ON p.ID = pm.element_id WHERE p.post_name = '$name' AND p.post_type = '$post_type' AND p.post_status != 'trash' AND pm.language_code = '{$languageCode}'");
				} else {
					$getResult =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_name = '$name' AND post_type = '$post_type' AND post_status != 'trash' order by ID DESC ");
				}
			}
		}
		if ($check == 'PRODUCTSKU') {
			if (isset($data_array['PRODUCTSKU'])) {
				$sku = $data_array['PRODUCTSKU'];
				if ($sitepress != null && is_plugin_active('wpml-ultimate-importer/wpml-ultimate-importer.php')) {
					$languageCode = $wpml_values['language_code'];
					$getResult =  $wpdb->get_results("SELECT DISTINCT p.ID FROM {$wpdb->prefix}posts p join {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id inner join {$wpdb->prefix}icl_translations icl ON pm.post_id = icl.element_id WHERE p.post_type = 'product' AND p.post_status != 'trash' and pm.meta_value = '$sku' and icl.language_code = '{$languageCode}'");
				} else {
					$getResult =  $wpdb->get_results("SELECT DISTINCT p.ID FROM {$wpdb->prefix}posts p join {$wpdb->prefix}postmeta pm ON p.ID = pm.post_id WHERE p.post_type = 'product' AND p.post_status != 'trash' and pm.meta_value = '$sku' ");
				}
			}
		}

		$updated_row_counts = $helpers_instance->update_count($unikey_value, $unikey_name);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];

		if ($mode == 'Insert') {

			if (is_array($getResult) && !empty($getResult)) {
				#skipped
				$core_instance->detailed_log[$line_number]['Message'] = "Skipped, Due to duplicate Product found!.";
				$fields = $wpdb->get_results("UPDATE $logTableName SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
				return array('MODE' => $mode);
			} else {

				$post_id = wp_insert_post($data_array);
				set_post_format($post_id, isset($data_array['post_format']));

				if (!empty($data_array['PRODUCTSKU'])) {
					update_post_meta($post_id, '_sku', $data_array['PRODUCTSKU']);
				}
				if (is_wp_error($post_id) || $post_id == '') {
					# skipped
					$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this Product. " . $post_id->get_error_message();
					$fields = $wpdb->get_results("UPDATE $logTableName SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
					return array('MODE' => $mode);
				} else {
					//WPML support on post types
					global $sitepress;
					if ($sitepress != null) {
						$helpers_instance->UCI_WPML_Supported_Posts($data_array, $post_id);
					}
				}

				if ($unmatched_row == 'true') {
					global $wpdb;
					$type = isset($type) ? $type : '';
					$post_entries_table = $wpdb->prefix . "ultimate_post_entries";
					$file_table_name = $wpdb->prefix . "smackcsv_file_events";
					$get_id  = $wpdb->get_results("SELECT file_name  FROM $file_table_name WHERE `hash_key` = '$hash_key'");
					$file_name = $get_id[0]->file_name;
					$wpdb->get_results("INSERT INTO $post_entries_table (`ID`,`type`, `file_name`,`status`) VALUES ( '{$post_id}','{$type}', '{$file_name}','Inserted')");
				}

				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Product ID: ' . $post_id . ', ' . $assigned_author;
				$fields = $wpdb->get_results("UPDATE $logTableName SET created = $created_count WHERE $unikey_name = '$unikey_value'");
			}
		}
		if ($mode == 'Update') {

			if (is_array($getResult) && !empty($getResult)) {
				$post_id = $getResult[0]->ID;
				$data_array['ID'] = $post_id;
				wp_update_post($data_array);
				set_post_format($post_id, $data_array['post_format']);

				if ($unmatched_row == 'true') {
					global $wpdb;
					$post_entries_table = $wpdb->prefix . "ultimate_post_entries";
					$file_table_name = $wpdb->prefix . "smackcsv_file_events";
					$get_id  = $wpdb->get_results("SELECT file_name  FROM $file_table_name WHERE `hash_key` = '$hash_key'");
					$file_name = $get_id[0]->file_name;
					$wpdb->get_results("INSERT INTO $post_entries_table (`ID`,`type`, `file_name`,`status`) VALUES ( '{$post_id}','{$type}', '{$file_name}','Updated')");
				}
				$core_instance->detailed_log[$line_number]['Message'] = 'Updated Product ID: ' . $post_id . ', ' . $assigned_author;
				$fields = $wpdb->get_results("UPDATE $logTableName SET updated = $updated_count WHERE $unikey_name = '$unikey_value'");
			} else {
				$post_id = wp_insert_post($data_array);
				set_post_format($post_id, $data_array['post_format']);

				if (is_wp_error($post_id) || $post_id == '') {
					# skipped
					$core_instance->detailed_log[$line_number]['Message'] = "Can't insert this Product. " . $post_id->get_error_message();
					$fields = $wpdb->get_results("UPDATE $logTableName SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
					return array('MODE' => $mode);
				}

				if ($unmatched_row == 'true') {
					global $wpdb;
					$post_entries_table = $wpdb->prefix . "ultimate_post_entries";
					$file_table_name = $wpdb->prefix . "smackcsv_file_events";
					$get_id  = $wpdb->get_results("SELECT file_name  FROM $file_table_name WHERE `hash_key` = '$hash_key'");
					$file_name = $get_id[0]->file_name;
					$wpdb->get_results("INSERT INTO $post_entries_table (`ID`,`type`, `file_name`,`status`) VALUES ( '{$post_id}','{$type}', '{$file_name}','Updated')");
				}
				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Product ID: ' . $post_id . ', ' . $assigned_author;
				$fields = $wpdb->get_results("UPDATE $logTableName SET created = $created_count WHERE $unikey_name = '$unikey_value'");
			}
		}
	}catch (\Exception $e) {
		$core_instance->detailed_log[$line_number]['Message'] = $e->getMessage();
		$core_instance->detailed_log[$line_number]['state'] = 'Skipped';
		$wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
		return array('MODE' => $mode,'ID' => '');
	}
		$returnArr['ID'] = $post_id;
		$returnArr['MODE'] = $mode_of_affect;
		if (!empty($data_array['post_author'])) {
			$returnArr['AUTHOR'] = isset($assigned_author) ? $assigned_author : '';
		}
		return $returnArr;
	}
	public function woocommerce_variations_import($data_array, $mode, $check, $unikey, $unikey_name, $line_number, $variation_count)
	{
		global $wpdb, $core_instance;
		$logTableName = $wpdb->prefix . "import_detail_log";
		$helpers_instance = ImportHelpers::getInstance();
		$updated_row_counts = $helpers_instance->update_count($unikey, $unikey_name);
		$skipped_count = $updated_row_counts['skipped'];

		$productInfo = '';
		$returnArr = array('MODE' => $mode, 'ID' => '');
		$product_id = isset($data_array['PRODUCTID']) ? $data_array['PRODUCTID'] : '';
		$parent_sku = isset($data_array['PARENTSKU']) ? $data_array['PARENTSKU'] : '';
		$variation_id =  isset($data_array['VARIATIONID']) ? $data_array['VARIATIONID'] : '';
		$variation_sku = isset($data_array['VARIATIONSKU']) ? $data_array['VARIATIONSKU'] : '';
		if ($product_id != '' && ($variation_sku == '' || $variation_id == '')) {
			if ($variation_sku != '') {
				$variation_condition = 'update_using_variation_sku';
			} else if ($variation_id != '') {
				$variation_condition = 'update_using_variation_id';
			} else {
				$variation_condition = 'insert_using_product_id';
			}
		} elseif ($parent_sku != '') {
			$get_parent_product_id = $wpdb->get_results("select id from {$wpdb->prefix}posts where post_status != 'trash' and post_type = 'product' and id in (select post_id from {$wpdb->prefix}postmeta where meta_value = '$parent_sku')");
			$count = count($get_parent_product_id);
			$key = 0;
			if (! empty($get_parent_product_id)) {
				$product_id = $get_parent_product_id[$key]->id;
				//Check whether the product is variable type
				$term_details = wp_get_object_terms($product_id, 'product_type');
				if ((!empty($term_details)) && ($term_details[0]->name != 'variable')) {

					$core_instance->detailed_log[$line_number]['Message'] = "Skipped,Product is not variable in type.";
					$wpdb->get_results("UPDATE $logTableName SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
					return array('MODE' => $mode, 'ID' => '');
				}
			} else {
				$product_id = '';
				$core_instance->detailed_log[$line_number]['Message'] = "Skipped,Product is not available.";
				$wpdb->get_results("UPDATE $logTableName SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
				return array('MODE' => $mode, 'ID' => '');
			}
			if ($mode == 'Insert') {
				$variation_condition = 'insert_using_product_sku';
			}
			if ($variation_sku != '' && $mode == 'Update') {
				$variation_condition = 'update_using_variation_sku';
			}
			if ($variation_id != '') {
				$variation_condition = 'update_using_variation_id';
			}
		} elseif ($parent_sku == '' && ($variation_sku != '' || $variation_id != '')) {
			if ($variation_sku != '') {
				$variation_condition = 'update_using_variation_sku';
			}
			if ($variation_id != '') {
				$variation_condition = 'update_using_variation_id';
			}
		}

		if ($variation_sku != '' && $variation_id != '') {
			update_post_meta($variation_id, '_sku', $variation_sku);
		}

		if ($product_id != '') {
			$is_exist_product = $wpdb->get_results($wpdb->prepare("select * from {$wpdb->prefix}posts where ID = %d", $product_id));
			if (!empty($is_exist_product) && $is_exist_product[0]->ID == $product_id) {
				$productInfo = $is_exist_product[0];
			} else {
				#return $returnArr;
			}
		}

		if (isset($variation_condition)) {
			switch ($variation_condition) {
				case 'update_using_variation_id_and_sku':

					$get_variation_data = $wpdb->get_results($wpdb->prepare("select DISTINCT pm.post_id from {$wpdb->prefix}posts p join {$wpdb->prefix}postmeta pm on p.ID = pm.post_id where p.ID = %d and p.post_type = %s and pm.meta_value = %s", $variation_id, 'product_variation', $variation_sku));

					if (! empty($get_variation_data) && $get_variation_data[0]->post_id == $variation_id) {
						$returnArr = $this->importVariationData($product_id, $variation_id, 'update_using_variation_id_and_sku', $unikey, $unikey_name, $line_number, $variation_count, $get_variation_data);
					} else {
						$returnArr = $this->importVariationData($product_id, $variation_id, 'default', $unikey, $unikey_name, $line_number, $variation_count, $productInfo);
					}
					break;
				case 'update_using_variation_id':

					$get_variation_data = $wpdb->get_results($wpdb->prepare("select * from {$wpdb->prefix}posts where ID = %d and post_type = %s", $variation_id, 'product_variation'));
					if (! empty($get_variation_data) && $get_variation_data[0]->ID == $variation_id) {
						$returnArr = $this->importVariationData($product_id, $variation_id, 'update_using_variation_id', $unikey, $unikey_name, $line_number, $variation_count, $get_variation_data);
					} else {
						$returnArr = $this->importVariationData($product_id, $variation_id, 'default', $unikey, $unikey_name, $line_number, $variation_count, $productInfo);
					}
					break;
				case 'update_using_variation_sku':
					$variation_data = $wpdb->get_results("select post_id from {$wpdb->prefix}postmeta where meta_value = '$variation_sku' and post_id in (select id from {$wpdb->prefix}posts where post_type = 'product_variation' and post_status != 'trash' and post_parent = $product_id)");
					$variation_id = !empty($variation_data) ? $variation_data[0]->post_id : "";
					if ($variation_id)
						$get_variation_data = $wpdb->get_results($wpdb->prepare("select * from {$wpdb->prefix}posts where ID = %d and post_type = %s", $variation_id, 'product_variation'));
					else
						$get_variation_data = [];
					if (! empty($get_variation_data) && $get_variation_data[0]->ID == $variation_id) {
						$returnArr = $this->importVariationData($product_id, $variation_id, 'update_using_variation_sku', $unikey, $unikey_name, $line_number, $variation_count, $get_variation_data);
					} else {
						$returnArr = $this->importVariationData($product_id, $variation_id, 'default', $unikey, $unikey_name, $line_number, $variation_count, $productInfo);
					}
					break;
				case 'insert_using_product_id':
					$returnArr = $this->importVariationData($product_id, $variation_id, 'insert_using_product_id', $unikey, $unikey_name, $line_number, $variation_count,  $productInfo);
					break;
				case 'insert_using_product_sku':
					$returnArr = $this->importVariationData($product_id, $variation_id, 'insert_using_product_sku', $unikey, $unikey_name, $line_number, $variation_count, $productInfo);
					break;
				default:
					$returnArr = $this->importVariationData($product_id, $variation_id, 'default', $unikey, $unikey_name, $line_number, $variation_count, $productInfo);
					break;
			}
		}
		return $returnArr;
	}

	public function importVariationData($product_id, $variation_id, $type, $unikey, $unikey_name, $line_number, $variation_count, $exist_variation_data = array())
	{
		global $wpdb;
		$helpers_instance = ImportHelpers::getInstance();
		global $core_instance;
		$logTableName = $wpdb->prefix . "import_detail_log";

		$updated_row_counts = $helpers_instance->update_count($unikey, $unikey_name);
		$created_count = $updated_row_counts['created'];
		$updated_count = $updated_row_counts['updated'];
		$skipped_count = $updated_row_counts['skipped'];
		if ($type == 'default' || $type == 'insert_using_product_id' || $type == 'insert_using_product_sku') {

			$get_count_of_variations = $wpdb->get_results($wpdb->prepare("select count(*) as variations_count from {$wpdb->prefix}posts where post_parent = %d and post_type = %s", $product_id, 'product_variation'));
			$variations_count = $get_count_of_variations[0]->variations_count;
			$menu_order_count = 0;
			if ($variations_count == 0) {
				$variations_count = '';
				$menu_order = 0;
			} else {
				$variations_count = $variations_count + 1;
				$menu_order_count = $variations_count - 1;
				$variations_count = '-' . $variations_count;
			}
			$get_variation_data = $wpdb->get_results($wpdb->prepare("select * from {$wpdb->prefix}posts where ID = %d", $product_id));
			foreach ($get_variation_data as $key => $val) {

				if ($product_id == $val->ID) {

					$variation_data = array();
					$variation_data['post_title'] = $val->post_title;
					$variation_data['post_date'] = $val->post_date;
					$variation_data['post_type'] = 'product_variation';
					$variation_data['post_status'] = 'publish';
					$variation_data['comment_status'] = 'closed';
					$variation_data['ping_status'] = 'closed';
					$variation_data['menu_order'] = $menu_order_count;
					$variation_data['post_name'] = 'product-' . $val->ID . '-variation' . $variations_count;
					$variation_data['post_parent'] = $val->ID;
				}
			}
			$variationid = wp_insert_post($variation_data);
			if (empty($variation_count)) {
				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Variation ID: ' . $variationid;
			} else {
				$parent_id = $wpdb->get_var("SELECT post_parent FROM {$wpdb->prefix}posts WHERE id = '$variationid' ");
				$core_instance->detailed_log[$line_number]['Message'] = 'Inserted Product ID: ' . $parent_id . '   Inserted Variation ID: ' . $variationid;
			}
			$wpdb->get_results("UPDATE $logTableName SET created = $created_count WHERE $unikey_name = '$unikey'");
			$returnArr = array('ID' => $variationid, 'MODE' => 'Inserted');
			return $returnArr;
		} elseif ($type == 'update_using_variation_id' || $type == 'update_using_variation_sku' || $type == 'update_using_variation_id_and_sku') {

			$core_instance->detailed_log[$line_number]['Message'] = 'Updated Variation ID: ' . $variation_id;
			$wpdb->get_results("UPDATE $logTableName SET updated = $updated_count WHERE $unikey_name = '$unikey'");

			$returnArr = array('ID' => $variation_id, 'MODE' => 'Updated');
			return $returnArr;
		}
	}
}

global $uci_woocomm_instance;
$uci_woocomm_instance = new WooCommerceCoreImport;
