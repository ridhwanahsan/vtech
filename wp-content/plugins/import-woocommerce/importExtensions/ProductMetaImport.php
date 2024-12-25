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
require_once('WooCommerceMetaImport.php');

class ProductMetaImport extends ImportHelpers
{
	private static $product_meta_instance = null;

	public static function getInstance()
	{

		if (ProductMetaImport::$product_meta_instance == null) {
			ProductMetaImport::$product_meta_instance = new ProductMetaImport;
			return ProductMetaImport::$product_meta_instance;
		}
		return ProductMetaImport::$product_meta_instance;
	}

	function set_product_meta_values($header_array, $value_array, $map, $post_id, $variation_id, $type, $line_number, $mode, $hash_key, $check_bundle_type = null)
	{
	
		global $wpdb;
		$woocommerceMetaInstance = WooCommerceMetaImport::getInstance();
		$helpers_instance = ImportHelpers::getInstance();
		$data_array = [];

		$data_array = $helpers_instance->get_header_values($map, $header_array, $value_array);
		$image_meta = $helpers_instance->get_meta_values($map, $header_array, $value_array);
		if ($type == 'WooCommerce Product' || $type == 'WooCommerce Product Variations') {
			$woocommerceMetaInstance->woocommerce_meta_import_function($data_array, $image_meta, $post_id, $variation_id, $type, $line_number, $header_array, $value_array, $mode, $hash_key);
		} else if ($type == 'WooCommerce Coupons') {
			$woocommerceMetaInstance->woocommerce_coupons_meta_import_function($data_array, $image_meta, $post_id, $variation_id, $type, $line_number, $mode, $header_array, $value_array, $hash_key);
		} else if ($type == 'BUNDLEMETA') {
			$woocommerceMetaInstance->woocommerce_product_bundle_import_function($data_array, '', $post_id, '', $type, $line_number, $mode, $header_array, $value_array, '', $hash_key, '', '', '');
		} else if ($type == 'PPOMMETA') {
				$woocommerceMetaInstance->ppom_meta_import_function($data_array, $post_id );
		}
	}
}
global $uci_woocomm_meta;
$uci_woocomm_meta = new ProductMetaImport;
