<?php
/**
 * WP Ultimate Exporter plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */
namespace Smackcoders\SMEXP;

use Smackcoders\WCSV\WC_Coupon;

if (! defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * Class JetBookingExport
 * @package Smackcoders\WCSV
 */
class JetBookingExport
{
    protected static $instance = null, $mapping_instance, $export_handler, $export_instance, $post_export;
    public $totalRowCount;
    public $plugin;

    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
            JetBookingExport::$export_instance = ExportExtension::getInstance();
            JetBookingExport::$post_export = PostExport::getInstance();
        }
        return self::$instance;
    }

    /**
     * JetBookingExport constructor.
     */
    public function __construct()
    {
        $this->plugin = Plugin::getInstance();
    }

    /**
     * Export woocommerce orders
     * @param $id
     * @param $type
     * @param $optional
     */
    public function getJetBookingData($id, $type = null, $optional = null)
    {           
        global $wpdb;
        $booking = jet_abaf_get_booking( $id );
        if(!empty($booking)){
            $booking_id = $booking->get_id();
            $status = $booking->get_status();
            $apartment_id = $booking->get_apartment_id();
            $apartment_unit = $booking->get_apartment_unit();
            $check_in_date  = date( 'Y-m-d', $booking->get_check_in_date());
            $check_out_date = date( 'Y-m-d', $booking->get_check_out_date() );
            $order_id = $booking->get_order_id();
            $user_id = $booking->get_user_id();
            $import_id = $booking->get_import_id();
           // $attributes = $booking->attributes();
            $guests = $booking->get_guests();
            $orderStatus = !empty($order_id) ? get_post_status($order_id) : '';

            JetBookingExport::$export_instance->data[$booking_id]['booking_id'] = $booking_id ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['status'] = $status ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['apartment_id'] = $apartment_id ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['apartment_unit'] = $apartment_unit ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['check_in_date'] = $check_in_date ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['check_out_date'] = $check_out_date ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['order_id'] = $order_id ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['user_id'] = $user_id ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['import_id'] = $import_id ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['guests'] = $guests ?? '';
            JetBookingExport::$export_instance->data[$booking_id]['orderStatus'] = $orderStatus ?? '';
        }
    }
}
