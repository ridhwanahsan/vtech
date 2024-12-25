<?php

/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

 namespace Smackcoders\FCSV;

if (!defined('ABSPATH'))
	exit; // Exit if accessed directly

    class JetBookingImport
    {
    
        private static $instance = null, $media_instance;
    
        public static function getInstance()
        {
            if (JetBookingImport::$instance == null) {
                JetBookingImport::$instance = new JetBookingImport;
                JetBookingImport::$instance = new JetBookingImport;
                JetBookingImport::$media_instance = MediaHandling::getInstance();
            }
            return JetBookingImport::$instance;
        }
        function set_jet_booking_values($header_array, $value_array, $map, $post_id, $type, $mode, $hash_key, $line_number, $gmode, $templatekey)
        {
            $post_values = [];
            $helpers_instance = ImportHelpers::getInstance();
            $post_values = $helpers_instance->get_header_values($map, $header_array, $value_array);
            $this->jet_booking_fields_import_function($post_values, $type, $post_id, $mode, $hash_key, $line_number, $header_array, $value_array, $gmode, $templatekey);
        }
    
        public function jet_booking_fields_import_function($data_array, $type, $post_id, $mode, $hash_key, $line_number, $header_array, $value_array, $gmode, $templatekey)
        {
            global $wpdb;
            $helpers_instance = ImportHelpers::getInstance();
            $plugin = 'jetengine-booking';
            $media_instance = MediaHandling::getInstance();
            $darray = array();
            $listTaxonomy = get_taxonomies();
            if (in_array($type, $listTaxonomy)) {
                $get_import_type = 'term';
            } elseif ($type == 'Users' || $type == 'user') {
                $get_import_type = 'user';
            } elseif ($type == 'Comments') {
                $get_import_type = 'comment';
            } else {
                $get_import_type = 'post';
            }
    
    
            foreach ($data_array as $dkey => $dvalue) {
    
                $dvalue = trim($dvalue);
                if (!empty($dvalue) && ($dkey == 'jet_abaf_price' || $dkey == 'jet_abaf_custom_schedule' || $dkey == 'jet_abaf_configuration')) {
                    // Unserialize the string, if possible
                    $data = maybe_unserialize($dvalue);
                    if (is_string($data)) {
                        $data = unserialize($dvalue);
                    }
                    // Update post meta with properly serialized data
                    update_post_meta($post_id, $dkey, $data);
                }
            }
    
            if (!empty($data_array['unit_title'])) {
                $unit_titles = explode('|', $data_array['unit_title']);
                $numbers = explode('|', $data_array['unit_number']);
    
                // Ensure both arrays have the same length
                if (count($unit_titles) === count($numbers)) {
                    foreach ($unit_titles as $index => $unit_title) {
                        $number = !empty($numbers[$index]) ? absint($numbers[$index]) : 1;
                        $apartment = $post_id;
                        $result = jet_abaf()->db->get_apartment_units($apartment);
                        $current_count = count($result);
    
                        for ($i = 1; $i <= $number; $i++) {
                            $unit_num = $current_count + $i;
    
                            // Insert each unit with its title and calculated unit number
                            jet_abaf()->db::wpdb()->insert(jet_abaf()->db->units->table(), [
                                'apartment_id' => $apartment,
                                'unit_title'   => $unit_title . ' ' . $unit_num,
                            ]);
                        }
                        $current_count += $number;
                    }
                }
            }
        }
    
        function jet_booking_import($item, $type, $mode, $unikey, $unikey_name, $line_number, $update_based_on, $check, $hash_key)
        {
            global $wpdb;
            $helpers_instance = ImportHelpers::getInstance();
            $core_instance = CoreFieldsImport::getInstance();
            global $core_instance;
            $log_table_name = $wpdb->prefix . "import_detail_log";
    
            $updated_row_counts = $helpers_instance->update_count($unikey, $unikey_name);
            $created_count = $updated_row_counts['created'];
            $updated_count = $updated_row_counts['updated'];
            $skipped_count = $updated_row_counts['skipped'];
            $item['status'] = strtolower($item['status']);
            if ($item['status'] == 'on hold' || $item['status'] == 'onhold') {
                $item['status'] = 'on-hold';
            }
            if ($mode == 'Insert' && !empty($item)) {
                $result = $this->insert_booking($item, $wpdb, $core_instance, $helpers_instance, $created_count, $updated_count, $skipped_count, $log_table_name, $type, $mode, $unikey, $unikey_name, $line_number, $update_based_on, $check, $hash_key);
            } else if ($mode == 'Update' && !empty($item)) {
                $result = $this->update_booking($item, $wpdb, $core_instance, $helpers_instance, $created_count, $updated_count, $skipped_count, $log_table_name, $type, $mode, $unikey, $unikey_name, $line_number, $update_based_on, $check, $hash_key);
            }
            return $result;
        }
    
        public function update_booking($item, $wpdb, $core_instance, $helpers_instance, $created_count, $updated_count, $skipped_count, $log_table_name, $type, $mode, $unikey, $unikey_name, $line_number, $update_based_on, $check, $hash_key)
        {
            $item_id = $item['booking_id'];
            if (! empty($item['attributes'])) {
                wp_cache_set('booking_attributes_' . $item_id, $item['attributes']);
            }
    
            if (! empty($item['guests'])) {
                wp_cache_set('booking_guests_' . $item_id, $item['guests']);
            }
    
            $not_allowed = [
                'booking_id',
                'order_id',
                'user_id',
                'attributes',
                'guests',
            ];
    
            if (empty($item) || empty($item['check_in_date']) || empty($item['check_out_date'])) {
                $core_instance->detailed_log[$line_number]['Message'] = "No data to update. Incorrect item data in Jet-Booking.";
                $core_instance->detailed_log[$line_number]['state'] = 'Skipped';
                $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
                return array('MODE' => $mode, 'ERROR_MSG' => 'No data to update');
            }
            foreach ($not_allowed as $key) {
                if (isset($item[$key])) {
                    unset($item[$key]);
                }
            }
            $item['check_in_date']  = strtotime($item['check_in_date']);
            $item['check_out_date'] = strtotime($item['check_out_date']);
    
            $apartment_units = jet_abaf()->db->get_apartment_units($item['apartment_id']);
    
            if (! empty($apartment_units)) {
                $apartment_unit = jet_abaf()->db->get_apartment_unit($item['apartment_id'], $item['apartment_unit']);
    
                if (empty($apartment_unit)) {
                    $item['apartment_unit'] = jet_abaf()->db->get_available_unit($item);
                }
            }
    
            $is_available       = jet_abaf()->db->booking_availability($item, $item_id);
            $is_dates_available = jet_abaf()->db->is_booking_dates_available($item, $item_id);
            $is_days_available  = jet_abaf()->tools->is_booking_period_available($item);
    
            if (! $is_available && ! $is_dates_available || ! $is_days_available) {
                $error_message = "Unable to add this record ";
                if (! $is_available) {
                    $error_message .= "Booking unit is not open or available.";
                } elseif (! $is_dates_available) {
                    $error_message .= "Requested booking dates are unavailable.";
                } elseif (! $is_days_available) {
                    $error_message .= "Requested booking days are unavailable.";
                } else {
                    $error_message .= "Something went wrong";
                }
                // Log the message and update the detailed log
                $core_instance->detailed_log[$line_number]['Message'] = $error_message;
                $core_instance->detailed_log[$line_number]['state'] = 'Skipped';
                $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
    
                return array('MODE' => $mode, 'ERROR_MSG' => $error_message);
            }
    
            jet_abaf()->db->update_booking($item_id, $item);
            $mode_of_affect = 'Updated';
            $core_instance->detailed_log[$line_number]['state'] = 'Updated';
            $wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE $unikey_name = '$unikey'");
            $returnArr['ID'] = $item_id;
            $returnArr['MODE'] = $mode_of_affect;
            return $returnArr;
        }
        public function insert_booking($item, $wpdb, $core_instance, $helpers_instance, $created_count, $updated_count, $skipped_count, $log_table_name, $type, $mode, $unikey, $unikey_name, $line_number, $update_based_on, $check, $hash_key)
        {
    
            $order_status = $item['orderStatus'];
            $import_id = $item['import_id'];
            $user_id = $item['user_id'];
            unset($item['orderStatus']);
            if (empty($item['check_in_date']) || empty($item['check_out_date'])) {
                $core_instance->detailed_log[$line_number]['Message'] = "Booking date is empty";
                $core_instance->detailed_log[$line_number]['state'] = 'Skipped';
                $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
                return array('MODE' => $mode, 'ERROR_MSG' => 'Invalid');
            }
    
            $item['check_in_date']  = strtotime($item['check_in_date']);
            $item['check_out_date'] = strtotime($item['check_out_date']);
    
            if ($item['check_in_date'] >= $item['check_out_date']) {
                $item['check_out_date'] = $item['check_in_date'] + 12 * HOUR_IN_SECONDS;
            }
    
            if (empty($item['apartment_unit'])) {
                $item['apartment_unit'] = jet_abaf()->db->get_available_unit($item);
            }
            $is_available       = jet_abaf()->db->booking_availability($item);
            $is_dates_available = jet_abaf()->db->is_booking_dates_available($item);
            $is_days_available  = jet_abaf()->tools->is_booking_period_available($item);
            $bookings_cpt = jet_abaf()->settings->get('apartment_post_type');
            $posts = jet_abaf()->tools->get_booking_posts();
            $post_ids = wp_list_pluck($posts, 'ID');
            $apartment_id = !empty($item['apartment_id']) ? $item['apartment_id'] : false;
            $apartment_id_check = in_array($apartment_id, $post_ids) ? true  : false;
    
            if (! $apartment_id || ! $apartment_id_check || ! $is_available && ! $is_dates_available || ! $is_days_available) {
                $error_message = "Unable to add this record ";
                if (! $apartment_id) {
                    $error_message .= "Apartment ID is missing.";
                } else if (! $apartment_id_check) {
                    $error_message .= "Apartment ID is not available in your " . $bookings_cpt;
                } else if (! $is_available) {
                    $error_message .= "Booking unit is not open or available.";
                } elseif (! $is_dates_available) {
                    $error_message .= "Requested booking dates are unavailable.";
                } elseif (! $is_days_available) {
                    $error_message .= "Requested booking days are unavailable.";
                } else {
                    $error_message .= "Something went wrong.";
                }
                // Log the message and update the detailed log
                $core_instance->detailed_log[$line_number]['Message'] = $error_message;
                $core_instance->detailed_log[$line_number]['state'] = 'Skipped';
                $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
    
                return array('MODE' => $mode, 'ERROR_MSG' => $error_message);
            }
            $booking_id = jet_abaf()->db->insert_booking($item);
            if ($booking_id !== '0' && ! empty($order_status)) {
                $this->set_related_order_data($order_status, $booking_id, $item);
            } else {
                $core_instance->detailed_log[$line_number]['Message'] = "Cat't add this  apartment_id is invalid";
                $core_instance->detailed_log[$line_number]['state'] = 'Skipped';
                $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey'");
                return array('MODE' => $mode, 'ERROR_MSG' => 'apartment_id invalid');
            }
            $mode_of_affect = 'Inserted';
            $core_instance->detailed_log[$line_number]['state'] = 'Inserted';
            $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE $unikey_name = '$unikey'");
            $returnArr['ID'] = $booking_id;
            $returnArr['MODE'] = $mode_of_affect;
            return $returnArr;
        }
        public function set_related_order_data($order_status, $booking_id, $booking)
        {
            if ('plain' === jet_abaf()->settings->get('booking_mode') && ! jet_abaf()->settings->get('wc_integration')) {
                $post_type        = jet_abaf()->settings->get('related_post_type');
                $post_type_object = get_post_type_object($post_type);
    
                $args = [
                    'post_type'   => $post_type,
                    'post_status' => ! empty($order_status) ? $order_status : 'draft',
                ];
    
                if (post_type_supports($post_type, 'excerpt')) {
                    $args['post_excerpt'] = sprintf(__('This is %s post.', 'jet-booking'), $post_type_object->labels->singular_name);
                }
    
                $post_id = wp_insert_post($args);
    
                if (! $post_id || is_wp_error($post_id)) {
                    return;
                }
    
                wp_update_post([
                    'ID'         => $post_id,
                    'post_title' => $post_type_object->labels->singular_name . ' #' . $post_id,
                    'post_name'  => $post_type_object->labels->singular_name . '-' . $post_id,
                ]);
                jet_abaf()->db->update_booking($booking_id, ['order_id' => $post_id]);
            } else {
                do_action('jet-booking/rest-api/add-booking/set-related-order-data', $order_status, $booking_id, $booking);
            }
        }
    }
    