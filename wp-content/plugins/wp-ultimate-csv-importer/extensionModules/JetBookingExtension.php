<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
    exit; // Exit if accessed directly

    class JetBookingExtension extends ExtensionHandler
{
    private static $instance = null;

    public static function getInstance()
    {
        if (JetBookingExtension::$instance == null) {
            JetBookingExtension::$instance = new JetBookingExtension;
        }
        return JetBookingExtension::$instance;
    }

    /**
     * Provides JetBookingExtension Meta fields for specific post type
     * @param string $data - selected import type
     * @return array - mapping fields
     */
    public function processExtension($data)
    {
        $import_type = $data;
        $response = [];
        $import_type = trim($this->import_post_types($import_type));
        $post_type = trim(jet_abaf()->settings->get( 'apartment_post_type' ));
        if (is_plugin_active('jet-booking/jet-booking.php') && isset($import_type) && isset($post_type) && $import_type == $post_type) {
            $jet_meta_fields = array(
                'Pricing Settings'  => 'jet_abaf_price',
                'Custom Schedule'   => 'jet_abaf_custom_schedule',
                'Date Picker Config' => 'jet_abaf_configuration',
                'Unit Titles' => 'unit_title',
                'Unit Number' => 'unit_number',
            );
        }
        $jet_meta_fields = isset($jet_meta_fields) ? $jet_meta_fields : '';
        $jet_booking_fields = $this->convert_static_fields_to_array($jet_meta_fields);
        $response['jet_booking_fields'] = $jet_booking_fields;

        return $response;
    }
    public function import_post_types($import_type, $importAs = null) {	
		$import_type = trim($import_type);

		$module = array('Posts' => 'post', 'Pages' => 'page', 'Users' => 'user', 'Comments' => 'comments', 'Taxonomies' => $importAs, 'CustomerReviews' =>'wpcr3_review', 'Categories' => 'categories', 'Tags' => 'tags', 'WooCommerce' => 'product', 'WPeCommerce' => 'wpsc-product','WPeCommerceCoupons' => 'wpsc-product','WooCommerceVariations' => 'product', 'WooCommerceOrders' => 'product', 'WooCommerceCoupons' => 'product', 'WooCommerceRefunds' => 'product', 'CustomPosts' => $importAs,'WooCommerceReviews' =>'reviews','GFEntries' => 'gfentries');
		foreach (get_taxonomies() as $key => $taxonomy) {
			$module[$taxonomy] = $taxonomy;
		}
		if(array_key_exists($import_type, $module)) {
			return $module[$import_type];
		}
		else {
			return $import_type;
		}
	}

    /**
     * Product Meta extension supported import types
     * @param string $import_type - selected import type
     * @return boolean
     */
    public function extensionSupportedImportType($import_type)
    {
        if (is_plugin_active('jet-booking/jet-booking.php')) {
            $import_type = $this->import_name_as($import_type);
            if ($import_type == 'Posts' || $import_type == 'Pages' || $import_type == 'CustomPosts' || $import_type == 'WooCommerce') {
                return true;
            } else {
                return false;
            }
        }
    }
}
