<?php

/**
 * Import Woocommerce plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMWC;
use Smackcoders\SMWC\WC_Coupon;
use Smackcoders\SMWC\WC_Product_Attribute;

if (! defined('ABSPATH'))
	exit; // Exit if accessed directly

require_once('ImportHelpers.php');

class WooCommerceMetaImport extends ImportHelpers
{
	private static $woocommerceMetaInstance = null, $media_instance;

	public static function getInstance()
	{

		if (WooCommerceMetaImport::$woocommerceMetaInstance == null) {
			WooCommerceMetaImport::$woocommerceMetaInstance = new WooCommerceMetaImport;
			WooCommerceMetaImport::$media_instance = new MediaHandling();
			return WooCommerceMetaImport::$woocommerceMetaInstance;
		}
		return WooCommerceMetaImport::$woocommerceMetaInstance;
	}
	public function woocommerce_product_bundle_import_function($data_array, $image_meta, $pID, $variation_id, $import_type, $line_number, $mode, $header_array, $value_array, $core_array, $hash_key, $gmode, $templatekey, $poly_values)
	{
		global $wpdb;
		$bundle = wc_get_product($pID);
		foreach ($data_array as $ekey => $eval) {
			switch ($ekey) {
				case 'product_bundle_items':
					if (!empty($data_array[$ekey]) && $bundle->is_type('bundle')) {
						$bundle_product_ids = explode('|', $data_array[$ekey]);

						if ($bundle) {
							// Retrieve existing bundled items
							$existing_bundle_items = $bundle->get_bundled_items();

							// Create a map of existing bundled item IDs by product ID
							$existing_items_map = [];
							foreach ($existing_bundle_items as $existing_item) {
								$existing_items_map[$existing_item->get_product_id()] = $existing_item->get_id();
							}

							$i = 0;
							foreach ($bundle_product_ids as $product_id) {
								if (is_numeric($product_id)) {
									$product_id = intval($product_id);
								} else {
									$product_id = ltrim($product_id);
									$product_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_title = '$product_id' ORDER BY ID DESC");
								}
								if ($product_id) {
									if (isset($existing_items_map[$product_id])) { // case : duplicate bundle ID check
										continue;
									} else {
										// Add new bundled item
										$bundled_items[] = array('product_id' => $product_id, 'bundle_id' => $pID, 'menu_order' => $i,);
										if (!empty($bundled_items)) {
											$bundle->set_bundled_data_items($bundled_items);
										}
									}
								}
								$i++;
							}
						}
					}
					break;
				case 'pb_regular_price':
					$regular_price = !empty($data_array[$ekey]) ? $data_array[$ekey] : '';
					// Set regular price
					if ($bundle && $bundle->is_type('bundle')) {
						if (isset($data_array['pb_regular_price'])) {
							$regular_price = $data_array['pb_regular_price'];
							$bundle->set_regular_price($regular_price);
						}
					}
					break;
				case 'pb_sale_price':
					$regular_price = !empty($data_array[$ekey]) ? $data_array[$ekey] : '';
					// Set regular price
					if ($bundle && $bundle->is_type('bundle')) {
						if (isset($data_array['pb_sale_price'])) {
							$sale_price = $data_array['pb_sale_price'];
							$bundle->set_sale_price($sale_price);
							$bundle->set_price($sale_price);
						}
					}
					break;
				case '_wc_pb_virtual_bundle':
					$virtual_bundle = strtolower($data_array[$ekey]);
					if (isset($virtual_bundle) && $bundle->is_type('bundle')) {
						$bundle->set_virtual_bundle($virtual_bundle);
					}
					break;
				case 'layout':
					$layout_mapping = ['standard' => 'default', 'tabular' => 'tabular', 'grid' => 'grid'];
					$layout_status = $layout_mapping[$data_array[$ekey]] ?? '';
					if (isset($layout_status) && $bundle->is_type('bundle') && !empty($layout_status)) {
						$bundle->set_layout($layout_status);
					}
					break;
				case 'form_location':
					$form_location_status = '';
					if ($data_array[$ekey] == 'Default') {
						$form_location_status = 'default';
					}
					if ($data_array[$ekey] == 'Before Tabs') {
						$form_location_status = 'after_summary';
					}
					if (isset($form_location_status) && $bundle->is_type('bundle')) {
						$bundle->set_add_to_cart_form_location($form_location_status);
					}
					break;
				case 'item_grouping':
					$item_grouping_status = '';
					if ($data_array[$ekey] == 'grouped') {
						$item_grouping_status = 'parent';
					} else if ($data_array[$ekey] == 'flat') {
						$item_grouping_status = 'noindent';
					} else {
						$item_grouping_status = '';
					}
					if (isset($item_grouping_status) && $bundle->is_type('bundle')) {
						$bundle->set_group_mode($item_grouping_status);
					}
					break;
				case 'min_bundle_size':
					$min_size = $data_array[$ekey];
					if (isset($min_size) && $bundle->is_type('bundle')) {
						$bundle->set_min_bundle_size($min_size);
					}
					break;
				case 'max_bundle_size':
					$max_size = $data_array[$ekey];
					if (isset($max_size) && $bundle->is_type('bundle')) {
						$bundle->set_max_bundle_size($max_size);
					}
					break;
				case 'edit_in_cart':
					$edit_cart_status = '';
					if ($data_array[$ekey] == 'Yes') {
						$edit_cart_status = 'yes';
					} elseif ($data_array[$ekey] == 'No') {
						$edit_cart_status = 'no';
					}
					if ($edit_cart_status && $bundle->is_type('bundle')) {
						$bundle->set_editable_in_cart($edit_cart_status);
					}
					break;
				case 'optional':
				case 'priced_individually':
				case 'override_title':
				case 'override_description':
				case 'hide_thumbnail':
					if (isset($data_array[$ekey]) && $data_array[$ekey] && $bundle->is_type('bundle')) {
						$bundle_product_ids = explode('|', $data_array[$ekey]);
						$bundle_product_table = $wpdb->prefix . 'woocommerce_bundled_itemmeta';

						// Fetch existing bundled item IDs
						$bundle_meta_query = $wpdb->prepare(
							"SELECT bundled_item_id FROM {$wpdb->prefix}woocommerce_bundled_items WHERE bundle_id = %d",
							$pID
						);
						$bundle_meta_result = $wpdb->get_results($bundle_meta_query);

						foreach ($bundle_meta_result as $i => $result) {
							$bundle_meta_id = $result->bundled_item_id;
							$bundle_meta_value = isset($bundle_product_ids[$i]) ? $bundle_product_ids[$i] : '';

							// Determine the meta_value based on the provided value
							$bundle_meta_values = '';
							if ($bundle_meta_value == 'Yes') {
								$bundle_meta_values = 'yes';
							} elseif ($bundle_meta_value == 'No') {
								$bundle_meta_values = 'no';
							}

							// Update or insert the metadata
							if ($mode == 'Update') {
								$this->update_bundle_meta($bundle_meta_id, $ekey, $bundle_meta_values);
							} else {
								$this->add_bundle_meta($bundle_meta_id, $ekey, $bundle_meta_values);
							}
						}
					}
					break;
				case 'single_product_visibility':
				case 'cart_visibility':
				case 'order_visibility':
				case 'single_product_price_visibility':
				case 'cart_price_visibility':
				case 'order_price_visibility':
					if (isset($data_array[$ekey]) && $data_array[$ekey] && $bundle->is_type('bundle')) {
						$bundle_product_ids = explode('|', $data_array[$ekey]);
						$bundle_meta_table = $wpdb->prefix . 'woocommerce_bundled_items';

						// Get bundled items
						$bundle_meta_query = $wpdb->prepare("SELECT bundled_item_id FROM {$bundle_meta_table} WHERE bundle_id = %d", $pID);
						$bundle_meta_result = $wpdb->get_results($bundle_meta_query);

						foreach ($bundle_meta_result as $index => $bundle_meta) {
							$bundle_meta_id = $bundle_meta->bundled_item_id;
							$bundle_meta_value = isset($bundle_product_ids[$index]) ? $bundle_product_ids[$index] : '';

							if ($bundle_meta_value == 'Yes') {
								$bundle_meta_values = 'visible';
							} elseif ($bundle_meta_value == 'No') {
								$bundle_meta_values = 'hidden';
							} else {
								continue; // Skip if the value is not recognized
							}

							if ($mode == 'Update') {
								// Custom function or use direct SQL query if no built-in function exists
								$this->update_bundle_meta($bundle_meta_id, $ekey, $bundle_meta_values);
							} else {
								// Custom function or use direct SQL query if no built-in function exists
								$this->add_bundle_meta($bundle_meta_id, $ekey, $bundle_meta_values);
							}
						}
					}
					break;
				case 'quantity_min':
				case 'quantity_max':
				case 'discount':
					if (isset($data_array[$ekey]) && $data_array[$ekey] && $bundle->is_type('bundle')) {
						$bundle_product_ids = explode('|', $data_array[$ekey]);

						// Fetch existing bundled item IDs
						$bundle_meta_query = $wpdb->prepare(
							"SELECT bundled_item_id FROM {$wpdb->prefix}woocommerce_bundled_items WHERE bundle_id = %d",
							$pID
						);
						$bundle_meta_result = $wpdb->get_results($bundle_meta_query);

						foreach ($bundle_meta_result as $i => $result) {
							$bundle_meta_id = $result->bundled_item_id;
							$bundle_meta_value = isset($bundle_product_ids[$i]) ? $bundle_product_ids[$i] : '';

							// Update or insert the metadata
							if ($mode == 'Update') {
								$this->update_bundle_meta($bundle_meta_id, $ekey, $bundle_meta_value);
							} else {
								$this->add_bundle_meta($bundle_meta_id, $ekey, $bundle_meta_value);
							}
						}
					}
					break;
				case 'override_title_value':
					if (isset($data_array[$ekey]) && $data_array[$ekey] && $bundle->is_type('bundle')) {
						$bundle_product_ids = explode('|', $data_array[$ekey]);
						$bundle_product_table = $wpdb->prefix . 'woocommerce_bundled_itemmeta';

						// Fetch existing bundled item IDs
						$bundle_meta_query = $wpdb->prepare(
							"SELECT bundled_item_id FROM {$wpdb->prefix}woocommerce_bundled_items WHERE bundle_id = %d",
							$pID
						);
						$bundle_meta_result = $wpdb->get_results($bundle_meta_query);

						foreach ($bundle_meta_result as $i => $result) {
							$bundle_meta_id = $result->bundled_item_id;
							$bundle_meta_value = isset($bundle_product_ids[$i]) ? $bundle_product_ids[$i] : '';

							// Update or insert the metadata
							if ($mode == 'Update') {
								$this->update_bundle_meta($bundle_meta_id, 'title', $bundle_meta_value);
							} else {
								$this->add_bundle_meta($bundle_meta_id, 'title', $bundle_meta_value);
							}
						}
					}
					break;
				case 'override_description_value':
					if (isset($data_array[$ekey]) && $data_array[$ekey] && $bundle->is_type('bundle')) {
						$bundle_product_ids = explode('|', $data_array[$ekey]);
						$bundle_product_table = $wpdb->prefix . 'woocommerce_bundled_itemmeta';

						// Fetch existing bundled item IDs
						$bundle_meta_query = $wpdb->prepare(
							"SELECT bundled_item_id FROM {$wpdb->prefix}woocommerce_bundled_items WHERE bundle_id = %d",
							$pID
						);
						$bundle_meta_result = $wpdb->get_results($bundle_meta_query);

						foreach ($bundle_meta_result as $i => $result) {
							$bundle_meta_id = $result->bundled_item_id;
							$bundle_meta_value = isset($bundle_product_ids[$i]) ? $bundle_product_ids[$i] : '';

							// Update or insert the metadata
							if ($mode == 'Update') {
								$this->update_bundle_meta($bundle_meta_id, 'description', $bundle_meta_value);
							} else {
								$this->add_bundle_meta($bundle_meta_id, 'description', $bundle_meta_value);
							}
						}
					}
					break;
			}
			$bundle->save();
		}
	}
	public function update_bundle_meta($bundled_item_id, $meta_key, $meta_value)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'woocommerce_bundled_itemmeta';

		// Check if metadata already exists
		$existing_meta_id = $wpdb->get_var($wpdb->prepare(
			"SELECT meta_id FROM {$table_name} WHERE bundled_item_id = %d AND meta_key = %s",
			$bundled_item_id,
			$meta_key
		));

		if ($existing_meta_id) {
			// Update existing metadata
			$wpdb->update(
				$table_name,
				array('meta_value' => $meta_value),
				array('meta_id' => $existing_meta_id),
				array('%s'),
				array('%d')
			);
		}
	}

	public function add_bundle_meta($bundled_item_id, $meta_key, $meta_value)
	{
		global $wpdb;
		$table_name = $wpdb->prefix . 'woocommerce_bundled_itemmeta';
		// Insert new metadata
		$wpdb->insert(
			$table_name,
			array(
				'bundled_item_id' => $bundled_item_id,
				'meta_key' => $meta_key,
				'meta_value' => $meta_value
			),
			array('%d', '%s', '%s')
		);
	}
	public function woocommerce_coupons_meta_import_function($data_array, $image_meta, $pID, $variation_id, $import_type, $line_number, $mode, $header_array, $value_array, $hash_key)
	{
		// Initialize the WooCommerce Coupon object
		try {
			$coupon = new \WC_Coupon($pID);
			// Prepare the metadata array for the coupon
			$metaData = [];

			foreach ($data_array as $ekey => $eval) {
				switch ($ekey) {
					case 'discount_type':
						$coupon->set_discount_type($data_array[$ekey]);
						break;
					case 'coupon_amount':
						$coupon->set_amount($data_array[$ekey]);
						break;
					case 'individual_use':
						$coupon->set_individual_use($data_array[$ekey]);
						break;
					case 'exclude_product_ids':
						$coupon->set_excluded_product_ids(explode(',', $data_array[$ekey]));
						break;
					case 'product_ids':
						$coupon->set_product_ids(explode(',', $data_array[$ekey]));
						break;
					case 'usage_limit':
						$coupon->set_usage_limit($data_array[$ekey]);
						break;
					case 'usage_limit_per_user':
						$coupon->set_usage_limit_per_user($data_array[$ekey]);
						break;
					case 'limit_usage_to_x_items':
						$coupon->set_limit_usage_to_x_items($data_array[$ekey]);
						break;
					case 'expiry_date':
						$coupon->set_date_expires(strtotime($data_array[$ekey]));
						break;
					case 'free_shipping':
						$coupon->set_free_shipping($data_array[$ekey]);
						break;
					case 'exclude_sale_items':
						$coupon->set_exclude_sale_items($data_array[$ekey]);
						break;
					case 'wildcard_value':
						if (strpos($data_array[$ekey], '|') !== false) {
							$data = explode('|', $data_array[$ekey]);
							foreach ($data as $keys => $datameta) {
								$metaData['wildcard_rules_' . $keys . '_value'] = $datameta;
							}
						} else {
							$metaData['wildcard_rules_0_value'] = $data_array[$ekey];
						}
						break;
					case 'wildcard_type':
						if (strpos($data_array[$ekey], '|') !== false) {
							$data = explode('|', $data_array[$ekey]);
							foreach ($data as $key => $datameta) {
								$metaData['wildcard_rules_' . $key . '_type'] = $datameta;
							}
							$metaData['wildcard_rules'] = count($data);
						} else {
							$metaData['wildcard_rules_0_type'] = $data_array[$ekey];
							$metaData['wildcard_rules'] = 1;
						}
						break;
					case 'minimum_amount':
						$coupon->set_minimum_amount($data_array[$ekey]);
						break;
					case 'maximum_amount':
						$coupon->set_maximum_amount($data_array[$ekey]);
						break;
					case 'customer_email':
						$coupon->set_email_restrictions(explode(',', $data_array[$ekey]));
						break;
					case 'exclude_product_categories':
						$coupon->set_excluded_product_categories(explode(',', $data_array[$ekey]));
						break;
					case 'product_categories':
						$coupon->set_product_categories(explode(',', $data_array[$ekey]));
						break;
					default:
						$metaData['_subscription_payment_sync_date'] = 'a:2:{s:3:"day";i:0;s:5:"month";i:0;}';
						break;
				}
			}
			// Add custom meta data (if applicable)
			foreach ($metaData as $meta_key => $meta_value) {
				update_post_meta($pID, $meta_key, $meta_value);
			}

			// Save the coupon
			$coupon_id = $coupon->save();
		} catch (\Exception $e) {
			error_log('Error message coupons: ' . $e->getMessage());
		}
	}
	public function woocommerce_meta_import_function($data_array, $image_meta, $pID, $variation_id, $import_type, $line_number, $header_array, $value_array, $mode, $hash_key)
	{
		global $wpdb;
		global $core_instance;
		$get_all_gallery_images = array();
		$metaData = array();
		$order_item = array();
		// if(($import_type == 'WooCommerce Product') && isset($core_array['PRODUCTSKU'])){
		// 	$metaData['_sku'] = $core_array['PRODUCTSKU'];
		// 	$core_instance->detailed_log[$line_number][' SKU'] = $core_array['PRODUCTSKU'];

		// }
		// if(($import_type == 'WooCommerce Product Variations') && isset($core_array['VARIATIONSKU'])){
		// 	$metaData['_sku'] = $core_array['VARIATIONSKU'];
		// 	$core_instance->detailed_log[$line_number][' SKU'] = $core_array['VARIATIONSKU'];
		// }
		$product = wc_get_product($pID);
		$product_type = $product ? $product->get_type() : '';
		if ($import_type == 'WooCommerce Product' && !isset($data_array['product_type'])) {
			if ($mode == 'Insert' || ($mode == 'Update' && empty($product_type))) {
				wp_set_object_terms($pID, 'simple', 'product_type');
			}
		}
		//$methods = get_class_methods($product);
		foreach ($data_array as $ekey => $eval) {
			switch ($ekey) {
				case 'product_type':

					$product_type = 'simple';
					if ($data_array[$ekey] == 1) {
						$product_type = 'simple';
					}
					if ($data_array[$ekey] == 2) {
						$product_type = 'grouped';
					}
					if ($data_array[$ekey] == 3) {
						$product_type = 'external';
					}
					if ($data_array[$ekey] == 4) {
						$product_type = 'variable';
					}
					if ($data_array[$ekey] == 5) {
						$product_type = 'subscription';
					}
					if ($data_array[$ekey] == 6) {
						$product_type = 'variable-subscription';
					}
					if ($data_array[$ekey] == 7) {
						$product_type = 'bundle';
					}
					$core_instance->detailed_log[$line_number]['Type_of_Product'] = $product_type;
					wp_set_object_terms($pID, $product_type, 'product_type');
					$product = wc_get_product($pID);
					break;
				case 'stock':
					$metaData['_stock'] = $data_array[$ekey];
					if (!$product->is_type('external') && method_exists($product, 'set_stock_quantity') && method_exists($product, 'set_manage_stock') && method_exists($product, 'set_stock_status')) {
						// Check if stock is numeric and valid
						if ((!empty($metaData['_stock']) && is_numeric($metaData['_stock']))) {
							$stock_status = '';
							if ($metaData['_stock'] >= 1) {
								$stock_status = 'instock';
								$product->set_stock_quantity($metaData['_stock']);
								$product->set_manage_stock(true);
								$product->set_stock_status($stock_status);
							} else {
								$stock_status = 'outofstock';
								$product->set_manage_stock(true);
								$product->set_stock_quantity($metaData['_stock']);
								$product->set_stock_status($stock_status);
							}
							// Update parent product stock status if it's a variation
							$parent_id = wp_get_post_parent_id($pID);
							if ($parent_id) {
								wc_update_product_stock_status($parent_id, $stock_status);
							}
						} else {
							// If stock is not valid, set the product to 'outofstock'
							$product->set_manage_stock(false);
							$product->set_stock_status('outofstock');
						}
					}
					break;
				case 'stock_status':
					$stock_status = $data_array[$ekey];
					if (!empty($stock_status) && !$product->is_type('external') && method_exists($product, 'set_stock_status')) {
						$product->set_stock_status($stock_status);
						$parent_id = wp_get_post_parent_id($pID);
						if ($parent_id) { //stock status if it's a variation
							wc_update_product_stock_status($parent_id, $stock_status);
						}
					}
					break;
				case 'visibility':
					// Define visibility options
					$visibility_options = array(
						1 => 'visible',
						2 => 'catalog',
						3 => 'search',
						4 => 'hidden'
					);

					// Default visibility
					$visibility = 'visible';

					// Check if the provided visibility value exists in the options
					if (isset($data_array[$ekey]) && array_key_exists($data_array[$ekey], $visibility_options) && method_exists($product, 'set_catalog_visibility')) {
						$visibility = $visibility_options[$data_array[$ekey]];
						$product->set_catalog_visibility($visibility);
					}
					break;

				case 'downloadable':
					if (isset($data_array[$ekey]) && method_exists($product, 'set_downloadable')) {
						$is_downloadable = ($data_array[$ekey] === 'yes' || $data_array[$ekey] === 1 || $data_array[$ekey] === '1');
						$product->set_downloadable($is_downloadable);
					}
					break;

				case 'virtual':
					if (isset($data_array[$ekey]) && method_exists($product, 'set_virtual')) {
						$is_virtual = ($data_array[$ekey] === 'yes' || $data_array[$ekey] === 1 || $data_array[$ekey] === '1');
						$product->set_virtual($is_virtual);
					}
					break;

				case 'product_image_gallery':
					if (!empty($data_array[$ekey]) && method_exists($product, 'set_gallery_image_ids')) {
						// Check the delimiter (',' or '|') for splitting the images
						if (strpos($data_array[$ekey], ',') !== false) {
							$get_all_gallery_images = explode(',', $data_array[$ekey]);
						} elseif (strpos($data_array[$ekey], '|') !== false) {
							$get_all_gallery_images = explode('|', $data_array[$ekey]);
						} else {
							$get_all_gallery_images[] = $data_array[$ekey];
						}

						// Prepare an array for storing image IDs
						$gallery_image_ids = [];
						$indexs = 0;
						foreach ($get_all_gallery_images as $gallery_image) {
							// If it's already an ID, use it; otherwise, handle the image upload
							if (is_numeric($gallery_image)) {
								$gallery_image_ids[] = $gallery_image;
							} else {
								// Assuming a function to upload image and get its attachment ID exists
								$attachmentId = WooCommerceMetaImport::$media_instance->image_meta_table_entry($line_number, '', $pID, 'product_image_gallery', $gallery_image, $hash_key, 'product', 'post', '', '', '', '', '', '', $indexs);
								$gallery_image_ids[] = $attachmentId;
							}
							$indexs++;
						}
						$product->set_gallery_image_ids($gallery_image_ids);
					}
					break;

				case 'regular_price':
					$regular_price = !empty($data_array[$ekey]) ? $data_array[$ekey] : '';

					if ($product && method_exists($product, 'set_regular_price') && method_exists($product, 'get_regular_price') && method_exists($product, 'get_sale_price')) {
						if ($regular_price) {
							$product->set_regular_price($regular_price);
						} else {
							// If regular price is empty, get the existing price
							$current_regular_price = $product->get_regular_price();
							if ($import_type === 'WooCommerce Product Variations' || $import_type === 'WooCommerce Product') {
								// If there is a sale price set, use it as the price
								$sale_price = $product->get_sale_price();
								$final_price = $sale_price ? $sale_price : $current_regular_price;
								$product->set_price($final_price);
							}
						}
					}
					break;
				case 'sale_price':
					$sale_price = !empty($data_array[$ekey]) ? $data_array[$ekey] : '';
					if ($product && method_exists($product, 'get_regular_price') && method_exists($product, 'set_price') && method_exists($product, 'set_sale_price')) {
						if ($mode === 'Update') {
							if (empty($sale_price)) {
								// If sale price is empty, reset to regular price
								$regular_price = $product->get_regular_price();
								$product->set_price($regular_price); // Set price to regular price
								$product->set_sale_price(''); // Remove sale price
							} else {
								// Set sale price and update product price
								$product->set_sale_price($sale_price);
								$product->set_price($sale_price);
							}
						} else {
							if (empty($sale_price)) {
								// If sale price is empty, use regular price
								$regular_price = $product->get_regular_price();
								$product->set_price($regular_price);
							} else {
								// Set sale price and update product price
								$product->set_sale_price($sale_price);
								$product->set_price($sale_price);
							}
						}
					}
					break;
				case 'tax_status':
					$tax_status_options = array(
						1 => 'taxable',
						2 => 'shipping',
						3 => 'none'
					);
					$tax_status = 'taxable';
					if (isset($data_array[$ekey]) && array_key_exists($data_array[$ekey], $tax_status_options) && method_exists($product, 'set_tax_status')) {
						$tax_status = $tax_status_options[$data_array[$ekey]];
						$product->set_tax_status($tax_status);
					}
					break;
				case 'tax_class':
					$tax_class = !empty($data_array[$ekey]) ? $data_array[$ekey] : '';
					if (method_exists($product, 'set_tax_class')) {
						$product->set_tax_class($tax_class);
					}
					break;
				case 'purchase_note':
					// Set the purchase note meta field
					if (method_exists($product, 'set_purchase_note')) {
						$product->set_purchase_note($data_array[$ekey]);
					}
					break;
				case 'featured_product':
					// Determine if the product should be featured
					$is_featured = !empty($data_array[$ekey]) && $data_array[$ekey] == '1';
					if (method_exists($product, 'set_featured')) {
						$product->set_featured($is_featured);
					}
					break;
				case 'weight':
					$weight = $data_array[$ekey];
					if (method_exists($product, 'set_weight')) {
						$product->set_weight($weight);
					}
					break;

				case 'length':
					$length = $data_array[$ekey];
					if (method_exists($product, 'set_length')) {
						$product->set_length($length);
					}
					break;

				case 'width':
					$width = $data_array[$ekey];
					if (method_exists($product, 'set_width')) {
						$product->set_width($width);
					}
					break;

				case 'height':
					$height = $data_array[$ekey];
					if (method_exists($product, 'set_height')) {
						$product->set_height($height);
					}
					break;
				case 'variation_description':
					if ($product->is_type('variation')) {
						$variation_description = $data_array[$ekey];
						$product->set_description($variation_description);
					}
					break;
				case 'sale_price_dates_from':
					$date_from = strtotime($data_array[$ekey]); // Convert to timestamp
					if (method_exists($product, 'set_date_on_sale_from')) {
						$product->set_date_on_sale_from($date_from);
					}
					break;

				case 'sale_price_dates_to':
					$date_to = strtotime($data_array[$ekey]); // Convert to timestamp
					if (method_exists($product, 'set_date_on_sale_to')) {
						$product->set_date_on_sale_to($date_to);
					}
					break;

				case 'backorders':
					$backorders = '';
					if ($data_array[$ekey] == 1) {
						$backorders = 'no';
					} elseif ($data_array[$ekey] == 2) {
						$backorders = 'notify';
					} elseif ($data_array[$ekey] == 3) {
						$backorders = 'yes';
					}
					if ($product->get_type() !== 'external' && method_exists($product, 'set_backorders')) {
						$product->set_backorders($backorders);
					}
					break;

				case 'manage_stock':
					if ((!$product->is_type('external'))) {
						$manage_stock = ($data_array[$ekey] == 'yes' || $data_array[$ekey] == 1) ? true : false;
						if (method_exists($product, 'set_manage_stock')) {
							$product->set_manage_stock($manage_stock);
						}
					}
					break;

				case 'low_stock_threshold':
					$low_stock_threshold = intval($data_array[$ekey]);
					if (method_exists($product, 'set_low_stock_amount')) {
						$product->set_low_stock_amount($low_stock_threshold);
					}
					break;

				case 'file_paths':
					$file_paths = $data_array[$ekey];
					if (!empty($file_paths) && method_exists($product, 'set_downloadable_files')) {
						$product->set_downloadable_files($file_paths);
					}
					break;

				case 'download_limit':
					$download_limit = intval($data_array[$ekey]);
					if ($product->is_downloadable() && method_exists($product, 'set_download_limit')) {
						$product->set_download_limit($download_limit);
					}
					break;

				case 'comment_status':
					$status = $data_array[$ekey];
					wp_update_post(array('ID' => $pID, 'comment_status' => $status));
					break;

				case 'menu_order':
					$menu_order = intval($data_array[$ekey]);
					wp_update_post(array('ID' => $pID, 'menu_order' => $menu_order));
					break;

				case 'download_expiry':
					$download_expiry = intval($data_array[$ekey]);
					if ($product->is_downloadable() && method_exists($product, 'set_download_expiry')) {
						$product->set_download_expiry($download_expiry);
					}
					break;
				case 'download_type':
					$download_type = $data_array[$ekey];
					if ($product->is_downloadable()) {
						if ($download_type === 'file' || $download_type === 'external') {
							//$product->update_meta_data('_download_type', $download_type);
							update_post_meta($pID, '_download_type', $download_type);
						}
					}
					break;

				case 'product_url':
					if ($product->is_type('external') && method_exists($product, 'set_product_url')) {
						$product_url = $data_array[$ekey];
						!empty($product_url) ? $product->set_product_url($product_url) : '';
					}
					break;

				case 'button_text':
					if ($product->is_type('external') && method_exists($product, 'set_button_text')) {
						$button_text = $data_array[$ekey];
						$product->set_button_text($button_text);
					}
					break;
				case 'product_shipping_class':
				case 'variation_shipping_class':
					$class_name = $data_array[$ekey];
					$class = get_term_by('name', $class_name, 'product_shipping_class');

					if ($class && !is_wp_error($class)) {
						$class_id = $class->term_id;

						if ($product && method_exists($product, 'set_shipping_class_id')) {
							if ($product->is_type('variation')) {
								// Handle variation shipping class
								$product->set_shipping_class_id($class_id);
							} else {
								// Handle simple or other product types
								$product->set_shipping_class_id($class_id);
							}
						}
					}
					break;
				case 'sold_individually':
					$sold_individually = $data_array[$ekey];
					if (method_exists($product, 'set_shipping_class_id')) {
						$product->set_sold_individually($sold_individually === 'yes');
					}
					break;
				case 'product_tag':
					$tags[$ekey] = $data_array[$ekey];
					$core_instance->detailed_log[$line_number]['Tags'] = $data_array[$ekey];
					break;
				case 'product_category':
					$categories[$ekey] = $data_array[$ekey];
					$core_instance->detailed_log[$line_number]['Categories'] = $data_array[$ekey];
					break;
				case 'downloadable_files':
					$downloadable_files = array(); // Initialize as an array
					if (!empty($data_array[$ekey]) && method_exists($product, 'set_downloadable') && method_exists($product, 'set_downloads')) {
						$product->set_downloadable(true);
						$downloadable_files_raw = explode('|', $data_array[$ekey]);
						$downloadable_files = [];

						foreach ($downloadable_files_raw as $file_entry) {
							$file_info = explode(',', $file_entry);
							$file_url = $file_info[1] ?? '';
							$file_name = $file_info[0] ?? '';
							$downloadable_files[] = [
								'name' => sanitize_text_field($file_name),
								'file' => esc_url($file_url),
							];
						}
						$product->set_downloads($downloadable_files);
					}
					break;
				case 'grouping_product':
					if (!empty($data_array[$ekey])) {
						$grouping_product_ids = explode(',', $data_array[$ekey]);
						if ($product && 'grouped' === $product->get_type()) {
							$my_grouping_product_id = [];
							foreach ($grouping_product_ids as $grouping_product_id) {
								if (is_numeric($grouping_product_id)) {
									$my_grouping_product_id[] = (int) $grouping_product_id;
								} else {
									$my_grouping_product_id[] =  $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_title = '$grouping_product_id' order by ID Desc ");
								}
							}
							if (!empty($my_grouping_product_id)) {
								$product->set_children($my_grouping_product_id);
							}
						}
					}
					break;

				case 'crosssell_ids':
					$crosssellids = [];
					if (!empty($data_array[$ekey])) {
						$exploded_crosssell_ids = explode(',', $data_array[$ekey]);
						foreach ($exploded_crosssell_ids as $crosssell_id) {
							if (is_numeric($crosssell_id)) {
								$crosssellids[] = (int) $crosssell_id;
							} else {
								$product_id =  $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_title = '$crosssell_id' order by ID Desc ");
								if ($product_id) {
									$crosssellids[] = $product_id;
								}
							}
						}
					}

					if (!empty($crosssellids) && method_exists($product, 'set_cross_sell_ids')) {
						$product->set_cross_sell_ids($crosssellids);
					}
					break;
				case 'upsell_ids':
					$upsellids = [];
					if (!empty($data_array[$ekey])) {
						$exploded_upsell_ids = explode(',', $data_array[$ekey]);
						foreach ($exploded_upsell_ids as $upsell_id) {
							if (is_numeric($upsell_id)) {
								$upsellids[] = (int) $upsell_id;
							} else {
								// Fetch product ID based on product title
								$product_id = $wpdb->get_var("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'product' AND post_title = '$upsell_id' order by ID Desc ");
								if ($product_id) {
									$upsellids[] = $product_id;
								}
							}
						}
					}
					if (!empty($upsellids) && method_exists($product, 'set_upsell_ids')) {
						$product->set_upsell_ids($upsellids);
					}
					break;
				case 'thumbnail_id':
					if (method_exists($product, 'set_image_id')) {
						if (is_numeric($data_array[$ekey])) {
							$product->set_image_id((int) $data_array[$ekey]);
						} else {
							$f_path = WooCommerceMetaImport::$media_instance->get_filename_path($data_array[$ekey], '');
							$fimg_name = isset($f_path['fimg_name']) ? $f_path['fimg_name'] : '';
							$attachment_id = $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = 'attachment' AND guid LIKE '%$fimg_name%'", ARRAY_A);
							!empty($attachment_id[0]['ID']) ? $product->set_image_id($attachment_id[0]['ID']) : '';
						}
					}
					break;
				case 'default_attributes':
					if ($product && $product->is_type('variation')) {
						$dattribute = explode(',', $data_array[$ekey]);
						$default_attributes = [];
						foreach ($dattribute as $dattrkey) {
							$def_attribute = explode('|', $dattrkey);
							$taxonomy = 'pa_' . $def_attribute[0];
							$attribute_taxonomy = wc_sanitize_taxonomy_name($taxonomy);
							$default_attributes[$attribute_taxonomy] = $def_attribute[1];
						}
						// Set the default attributes for the variable product
						if (!empty($default_attributes) && isset($default_attributes)) {
							$parent_product_id = wp_get_post_parent_id($pID);
							$variation = wc_get_product($parent_product_id);
							$variation->set_default_attributes($default_attributes);
							$variation->save();
						}
					}
					break;
				case 'custom_attributes':
					$variation = wc_get_product($pID);
					// Check if the product is a valid variation
					if (! $variation || ! $variation->is_type('variation')) {
						break;
					}
					$excerpt = [];
					$vartitle = [];
					$attributes = explode(',', $data_array[$ekey]);
					foreach ($attributes as $attribute) {
						$attribute_parts = explode('|', $attribute);
						if (count($attribute_parts) === 2) {
							$attribute_label = $attribute_parts[0];
							$attribute_value = $attribute_parts[1];
							$taxonomy_slug = wc_attribute_taxonomy_name($attribute_label);
							$term = get_term_by('name', $attribute_value, $taxonomy_slug);

							if ($term) {
								$term_slug = $term->slug;
								$customAttributes['attribute_' . $taxonomy_slug] = $term_slug;
								$excerpt[] = $attribute_label . ': ' . $term_slug;
								$vartitle[] = $term_slug;
							}
						}
					}
					// Update custom attributes for the variation
					if (! empty($customAttributes)) {
						$variation->set_attributes($customAttributes);
						$variation->save();
					}

					// Update the product title and excerpt
					if (! empty($vartitle) && ! empty($excerpt)) {
						$parent_product_id = wp_get_post_parent_id($variation_id);

						if ($parent_product_id) {
							$parent_product = wc_get_product($parent_product_id);
							$title = $parent_product->get_name();

							// Prepare the title and excerpt
							$vartitle_str = implode(", ", $vartitle);
							$excerpt_str = implode(", ", $excerpt);

							if (strpos($vartitle_str, '-') !== false) {
								$vartitle_str = str_replace('-', ' ', $vartitle_str);
							}

							// Update the product title and excerpt
							$new_title = $title . ' - ' . $vartitle_str;
							$variation->set_name($new_title);
							$variation->set_short_description($excerpt_str);
							$variation->save();
						}
					}
					break;
					//WooCommerce yith-woocommerce Products Fields
				case '_ywbc_barcode_protocol':
					$metaData['_ywbc_barcode_protocol'] = $data_array[$ekey];
					break;
				case '_ywbc_barcode_value':
					$metaData['_ywbc_barcode_value'] = $data_array[$ekey];
					break;
				case '_ywbc_barcode_display_value':
					$metaData['_ywbc_barcode_display_value'] = $data_array[$ekey];
					break;
					//Add support for yith_cog_cost
				case 'yith_cog_cost':
					$metaData['yith_cog_cost'] = $data_array[$ekey];
					break;
				case 'minimum_allowed_quantity':
					$metaData['minimum_allowed_quantity'] = $data_array[$ekey];
					break;
				case 'maximum_allowed_quantity':
					$metaData['maximum_allowed_quantity'] = $data_array[$ekey];
					break;
					//WooCommerce Chained Products Fields
				case 'chained_product_detail':
					$arr = array();
					$cpid_key = array();
					if ($data_array[$ekey]) {
						$chainedid = explode('|', $data_array[$ekey]);

						foreach ($chainedid as $unitid) {
							$id = $unitid;

							$chainedunit = explode(',', $unitid);
							if (is_numeric($chainedunit[0])) {
								$chainid = trim($chainedunit[0]);
								$unit = ltrim($chainedunit[1], ' ');
								$query_result = $wpdb->get_results($wpdb->prepare("select post_title from {$wpdb->prefix}posts where ID = %d", $chainedunit[0]));
								$product_name = $query_result[0]->post_title;
								$cpid_key[$chainid]['unit'] = $unit;
								$cpid_key[$chainid]['product_name'] = $product_name;
								$cpid_key[$chainid]['priced_individually'] = 'no';
								$arr[] = $chainedunit[0];
							} else {

								$query_result = $wpdb->get_results($wpdb->prepare("select ID from {$wpdb->prefix}posts where post_title = %s", $chainedunit[0]));
								$product_id = $query_result[0]->ID;
								$unit = ltrim($chainedunit[1], ' ');

								$cpid_key[$product_id]['unit'] = $unit;
								$cpid_key[$product_id]['product_name'] = $chainedunit[0];
								$cpid_key[$product_id]['priced_individually'] = 'no';
								$arr[] = $product_id;
							}
						}
						$chained_product_detail = $cpid_key;
					} else {
						$chained_product_detail = '';
					}
					$metaData['_chained_product_detail'] = $chained_product_detail;
					$metaData['_chained_product_ids'] = $arr;
					break;
				case 'chained_product_manage_stock':
					$metaData['_chained_product_manage_stock'] = $data_array[$ekey];
					break;
					//WooCommerce Product Retailers Fields
				case 'wc_product_retailers_retailer_only_purchase':
					$metaData['_wc_product_retailers_retailer_only_purchase'] = $data_array[$ekey];
					break;
				case 'wc_product_retailers_use_buttons':
					$metaData['_wc_product_retailers_use_buttons'] = $data_array[$ekey];
					break;
				case 'wc_product_retailers_product_button_text':
					$metaData['_wc_product_retailers_product_button_text'] = $data_array[$ekey];
					break;
				case 'wc_product_retailers_catalog_button_text':
					$metaData['_wc_product_retailers_catalog_button_text'] = $data_array[$ekey];
					break;
				case 'wc_product_retailers_id':
					$retailer_id[$ekey] = $data_array[$ekey];
					break;
				case 'wc_product_retailers_price':
					$retailer_price[$ekey] = $data_array[$ekey];
					break;
				case 'wc_product_retailers_url':
					$retailer_url[$ekey] = $data_array[$ekey];
					break;
					//WooCommerce Product Add-ons Fields
				case 'product_addons_exclude_global':
					$metaData['_product_addons_exclude_global'] = $data_array[$ekey];
					break;
				case 'product_addons_group_name':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_group_description':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_type':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_position':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_required':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_label_name':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_price':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_minimum':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
				case 'product_addons_maximum':
					$product_addons[$ekey] = $data_array[$ekey];
					break;
					//WooCommerce Warranty Requests Fields
				case 'warranty_label':
					$metaData['_warranty_label'] = $data_array[$ekey];
					break;
				case 'warranty_type':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'warranty_length':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'warranty_value':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'warranty_duration':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'warranty_addons_amount':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'warranty_addons_value':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'warranty_addons_duration':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'no_warranty_option':
					$warranty[$ekey] = $data_array[$ekey];
					break;
				case 'preorders_enabled':
					$metaData['_wc_pre_orders_enabled'] = $data_array[$ekey];
					break;
				case 'preorders_availability_datetime':
					if ($data_array[$ekey]) {
						$datetime_value = strtotime($data_array[$ekey]);
					} else {
						$datetime_value = '';
					}
					$metaData['_wc_pre_orders_availability_datetime'] = $datetime_value;
					break;
				case 'preorders_fee':
					$metaData['_wc_pre_orders_fee'] = $data_array[$ekey];
					break;
				case 'preorders_when_to_charge':
					$metaData['_wc_pre_orders_when_to_charge'] = $data_array[$ekey];
					break;
				default:
					if (empty($variation_id)) {
						$metaData[$ekey] = $data_array[$ekey];
					}
					$metaData['_subscription_payment_sync_date'] = 'a:2:{s:3:"day";i:0;s:5:"month";i:0;}';
					break;
			}
			$product->save();
		}
		//WooCommerce Product Retailers Fields
		if (!empty($retailer_id)) {
			$exploded_ret_id = explode('|', $retailer_id['wc_product_retailers_id']);
			foreach ($exploded_ret_id as $ret_id) {
				$product_retailer['id'][] = $ret_id;
			}
		}
		if (!empty($retailer_price)) {
			$exploded_ret_price = explode('|', $retailer_price['wc_product_retailers_price']);
			foreach ($exploded_ret_price as $ret_price) {
				$product_retailer['product_price'][] = $ret_price;
			}
		}
		if (!empty($retailer_url)) {
			$exploded_ret_url = explode('|', $retailer_url['wc_product_retailers_url']);
			foreach ($exploded_ret_url as $ret_url) {
				$product_retailer['product_url'][] = $ret_url;
			}
		}
		if (!empty($product_retailer)) {
			$retailers_detail = array();
			$count_value = count($product_retailer['id']);
			for ($at = 0; $at < $count_value; $at++) {
				if (isset($product_retailer['id']) && isset($product_retailer['id'][$at])) {
					$retailers_detail[$product_retailer['id'][$at]]['id'] = $product_retailer['id'][$at];
				}
				if (isset($product_retailer['product_price']) && isset($product_retailer['product_price'][$at])) {
					$retailers_detail[$product_retailer['id'][$at]]['product_price'] = $product_retailer['product_price'][$at];
				}
				if (isset($product_retailer['product_url']) && isset($product_retailer['product_url'][$at])) {
					$retailers_detail[$product_retailer['id'][$at]]['product_url'] = $product_retailer['product_url'][$at];
				}
			}
		}
		if (!empty($retailers_detail)) {
			$metaData['_wc_product_retailers'] = $retailers_detail;
		}
		//WooCommerce Product Add-ons
		if (!empty($product_addons)) {
			$exploded_lab_name = explode('|', $product_addons['product_addons_label_name']);
			$count_lab_name = count($exploded_lab_name);
			for ($i = 0; $i < $count_lab_name; $i++) {
				$exploded_label_name = explode(',', $exploded_lab_name[$i]);
				foreach ($exploded_label_name as $lname) {
					$addons_option['label'][$i][] = $lname;
				}
			}
			$explode_lab_price = explode('|', $product_addons['product_addons_price']);
			$count_lab_price = count($explode_lab_price);
			for ($i = 0; $i < $count_lab_price; $i++) {
				$exploded_price = explode(',', $explode_lab_price[$i]);
				foreach ($exploded_price as $lprice) {

					$addons_option['price'][$i][] = $lprice;
				}
			}
			$expl_min = explode('|', $product_addons['product_addons_minimum']);
			$count_min = count($expl_min);
			for ($i = 0; $i < $count_min; $i++) {
				$exploded_min = explode(',', $expl_min[$i]);
				foreach ($exploded_min as $min) {
					$addons_option['min'][$i][] = $min;
				}
			}
			$expl_mac = explode('|', $product_addons['product_addons_maximum']);
			$count_max = count($expl_mac);
			for ($i = 0; $i < $count_max; $i++) {
				$exploded_max = explode(',', $expl_mac[$i]);
				foreach ($exploded_max as $max) {
					$addons_option['max'][] = $max;
				}
			}
			if (!empty($addons_option)) {
				$options_array = array();
				$cv = count($addons_option['label']);
				for ($a = 0; $a < $cv; $a++) {
					if (isset($addons_option['label']) && isset($addons_option['label'][$a])) {
						$options_array[$a]['label'] = $addons_option['label'][$a];
					}
					if (isset($addons_option['price']) && isset($addons_option['price'][$a])) {
						$options_array[$a]['price'] = $addons_option['price'][$a];
					}
					if (isset($addons_option['min']) && isset($addons_option['min'][$a])) {
						$options_array[$a]['min'] = $addons_option['min'][$a];
					}
					if (isset($addons_option['max']) && isset($addons_option['max'][$a])) {
						$options_array[$a]['max'] = $addons_option['max'][$a];
					}
				}
			}
			$exploded_group_name = explode('|', $product_addons['product_addons_group_name']);
			foreach ($exploded_group_name as $gname) {
				$addons['name'][] = $gname;
			}
			$exploded_group_description = explode('|', $product_addons['product_addons_group_description']);
			foreach ($exploded_group_description as $gdes) {
				$addons['description'][] = $gdes;
			}
			$exploded_position = explode('|', $product_addons['product_addons_position']);
			foreach ($exploded_position as $pos) {
				$addons['position'][] = $pos;
			}
			$exploded_type = explode('|', $product_addons['product_addons_type']);
			foreach ($exploded_type as $type) {
				$addons['type'][] = $type;
			}
			$exploded_required = explode('|', $product_addons['product_addons_required']);
			foreach ($exploded_required as $req) {
				$addons['required'][] = $req;
			}
			if (!empty($addons)) {
				$addons_array = array();
				$cnt = count($addons['name']);
				for ($b = 0; $b < $cnt; $b++) {
					if (isset($addons['name']) && isset($addons['name'][$b])) {
						$addons_array[$addons['name'][$b]]['name'] = $addons['name'][$b];
					}
					if (isset($addons['description']) && isset($addons['description'][$b])) {
						$addons_array[$addons['name'][$b]]['description'] = $addons['description'][$b];
					}
					if (isset($addons['type']) && isset($addons['type'][$b])) {
						$addons_array[$addons['name'][$b]]['type'] = $addons['type'][$b];
					}
					if (isset($addons['position']) && isset($addons['position'][$b])) {
						$addons_array[$addons['name'][$b]]['position'] = $addons['position'][$b];
					}
					if (isset($addons_option['label']) && isset($addons_option['label'][$b])) {
						for ($i = 0; $i < count($addons_option['label'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['label'] = $addons_option['label'][$b][$i];
						}
					}
					if (isset($addons_option['price']) && isset($addons_option['price'][$b])) {
						for ($i = 0; $i < count($addons_option['price'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['price'] = $addons_option['price'][$b][$i];
						}
					}
					if (isset($addons_option['min']) && isset($addons_option['min'][$b])) {
						for ($i = 0; $i < count($addons_option['min'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['min'] = $addons_option['min'][$b][$i];
						}
					}
					if (isset($addons_option['max']) && isset($addons_option['max'][$b])) {
						for ($i = 0; $i < count($addons_option['max'][$b]); $i++) {
							$addons_array[$addons['name'][$b]]['options'][$i]['max'] = $addons_option['max'][$b][$i];
						}
					}
					if (isset($addons['required']) && isset($addons['required'][$b])) {
						$addons_array[$addons['name'][$b]]['required'] = $addons['required'][$b];
					}
				}
			}
			if (!empty($addons_array)) {
				$metaData['_product_addons'] = $addons_array;
			}
		}
		if (!empty($warranty)) {
			if ($warranty['warranty_type'] == 'included_warranty') {
				$warranty_result['type'] = $warranty['warranty_type'];
				$warranty_result['length'] = $warranty['warranty_length'];
				$warranty_result['value'] = $warranty['warranty_value'];
				$warranty_result['duration'] = $warranty['warranty_duration'];
				$metaData['_warranty'] = $warranty_result;
			} else if ($warranty['warranty_type'] == 'addon_warranty') {
				if ($warranty['warranty_addons_amount'] != '') {
					$addon_amt = explode('|', $warranty['warranty_addons_amount']);
					foreach ($addon_amt as $amt) {
						$warranty_addons['amount'][] = $amt;
					}
				}
				if ($warranty['warranty_addons_value'] != '') {
					$addon_val = explode('|', $warranty['warranty_addons_value']);
					foreach ($addon_val as $val) {
						$warranty_addons['value'][] = $val;
					}
				}
				if ($warranty['warranty_addons_duration'] != '') {
					$addon_dur = explode('|', $warranty['warranty_addons_duration']);
					foreach ($addon_dur as $dur) {
						$warranty_addons['duration'][] = $dur;
					}
				}
				if (!empty($warranty_addons)) {
					$warranty_addons_detail = array();
					$addon_count = count($warranty_addons['amount']);
					for ($ad = 0; $ad < $addon_count; $ad++) {
						if (isset($warranty_addons['amount']) && isset($warranty_addons['amount'][$ad])) {
							$warranty_addons_detail[$warranty_addons['amount'][$ad]]['amount'] = $warranty_addons['amount'][$ad];
						}
						if (isset($warranty_addons['value']) && isset($warranty_addons['value'][$ad])) {
							$warranty_addons_detail[$warranty_addons['amount'][$ad]]['value'] = $warranty_addons['value'][$ad];
						}
						if (isset($warranty_addons['duration']) && isset($warranty_addons['duration'][$ad])) {
							$warranty_addons_detail[$warranty_addons['amount'][$ad]]['duration'] = $warranty_addons['duration'][$ad];
						}
					}
				}
				if (!empty($warranty_addons_detail)) {
					$warranty_result['type'] = $warranty['warranty_type'];
					$warranty_result['addons'] = $warranty_addons_detail;
					$warranty_result['no_warranty_option'] = $warranty['no_warranty_option'];
					$metaData['_warranty'] = $warranty_result;
				}
			} else {
				$metaData['_warranty'] = '';
			}
		}
		foreach ($metaData as $meta_key => $meta_value) {
			update_post_meta($pID, $meta_key, $meta_value);
		}
	}

	public function ppom_meta_import_function($ppom_fields, $post_id){

		$order = wc_get_order( $post_id );
		
		// Check if order exists
		if ( $order ) {
			// Get the order items
			foreach ( $order->get_items() as $item_id => $item ) {
				
				
			foreach ( $ppom_fields as $pkey => $pval ) {
				
				wc_add_order_item_meta( $item_id, $pkey , $pval );
				
			}
		}
		
	}
}
}
